@extends('layouts.master')

@section('title', 'Detail Karyawan')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
  <h1>Detail Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Daftar Karyawan</a></li>
      <li class="breadcrumb-item active">Detail Karyawan</li>
    </ol>
  </nav>
</div>

<section class="section profile">
  <div class="row">
    <div class="col-xl-4">
      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
          <h2>{{ $user->name }}</h2>
          <div class="pt-2">
            @if($user->role == 'admin')
              <span class="badge bg-primary">Admin</span>
            @elseif($user->role == 'karyawan_borongan')
              <span class="badge bg-success">Karyawan Borongan</span>
            @elseif($user->role == 'karyawan_bulanan')
              <span class="badge bg-info">Karyawan Bulanan</span>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-8">
      <div class="card">
        <div class="card-body pt-3">
          <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Ringkasan</button>
            </li>
          </ul>
          
          <div class="tab-content pt-2">
            <div class="tab-pane fade show active profile-overview" id="profile-overview">
              <h5 class="card-title">Detail Profil</h5>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Nama Lengkap</div>
                <div class="col-lg-9 col-md-8">{{ $user->name }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Email</div>
                <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Nomor Telepon</div>
<<<<<<< HEAD
                <div class="col-lg-9 col-md-8">{{ $user->phone_number ?? '-' }}</div>
=======
                <div class="col-lg-9 col-md-8">{{ $user->phone_number }}</div>
>>>>>>> d76b8a2b8e63c4187c6e59c3e92145e9a9e5c106
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Role</div>
                <div class="col-lg-9 col-md-8">
                  @if($user->role == 'admin')
                    Admin
                  @elseif($user->role == 'karyawan_borongan')
                    Karyawan Borongan
                  @elseif($user->role == 'karyawan_bulanan')
                    Karyawan Bulanan
                  @endif
                </div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Dibuat Pada</div>
                <div class="col-lg-9 col-md-8">{{ $user->created_at->format('d M Y, H:i') }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Diperbarui Pada</div>
                <div class="col-lg-9 col-md-8">{{ $user->updated_at->format('d M Y, H:i') }}</div>
              </div>

<<<<<<< HEAD
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                   Kembali
                </a>
=======
              <div class="row mt-3">
                <div class="col-lg-12">
                  <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                     <i class="bi bi-pencil"></i> Edit
                  </a>
                  <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                     <i class="bi bi-arrow-left"></i> Kembali
                  </a>
                </div>
>>>>>>> d76b8a2b8e63c4187c6e59c3e92145e9a9e5c106
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
@endsection