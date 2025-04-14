@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Manajemen Nilai Produk') }}</span>
                    <a href="{{ route('admin.nilaiproduk.create') }}" class="btn btn-primary btn-sm">Tambah Nilai Produk</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.nilaiproduk.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama produk atau karyawan..." value="{{ request('search') }}">
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
                                    <th>Nama Produk</th>
                                    <th>Nama Karyawan</th>
                                    <th>Status Karyawan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($nilaiProduks as $index => $nilaiProduk)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $nilaiProduk->produk->nama_produk }}</td>
                                        <td>{{ $nilaiProduk->karyawan->nama }}</td>
                                        <td>{{ ucfirst($nilaiProduk->karyawan->status) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.nilaiproduk.show', $nilaiProduk->id_nilaiproduk) }}" class="btn btn-info btn-sm">Detail</a>
                                                <a href="{{ route('admin.nilaiproduk.edit', $nilaiProduk->id_nilaiproduk) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.nilaiproduk.destroy', $nilaiProduk->id_nilaiproduk) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus nilai produk ini?')">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data nilai produk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $nilaiProduks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection