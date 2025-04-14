@extends('layouts.master')
@section('title', 'Dashboard Admin')
@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Selamat datang, Admin!</p>
        
        <!-- Card untuk stok produk -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Informasi Stok Produk</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($produk as $item)
                                <div class="col-md-3 mb-3">
                                    <div class="card {{ $item->stok_produk <= 0 ? 'border-danger' : ($item->stok_produk <= 10 ? 'border-warning' : 'border-success') }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item->nama_produk }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">{{ $item->jenis_produk }}</h6>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div>
                                                    <span class="badge {{ $item->tipe_harga == 'diskon' ? 'bg-warning' : 'bg-info' }}">
                                                        {{ ucfirst($item->tipe_harga) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="fw-bold">Stok:</span>
                                                    <span class="badge {{ $item->stok_produk <= 0 ? 'bg-danger' : ($item->stok_produk <= 10 ? 'bg-warning' : 'bg-success') }}">
                                                        {{ $item->stok_produk }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        Tidak ada data produk
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection