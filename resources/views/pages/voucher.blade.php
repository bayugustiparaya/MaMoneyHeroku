@extends('layouts.template')
@section('title', 'Voucher')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tukar Point dengan Voucher</h1> 
</div>

<div class="row">
    @if (session('pesan'))
    <div class="col-12 w-100">
        <div class="alert alert-danger">
            {{ session('pesan') }}
        </div>
    </div>
    @endif
</div>
<div class="row">
    <div class="col-xl-2 col-md-4 mb-4 order-xl-2 order-xl-2">
        <div class="card border-left-warning shadow py-2">
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
    <div class="card shadow col-xl-10 col-md-8 order-xl-1 order-lg-1 pt-2 mb-4">
        <div class="card-columns">
            @forelse($vouchers as $v)
            <div class="card shadow mx-1 my-1">
                <?php
                    $expiresAt = new \DateTime('tomorrow');
                    $imageReference = app('firebase.storage')->getBucket()->object('img/'.$v->image);
                    if($imageReference->exists()) {
                        $image = $imageReference->signedUrl($expiresAt);
                    } else {
                        $image = "YNTKTS";
                    }
                ?>
                <img src="{{ $image }}" class="card-img-top" alt="{{ $image }}">
                <div class="card-body">
                    <h5 class="text-dark">{{ $v->name }}</h5>
                    <div class="d-flex justify-content-between ">
                        <div style="font-size: 1em;" class="align-self-center card-text text-danger">{{ $v->point }} Point</div>
                        @if ($v->point > Auth::user()->point)
                            <small class="small"> {{ (Auth::user()->point -  $v->point) }} point </small>
                        @endif
                        <a href="{{url('/dashboard/voucher/buy',$v->id)}}" class="btn btn-success">Beli</a>
                    </div>
                </div>
            </div>
            @empty
                <label>Voucher lagi kosong, sabar ya</label>
            @endforelse
        </div>
    </div>
</div>
@endsection
