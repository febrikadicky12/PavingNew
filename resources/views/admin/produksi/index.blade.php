<!-- resources/views/admin/produksi/index.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Data Produksi') }}</span>
                    <a href="{{ route('admin.produksi.create') }}" class="btn btn-primary btn-sm">Tambah Produksi</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.produksi.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari produksi..." name="search" value="{{ $search }}">
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
                                    <th>Produk</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Bahan</th>
                                    <th>Karyawan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produksi as $index => $item)
                                    <tr>
                                        <td>{{ $produksi->firstItem() + $index }}</td>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->tanggal_produksi)) }}</td>
                                        <td>{{ $item->jumlah_produksi }}</td>
                                        <td>
                                            <span class="badge {{ $item->status_produksi == 'sudah' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $item->status_produksi }}
                                            </span>
                                        </td>
                                        <td>{{ optional($item->bahan)->nama_bahan ?? 'Tidak tersedia' }}</td>
                                        <td>{{ optional($item->karyawan)->nama ?? 'Tidak tersedia' }}</td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.produksi.show', $item->id_produksi) }}" class="btn btn-info btn-sm">Detail</a>
                                                <a href="{{ route('admin.produksi.edit', $item->id_produksi) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.produksi.destroy', $item->id_produksi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data produksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $produksi->appends(['search' => $search])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection