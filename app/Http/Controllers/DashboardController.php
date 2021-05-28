<?php

namespace App\Http\Controllers;

use App\Http\Requests\belanjaRequest;
use App\Models\MyVoucher;
use App\Models\Note;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use File;

class DashboardController extends Controller
{
    public $point = 10;

    public function __construct()
    {
        $this->middleware(['auth','is_user']);
    }

    public function index()
    {
        return view('pages.dashboard', [
            'transaction' => Transaction::where('user_id', Auth::user()->id)
                    ->orderBy('created_at', 'desc')
                    ->limit(7)
                    ->get(),
            'catatan' => Note::where('user_id', Auth::user()->id)
                    ->where('is_finished', 0)
                    ->get(),
        ]);
    }

    public function topup()
    {
        return view('pages.topup');
    }

    public function topupStore(Request $request)
    {
        User::where('id', Auth::user()->id)
            ->update([
                'balance' => Auth::user()->balance + (int)$request->nominal,
                'point' => Auth::user()->point + $this->point,
            ]);
        Transaction::create([
            'deskripsi' => 'Topup',
            'nominal' => (int)$request->nominal,
            'user_id' => Auth::user()->id,
            'inout' => 'in',
            'point'=> '+ '.$this->point,
        ]);

        $judulTrans = "Topup";
        $pesan = "Topup berhasil dengan nominal Rp. ".number_format($request->nominal, 0, ',', '.').
                "\nSaldo Total anda Rp. ".number_format(Auth::user()->balance, 0, ',', '.');
        return view('pages.success', compact(['judulTrans','pesan']));
    }

    public function transfer()
    {
        return view('pages.transfer');
    }

    public function transferStore(Request $request)
    {
        $request->validate([
            'nominal' => 'integer|max:' . Auth::user()->balance,
        ]);
        
        if ( Auth::user()->spending_target  <  (Auth::user()->spending + (int)$request->nominal)) {
            return redirect()
                ->route('dashboard.saldo.transfer')
                ->with('message','Gagal!! Anda melebihi batas target pengeluaran. Silahkan atur target pengeluaran anda di Menu "Akun Saya"');
            exit;
        }

        Transaction::create([
            'deskripsi' => 'Transfer-' . $request->bank . '-' . $request->rekening,
            'nominal' => (int)$request->nominal,
            'inout' => 'out',
            'point'=> '+ '.$this->point,
            'user_id' => Auth::user()->id,
        ]);

        if (Auth::user()->saving_before_trans) {
            User::where('id', Auth::user()->id)->update([
                'balance' => Auth::user()->balance - (int)$request->nominal - (int)$request->saving,
                'point' => Auth::user()->point + $this->point,
                'spending' => Auth::user()->spending + (int)$request->nominal,
                'saving_balance' => Auth::user()->saving_balance + (int)$request->saving
            ]);
            Transaction::create([
                'deskripsi' => 'Nabung',
                'nominal' => (int)$request->saving,
                'inout' => 'in',
                'point'=> '0',
                'user_id' => Auth::user()->id,
            ]);
        } else {
            User::where('id', Auth::user()->id)->update([
                'balance' => Auth::user()->balance - (int)$request->nominal,
                'point' => Auth::user()->point + $this->point,
                'spending' => Auth::user()->spending + (int)$request->nominal
            ]);
        }
        $judulTrans = "Transfer";
        $pesan = "Transfer ke
                $request->bank - $request->rekening 
                Sebesar Rp. ".number_format($request->nominal, 0, ',', '.').
                " Telah berhasil. \nSaldo Total anda Rp. ".number_format(Auth::user()->balance, 0, ',', '.');
        return view('pages.success', compact(['judulTrans','pesan']));
    }

    public function riwayat()
    {
        return view('pages.riwayat', [
            'transaction' => Transaction::where('user_id', Auth::user()->id)
                    ->orderBy('created_at', 'desc')
                    ->get(),
        ]);
    }

    public function pengeluaran()
    {
        return view('pages.pengeluaran', [
            'transaction' => Transaction::where('user_id', Auth::user()->id)
                    ->where('inout', 'out')
                    ->orderBy('created_at', 'desc')
                    ->get(),
        ]);
    }

    public function pulsa()
    {
        return view('pages.pulsa');
    }

    public function pulsaStore(Request $request)
    {
        $request->validate([
            'nominal' => 'integer|max:' . Auth::user()->balance,
        ]);
        
        if ( Auth::user()->spending_target  <  (Auth::user()->spending + (int)$request->nominal)) {
            return redirect()
                ->route('dashboard.shop.pulsa')
                ->with('message','Gagal!! Anda melebihi batas target pengeluaran. Silahkan atur target pengeluaran anda di Menu "Akun Saya"');
            exit;
        }

        Transaction::create([
            'deskripsi' => 'Pulsa-' . $request->provider . '-' . $request->nomorhp,
            'nominal' => (int)$request->nominal,
            'inout' => 'out',
            'point'=> '+ '.$this->point,
            'user_id' => Auth::user()->id,
        ]);

        if (Auth::user()->saving_before_trans) {
            User::where('id', Auth::user()->id)->update([
                'balance' => Auth::user()->balance - (int)$request->nominal - (int)$request->saving,
                'point' => Auth::user()->point + $this->point,
                'spending' => Auth::user()->spending + (int)$request->nominal,
                'saving_balance' => Auth::user()->saving_balance + (int)$request->saving
            ]);
            Transaction::create([
                'deskripsi' => 'Nabung',
                'nominal' => (int)$request->saving,
                'inout' => 'in',
                'point'=> '0',
                'user_id' => Auth::user()->id,
            ]);
        } else {
            User::where('id', Auth::user()->id)->update([
                'balance' => Auth::user()->balance - (int)$request->nominal,
                'point' => Auth::user()->point + $this->point,
                'spending' => Auth::user()->spending + (int)$request->nominal
            ]);
        }
        $judulTrans = "Pulsa";
        $pesan = "Pembelian Pulsa 
                $request->provider - $request->nomorhp 
                Sebesar Rp. ".number_format($request->nominal, 0, ',', '.').
                " Telah berhasil. \nSaldo Total anda Rp. ".number_format(Auth::user()->balance, 0, ',', '.');
        return view('pages.success', compact(['judulTrans','pesan']));
    }

    public function listrik()
    {
        return view('pages.listrik');
    }

    public function listrikStore(Request $request)
    {
        $request->validate([
            'nominal' => 'integer|max:' . Auth::user()->balance,
        ]);
        
        if ( Auth::user()->spending_target  <  (Auth::user()->spending + (int)$request->nominal)) {
            return redirect()
                ->route('dashboard.shop.listrik')
                ->with('message','Gagal!! Anda melebihi batas target pengeluaran. Silahkan atur target pengeluaran anda di Menu "Akun Saya"');
            exit;
        }

        Transaction::create([
            'deskripsi' => 'listrik-' . $request->meter,
            'nominal' => (int)$request->nominal,
            'inout' => 'out',
            'point'=> '+ '.$this->point,
            'user_id' => Auth::user()->id,
        ]);

        if (Auth::user()->saving_before_trans) {
            User::where('id', Auth::user()->id)->update([
                'balance' => Auth::user()->balance - (int)$request->nominal - (int)$request->saving,
                'point' => Auth::user()->point + $this->point,
                'spending' => Auth::user()->spending + (int)$request->nominal,
                'saving_balance' => Auth::user()->saving_balance + (int)$request->saving
            ]);
            Transaction::create([
                'deskripsi' => 'Nabung',
                'nominal' => (int)$request->saving,
                'inout' => 'in',
                'point'=> '0',
                'user_id' => Auth::user()->id,
            ]);
        } else {
            User::where('id', Auth::user()->id)->update([
                'balance' => Auth::user()->balance - (int)$request->nominal,
                'point' => Auth::user()->point + $this->point,
                'spending' => Auth::user()->spending + (int)$request->nominal
            ]);
        }
        $judulTrans = "Token Listrik";
        $nmrToken ="";
        for($i=0; $i < 5; $i++) {
            $nmrToken = $nmrToken."".mt_rand(1000, 9999)." ";
        }
        $pesan = "Pembelian Token Listrik NoMeter/ID $request->meter 
                Sebesar Rp. ".number_format($request->nominal, 0, ',', '.').
                " Telah berhasil. \nSaldo Total anda Rp. ".number_format(Auth::user()->balance, 0, ',', '.'). "
                Tarif/Daya : R1/ 900 VA - Jml KWH : ".number_format(($request->nominal / 700),2)." KwH
                <b> Stroom/Token : $nmrToken </b>";
        return view('pages.success', compact(['judulTrans','pesan']));
    }

    public function catatan()
    {
        return view('pages.catatan', [
            'catatan' => Note::where('user_id', Auth::user()->id)->get(),
            ]);
    }

    public function tambahCtt()
    {
        return view('pages.catatanCreate');
    }

    public function editCtt(Note $note)
    {
        return view('pages.catatanEdit', compact('note'));
    }

    public function insertCtt(Request $request)
    {
        Note::create([
            'user_id' => Auth::user()->id,
            'judul' => $request->judul,
            'catatan' => $request->catatan,
        ]);
        return redirect('/dashboard/catatan');
    }

    public function updateCtt(Request $request)
    {
        Note::findOrFail($request->id)->update($request->all());
        return redirect('/dashboard/catatan');
    }

    public function finishedCtt(Note $note)
    {
        Note::where('id', $note->id)->update([
            'is_finished' => 1
        ]);
        return back();
    }

    public function delCtt(Note $note)
    {
        Note::where('id', $note->id)->delete();
        return back();
    }

