@extends('layouts.master')

@section('title', 'Detail Karyawan')

@section('content')
<div class="pagetitle">
  <h1>Detail Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Dashboard</a></li>
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
          <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
          <h2>{{ $user->name }}</h2>
          <h3>
            @if($user->role == 'karyawan_borongan')
              Karyawan Borongan
            @elseif($user->role == 'karyawan_bulanan')
              Karyawan Bulanan
            @endif
          </h3>
        </div>
      </div>
    </div>

    <div class="col-xl-8">
      <div class="card">
        <div class="card-body pt-3">
          <!-- Bordered Tabs -->
          <ul class="nav nav-tabs nav-tabs-bordered">
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Ringkasan</button>
            </li>
          </ul>
          
          <div class="tab-content pt-3">
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
                <div class="col-lg-9 col-md-8">{{ $user->phone ?? '-' }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Role</div>
                <div class="col-lg-9 col-md-8">
                  @if($user->role == 'karyawan_borongan')
                    <span class="badge bg-success">Karyawan Borongan</span>
                  @elseif($user->role == 'karyawan_bulanan')
                    <span class="badge bg-info">Karyawan Bulanan</span>
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

                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                  <i class="bi bi-arrow-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <!-- End Bordered Tabs -->
        </div>
      </div>
    </div>
  </div>
</section>
@endsection