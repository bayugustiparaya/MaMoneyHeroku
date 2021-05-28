@extends('layouts.template')
@section('title', 'Data Pengguna')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengguna</h1>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 mb-2">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h5>Info</h5>
                <div class="small">
                    <i class="fas fa-lock-open"></i>&nbsp;  <i>Akun Aktif</i>
                </div>
                <div class="small">
                    <i class="fas fa-lock"></i>&nbsp;  <i>Akun Non-Aktif</i>
                </div>
                <div class="small">
                    <i class="fas fa-key"></i>&nbsp;  <i>Reset Password (12345678)</i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if (session('pesan'))
    <div class="col-12 w-100">
        <div class="alert alert-success">
            {{ session('pesan') }}
        </div>
    </div>
    @endif
</div>

<div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow">        
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">E-Mail</th>
                                <th scope="col">Saldo</th>
                                <th scope="col">Tabungan</th>
                                <th scope="col">Point</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $usr)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$usr->name}}</td>
                                <td>{{$usr->email}}</td>
                                <td>@currency($usr->balance)</td>
                                <td>@currency($usr->saving_balance)</td>
                                <td>{{$usr->point}}</td>
                                @if ($usr->is_active)
                                <td><i class="fas fa-lock-open"></i>&nbsp;<i>Aktif</i></td>
                                @else
                                <td><i class="fas fa-lock"></i>&nbsp;<i>Non-Aktif</i></td>
                                @endif
                                <td>
                                    <div class="d-flex">
                                        <a href="{{url('/admin/users/pswd',$usr->id)}}" title="Reset Password" class="mx-1 btn btn-warning btn-sm"><i class="fas fa-key"></i></a>
                                        @if ($usr->is_active)
                                        <a href="{{url('/admin/users/status',$usr->id)}}" title="Non-Aktifkan Akun" class="mx-1 btn btn-danger btn-sm"><i class="fas fa-lock"></i></a>
                                        @else
                                        <a href="{{url('/admin/users/status',$usr->id)}}" title="Aktifkan Akun" class="mx-1 btn btn-danger btn-sm"><i class="fas fa-lock-open"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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
