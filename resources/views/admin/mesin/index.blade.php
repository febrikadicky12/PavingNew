@extends('layouts.master')

@section('title', 'Data Mesin')

@section('content')
<main id="main" class="main">
<section class="content-section">
    <div class="container mt-4">
        <h2>Data Mesin</h2>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <form action="{{ route('admin.mesin.index') }}" method="GET" class="d-flex">
            </form>
            
            <a href="{{ route('admin.mesin.create') }}" class="btn btn-primary">Tambah Mesin</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mesin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mesins as $mesin)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mesin->nama_mesin }}</td>
                    <td>{{ $mesin->status }}</td>
                    <td>
                        <a href="{{ route('admin.mesin.edit', ['mesin' => $mesin->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.mesin.destroy', $mesin->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus mesin ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
