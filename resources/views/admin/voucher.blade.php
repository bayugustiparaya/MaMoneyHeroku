@extends('layouts.template')
@section('title', 'Data Voucher')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Voucher</h1>
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

<a class="btn btn-primary mx-2 my-2" href="{{ route('admin.voucher.add') }}">Tambah Voucher</a>

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
                                <th scope="col">Point</th>
                                <th scope="col">Image</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($voucher as $v)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$v->name}}</td>
                                <td>{{$v->point}}</td>

                            <?php
                                $expiresAt = new \DateTime('tomorrow');
                                $imageReference = app('firebase.storage')->getBucket()->object('img/'.$v->image);
                                if($imageReference->exists()) {
                                    $image = $imageReference->signedUrl($expiresAt);
                                } else {
                                    $image = "YNTKTS";
                                }

                            ?>
                                <td>
                                    <a href="{{ $image }}" target="_blank"><img src={{ $image }} alt="{{ $image }}" class="rounded" height="170px" ></a>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{url('/admin/voucher',$v->id)}}" title="Edit" class="mx-1 btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="{{url('/admin/voucher/del',$v->id)}}" title="Delete" class="mx-1 btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
