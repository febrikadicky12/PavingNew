@extends('layouts.master')

@section('title', 'Tambah Bahan')

@section('content')
<section class="content-section">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm rounded-lg p-4">
            <h2 class="text-xl font-bold mb-4">Tambah Bahan</h2>
            <form action="{{ route('admin.bahan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_bahan" class="form-label">Nama Bahan</label>
                    <input type="text" name="nama_bahan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="stock_bahan" class="form-label">Stock</label>
                    <input type="number" name="stock_bahan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_bahan" class="form-label">Jenis Bahan</label>
                    <input type="text" name="jenis_bahan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="id_suplier" class="form-label">Suplier</label>
                    <select name="id_suplier" class="form-control" required>
                        <option value="">Pilih Suplier</option>
                        @foreach($supliers as $supl)
                            <option value="{{ $supl->id_suplier }}">{{ $supl->nama_suplier }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="harga_satuan" class="form-label">Harga Satuan</label>
                    <input type="number" name="harga_satuan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
        </div>
    </div>
</section>
@endsection
