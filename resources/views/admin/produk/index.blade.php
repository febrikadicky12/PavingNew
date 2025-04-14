@extends('layouts.master')

@section('title', 'Kelola Produk')

@section('content')
<main id="main" class="main">

<div class="container">
    <h1>Kelola Produk</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Produk</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Produk</h5>

                    <!-- Search Bar -->
                    

                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">Tambah Produk</a>
                    </div>

                    <form action="{{ route('admin.produk.index') }}" method="GET" class="mb-4">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Cari Produk..." name="search" value="{{ $search ?? '' }}">
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Cari
              </button>
              @if(!empty($search))
                <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                  <i class="bi bi-x-circle"></i> Reset
                </a>
              @endif
            </div>
          </form>

                    <!-- Table -->
                    <div class="table-responsive">
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Jenis</th>
                                <th>Harga</th>
                                <th>Ukuran</th>
                                <th>Tipe Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->jenis_produk }}</td>
                                <td>Rp {{ number_format($item->harga_produk, 0, ',', '.') }}</td>
                                <td>{{ $item->ukuran_produk }}</td>
                                <td>{{ ucfirst($item->tipe_harga) }}</td>
                                <td>{{ $item->stok_produk }}</td>
                                <td>
                                    <a href="{{ route('admin.produk.show', $item->id_produk) }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('admin.produk.edit', $item->id_produk) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.produk.destroy', $item->id_produk) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table><!-- End Table -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
