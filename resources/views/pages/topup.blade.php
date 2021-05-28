@extends('layouts.template')
@section('title', 'Topup')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Topup</h1>
</div>

<div class="row">

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Topup</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('/dashboard/topup')}}">
                    @csrf
                    <div class="form-group">
                        <label for="forBank">Bank - Rekening</label>
                        <select class="form-control" name="bank" id="forBank" required>
                            <option>BCA - 0028 87277</option>
                            <option>BNI - 288298 92</option>
                            <option>BRI - 22 2989 99</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="forNominal">Nominal</label>
                        <input name="nominal" type="number" class="form-control" id="forNominal" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Topup</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Petunjuk</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;" src="{{ asset('img/svg/undraw_wallet_aym5.svg') }}" alt="">
                </div>
                <p>Silahkan transfer topup ke rekening sesuai bank yang diinginkan , Bank akan memproses secara realtime</p>
            </div>
        </div>
    </div>
    
</div>
@endsection
