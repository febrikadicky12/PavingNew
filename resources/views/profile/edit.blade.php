@extends('layouts.master')

@section('title', 'Edit Profile')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('profile.index') }}">Profile</a></li>
          <li class="breadcrumb-item active">Edit Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-12">

          <div class="card">
            <div class="card-body pt-3">
              <h5 class="card-title">Edit Profile Information</h5>

              <!-- Profile Edit Form -->
              <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                  <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                  <div class="col-md-8 col-lg-9">
                    @if($user->profile_image)
                      <img src="{{ asset('images/profile/'.$user->profile_image) }}" alt="Profile" class="img-fluid rounded" style="max-width: 200px;">
                    @else
                      <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="img-fluid rounded" style="max-width: 200px;">
                    @endif
                    <div class="pt-2">
                      <input type="file" class="form-control @error('profile_image') is-invalid @enderror" name="profile_image" id="profileImage">
                      @error('profile_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="text-muted">Accepted formats: jpeg, png, jpg, gif. Max size: 2MB</small>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="fullName" value="{{ old('name', $user->name) }}">
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="Email" value="{{ old('email', $user->email) }}">
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-md-4 col-lg-3 col-form-label">Role</label>
                  <div class="col-md-8 col-lg-9">
                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled readonly>
                    <small class="text-muted">Role cannot be changed from this form</small>
                  </div>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                  <a href="{{ route('profile.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
              </form><!-- End Profile Edit Form -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
@endsection