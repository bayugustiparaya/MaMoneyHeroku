@extends('layouts.template')
@section('title', 'Tabungan')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tabungan</h1>
</div>

@if (session('status'))
<div class="row">
    <div class="col-12 w-100">
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
    </div>
</div>
@endif
<div class="row">

    <div class="col-xl-4 col-md-6 mb-4">
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

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Nabung</div>
                        <div class="h5 mb-0 small text-gray-800">{{ __('Tambah Tabungan') }}</div>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#nabung">
                            <i class="fas fa-upload"></i>
                        </button>
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
                            Tarik</div>
                            <div class="h5 mb-0 small text-gray-800">{{ __('Tarik ke saldo aktif') }}</div>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#tarik">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-xl-4 col-lg-5 order-lg-2">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ asset('img/svg/undraw_Savings_re_eq4w.svg') }}" alt="">
                </div>
                <p>Yuk Rajin menabung!! <br>
                    Untuk masa depan yang lebih sejahtera.
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7 order-lg-1">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Tabungan</h6>
            </div>
            <div class="card-body">
                <div class="chart-area" style="overflow: auto; ">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Ket</th>
                                <th>Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaction as $t)
                            <tr>
                                <td>{{$t->created_at}}</td>
                                <td>{{$t->deskripsi}}</td>
                                <td> @currency($t->nominal)</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="100" class="text-center">Belum ada rekap tabungan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Modal --}}

<div class="modal fade" id="nabung" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="nabungLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{url('/dashboard/tabungan')}}" id="form-id">
                @csrf
                <input type="hidden" name="aksi" value="nabung">
                <div class="modal-header">
                    <h5 class="modal-title" id="nabungLabel">Yuk Nabung</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label class="form-control-label" for="saving">Jumlah Menabung<span class="small text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp. </span>
                        </div>
                        <input type="number" id="saving" class="form-control" name="nominal" placeholder="Jumlah penarikan" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
<div class="modal fade" id="tarik" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="tarikLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{url('/dashboard/tabungan')}}" id="form-id">
                @csrf
                <input type="hidden" name="aksi" value="tarik">
                <div class="modal-header">
                <h5 class="modal-title" id="tarikLabel">Penarikan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <label class="form-control-label" for="saving">Jumlah Penarikan ke Saldo Aktif<span class="small text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp. </span>
                        </div>
                        <input type="number" id="saving" class="form-control" name="nominal" placeholder="Jumlah nabung" required>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
            
@endsection

@section('for-script')
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').dataTable( {
            "order": [],
        } );
    });
</script>
@endsection
