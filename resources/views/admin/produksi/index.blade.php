@extends('layouts.master')

@section('title', 'Produksi')

@section('content')
<main id="main" class="main">
    
<div class="container">
    <h1>Kelola Produksi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Produksi</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Produksi</h5>

                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('admin.produksi.create') }}" class="btn btn-primary">Tambah Produksi</a>
                    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produksi as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->produk->nama_produk }}</td>
                <td>{{ $item->tanggal_produksi }}</td>
                <td>{{ $item->jumlah_produksi }}</td>
                <td>{{ ucfirst($item->status_produksi) }}</td>
                <td>
                    <a href="{{ route('admin.produksi.show', $item->id_produksi) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('admin.produksi.edit', $item->id_produksi) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.produksi.destroy', $item->id_produksi) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
