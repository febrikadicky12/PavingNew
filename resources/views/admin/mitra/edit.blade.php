@extends('layouts.master')

@section('title', 'Edit Mitra')

@section('content')

<div class="pagetitle">
    <h1>Edit Mitra</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.mitra.index') }}">Mitra</a></li>
            <li class="breadcrumb-item active">Edit Mitra</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Edit Mitra</h5>

                    <form action="{{ route('admin.mitra.update', $mitra->id_mitra) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Mitra</label>
                            <input type="text" name="nama_mitra" class="form-control" value="{{ old('nama_mitra', $mitra->nama_mitra) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $mitra->alamat) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="no_telpon" class="form-control" value="{{ old('no_telpon', $mitra->no_telpon) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Produk</label>
                            <select name="id_produk" class="form-control" required>
                                <option value="" disabled>Pilih Produk</option>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->id_produk }}" {{ $mitra->id_produk == $p->id_produk ? 'selected' : '' }}>
                                        {{ $p->nama_produk }}
                                    </option>
                                @endforeach  
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.mitra.index') }}" class="btn btn-secondary">Batal</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
