@extends('layouts.master')

@section('title', 'Tambah Produksi')

@section('content')
<div class="container">
    <h2>Form Tambah Produksi</h2>
    <form action="{{ route('admin.produksi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_produk" class="form-label">ID Produk</label>
            <input type="text" class="form-control" id="id_produk" name="id_produk" value="{{ request('id_produk') }}" readonly>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Produksi</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection