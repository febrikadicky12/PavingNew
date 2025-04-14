@extends('layouts.master')

@section('title', 'Tambah Karyawan')

@section('content')
<<<<<<< HEAD

=======
<main id="main" class="main">
>>>>>>> 3837196eef8476f2d5ba08269722bc426acc43d7
<div class="pagetitle">
  <h1>Tambah Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Daftar Karyawan</a></li>
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
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
              <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="phone_number" class="col-sm-2 col-form-label">Nomor Telepon</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
              </div>
            </div>
<<<<<<< HEAD

            <div class="row mb-3">
              <label for="password" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Role</label>
              <div class="col-sm-10">
                <select class="form-select" name="role" required>
                  <option selected disabled>Pilih Role</option>
=======
            <div class="col-md-12">
              <div class="form-floating">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomor Telepon" value="{{ old('phone') }}" required>
                <label for="phone">Nomor Telepon</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating mb-3">
                <select class="form-select" id="role" name="role" aria-label="Role" required>
                  <option value="" selected disabled>Pilih Role</option>
>>>>>>> 3837196eef8476f2d5ba08269722bc426acc43d7
                  <option value="karyawan_borongan" {{ old('role') == 'karyawan_borongan' ? 'selected' : '' }}>Karyawan Borongan</option>
                  <option value="karyawan_bulanan" {{ old('role') == 'karyawan_bulanan' ? 'selected' : '' }}>Karyawan Bulanan</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection