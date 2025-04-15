@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Detail Penjualan</h3>
                        <a href="{{ route('admin.penjualan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="30%">ID Penjualan</th>
                                    <td>{{ $penjualan->id_penjualan }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Penjualan</th>
                                    <td>{{ date('d F Y H:i:s', strtotime($penjualan->tanggal)) }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Produk</th>
                                    <td>{{ $penjualan->produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Produk</th>
                                    <td>{{ $penjualan->produk->jenis_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Ukuran Produk</th>
                                    <td>{{ $penjualan->produk->ukuran_produk ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Harga</th>
                                    <td>
                                        @if($penjualan->produk->tipe_harga == 'diskon')
                                            <span class="badge badge-success">Diskon</span>
                                        @else
                                            <span class="badge badge-primary">Reguler</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Harga Per Unit</th>
                                    <td>Rp {{ number_format($penjualan->produk->harga_produk, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Produk</th>
                                    <td>{{ $penjualan->jumlah_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Total Harga</th>
                                    <td>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection