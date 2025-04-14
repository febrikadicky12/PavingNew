@extends('layouts.master')

@section('title', 'Edit Suplier')

@section('content')
<main id="main" class="main">
<section class="content-section">
    <div class="col-lg-8 mx-auto">
        <h2>Edit Suplier</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
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

            <div class="d-flex justify-content-end mb-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.suplier.index') }}" class="btn btn-secondary ms-2">Batal</a>
            </div>        
        </form>
    </div>
</section>
@endsection
