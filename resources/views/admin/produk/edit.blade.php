@extends('layouts.master')

@section('title', 'Edit Produk')

@section('content')

<div class="pagetitle">
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
                            <input type="number" name="harga_produk" value="{{ old('harga_produk') }}" class="form-control" step="any" min="0" onwheel="this.blur()">
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
                            <input type="number" name="stok_produk" class="form-control" value="{{ $produk->stok_produk }}" required>
                        </div>

                        <button type="submit" class="btn btn-success">Update Produk</button>
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>

                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
