@extends('layouts.master')

@section('title', 'Edit Produk')

@section('content')

<div class="container">
    <h1>Edit Produk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">Edit Produk</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Edit Produk</h5>

                    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Produk</label>
                            <input type="text" name="jenis_produk" class="form-control" value="{{ $produk->jenis_produk }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Produk</label>
                            <input type="text" name="harga_produk" class="form-control" value="{{ $produk->harga_produk }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ukuran Produk</label>
                            <input type="text" name="ukuran_produk" class="form-control" value="{{ $produk->ukuran_produk }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Harga</label>
                            <select name="tipe_harga" class="form-control" required>
                                <option value="reguler" {{ $produk->tipe_harga == 'reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="diskon" {{ $produk->tipe_harga == 'diskon' ? 'selected' : '' }}>Diskon</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok Produk</label>
                            <input type="text" name="stok_produk" class="form-control" value="{{ $produk->stok_produk }}" required>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-primary">Update Produk</button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                        
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
