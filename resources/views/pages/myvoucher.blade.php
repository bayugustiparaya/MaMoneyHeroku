@extends('layouts.template')
@section('title', 'Voucher')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Voucher Saya</h1> 
</div>

@if (session('pesan'))
<div class="row">
    <div class="col-12 w-100">
        <div class="alert alert-danger">
            {{ session('pesan') }}
        </div>
    </div>
</div>
@endif

<div class="card-columns">
    @forelse($myvouchers as $mv)
    <div class="card">

        <?php
            $expired = true;
            $imageReference = app('firebase.storage')->getBucket()->object('img/'.$mv->image);
            if($imageReference->exists()) {
                $expiresAt = new \DateTime('tomorrow');
                $image = $imageReference->signedUrl($expiresAt);
                $expired = false;
            } else {
                $image = "img/svg/undraw_empty_xct9.svg";
            }
        ?>

        <img src="{{ asset($image) }}" class="card-img-top" alt="{{ $image }}">
        <div class="card-body">
            <p class="card-text">{{ $mv->voucher_name }} <br> 
            {{-- <small class="text-muted">{{ $mv->kode }}</small> --}}
            </p>

            @if ($expired)
            <button type="button" class="btn btn-danger btn-sm" disabled>
                Expired Barcode
            </button>    
            @else
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mdl{{ $mv->id }}">
                Scan Barcode
            </button>
            @endif
            
            
            <!-- Modal -->
            <div class="modal fade" id="mdl{{$mv->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="mdl{{$mv->id}}Label">{{ $mv->voucher_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center">
                            <?php 
                            echo DNS2D::getBarcodeHTML($mv->kode, 'QRCODE');
                            ?>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">{{ $mv->kode }}</small>
                        </div>
                    </div>
                </div>
                </div>
            </div>

        </div>
    </div>
    
    @empty
        <label>Belum ada voucher nih... <br> Yuk tukarkan poin mu!!</label>
    @endforelse
</div>

@endsection
