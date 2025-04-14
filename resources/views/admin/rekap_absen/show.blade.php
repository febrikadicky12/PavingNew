@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Absensi: {{ $karyawan->nama }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.rekap_absen.show', $karyawan->id_karyawan) }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text">Bulan</span>
                                    <input type="month" name="month" class="form-control" value="{{ $month }}" onchange="this.form.submit()">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.rekap_absen.index') }}?month={{ $month }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calendar as $day)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($day['date'])->format('d F Y') }}</td>
                                    <td>
                                        @if($day['status'] == 'masuk')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($day['status'] == 'ijin')
                                            <span class="badge bg-warning">Izin</span>
                                        @elseif($day['status'] == 'alpha')
                                            <span class="badge bg-danger">Alpha</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection