<<<<<<< HEAD
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
=======
<!-- resources/views/admin/produksi/index.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Data Produksi') }}</span>
                    <a href="{{ route('admin.produksi.create') }}" class="btn btn-primary btn-sm">Tambah Produksi</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.produksi.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari produksi..." name="search" value="{{ $search }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Bahan</th>
                                    <th>Karyawan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produksi as $index => $item)
                                    <tr>
                                        <td>{{ $produksi->firstItem() + $index }}</td>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->tanggal_produksi)) }}</td>
                                        <td>{{ $item->jumlah_produksi }}</td>
                                        <td>
                                            <span class="badge {{ $item->status_produksi == 'sudah' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $item->status_produksi }}
                                            </span>
                                        </td>
                                        <td>{{ optional($item->bahan)->nama_bahan ?? 'Tidak tersedia' }}</td>
                                        <td>{{ optional($item->karyawan)->nama ?? 'Tidak tersedia' }}</td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.produksi.show', $item->id_produksi) }}" class="btn btn-info btn-sm">Detail</a>
                                                <a href="{{ route('admin.produksi.edit', $item->id_produksi) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.produksi.destroy', $item->id_produksi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data produksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $produksi->appends(['search' => $search])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
>>>>>>> d76b8a2b8e63c4187c6e59c3e92145e9a9e5c106
