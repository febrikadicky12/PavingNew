@extends('layouts.master')

@section('content')
<section class="content-section">
    <div class="col-lg-8 mx-auto">
        <h2>Edit Bahan</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.bahan.update', $bahan->id_bahan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                <input type="text" name="nama_bahan" id="nama_bahan" class="form-control" value="{{ old('nama_bahan', $bahan->nama_bahan) }}" required>
            </div>

            <div class="mb-3">
                <label for="stock_bahan" class="form-label">Stock</label>
                <input type="number" name="stock_bahan" id="stock_bahan" class="form-control" value="{{ old('stock_bahan', $bahan->stock_bahan) }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_bahan" class="form-label">Jenis Bahan</label>
                <input type="text" name="jenis_bahan" id="jenis_bahan" class="form-control" value="{{ old('jenis_bahan', $bahan->jenis_bahan) }}" required>
            </div>

            <div class="mb-3">
                <label for="id_suplier" class="form-label">Nama Suplier</label>
                <select name="id_suplier" id="id_suplier" class="form-control" required>
                    <option value="">-- Pilih Suplier --</option>
                    @foreach($supliers as $suplier)
                        <option value="{{ $suplier->id_suplier }}" 
                            {{ old('id_suplier', $bahan->id_suplier) == $suplier->id_suplier ? 'selected' : '' }}>
                            {{ $suplier->nama_suplier }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                <input type="number" name="harga_satuan" id="harga_satuan" class="form-control" value="{{ old('harga_satuan', $bahan->harga_satuan) }}" required>
            </div>

            <div class="mb-3">
                <label for="satuan" class="form-label">Satuan</label>
                <input type="text" name="satuan" id="satuan" class="form-control" value="{{ old('satuan', $bahan->satuan) }}" required>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.datamesin.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">{{ isset($bahan) ? 'Update' : 'Simpan' }}</button>
            </div>            
        </form>
    </div>
</section>
@endsection
