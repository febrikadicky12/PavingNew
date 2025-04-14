<!-- resources/views/admin/penggajian/bulanan/index.blade.php -->
@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Penggajian Karyawan Bulanan</h1>
        <div>
            <a href="{{ route('admin.penggajian.bulanan.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Penggajian
            </a>
            <button type="button" class="btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#generateBatchModal">
                <i class="fas fa-file-invoice-dollar fa-sm text-white-50"></i> Generate Batch
            </button>
            <a href="{{ route('admin.penggajian.bulanan.report', ['period' => $period]) }}" class="btn btn-sm btn-info shadow-sm" target="_blank">
                <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Penggajian Bulanan</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Filter:</div>
                    <a class="dropdown-item" href="{{ route('admin.penggajian.bulanan.index') }}">Reset Filter</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('admin.penggajian.bulanan.index') }}" method="GET" class="form-inline">
                        <div class="form-group mb-2">
                            <label for="period" class="sr-only">Periode</label>
                            <input type="month" class="form-control" id="period" name="period" value="{{ $period }}" onchange="this.form.submit()">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('admin.penggajian.bulanan.index') }}" method="GET" class="form-inline float-right">
                        <input type="hidden" name="period" value="{{ $period }}">
                        <div class="form-group mb-2">
                            <label for="search" class="sr-only">Cari</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Cari nama karyawan..." value="{{ $search }}">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 ml-2">Cari</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Periode</th>
                            <th>Total Gaji</th>
                            <th>Tanggal Gajian</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penggajian as $index => $item)
                        <tr>
                            <td>{{ $index + $penggajian->firstItem() }}</td>
                            <td>{{ $item->karyawan->nama }}</td>
                            <td>{{ $item->periode_gaji->format('F Y') }}</td>
                            <td>Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                            <td>{{ $item->tgl_penggajian->format('d/m/Y') }}</td>
                            
                            <td>
                                @if ($item->status_penggajian == 'sudah bayar')
                                <span class="badge badge-success">Sudah Bayar</span>
                                @else
                                <span class="badge badge-warning">Belum Dibayar</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.penggajian.bulanan.show', $item->id_penggajian) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.penggajian.bulanan.edit', $item->id_penggajian) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.penggajian.bulanan.slip', $item->id_penggajian) }}" class="btn btn-success btn-sm" target="_blank">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $item->id_penggajian }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $item->id_penggajian }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $item->id_penggajian }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $item->id_penggajian }}">Konfirmasi Hapus</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data penggajian untuk {{ $item->karyawan->nama }} periode {{ $item->periode_gaji->format('F Y') }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <form action="{{ route('admin.penggajian.bulanan.destroy', $item->id_penggajian) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Hapus</button>
</form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data penggajian</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end">
                {{ $penggajian->appends(['period' => $period, 'search' => $search])->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Generate Batch Modal -->
<div class="modal fade" id="generateBatchModal" tabindex="-1" role="dialog" aria-labelledby="generateBatchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateBatchModalLabel">Generate Batch Penggajian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.penggajian.bulanan.generate-batch') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="batch_period">Periode</label>
                        <input type="month" class="form-control" id="batch_period" name="period" value="{{ $period }}" required>
                    </div>
                    <div class="form-group">
                        <label for="batch_id_gaji">Jenis Gaji</label>
                        <select class="form-control" id="batch_id_gaji" name="id_gaji" required>
                            <option value="" selected disabled>Pilih Jenis Gaji</option>
                            @foreach (App\Models\Gaji::where('jenis_karyawan', 'bulanan')->get() as $gaji)
                            <option value="{{ $gaji->id_gaji }}">{{ $gaji->nama_gaji }} - Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="batch_tgl_penggajian">Tanggal Penggajian</label>
                        <input type="date" class="form-control" id="batch_tgl_penggajian" name="tgl_penggajian" required>
                    </div>
                    <div class="form-group">
                        <label for="batch_status_penggajian">Status Penggajian</label>
                        <select class="form-control" id="batch_status_penggajian" name="status_penggajian" required>
                            <option value="belum dibayar">Belum Dibayar</option>
                            <option value="sudah bayar">Sudah Bayar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection