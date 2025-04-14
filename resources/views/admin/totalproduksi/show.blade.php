@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Detail Total Produksi') }}</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th width="30%">Karyawan</th>
                                <td>{{ $totalProduksi->karyawan->nama }}</td>
                            </tr>
                            <tr>
                                <th>Status Karyawan</th>
                                <td>{{ $totalProduksi->karyawan->status }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon</th>
                                <td>{{ $totalProduksi->karyawan->no_telp }}</td>
                            </tr>
                            <tr>
                                <th>Periode Produksi</th>
                                <td>{{ date('d-m-Y', strtotime($totalProduksi->periode_produksi)) }}</td>
                            </tr>
                            <tr>
                                <th>Gaji</th>
                                <td>
                                    @if ($totalProduksi->gaji)
                                        @if ($totalProduksi->gaji->jenis_karyawan == 'bulanan')
                                            Gaji Pokok: Rp {{ number_format($totalProduksi->gaji->gaji_pokok, 0, ',', '.') }}
                                        @elseif ($totalProduksi->gaji->jenis_karyawan == 'borongan')
                                            @php
                                                $totalGaji = $totalJumlahProduksi * $totalProduksi->gaji->tarif_produksi;
                                            @endphp
                                            Rp {{ number_format($totalGaji, 0, ',', '.') }}
                                            ({{ number_format($totalJumlahProduksi, 0, ',', '.') }} item × Rp {{ number_format($totalProduksi->gaji->tarif_produksi, 0, ',', '.') }})
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Total Jumlah Produksi</th>
                                <td><strong>{{ number_format($totalJumlahProduksi, 0, ',', '.') }} item</strong></td>
                            </tr>
                        </table>
                    </div>

                    <h5 class="mt-4">Daftar Produksi Terkait</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produksiItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->produk->nama_produk }}</td>
                                        <td>{{ date('d-m-Y', strtotime($item->tanggal_produksi)) }}</td>
                                        <td>{{ $item->jumlah_produksi }}</td>
                                        <td>
                                            <span class="badge {{ $item->status_produksi == 'sudah' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $item->status_produksi }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data produksi terkait.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('admin.totalproduksi.index') }}" class="btn btn-secondary">
                            {{ __('Kembali') }}
                        </a>
                        <a href="{{ route('admin.totalproduksi.edit', $totalProduksi->id_totalproduksi) }}" class="btn btn-warning">
                            {{ __('Edit') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection