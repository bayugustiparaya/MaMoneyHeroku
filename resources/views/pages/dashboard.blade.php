@extends('layouts.template')
@section('title', 'Dashboard')
@section('content')

<div class="row">
    @if (session('status'))
    <div class="col-12 w-100">
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    </div>
    @endif
</div>
<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Saldo Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> @currency(Auth::user()->balance) </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$transaction->count()}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah Poin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->point }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-gem fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tabungan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"> @currency(Auth::user()->saving_balance)</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-piggy-bank fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Terakhir</h6>
            </div>
            <div class="card-body">
                <div class="chart-area" style="overflow: auto;">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Judul Transaksi</th>
                                <th>Nominal</th>
                                <th>Point</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaction as $t)
                            <tr>
                                <td>{{$t->deskripsi}}</td>
                                <td> @currency($t->nominal)</td>
                                <td> {{$t->point}}</td>
                                <td>{{$t->created_at}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100" class="text-center">Data Kosong</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 text-primary">Target Pengeluaran</h6>
                <small>@currency(Auth::user()->spending_target)</small>
            </div>
            <div class="card-body">
                <div class="mt-1 small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-warning"></i> Total :  @currency(Auth::user()->spending)
                    </span><br>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Sisa  : @currency((Auth::user()->spending_target) - (Auth::user()->spending))
                    </span>
                </div>
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                    <input type="hidden" id="spending" value="{{  Auth::user()->spending }}">
                    <input type="hidden" id="spendingTarget" value="{{  Auth::user()->spending_target }}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ilustrasi</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ asset('img/svg/undraw_online_payments_luau.svg') }}" alt="">
                </div>
                <p>Kalau ada yang praktis, kenapa harus ribet ? <br>
                    Belanja Kapanpun dimanapun.
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Catatan</h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Catatan</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($catatan as $c)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$c->judul}}</td>
                            <td>{{$c->catatan}}</td>
                            <td>
                                <form action="{{url('/dashboard/catatan/finish',$c->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check-circle"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100" class="text-center">Catatan Kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('for-script')
<script>
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#858796';
    var ctx = document.getElementById("myPieChart");
    var spen = document.getElementById("spending").value;
    var targ = document.getElementById("spendingTarget").value;
    var sisa = targ - spen;
    var myPieChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["Total Pengeluaran", "Sisa Pengeluaran"],
        datasets: [{
          data: [spen, sisa, 1],
          backgroundColor: ['#f6c23e', '#1cc88a'],
          hoverBackgroundColor: ['#ffd900', '#17a673'],
          hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: false
        },
        cutoutPercentage: 60,
      },
    });
</script>
@endsection
