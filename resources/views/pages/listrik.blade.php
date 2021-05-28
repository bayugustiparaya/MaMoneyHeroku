@extends('layouts.template')
@section('title', 'Listrik')
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
    <div class="col-12">
        @error('nominal')
        <div class="alert alert-danger">Saldo tidak cukup</div>
        @enderror
    </div>
</div>

@if ($message = Session::get('message'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ $message }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
@endif

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Token Listrik</h1>
</div>

<div class="row">

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Token Listrik</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('/dashboard/listrik')}}" id="form-id">
                    @csrf
                    <div class="form-group">
                        <div class="form-group">
                            <label for="forMeter">No. Meter/ID Pelanggan</label>
                            <input type="text" class="form-control" id="forMeter" name="meter" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="forJml">Jumlah<i>(20000 / 25000 / 50000 / etc)</i></label>
                        <input type="number" class="form-control" id="forJml" name="nominal" required>
                    </div>
                    @if(Auth::user()->saving_before_trans)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                        Beli
                    </button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Yuk Nabung</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <i class="small text-warning">Anda mengaktifkan fitur menabung untuk melanjutkan transaksi. <br> Jika ingin menonaktifkan, sikahkan pergi ke pengaturan akun "Akun Saya".</i>
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15rem;" src="{{ asset('img/svg/undraw_Savings_re_eq4w.svg') }}" alt="">
                                </div>
                                <hr>
                                <label class="form-control-label" for="saving">Jumlah Menabung<span class="small text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp. </span>
                                    </div>
                                    <input type="number" id="saving" class="form-control" name="saving" placeholder="Jumlah tabungan" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Proses</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    @else 
                    <button type="submit" class="btn btn-primary">Beli</button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Ilustrasi</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 20rem;" src="{{ asset('img/svg/undraw_working_late_pukg.svg') }}" alt="">
                </div>
                <p>Cek berkala listrik mu. Jangan sampai mati lampu.</p>
            </div>
        </div>
    </div>

</div>
@endsection

@section('for-script')
<script>  
    $(window).ready(function() { 
    $("#form-id").on("keypress", function (event) { 
        console.log("aaya"); 
        var keyPressed = event.keyCode || event.which; 
        if (keyPressed === 13) { 
            // alert("You pressed the Enter key!!"); 
            event.preventDefault(); 
            return false; 
        } 
    }); 
    }); 

</script>  
@endsection
