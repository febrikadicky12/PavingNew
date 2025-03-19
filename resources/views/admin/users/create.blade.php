@extends('layouts.master')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="pagetitle">
  <h1>Tambah Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Dashboard</a></li>
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
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Form -->
          <form action="{{ route('admin.users.store') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-12">
              <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                <label for="name">Nama Lengkap</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                <label for="email">Email</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating mb-3">
                <select class="form-select" id="role" name="role" aria-label="Role" required>
                  <option value="" selected disabled>Pilih Role</option>
                  <option value="karyawan_borongan" {{ old('role') == 'karyawan_borongan' ? 'selected' : '' }}>Karyawan Borongan</option>
                  <option value="karyawan_bulanan" {{ old('role') == 'karyawan_bulanan' ? 'selected' : '' }}>Karyawan Bulanan</option>
                </select>
                <label for="role">Role</label>
              </div>
            </div>
            <div class="text-start">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
            </div>
          </form>
          <!-- End Form -->
        </div>
      </div>
    </div>
  </div>
</section>
@endsection