@extends('layouts.master')

@section('title', 'Edit Suplier')

@section('content')
<section class="content-section">
<div class="row">
    <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm rounded-lg p-4">
        <h2>Edit Suplier</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.suplier.update', $suplier->id_suplier) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>Nama Suplier</label>
                <input type="text" name="nama_suplier" class="form-control" 
                       value="{{ old('nama_suplier', $suplier->nama_suplier) }}" required>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" 
                       value="{{ old('alamat', $suplier->alamat) }}" required>
            </div>

            <div class="mb-3">
                <label>No Telp</label>
                <input type="text" name="no_telp" class="form-control" 
                       value="{{ old('no_telp', $suplier->no_telp) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</section>
@endsection
