@extends('layouts.template')
@section('title', 'Tambah Catatan')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Catatan</h1>
</div>

<div class="card border-left-warning shadow h-100 py-2">
    <div class="card-body">
        <form action="{{url('/dashboard/tambah-catatan')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="forJudul">Judul</label>
                <input name="judul" type="text" class="form-control" id="forJudul" required>
            </div>
            <div class="form-group">
                <label for="forDesc">Catatan</label>
                <textarea name="catatan" class="form-control" id="forDesc" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Tambah Catatan</button>
        </form>
    </div>
</div>

@endsection