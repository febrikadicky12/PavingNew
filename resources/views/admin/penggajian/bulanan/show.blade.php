<!-- resources/views/admin/penggajian/bulanan/show.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Penggajian Karyawan Bulanan</h1>
        <div>
            <a href="{{ route('admin.penggajian.bulanan.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
            <a href="{{ route('admin.penggajian.bulanan.slip', $penggajian->id_penggajian) }}" class="btn btn-sm btn-info shadow-sm" target="_blank">
                <i class="fas fa-file-invoice fa-sm text-white-50"></i> Download Slip
            </a>
            <a href="{{ route('admin.penggajian.bulanan.edit', $penggajian->id_penggajian) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Karyawan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <tr>
                                <th width="35%">Nama Karyawan</th>
                                <td>{{ $penggajian->karyawan->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>{{ $penggajian->karyawan->jabatan }}</td>
                            </tr>
                            <tr>
                                <th>Periode Gaji</th>
                                <td>{{ $penggajian->periode_gaji->format('F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Penggajian</th>
                                <td>{{ $penggajian->tgl_penggajian->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Status Penggajian</th>
                                <td>
                                    @if ($penggajian->status_penggajian == 'sudah bayar')
                                    <span class="badge badge-success">Sudah Bayar</span>
                                    @else
                                    <span class="badge badge-warning">Belum Dibayar</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
         <!-- Add this somewhere in your view for debugging -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Debug Info</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <tr>
                    <th>ID Rekap</th>
                    <td>{{ $penggajian->id_rekap }}</td>
                </tr>
                <tr>
                    <th>Potongan Izin Rate</th>
                    <td>Rp {{ number_format($penggajian->gaji->potongan_izin, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Potongan Alpa Rate</th>
                    <td>Rp {{ number_format($penggajian->gaji->potongan_alpa, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Raw Calculation</th>
                    <td>
                        {{ $penggajian->gaji->gaji_pokok }} - 
                        ({{ $penggajian->rekapAbsen->jumlah_izin }} * {{ $penggajian->gaji->potongan_izin }}) - 
                        ({{ $penggajian->rekapAbsen->jumlah_alpa }} * {{ $penggajian->gaji->potongan_alpa }})
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rincian Penggajian</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <tr>
                        <th width="35%">Nama Gaji</th>
                        <td>{{ $penggajian->gaji->nama_gaji }}</td>
                    </tr>
                    <tr>
                        <th>Gaji Pokok</th>
                        <td>Rp {{ number_format($penggajian->gaji->gaji_pokok, 0, ',', '.') }}</td>
                    </tr>
                    @if ($penggajian->gaji->potongan_izin > 0 && $penggajian->rekapAbsen->jumlah_izin > 0)
                    <tr>
                        <th>Potongan Izin</th>
                        <td>Rp {{ number_format($penggajian->gaji->potongan_izin * $penggajian->rekapAbsen->jumlah_izin, 0, ',', '.') }} ({{ $penggajian->rekapAbsen->jumlah_izin }} hari x Rp {{ number_format($penggajian->gaji->potongan_izin, 0, ',', '.') }})</td>
                    </tr>
                    @endif
                    @if ($penggajian->gaji->potongan_alpa > 0 && $penggajian->rekapAbsen->jumlah_alpa > 0)
                    <tr>
                        <th>Potongan Alpa</th>
                        <td>Rp {{ number_format($penggajian->gaji->potongan_alpa * $penggajian->rekapAbsen->jumlah_alpa, 0, ',', '.') }} ({{ $penggajian->rekapAbsen->jumlah_alpa }} hari x Rp {{ number_format($penggajian->gaji->potongan_alpa, 0, ',', '.') }})</td>
                    </tr>
                    @endif
                    <tr class="table-primary">
                        <th>Total Gaji</th>
                        <td><strong>Rp {{ number_format($penggajian->total_gaji, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="text-right mb-4">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
            <i class="fas fa-trash"></i> Hapus Data Penggajian
        </button>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data penggajian untuk {{ $penggajian->karyawan->nama }} periode {{ $penggajian->periode_gaji->format('F Y') }}?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.penggajian.bulanan.destroy', $penggajian->id_penggajian) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection