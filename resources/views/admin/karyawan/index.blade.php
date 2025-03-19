@extends('layouts.master')

@section('title', 'Daftar Karyawan')

@section('content')
<div class="pagetitle">
  <h1>Daftar Karyawan</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Daftar Karyawan</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
            <h5 class="card-title">Daftar Karyawan</h5>
            <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary">
              Tambah Karyawan
            </a>
          </div>

          <!-- Search Form -->
          <form action="{{ route('admin.karyawan.index') }}" method="GET" class="mb-4">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Cari karyawan..." name="search" value="{{ $search ?? '' }}">
              <button class="btn btn-primary" type="submit">
                </i> Cari
              </button>
              @if(!empty($search))
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                  </i> Reset
                </a>
              @endif
            </div>
          </form>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <!-- Table with stripped rows -->
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama</th>
                  <th scope="col">No. Telepon</th>
                  <th scope="col">Status</th>
                  <th scope="col">Dibuat Pada</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($karyawans as $index => $karyawan)
                <tr>
                  <th scope="row">{{ $index + $karyawans->firstItem() }}</th>
                  <td>{{ $karyawan->nama }}</td>
                  <td>{{ $karyawan->no_telp }}</td>
                  <td>
                    @if($karyawan->status == 'borongan')
                      <span class="badge bg-success">Karyawan Borongan</span>
                    @elseif($karyawan->status == 'bulanan')
                      <span class="badge bg-info">Karyawan Bulanan</span>
                    @endif
                  </td>
                  <td>{{ $karyawan->created_at ? $karyawan->created_at->format('d M Y, H:i') : '-' }}</td>

                  <td>
                    <div class="d-flex gap-1">
                      <a href="{{ route('admin.karyawan.show', $karyawan->id_karyawan) }}" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i>
                      </a>
                      <a href="{{ route('admin.karyawan.edit', $karyawan->id_karyawan) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <form action="{{ route('admin.karyawan.destroy', $karyawan->id_karyawan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center">Tidak ada data karyawan</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
          <!-- End Table -->

          <!-- Pagination -->
          <div class="mt-3">
            {{ $karyawans->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection