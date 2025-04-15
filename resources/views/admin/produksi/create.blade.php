<!-- resources/views/admin/produksi/create.blade.php -->
@extends('layouts.master')

@section('content')
<main id="main" class="main">
<div class="container">
    <h2>Tambah Produksi</h2>
    <form action="{{ route('admin.produksi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Produk:</label>
            <select name="id_produk" class="form-control @error('id_produk') is-invalid @enderror">
                <option value="" disabled selected>Pilih Produk</option>
                @foreach ($produk as $p)
                <option value="{{ $p->id_produk }}" {{ old('id_produk') == $p->id_produk ? 'selected' : '' }}>
                    {{ $p->nama_produk }}
                </option>
                @endforeach
            </select>
            @error('id_produk')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Produksi:</label>
            <input type="date" name="tanggal_produksi" class="form-control @error('tanggal_produksi') is-invalid @enderror" value="{{ old('tanggal_produksi') }}" required>
            @error('tanggal_produksi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Produksi:</label>
            <input type="number" name="jumlah_produksi" class="form-control @error('jumlah_produksi') is-invalid @enderror" value="{{ old('jumlah_produksi') }}" required min="1">
            @error('jumlah_produksi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Bahan yang Digunakan:</label>
            <select name="id_bahan" class="form-control @error('id_bahan') is-invalid @enderror">
                <option value="" disabled selected>Pilih Bahan</option>
                @foreach ($bahan as $b)
                <option value="{{ $b->id_bahan }}" {{ old('id_bahan') == $b->id_bahan ? 'selected' : '' }}>
                    {{ $b->nama_bahan }} (Stok: {{ $b->stock_bahan }})
                </option>
                @endforeach
            </select>
            @error('id_bahan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Karyawan:</label>
            <select name="id_karyawan" class="form-control @error('id_karyawan') is-invalid @enderror">
                <option value="" disabled selected>Pilih Karyawan</option>
                @foreach ($karyawan as $k)
                <option value="{{ $k->id_karyawan }}" {{ old('id_karyawan') == $k->id_karyawan ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
                @endforeach
            </select>
            @error('id_karyawan')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Mesin:</label>
            <select name="id_mesin" class="form-control @error('id_mesin') is-invalid @enderror">
                <option value="" disabled selected>Pilih Mesin</option>
                @foreach ($mesin as $m)
                    @if ($m->status == 'baik')
                        <option value="{{ $m->id }}" {{ old('id_mesin') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama_mesin }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('id_mesin')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status Produksi:</label>
            <select name="status_produksi" class="form-control @error('status_produksi') is-invalid @enderror">
                <option value="" disabled selected>Pilih Status</option>
                <option value="proses" {{ old('status_produksi') == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="sudah" {{ old('status_produksi') == 'sudah' ? 'selected' : '' }}>Sudah</option>
            </select>
            @error('status_produksi')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="id_totalproduksi" class="form-label">Total Produksi:</label>
            <select id="id_totalproduksi" name="id_totalproduksi" class="form-control @error('id_totalproduksi') is-invalid @enderror" required>
                <option value="" disabled selected>Pilih Total Produksi</option>
                @foreach($totalProduksis as $totalProduksi)
                    <option value="{{ $totalProduksi->id_totalproduksi }}" {{ old('id_totalproduksi') == $totalProduksi->id_totalproduksi ? 'selected' : '' }}>
                        {{ $totalProduksi->karyawan ? $totalProduksi->karyawan->nama : 'No Karyawan' }} - {{ \Carbon\Carbon::parse($totalProduksi->periode_produksi)->format('d-m-Y') }}
                    </option>
                @endforeach
            </select>
            @error('id_totalproduksi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mb-3">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.produksi.index') }}" class="btn btn-secondary ms-2">Batal</a>
        </div>
    </form>
</div>
@endsection