    public function voucher()
    {
        return view('pages.voucher', [
            'vouchers' => Voucher::orderBy('point', 'asc')->get(),
        ]);
    }

    public function buyVoucher(Voucher $voucher)
    {
        if ( Auth::user()->point  <  $voucher->point ) {
            return back()->with('pesan','Point anda masih kurang');
            exit;
        }

        Transaction::create([
            'deskripsi' => 'Beli Voucher',
            'nominal' => 0,
            'inout' => '-',
            'point'=> '- '.$voucher->point,
            'user_id' => Auth::user()->id,
        ]);

        User::where('id', Auth::user()->id)->update([
            'point' => Auth::user()->point - $voucher->point,
        ]);
        
        $skrg = mt_rand(10000, 99999);
        $kodeencrpt = crypt($skrg,"mymoneyoke");
        
        // $gambar = $voucher->image;
        MyVoucher::create([
            'user_id' => Auth::user()->id,
            'voucher_id' => $voucher->id,
            'voucher_name' => $voucher->name,
            'kode' => $kodeencrpt,
            'image' => $voucher->image,
        ]);
        // $pathlama = public_path().'/img/'.$voucher->image;
        // $pathbaru = public_path().'/img/'.$gambar;
        // File::copy($pathlama, $pathbaru);
        $judulTrans = "Voucher";
        $pesan = "Pembelian Voucher dengan menukar Point berhasil.
                    <b> $voucher->point </b> Point ditukar dengan Voucher <b>$voucher->name </b>
                    Sisa Point anda ".Auth::user()->point;
        return view('pages.success', compact(['judulTrans','pesan']));
    }

    public function myvoucher()
    {
        return view('pages.myvoucher', [
            'myvouchers' => MyVoucher::where('user_id', Auth::user()->id)
                            ->latest()
                            ->get(),
        ]);
    }

    public function tabungan()
    {
        return view('pages.tabungan', [
            'transaction' => Transaction::where('user_id', Auth::user()->id)
                    ->whereIN('deskripsi', ['Nabung','Tarik Tabungan'])
                    ->orderBy('created_at', 'desc')
                    ->get(),
        ]);
    }

    public function transNabung(Request $request)
    {
        if ($request->aksi === "nabung") {
            if(Auth::user()->balance < $request->nominal) {
                return redirect('/dashboard/tabungan/')->with('status','Saldo Aktif Anda tidak cukup');
                exit;
            } else {
                User::where('id', Auth::user()->id)
                    ->update([
                        'balance' => Auth::user()->balance - (int)$request->nominal,
                        'saving_balance' => Auth::user()->saving_balance + (int)$request->nominal,
                    ]);
                Transaction::create([
                    'deskripsi' => 'Nabung',
                    'nominal' => $request->nominal,
                    'user_id' => Auth::user()->id,
                    'inout' => '-',
                    'point'=> '0',
                ]);
                $pesan = "Berhail Menabung";
            }
        } elseif ($request->aksi === "tarik") {
            if(Auth::user()->saving_balance < $request->nominal) {
                return redirect('/dashboard/tabungan/')->with('status','Tabungan Anda tidak cukup');
                exit;
            } else {
                User::where('id', Auth::user()->id)
                    ->update([
                        'balance' => Auth::user()->balance + (int)$request->nominal,
                        'saving_balance' => Auth::user()->saving_balance - (int)$request->nominal,
                    ]);
                Transaction::create([
                    'deskripsi' => 'Tarik Tabungan',
                    'nominal' => $request->nominal,
                    'user_id' => Auth::user()->id,
                    'inout' => '-',
                    'point'=> '0',
                ]);
                $pesan = "Berhail penarikan dari tabungan ke saldo aktif";
            }
        }
        return redirect('/dashboard/tabungan/')->with('status',$pesan);
    }

    // belum fiks
    
    public function belanjaApi(belanjaRequest $request)
    {
        $balance = (User::findOrFail($request->id)->only('balance'))['balance'];
        $point = (User::findOrFail($request->id)->only('point'))['point'];

        User::where('id', $request->id)->update([
            'balance' => $balance - (int)$request->nominal,
            'point' => $point + $this->point
        ]);
        Transaction::create([
            'deskripsi' => 'Belanja-' . $request->bank . '-' . $request->vendor,
            'nominal' => (int)$request->nominal,
            'user_id' => $request->id
        ]);
        return response()->json([
            'status' => 'berhasil',
            'data_transaksi' => [
                'bank' => $request->bank,
                'nominal' => $request->nominal,
                'vendor' => $request->vendor
            ],
            'data_pengguna' => [
                'id' => $request->id,
                'nama' => User::findOrFail($request->id)->name,
                'saldo' => User::findOrFail($request->id)->balance,
                'poin' => User::findOrFail($request->id)->point,
            ]
        ]);
    }

    public function ceksaldoApi(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $user = User::findOrFail($request->id);
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'saldo' => $user->balance,
            'poin' => $user->point,
        ]);
    }
}
