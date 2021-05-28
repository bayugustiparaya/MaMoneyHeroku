@extends('layouts.template')
@section('title', 'Edit Catatan')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Catatan</h1>
</div>

<div class="card border-left-warning shadow h-100 py-2">
    <div class="card-body">
        <form action="{{url('/dashboard/catatan',$note->id)}}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Judul</label>
                <input value="{{$note->judul}}" name="judul" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <input value="{{$note->id}}" name="id" type="hidden" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Catatan</label>
                <textarea name="catatan" class="form-control" id="exampleFormControlTextarea1" rows="3">{{$note->catatan}}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Update Catatan</button>
        </form>
    </div>
</div>

@endsection