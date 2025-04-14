@extends('layouts.master')

@section('title', 'Tambah Mesin')

@section('content')
<main id="main" class="main">
<div class="container mt-4">
    <h1 class="mb-4">Tambah Mesin</h1>

    <form action="{{ route('admin.mesin.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama_mesin" class="form-label">Nama Mesin</label>
            <input type="text" name="nama_mesin" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="baik">Baik</option>
                <option value="tidak baik">Tidak Baik</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.mesin.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection