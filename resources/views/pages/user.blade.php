@extends('layouts.template')
@section('title', 'User')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">User</h1>

</div>

<!-- Content Row -->
<div class="row">






</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail User</h6>

            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <img src="{{url('tampilan/img/user.jpg')}}" class="img-fluid rounded" alt="">
                    </div>
                    <div class="col-9 d-flex align-items-center">
                        <div>
                            <h5 class="text-dark"><b>{{$user->name}}</b></h5>
                            <p>{{$user->email}}</p>
                            <p>{{$user->point}}</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


@endsection