@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rfkap Absensi Karyawan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.rekap_absen.index') }}" method="GET" class="mb-4 row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text">Bulan</span>
                                <input type="month" name="month" class="form-control" value="{{ $month }}" onchange="this.form.submit()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama karyawan..." value="{{ $search ?? '' }}">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                           
                            
                            <a href="{{ route('admin.rekap_absen.downloadPdf') }}?month={{ $month }}&search={{ $search ?? '' }}" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Karyawan</th>
                                    <th>Hadir</th>
                                    <th>Izin</th>
                                    <th>Alpha</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceData as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data['karyawan']->nama }}</td>
                                    <td>{{ $data['hadir'] }}</td>
                                    <td>{{ $data['izin'] }}</td>
                                    <td>{{ $data['alpha'] }}</td>
                                    <td>
                                        <a href="{{ route('admin.rekap_absen.show', $data['karyawan']->id_karyawan) }}?month={{ $month }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-calendar"></i> Detail
                                        </a>
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection