@extends('layouts.master')

@section('content')
<main id="main" class="main">
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Detail Pembelian</h3>
                <a href="{{ route('admin.pembelian.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">ID Pembelian</th>
                            <td>: {{ $pembelian->id_pembelian }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pembelian</th>
                            <td>: 
                                @if(isset($pembelian->tgl_pembelian))
                                    {{ \Carbon\Carbon::parse($pembelian->tgl_pembelian)->format('d/m/Y H:i') }}
                                @else
                                {{ \Carbon\Carbon::parse($pembelian->created_at)->format('d/m/Y H:i') }}

                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Supplier</th>
                            <td>: {{ $pembelian->suplier->nama_suplier }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Supplier</th>
                            <td>: {{ $pembelian->suplier->alamat }}</td>
                        </tr>
                        <tr>
                            <th>No. Telp Supplier</th>
                            <td>: {{ $pembelian->suplier->no_telp }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Bahan</th>
                            <td>: {{ $pembelian->bahan->nama_bahan }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Bahan</th>
                            <td>: {{ $pembelian->bahan->jenis_bahan }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>: {{ $pembelian->jumlah }} {{ $pembelian->bahan->satuan }}</td>
                        </tr>
                        <tr>
                            <th>Harga Total</th>
                            <td>: Rp {{ number_format($pembelian->harga_total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Harga Satuan</th>
                            <td>: Rp {{ number_format($pembelian->harga_total / $pembelian->jumlah, 0, ',', '.') }} / {{ $pembelian->bahan->satuan }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection