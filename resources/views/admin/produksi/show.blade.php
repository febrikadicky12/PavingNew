<<<<<<< HEAD
@extends('layouts.master')

@section('title', 'Detail Produksi')

@section('content')
<main id="main" class="main">
<div class="container">
    <h2>Detail Produksi</h2>
    <table class="table">
        <tr>
            <th>Produk</th>
            <td>{{ $produksi->produk->nama_produk }}</td>
        </tr>
        <tr>
            <th>Tanggal Produksi</th>
            <td>{{ $produksi->tanggal_produksi }}</td>
        </tr>
        <tr>
            <th>Jumlah Produksi</th>
            <td>{{ $produksi->jumlah_produksi }}</td>
        </tr>
        <tr>
            <th>Bahan yang Digunakan</th>
            <td>{{ $produksi->bahan->nama_bahan }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($produksi->status_produksi) }}</td>
        </tr>
        <tr>
            <th>Karyawan</th>
            <td>{{ $produksi->karyawan->nama ?? 'Tidak Diketahui' }}</td>
        </tr>
        <tr>
            <th>Mesin</th>
            <td>{{ $produksi->mesin->nama_mesin ?? 'Tidak Diketahui' }}</td>
        </tr>
    </table>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.produksi.index') }}" class="btn btn-secondary">Kembali</a>
    </div> 

</div> 
@endsection
=======
<!-- resources/views/admin/produksi/show.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detail Produksi') }}</span>
                    <a href="{{ route('admin.produksi.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">ID Produksi</th>
                            <td>{{ $produksi->id_produksi }}</td>
                        </tr>
                        <tr>
                            <th>Produk</th>
                            <td>{{ $produksi->produk->nama_produk }} - {{ $produksi->produk->jenis_produk }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Produksi</th>
                            <td>{{ date('d-m-Y', strtotime($produksi->tanggal_produksi)) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Produksi</th>
                            <td>{{ $produksi->jumlah_produksi }}</td>
                        </tr>
                        <tr>
                            <th>Status Produksi</th>
                            <td>
                                <span class="badge {{ $produksi->status_produksi == 'sudah' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $produksi->status_produksi }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Bahan</th>
                            <td>{{ $produksi->bahan->nama_bahan ?? '-' }}</td>

                        </tr>
                        <tr>
                            <th>Karyawan</th>
                            <td>{{ $produksi->karyawan->nama }} ({{ $produksi->karyawan->status }})</td>
                        </tr>
                        <tr>
                            <th>Mesin</th>
                            <td>{{ $produksi->mesin->nama_mesin }}</td>
                        </tr>
                        <tr>
                            <th>Total Produksi</th>
                            <td>{{ $produksi->totalProduksi->karyawan->nama }} - {{ date('d-m-Y', strtotime($produksi->totalProduksi->periode_produksi)) }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>{{ $produksi->created_at ? date('d-m-Y H:i:s', strtotime($produksi->created_at)) : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diperbarui Pada</th>
                            <td>{{ $produksi->updated_at ? date('d-m-Y H:i:s', strtotime($produksi->updated_at)) : '-' }}</td>
                        </tr>
                    </table>

                    <div class="mt-3 d-flex">
                        <a href="{{ route('admin.produksi.edit', $produksi->id_produksi) }}" class="btn btn-warning me-2">Edit</a>
                        <form action="{{ route('admin.produksi.destroy', $produksi->id_produksi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
>>>>>>> d76b8a2b8e63c4187c6e59c3e92145e9a9e5c106
