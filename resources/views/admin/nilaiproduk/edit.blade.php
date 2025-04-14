@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Nilai Produk') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.nilaiproduk.update', $nilaiProduk->id_nilaiproduk) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="id_produk" class="col-md-4 col-form-label text-md-right">{{ __('Produk') }}</label>

                            <div class="col-md-6">
                                <select id="id_produk" class="form-control @error('id_produk') is-invalid @enderror" name="id_produk" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach($produks as $produk)
                                        <option value="{{ $produk->id_produk }}" {{ old('id_produk', $nilaiProduk->id_produk) == $produk->id_produk ? 'selected' : '' }}>
                                            {{ $produk->nama_produk }} ({{ $produk->jenis_produk }})
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
                            <label for="id_karyawan" class="col-md-4 col-form-label text-md-right">{{ __('Karyawan') }}</label>

                            <div class="col-md-6">
                                <select id="id_karyawan" class="form-control @error('id_karyawan') is-invalid @enderror" name="id_karyawan" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach($karyawans as $karyawan)
                                        <option value="{{ $karyawan->id_karyawan }}" {{ old('id_karyawan', $nilaiProduk->id_karyawan) == $karyawan->id_karyawan ? 'selected' : '' }}>
                                            {{ $karyawan->nama }} ({{ ucfirst($karyawan->status) }})
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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Perbarui') }}
                                </button>
                                <a href="{{ route('admin.nilaiproduk.index') }}" class="btn btn-secondary">
                                    {{ __('Batal') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection