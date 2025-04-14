@extends('layouts.master')

@section('title', 'Detail Karyawan')

@section('content')
<main id="main" class="main">
<div class="pagetitle">
  <h1>Detail Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.karyawan.index') }}">Daftar Karyawan</a></li>
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
          <h2>{{ $karyawan->nama }}</h2>
          <h3>
            @if($karyawan->status == 'borongan')
              Karyawan Borongan
            @elseif($karyawan->status == 'bulanan')
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
                <div class="col-lg-9 col-md-8">{{ $karyawan->nama }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">No. Telepon</div>
                <div class="col-lg-9 col-md-8">{{ $karyawan->no_telp }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Status</div>
                <div class="col-lg-9 col-md-8">
                  @if($karyawan->status == 'borongan')
                    <span class="badge bg-success">Karyawan Borongan</span>
                  @elseif($karyawan->status == 'bulanan')
                    <span class="badge bg-info">Karyawan Bulanan</span>
                  @endif
                </div>
              </div>


              <div class="row">
                <div class="col-lg-3 col-md-4 label">Dibuat Pada</div>
                <div class="col-lg-9 col-md-8">{{ $karyawan->created_at->format('d M Y, H:i') }}</div>
              </div>

              <div class="row">
                <div class="col-lg-3 col-md-4 label">Diperbarui Pada</div>
                <div class="col-lg-9 col-md-8">{{ $karyawan->updated_at->format('d M Y, H:i') }}</div>
              </div>

              <div class="text-center mt-3">
                <a href="{{ route('admin.karyawan.edit', $karyawan->id_karyawan) }}" class="btn btn-warning">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
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