@extends('layouts.master')

@section('title', 'Detail Produk')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Detail Produk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">Detail Produk</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $produk->nama_produk }}</h5>

                    <p><strong>Jenis:</strong> {{ $produk->jenis_produk }}</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</p>
                    <p><strong>Ukuran:</strong> {{ $produk->ukuran_produk }}</p>
                    <p><strong>Tipe Harga:</strong> {{ ucfirst($produk->tipe_harga) }}</p>
                    <p><strong>Stok:</strong> {{ $produk->stok_produk }}</p>

                    <a href="{{ route('admin.produk.index') }}" class="btn btn-primary">Kembali</a>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
