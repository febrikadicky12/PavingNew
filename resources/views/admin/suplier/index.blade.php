@extends('layouts.master')

@section('title', 'Daftar Suplier')

@section('content')
<div class="container mt-4">
    <h2>Daftar Suplier</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="d-flex justify-content-end mb-3">
    <a href="{{ route('admin.suplier.create') }}" class="btn btn-primary mb-3">Tambah Suplier</a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supliers as $suplier)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $suplier->nama_suplier }}</td>
                    <td>{{ $suplier->alamat }}</td>
                    <td>{{ $suplier->no_telp }}</td>
                    <td>
                        <a href="{{ route('admin.suplier.edit', $suplier->id_suplier) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.suplier.destroy', $suplier->id_suplier) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
