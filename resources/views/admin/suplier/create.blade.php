@extends('layouts.master')

@section('title', 'Form Tambah Suplier')

@section('content')
<section class="content-section">
    <div class="row">
    <div class="col-lg-8 mx-auto">
    <div class="card shadow-sm rounded-lg p-4">
        <h2>Tambah Suplier</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.suplier.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Suplier</label>
                <input type="text" name="nama_suplier" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No Telp</label>
                <input type="text" name="no_telp" class="form-control" required>
            </div>
            <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
    </div>
</section>
@endsection
