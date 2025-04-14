@extends('layouts.master')

@section('title', 'Tambah Produk')

@section('content')
<main id="main" class="main">

<div class="container">
    <h1>Tambah Produk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">Tambah Produk</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
    <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Tambah Produk</h5>

                    <form action="{{ route('admin.produk.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Produk</label>
                            <input type="text" name="jenis_produk" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Produk</label>
                            <input type="text" name="harga_produk" value="{{ old('harga_produk') }}" class="form-control" step="any" min="0" onwheel="this.blur()">
                            </div>

                        <div class="mb-3">
                            <label class="form-label">Ukuran Produk</label>
                            <input type="text" name="ukuran_produk" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Harga</label>
                            <select name="tipe_harga" class="form-select">
                                <option value="reguler">Reguler</option>
                                <option value="diskon">Diskon</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok Produk</label>
                            <input type="text" name="stok_produk" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                        

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
