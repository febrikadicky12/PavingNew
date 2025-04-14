<!-- resources/views/admin/penggajian/bulanan/edit.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Penggajian Karyawan Bulanan</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Penggajian</h6>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Informasi Karyawan</h5>
                            <p class="mb-1"><strong>Nama:</strong> {{ $penggajian->karyawan->nama }}</p>
                            <p class="mb-1"><strong>Jabatan:</strong> {{ $penggajian->karyawan->jabatan }}</p>
                            <p class="mb-1"><strong>Periode:</strong> {{ $penggajian->periode_gaji->format('F Y') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Informasi Absensi</h5>
                            <p class="mb-1"><strong>Hadir:</strong> {{ $penggajian->rekapAbsen->jumlah_hadir }} hari</p>
                            <p class="mb-1"><strong>Izin:</strong> {{ $penggajian->rekapAbsen->jumlah_izin }} hari</p>
                            <p class="mb-1"><strong>Alpa:</strong> {{ $penggajian->rekapAbsen->jumlah_alpa }} hari</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.penggajian.bulanan.update', $penggajian->id_penggajian) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_gaji">Jenis Gaji</label>
                            <select class="form-control @error('id_gaji') is-invalid @enderror" id="id_gaji" name="id_gaji" required>
                                @foreach($gajis as $gaji)
                                <option value="{{ $gaji->id_gaji }}" {{ old('id_gaji', $penggajian->id_gaji) == $gaji->id_gaji ? 'selected' : '' }}>
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
                            <input type="date" class="form-control @error('tgl_penggajian') is-invalid @enderror" id="tgl_penggajian" name="tgl_penggajian" value="{{ old('tgl_penggajian', $penggajian->tgl_penggajian->format('Y-m-d')) }}" required>
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
                        <option value="belum dibayar" {{ old('status_penggajian', $penggajian->status_penggajian) == 'belum dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="sudah bayar" {{ old('status_penggajian', $penggajian->status_penggajian) == 'sudah bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                    </select>
                    @error('status_penggajian')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.penggajian.bulanan.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection