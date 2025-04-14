@extends('layouts.master')

@section('title', 'Kelola Bahan')

@section('content')
<main id="main" class="main">

<div class="pagetitle">
    <h1>Kelola Bahan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Bahan</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Daftar Bahan</h5>

                    <div class="row">
                        <div class="col text-end mb-3">
                            <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary">Tambah Bahan</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                    <form action="{{ route('admin.bahan.index') }}" method="GET" class="mb-4">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Cari Bahan..." name="search" value="{{ $search ?? '' }}">
              <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Cari
              </button>
              @if(!empty($search))
                <a href="{{ route('admin.bahan.index') }}" class="btn btn-secondary">
                  <i class="bi bi-x-circle"></i> Reset
                </a>
              @endif
            </div>
          </form>
         
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Table -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Stock</th>
                                <th>Jenis</th>
                                <th>Suplier</th>
                                <th>Harga</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bahan as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->nama_bahan }}</td>
                                <td>{{ $item->stock_bahan }}</td>
                                <td>{{ $item->jenis_bahan }}</td>
                                <td>{{ $item->suplier->nama_suplier ?? 'Tidak ada' }}</td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $item->satuan }}</td>
                                <td>
                                    <a href="{{ route('admin.bahan.edit', $item->id_bahan) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.bahan.destroy', $item->id_bahan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus bahan ini?')">Hapus</button>
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
