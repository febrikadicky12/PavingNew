<!-- resources/views/admin/produksi/create.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
<<<<<<< HEAD
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
=======
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Tambah Data Produksi') }}</span>
                    <a href="{{ route('admin.produksi.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.produksi.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="id_produk" class="col-md-4 col-form-label text-md-right">{{ __('Produk') }}</label>

                            <div class="col-md-6">
                                <select id="id_produk" class="form-control @error('id_produk') is-invalid @enderror" name="id_produk" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->id_produk }}" {{ old('id_produk') == $produk->id_produk ? 'selected' : '' }}>
                                            {{ $produk->nama_produk }} - {{ $produk->jenis_produk }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('id_produk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="tanggal_produksi" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Produksi') }}</label>

                            <div class="col-md-6">
                                <input id="tanggal_produksi" type="date" class="form-control @error('tanggal_produksi') is-invalid @enderror" name="tanggal_produksi" value="{{ old('tanggal_produksi', date('Y-m-d')) }}" required>

                                @error('tanggal_produksi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="jumlah_produksi" class="col-md-4 col-form-label text-md-right">{{ __('Jumlah Produksi') }}</label>

                            <div class="col-md-6">
                                <input id="jumlah_produksi" type="number" min="1" class="form-control @error('jumlah_produksi') is-invalid @enderror" name="jumlah_produksi" value="{{ old('jumlah_produksi') }}" required>

                                @error('jumlah_produksi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="status_produksi" class="col-md-4 col-form-label text-md-right">{{ __('Status Produksi') }}</label>

                            <div class="col-md-6">
                                <select id="status_produksi" class="form-control @error('status_produksi') is-invalid @enderror" name="status_produksi" required>
                                    <option value="">Pilih Status</option>
                                    <option value="sudah" {{ old('status_produksi') == 'sudah' ? 'selected' : '' }}>Sudah</option>
                                    <option value="proses" {{ old('status_produksi') == 'proses' ? 'selected' : '' }}>Proses</option>
                                </select>

                                @error('status_produksi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="id_bahan" class="col-md-4 col-form-label text-md-right">{{ __('Bahan') }}</label>

                            <div class="col-md-6">
                                <select id="id_bahan" class="form-control @error('id_bahan') is-invalid @enderror" name="id_bahan" required>
                                    <option value="">Pilih Bahan</option>
                                    @foreach($bahans as $bahan)
                                        <option value="{{ $bahan->id_bahan }}" {{ old('id_bahan') == $bahan->id_bahan ? 'selected' : '' }}>
                                            {{ $bahan->nama_bahan }} (Stok: {{ $bahan->stock_bahan }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('id_bahan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="id_karyawan" class="col-md-4 col-form-label text-md-right">{{ __('Karyawan') }}</label>

                            <div class="col-md-6">
                                <select id="id_karyawan" class="form-control @error('id_karyawan') is-invalid @enderror" name="id_karyawan" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id_karyawan }}" {{ old('id_karyawan') == $karyawan->id_karyawan ? 'selected' : '' }}>
                                            {{ $karyawan->nama }} - {{ $karyawan->status }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('id_karyawan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="id_mesin" class="col-md-4 col-form-label text-md-right">{{ __('Mesin') }}</label>

                            <div class="col-md-6">
                                <select id="id_mesin" class="form-control @error('id_mesin') is-invalid @enderror" name="id_mesin" required>
                                    <option value="">Pilih Mesin</option>
                                    @foreach($mesins as $mesin)
                                        <option value="{{ $mesin->id }}" {{ old('id_mesin') == $mesin->id ? 'selected' : '' }}>
                                            {{ $mesin->nama_mesin }} ({{ $mesin->status_mesin }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('id_mesin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="id_totalproduksi" class="col-md-4 col-form-label text-md-right">{{ __('Total Produksi') }}</label>

                            <div class="col-md-6">
                                <select id="id_totalproduksi" class="form-control @error('id_totalproduksi') is-invalid @enderror" name="id_totalproduksi" required>
                                    <option value="">Pilih Total Produksi</option>
                                    @foreach($totalProduksis as $totalProduksi)
    <option value="{{ $totalProduksi->id_totalproduksi }}" {{ old('id_totalproduksi') == $totalProduksi->id_totalproduksi ? 'selected' : '' }}>
        {{ $totalProduksi->karyawan ? $totalProduksi->karyawan->nama : 'No Karyawan' }} - {{ date('d-m-Y', strtotime($totalProduksi->periode_produksi)) }}
    </option>
@endforeach
                                </select>

                                @error('id_totalproduksi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Simpan') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
>>>>>>> d76b8a2b8e63c4187c6e59c3e92145e9a9e5c106
