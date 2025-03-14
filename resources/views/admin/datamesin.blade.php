@extends('layouts.master')

@section('title', 'Data Mesin')

@section('content')
<div class="container">
    <h2>Data Mesin</h2>

    <!-- Menambahkan flexbox untuk memberikan jarak antara search dan tombol tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="{{ route('admin.datamesin.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control" placeholder="Cari mesin..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary ms-2">Cari</button>
        </form>
        
        <a href="{{ route('admin.datamesin.create') }}" class="btn btn-success">Tambah Mesin</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Nama Mesin</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        @foreach($mesins as $mesin)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $mesin->nama_mesin }}</td>
            <td>{{ $mesin->status }}</td>
            <td>
                <a href="{{ route('admin.datamesin.edit', $mesin->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.datamesin.destroy', $mesin->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mesin ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection 
