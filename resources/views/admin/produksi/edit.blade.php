<!-- resources/views/admin/produksi/edit.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Edit Data Produksi') }}</span>
                    <a href="{{ route('admin.produksi.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.produksi.update', $produksi->id_produksi) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="id_produk" class="col-md-4 col-form-label text-md-right">{{ __('Produk') }}</label>

                            <div class="col-md-6">
                                <select id="id_produk" class="form-control @error('id_produk') is-invalid @enderror" name="id_produk" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->id_produk }}" {{ old('id_produk', $produksi->id_produk) == $produk->id_produk ? 'selected' : '' }}>
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
                                <input id="tanggal_produksi" type="date" class="form-control @error('tanggal_produksi') is-invalid @enderror" name="tanggal_produksi" value="{{ old('tanggal_produksi', date('Y-m-d', strtotime($produksi->tanggal_produksi))) }}" required>

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
                                <input id="jumlah_produksi" type="number" min="1" class="form-control @error('jumlah_produksi') is-invalid @enderror" name="jumlah_produksi" value="{{ old('jumlah_produksi', $produksi->jumlah_produksi) }}" required>

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
                                    <option value="sudah" {{ old('status_produksi', $produksi->status_produksi) == 'sudah' ? 'selected' : '' }}>Sudah</option>
                                    <option value="proses" {{ old('status_produksi', $produksi->status_produksi) == 'proses' ? 'selected' : '' }}>Proses</option>
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
                                        <option value="{{ $bahan->id_bahan }}" {{ old('id_bahan', $produksi->id_bahan) == $bahan->id_bahan ? 'selected' : '' }}>
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
                                        <option value="{{ $karyawan->id_karyawan }}" {{ old('id_karyawan', $produksi->id_karyawan) == $karyawan->id_karyawan ? 'selected' : '' }}>
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
                                        <option value="{{ $mesin->id }}" {{ old('id_mesin', $produksi->id_mesin) == $mesin->id ? 'selected' : '' }}>
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
                                        <option value="{{ $totalProduksi->id_totalproduksi }}" {{ old('id_totalproduksi', $produksi->id_totalproduksi) == $totalProduksi->id_totalproduksi ? 'selected' : '' }}>
                                            {{ $totalProduksi->karyawan->nama }} - {{ date('d-m-Y', strtotime($totalProduksi->periode_produksi)) }}
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
                                    {{ __('Update') }}
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