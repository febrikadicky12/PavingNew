@extends('layouts.master')

@section('title', 'Tambah Mitra')

@section('content')

<div class="pagetitle">
    <h1>Tambah Mitra</h1>
</div>

<form action="{{ route('admin.mitra.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Mitra</label>
        <input type="text" name="nama_mitra" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Alamat</label>
        <input type="text" name="alamat" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nomor Telepon</label>
        <input type="tel" name="no_telpon" value="{{ old('no_telpon') }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Produk</label>
        <select name="id_produk" class="form-control">
            <option value="">Pilih Produk</option>
            @foreach($produk as $p)
                <option value="{{ $p->id_produk }}">{{ $p->nama_produk }}</option>
            @endforeach
        </select>
    </div>
    <div class="d-flex justify-content-end gap-2">
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.mitra.index') }}" class="btn btn-secondary">Batal</a>
    </div>      

</form>

@endsection
