@extends('layouts.master')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Data Pembelian</h3>
                <a href="{{ route('admin.pembelian.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pembelian
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pembelian.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Cari pembelian..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pembelian</th>
                            <th>Supplier</th>
                            <th>Bahan</th>
                            <th>Jumlah</th>
                            <th>Harga Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembelian as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if(isset($item->tgl_pembelian))
                                        {{ \Carbon\Carbon::parse($item->tgl_pembelian)->format('d/m/Y H:i') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                    @endif
                                </td>
                                <td>{{ $item->suplier->nama_suplier ?? 'Data supplier tidak ditemukan' }}</td>
                                <td>{{ $item->bahan ? $item->bahan->nama_bahan : 'Data bahan tidak ditemukan' }}</td>
                                <td>{{ $item->jumlah }} {{ $item->bahan ? $item->bahan->satuan : '-' }}</td>
                                <td>Rp {{ number_format($item->harga_total, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.pembelian.show', $item->id_pembelian) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('admin.pembelian.edit', $item->id_pembelian) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.pembelian.destroy', $item->id_pembelian) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data pembelian</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination (if you have it) -->
            @if(isset($pembelian) && method_exists($pembelian, 'links'))
                <div class="mt-3">
                    {{ $pembelian->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection