@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tambah Data Total Produksi') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.totalproduksi.store') }}">
                        @csrf

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
                            <label for="periode_produksi" class="col-md-4 col-form-label text-md-right">{{ __('Periode Produksi') }}</label>

                            <div class="col-md-6">
                                <input id="periode_produksi" type="date" class="form-control @error('periode_produksi') is-invalid @enderror" name="periode_produksi" value="{{ old('periode_produksi', date('Y-m-d')) }}" required>

                                @error('periode_produksi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
    <label for="id_gaji" class="col-md-4 col-form-label text-md-right">{{ __('Gaji') }}</label>
    <div class="col-md-6">
        <select id="id_gaji" class="form-control @error('id_gaji') is-invalid @enderror" name="id_gaji" required>

            {{-- Opsi default (di luar loop) --}}
            <option value="">Pilih Gaji</option>

            {{-- Mulai loop di sini --}}
            @foreach($gajis as $gaji) 
                {{-- Baris <option> HARUS berada DI DALAM @foreach --}}
                <option value="{{ $gaji->id_gaji }}" {{ old('id_gaji') == $gaji->id_gaji ? 'selected' : '' }}>
                    @if ($gaji->jenis_karyawan == 'bulanan')
                        Bulanan - Gaji Pokok: Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }} 
                    @else {{-- Jika borongan --}}
                        Borongan - Tarif: Rp {{ number_format($gaji->tarif_produksi, 0, ',', '.') }}
                    @endif
                    (ID: {{ $gaji->id_gaji }}) 
                </option>
                {{-- Akhir baris <option> --}}
            @endforeach 
            {{-- Akhir loop di sini --}}

        </select> {{-- Akhir select --}}

        @error('id_gaji')
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
                                <a href="{{ route('admin.totalproduksi.index') }}" class="btn btn-secondary">
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
