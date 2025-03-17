@extends('layouts.master')

@section('content')
<section class="content-section">
    <div class="container mt-4">
        <h2>Detail Mesin</h2>
        <table class="table table-bordered">
            <tr>
                <th>ID Mesin</th>
                <td>{{ $mesin->id }}</td>
            </tr>
            <tr>
                <th>Nama Mesin</th>
                <td>{{ $mesin->nama_mesin }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $mesin->status }}</td>
            </tr>
        </table>
        <a href="{{ route('admin.datamesin.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</section>
@endsection
