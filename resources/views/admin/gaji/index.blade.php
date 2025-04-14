@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Gaji</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gaji.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Data Gaji
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <table id="gajiTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Karyawan</th>
                                <th>Gaji Pokok</th>
                                <th>Tarif Produksi</th>
                                <th>Potongan Izin</th>
                                <th>Potongan Alpa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gajis as $index => $gaji)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ ucfirst($gaji->jenis_karyawan) }}</td>
                                <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->tarif_produksi, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->potongan_izin, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($gaji->potongan_alpa, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('admin.gaji.edit', $gaji->id_gaji) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.gaji.destroy', $gaji->id_gaji) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
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
@endsection

@section('scripts')
<script>
    $(function () {
        $("#gajiTable").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
@endsection