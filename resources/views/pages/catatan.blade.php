@extends('layouts.template')
@section('title', 'Catatan')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Catatan</h1>
</div>
<a class="btn btn-primary mx-2 my-2" href="{{ route('dashboard.catatan.add') }}">Tambah Catatan</a>

<div class="row">
    
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow">        
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Catatan</th>
                                <th scope="col" >Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($catatan as $c)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td style="<?= $c->is_finished == 1 ? 'text-decoration:line-through' : '' ?>">{{$c->judul}}</td>
                                <td>{{$c->catatan}}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{url('/dashboard/catatan',$c->id)}}" title="Edit" class="mx-1 btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                        <form action="{{url('/dashboard/catatan/finish',$c->id)}}" method="post">
                                            @csrf
                                            <button type="submit" title="Finish" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                                        </form>
                                        <a href="{{url('/dashboard/catatan/del',$c->id)}}" title="Delete" class="mx-1 btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
