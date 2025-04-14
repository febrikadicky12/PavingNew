<!-- resources/views/admin/totalproduksi/report.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Laporan Total Produksi') }}</span>
                    <a href="{{ route('admin.totalproduksi.report') }}" class="btn btn-success btn-sm mx-1">Laporan</a>

                </div>

                <div class="card-body">
                    <form action="{{ route('admin.totalproduksi.report') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group pt-4 mt-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.totalproduksi.report') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Karyawan</th>
                                    <th>Status</th>
                                    <th>Periode</th>
                                    <th>Gaji</th>
                                    <th>Total Item Produksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($report as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->karyawan->nama }}</td>
                                        <td>{{ $item->karyawan->status }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->periode_produksi)) }}</td>
                                        <td>{{ $item->gaji ? 'Rp ' . number_format($item->gaji->jumlah_gaji, 0, ',', '.') : '-' }}</td>
                                        <td>{{ number_format($item->total_items, 0, ',', '.') }} item</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data produksi pada periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total:</th>
                                    <th>Rp {{ number_format($report->sum(function($item) { 
                                        return $item->gaji ? $item->gaji->jumlah_gaji : 0; 
                                    }), 0, ',', '.') }}</th>
                                    <th>{{ number_format($report->sum('total_items'), 0, ',', '.') }} item</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.totalproduksi.print') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="btn btn-primary" target="_blank">
                            <i class="bi bi-printer"></i> Cetak Laporan
                        </a>
                        <a href="{{ route('admin.totalproduksi.export') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="btn btn-success">
                            <i class="bi bi-file-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection