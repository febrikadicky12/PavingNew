@section('title', 'Detail Mesin')

@section('content')
<main id="main" class="main">
<div class="container mt-4">
    <h1 class="mb-4">Detail Mesin</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $mesin->nama_mesin }}</h5>
            <p class="card-text"><strong>Kode Mesin:</strong> {{ $mesin->kode_mesin }}</p>
            <p class="card-text"><strong>Status:</strong> {{ ucfirst($mesin->status) }}</p>

            <a href="{{ route('admin.mesin.edit', $mesin->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.mesin.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection