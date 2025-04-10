@extends('layouts.master')

@section('title', 'Edit Mesin')

@section('content')
<main id="main" class="main">
<div class="container mt-4">
    <h1 class="mb-4">Edit Mesin</h1>

    <form action="{{ route('admin.mesin.update', $mesin->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_mesin" class="form-label">Nama Mesin</label>
            <input type="text" name="nama_mesin" class="form-control" value="{{ $mesin->nama_mesin }}" required>
        </div>


        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="baik" {{ $mesin->status == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="tidak baik" {{ $mesin->status == 'tidak baik' ? 'selected' : '' }}>Tidak Baik</option>
            </select>
        </div>

        <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.mesin.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection