@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Tambah Penjualan Baru</h3>
                        <a href="{{ route('admin.penjualan.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.penjualan.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="id_produk">Produk <span class="text-danger">*</span></label>
                            <select name="id_produk" id="id_produk" class="form-control @error('id_produk') is-invalid @enderror" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $item)
                                    <option value="{{ $item->id_produk }}" 
                                        data-harga="{{ $item->harga_produk }}" 
                                        data-stok="{{ $item->stok_produk }}" 
                                        {{ old('id_produk') == $item->id_produk ? 'selected' : '' }}>
                                        {{ $item->nama_produk }} - {{ $item->jenis_produk }} (Stok: {{ $item->stok_produk }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="jumlah_produk">Jumlah <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('jumlah_produk') is-invalid @enderror" id="jumlah_produk" name="jumlah_produk" value="{{ old('jumlah_produk', 1) }}" min="1" required>
                            @error('jumlah_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small id="stok-tersedia" class="form-text text-muted">Stok tersedia: -</small>
                        </div>
                        
                        <div class="form-group">
    <label for="total_harga">Total Harga <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Rp</span>
        </div>
        <input type="number" class="form-control @error('total_harga') is-invalid @enderror" 
               id="total_harga" name="total_harga" value="{{ old('total_harga', 0) }}" required>
        @error('total_harga')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
                        
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        function updateTotalHarga() {
            var selectedOption = $('#id_produk option:selected');
            var harga = selectedOption.data('harga') || 0;
            var jumlah = $('#jumlah_produk').val() || 0;
            var total = harga * jumlah;
            
            $('#total_harga_preview').val(total.toLocaleString('id-ID'));
        }
        
        function updateStokInfo() {
            var selectedOption = $('#id_produk option:selected');
            var stok = selectedOption.data('stok') || 0;
            $('#stok-tersedia').text('Stok tersedia: ' + stok);
        }
        
        $('#id_produk').change(function() {
            updateTotalHarga();
            updateStokInfo();
        });
        
        $('#jumlah_produk').on('input', function() {
            updateTotalHarga();
        });
        
        // Initialize
        updateTotalHarga();
        updateStokInfo();
    });
</script>
@endpush
@endsection