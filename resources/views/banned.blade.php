@extends('layouts.template')
@section('title', 'Account Banned')
@section('content')

<div class="row d-flex justify-content-center">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4 ">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Banned</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;" src="{{ asset('img/svg/undraw_warning_cyit.svg') }}" alt="">
                </div>
                <p class="text-center">Akun anda saat ini ber-status tidak aktif / <b>banned</b>. <br>
                Silahkan hubungi Admin <br><br>
                Hal ini mungkin terjadi kesalahan pada akun anda</p>
            </div>
        </div>
    </div>
</div>

@endsection
