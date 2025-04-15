@extends('layouts.master')

@section('title', 'Detail Produksi')

@section('content')
<main id="main" class="main">
<div class="container">
    <h2>Detail Produksi</h2>
    <table class="table">
        <tr>
            <th>Produk</th>
            <td>{{ $produksi->produk->nama_produk }}</td>
        </tr>
        <tr>
            <th>Tanggal Produksi</th>
            <td>{{ $produksi->tanggal_produksi }}</td>
        </tr>
        <tr>
            <th>Jumlah Produksi</th>
            <td>{{ $produksi->jumlah_produksi }}</td>
        </tr>
        <tr>
            <th>Bahan yang Digunakan</th>
            <td>{{ $produksi->bahan->nama_bahan }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($produksi->status_produksi) }}</td>
        </tr>
        <tr>
            <th>Karyawan</th>
            <td>{{ $produksi->karyawan->nama ?? 'Tidak Diketahui' }}</td>
        </tr>
        <tr>
            <th>Mesin</th>
            <td>{{ $produksi->mesin->nama_mesin ?? 'Tidak Diketahui' }}</td>
        </tr>
    </table>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.produksi.index') }}" class="btn btn-secondary">Kembali</a>
    </div> 

</div> 
@endsection
