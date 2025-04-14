@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detail Nilai Produk') }}</span>
                    <a href="{{ route('admin.nilaiproduk.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">ID Nilai Produk</th>
                            <td>{{ $nilaiProduk->id_nilaiproduk }}</td>
                        </tr>
                        <tr>
                            <th>Nama Produk</th>
                            <td>{{ $nilaiProduk->produk->nama_produk }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Produk</th>
                            <td>{{ $nilaiProduk->produk->jenis_produk }}</td>
                        </tr>
                        <tr>
                            <th>Ukuran Produk</th>
                            <td>{{ $nilaiProduk->produk->ukuran_produk }}</td>
                        </tr>
                        <tr>
                            <th>Harga Produk</th>
                            <td>Rp {{ number_format($nilaiProduk->produk->harga_produk, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Karyawan</th>
                            <td>{{ $nilaiProduk->karyawan->nama }}</td>
                        </tr>
                        <tr>
                            <th>Status Karyawan</th>
                            <td>{{ ucfirst($nilaiProduk->karyawan->status) }}</td>
                        </tr>
                        <tr>
                            <th>No. Telp Karyawan</th>
                            <td>{{ $nilaiProduk->karyawan->no_telp }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('admin.nilaiproduk.edit', $nilaiProduk->id_nilaiproduk) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.nilaiproduk.destroy', $nilaiProduk->id_nilaiproduk) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus nilai produk ini?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection