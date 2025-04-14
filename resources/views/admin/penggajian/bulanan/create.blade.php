<!-- resources/views/admin/penggajian/bulanan/create.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Penggajian Karyawan Bulanan</h1>
        <a href="{{ route('admin.penggajian.bulanan.index') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Penggajian Bulanan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.penggajian.bulanan.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_karyawan">Karyawan</label>
                            <select class="form-control @error('id_karyawan') is-invalid @enderror" id="id_karyawan" name="id_karyawan" required>
                                <option value="" selected disabled>Pilih Karyawan</option>
                                @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->id_karyawan }}" {{ old('id_karyawan') == $karyawan->id_karyawan ? 'selected' : '' }}>
                                    {{ $karyawan->nama }} - {{ $karyawan->jabatan }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_karyawan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="period">Periode Gaji</label>
                            <select class="form-control @error('period') is-invalid @enderror" id="period" name="period" required>
                                <option value="" selected disabled>Pilih Periode</option>
                                @foreach($months as $key => $month)
                                <option value="{{ $key }}" {{ old('period') == $key ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                                @endforeach
                            </select>
                            @error('period')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_gaji">Jenis Gaji</label>
                            <select class="form-control @error('id_gaji') is-invalid @enderror" id="id_gaji" name="id_gaji" required>
                                <option value="" selected disabled>Pilih Jenis Gaji</option>
                                @foreach($gajis as $gaji)
                                <option value="{{ $gaji->id_gaji }}" {{ old('id_gaji') == $gaji->id_gaji ? 'selected' : '' }}>
                                    {{ $gaji->nama_gaji }} - Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_gaji')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_penggajian">Tanggal Penggajian</label>
                            <input type="date" class="form-control @error('tgl_penggajian') is-invalid @enderror" id="tgl_penggajian" name="tgl_penggajian" value="{{ old('tgl_penggajian', date('Y-m-d')) }}" required>
                            @error('tgl_penggajian')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                <label for="status_penggajian">Status Penggajian</label>
                <select class="form-control @error('status_penggajian') is-invalid @enderror" id="status_penggajian" name="status_penggajian" required>
                    <option value="belum dibayar" {{ old('status_penggajian') == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                    <option value="sudah bayar" {{ old('status_penggajian') == 'sudah bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                </select>
                @error('status_penggajian')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.penggajian.bulanan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // You can add additional JS functionality here if needed
        $('#id_karyawan').select2({
            placeholder: "Pilih Karyawan",
            allowClear: true
        });
    });
</script>
@endsection