<!-- resources/views/karyawan/absen/index.blade.php -->
@extends('layoutskaryawanbulanan.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Absensi Karyawan') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>Informasi Karyawan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $karyawan->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ ucfirst($karyawan->status) }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($today)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if (!$todayAttendance)
                        <div class="mb-4">
                            <h5>Form Absensi Hari Ini</h5>
                            <form method="POST" action="{{ route('karyawan.bulanan.absen.store') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="status">Status Kehadiran</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="masuk">Masuk</option>
                                        <option value="ijin">Izin</option>
                                        <option value="alpha">Alpha</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Absensi</button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info">
                            Anda sudah melakukan absensi hari ini dengan status: <strong>{{ ucfirst($todayAttendance->status) }}</strong>
                        </div>
                    @endif

                    <div>
                        <h5>Riwayat Absensi (30 Hari Terakhir)</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($attendanceHistory as $attendance)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($attendance->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}</td>
                                            <td>
                                                @if($attendance->status == 'masuk')
                                                    <span class="badge bg-success">Masuk</span>
                                                @elseif($attendance->status == 'ijin')
                                                    <span class="badge bg-warning">Izin</span>
                                                @elseif($attendance->status == 'alpha')
                                                    <span class="badge bg-danger">Alpha</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Belum ada riwayat absensi</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection