@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Data Total Produksi') }}</span>
                    <div>
                        <a href="{{ route('admin.totalproduksi.create') }}" class="btn btn-primary btn-sm">Tambah Total Produksi</a>
                    </div>
                </div>

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

                    <form action="{{ route('admin.totalproduksi.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari total produksi..." name="search" value="{{ $search }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Karyawan</th>
                                    <th>Periode</th>
                                    <th>Gaji Pokok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($totalProduksi as $index => $item)
                                    <tr>
                                        <td>{{ $totalProduksi->firstItem() + $index }}</td>
                                        <td>{{ $item->karyawan ? $item->karyawan->nama : '-' }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->periode_produksi)) }}</td>
                                        <td>
                                            @if ($item->gaji)
                                                @if ($item->gaji->jenis_karyawan == 'bulanan' && $item->gaji->gaji_pokok)
                                                    Rp {{ number_format($item->gaji->gaji_pokok, 0, ',', '.') }}
                                                @elseif ($item->gaji->jenis_karyawan == 'borongan')
                                                    @php
                                                        $totalItems = App\Models\Produksi::where('id_totalproduksi', $item->id_totalproduksi)->sum('jumlah_produksi');
                                                        $totalGaji = $totalItems * $item->gaji->tarif_produksi;
                                                    @endphp
                                                    Rp {{ number_format($totalGaji, 0, ',', '.') }}
                                                    ({{ $totalItems }} item × Rp {{ number_format($item->gaji->tarif_produksi, 0, ',', '.') }})
                                                @else
                                                    -
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.totalproduksi.show', $item->id_totalproduksi) }}" class="btn btn-info btn-sm">Detail</a>
                                                <a href="{{ route('admin.totalproduksi.edit', $item->id_totalproduksi) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <form action="{{ route('admin.totalproduksi.destroy', $item->id_totalproduksi) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data total produksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $totalProduksi->appends(['search' => $search])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection