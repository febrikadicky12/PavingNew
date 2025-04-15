@extends('layouts.master')

@section('title', 'Edit Karyawan')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
  <h1>Edit Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Daftar Karyawan</a></li>
      <li class="breadcrumb-item active">Edit Karyawan</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Form Edit Karyawan</h5>

          @if($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row mb-3">
              <label for="name" class="col-sm-2 col-form-label">Nama Lengkap</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="email" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="phone_number" class="col-sm-2 col-form-label">Nomor Telepon</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>
              </div>
            </div>

            <div class="row mb-3">
              <label for="password" class="col-sm-2 col-form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password">
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-2 col-form-label">Role</label>
              <div class="col-sm-10">
                <select class="form-select" id="role" name="role" required>
                  <option value="" disabled>Pilih Role</option>
                  <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                  <option value="karyawan_borongan" {{ (old('role', $user->role) == 'karyawan_borongan') ? 'selected' : '' }}>Karyawan Borongan</option>
                  <option value="karyawan_bulanan" {{ (old('role', $user->role) == 'karyawan_bulanan') ? 'selected' : '' }}>Karyawan Bulanan</option>
                </select>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
@endsection