@extends('layouts.master')

@section('title', 'Daftar Mitra')

@section('content')

<div class="pagetitle">
    <h1>Daftar Mitra</h1>
    <a href="{{ route('admin.mitra.create') }}" class="btn btn-primary">Tambah Mitra</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No. Telepon</th>
            <th>Produk</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mitra as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_mitra }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->no_telpon }}</td>
            <td>{{ $item->produk->nama_produk ?? 'Tidak ada' }}</td>
            <td>
                <a href="{{ route('admin.mitra.edit', $item->id_mitra) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.mitra.destroy', $item->id_mitra) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
