@extends('layouts.template')
@section('title', 'Pengeluaran')
@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengeluaran Anda</h1>
</div>

<div class="row">
    
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow">
    
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Pengeluaran</h6>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Judul Transaksi</th>
                                <th>Nominal</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaction as $t)
                            <tr>
                                <td>{{$t->deskripsi}}</td>
                                <td>{{$t->nominal}}</td>
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