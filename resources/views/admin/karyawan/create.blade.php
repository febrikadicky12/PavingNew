@extends('layouts.master')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="pagetitle">
  <h1>Tambah Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.karyawan.index') }}">Daftar Karyawan</a></li>
      <li class="breadcrumb-item active">Tambah Karyawan</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Form Tambah Karyawan</h5>

          @if($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Form -->
          <form action="{{ route('admin.karyawan.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-12">
              <div class="form-floating">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
                <label for="nama">Nama Lengkap</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Nomor Telepon" value="{{ old('no_telp') }}" required>
                <label for="no_telp">Nomor Telepon</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating mb-3">
                <select class="form-select" id="status" name="status" aria-label="Status" required>
                  <option value="" selected disabled>Pilih Status</option>
                  <option value="borongan" {{ old('status') == 'borongan' ? 'selected' : '' }}>Karyawan Borongan</option>
                  <option value="bulanan" {{ old('status') == 'bulanan' ? 'selected' : '' }}>Karyawan Bulanan</option>
                </select>
                <label for="status">Status</label>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
          </form>
          <!-- End Form -->
        </div>
      </div>
    </div>
  </div>
</section>
@endsection