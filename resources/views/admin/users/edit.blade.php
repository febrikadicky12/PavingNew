@extends('layouts.master')

@section('title', 'Edit Karyawan')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
  <h1>Edit Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Dashboard</a></li>
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
              <ul class="mb-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <!-- Form -->
          <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="row g-3">
            @csrf
            @method('PUT')
            <div class="col-md-12">
              <div class="form-floating">
                <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}" required>
                <label for="name">Nama Lengkap</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}" required>
                <label for="email">Email</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomor Telepon" value="{{ old('phone', $user->phone) }}" required>
                <label for="phone">Nomor Telepon</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating mb-3">
                <select class="form-select" id="role" name="role" aria-label="Role" required>
                  <option value="" disabled>Pilih Role</option>
                  <option value="karyawan_borongan" {{ old('role', $user->role) == 'karyawan_borongan' ? 'selected' : '' }}>Karyawan Borongan</option>
                  <option value="karyawan_bulanan" {{ old('role', $user->role) == 'karyawan_bulanan' ? 'selected' : '' }}>Karyawan Bulanan</option>
                </select>
                <label for="role">Role</label>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Perbarui</button>
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