<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use File;
// use Google\Cloud\Firestore\FirestoreClient;
// use Kreait\Firebase;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']);
    }

    public function index()
    {
        return view('admin.index', [
            'vc' => Voucher::count(),
            'uc' => User::where('level', 'user')
                        ->count(),
            'uactive' => User::where('level', 'user')
                        ->where('is_active', '1')->count(),
            'unactive' => User::where('level', 'user')
                        ->where('is_active', '0')->count(),
            'users' => User::where('level', 'user')
                        ->orderBy('created_at', 'desc')
                        ->limit(7)
                        ->get(),
        ]);
    }
    
    public function voucher()
    {
        return view('admin.voucher', [
            'voucher' => Voucher::all(),
        ]);
    }

    public function tambahVchr()
    {
        return view('admin.voucherCreate');
    }

    public function editVchr(Voucher $voucher)
    {
        return view('admin.voucherEdit', compact('voucher'));
    }

    public function insertVchr(Request $request)
    {
        $nmgambar = time().str_replace(' ', '', $request->gambar->getClientOriginalName());
        $firebase_storage_path = 'img/';  
        $localfolder = public_path('firebase-temp-uploads') .'/';  
        if ($request->gambar->move($localfolder, $nmgambar)) {  
            $uploadedfile = fopen($localfolder.$nmgambar, 'r');  
            app('firebase.storage')->getBucket()->upload($uploadedfile, [
                    'resumable' => true,
                    'name' => $firebase_storage_path . $nmgambar,
                    'predefinedAcl' => 'publicRead',
                ]);  
            unlink($localfolder . $nmgambar);  
            Voucher::create([
                'name' => $request->name,
                'point' => $request->point,
                'image' => $nmgambar,
            ]);
            return redirect('/admin/voucher')->with('pesan', 'Berhasil menambahkan voucher');
        } else {  
            echo 'error - YNTKTS';  
        }  
    }

    public function updateVchr(Request $request)
    {
        $oldimage = (Voucher::findOrFail($request->id)->only('image'))['image'];
        if ($request->gambar === null) {
            $nmgambar = $oldimage;
        } else {
            $nmgambar = time().str_replace(' ', '', $request->gambar->getClientOriginalName());
            $firebase_storage_path = 'img/';  
            $localfolder = public_path('firebase-temp-uploads') .'/';  
            if ($request->gambar->move($localfolder, $nmgambar)) {  
                $uploadedfile = fopen($localfolder.$nmgambar, 'r');  
                app('firebase.storage')->getBucket()->upload($uploadedfile, [
                        'resumable' => true,
                        'name' => $firebase_storage_path . $nmgambar,
                        'predefinedAcl' => 'publicRead',
                    ]);  
                unlink($localfolder . $nmgambar);  
            }  
            // dell image on firebase
            $imageReference = app('firebase.storage')->getBucket()->object('img/'.$oldimage);
            if($imageReference->exists()) { 
                $imageReference->delete();      
            }
        }
        Voucher::findOrFail($request->id)->update([
            'name' => $request->name,
            'point' => $request->point,
            'image' => $nmgambar,
        ]);
        return redirect('/admin/voucher')->with('pesan', 'Berhasil mengubah voucher');
    }

    public function delVchr(Voucher $voucher)
    {
        Voucher::where('id', $voucher->id)->delete();     
        $imageReference = app('firebase.storage')->getBucket()->object('img/'.$voucher->image);
        if($imageReference->exists()) {
            $imageReference->delete();
        }
        return back()->with('pesan', 'Voucher Dihapus');
    }

    public function users()
    {
        return view('admin.users', [
            'users' => User::where('level', 'user')->get(),
        ]);
    }

    public function resetPswdUser(User $user)
    {
        User::where('id', $user->id)->update([
            'password' => Hash::make("12345678")
        ]);
        return back()->with('pesan', 'Password Berhasil direset ke 12345678');;
    }

    public function statusChngUser(User $user)
    {
        User::where('id', $user->id)->update([
            'is_active' => !$user->is_active
        ]);
        return back()->with('pesan', 'Status akun berhasil diubah');
    }
}
