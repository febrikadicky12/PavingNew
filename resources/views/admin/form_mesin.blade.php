@extends('layouts.master')

@section('title', 'Mesin')

@section('content')
<div class="container mt-4">
    <h2>{{ isset($mesin) ? 'Edit' : 'Tambah' }} Mesin</h2>

    <form method="POST" action="{{ isset($mesin) ? route('admin.datamesin.update', $mesin->id) : route('admin.datamesin.store') }}">
        @csrf
        @if(isset($mesin))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label>Nama Mesin</label>
            <input type="text" name="nama_mesin" class="form-control" value="{{ $mesin->nama_mesin ?? '' }}" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="baik" {{ isset($mesin) && $mesin->status == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="tidak baik" {{ isset($mesin) && $mesin->status == 'tidak baik' ? 'selected' : '' }}>Tidak Baik</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($mesin) ? 'Update' : 'Tambah' }}</button>
    </form>
</div>
@endsection
