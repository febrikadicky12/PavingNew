@extends('layouts.master')



@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Edit Pembelian</h3>
                <a href="{{ route('admin.pembelian.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.pembelian.update', $pembelian->id_pembelian) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="id_suplier">Supplier</label>
                    <select name="id_suplier" id="id_suplier" class="form-control @error('id_suplier') is-invalid @enderror" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($supliers as $suplier)
                            <option value="{{ $suplier->id_suplier }}" {{ (old('id_suplier', $pembelian->id_suplier) == $suplier->id_suplier) ? 'selected' : '' }}>
                                {{ $suplier->nama_suplier }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_suplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="id_bahan">Bahan</label>
                    <select name="id_bahan" id="id_bahan" class="form-control @error('id_bahan') is-invalid @enderror" required>
                        <option value="">-- Pilih Bahan --</option>
                        @foreach($bahans as $bahan)
                            <option value="{{ $bahan->id_bahan }}" {{ (old('id_bahan', $pembelian->id_bahan) == $bahan->id_bahan) ? 'selected' : '' }}>
                                {{ $bahan->nama_bahan }} ({{ $bahan->satuan }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_bahan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $pembelian->jumlah) }}" min="1" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="harga_total">Harga Total (Rp)</label>
                            <input type="number" name="harga_total" id="harga_total" class="form-control @error('harga_total') is-invalid @enderror" value="{{ old('harga_total', $pembelian->harga_total) }}" min="0" required>
                            @error('harga_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // When supplier selection changes
        $('#id_suplier').change(function() {
            var id_suplier = $(this).val();
            var current_bahan_id = {{ $pembelian->id_bahan }};
            
            if(id_suplier) {
                // Clear current options
                $('#id_bahan').empty();
                $('#id_bahan').append('<option value="">-- Pilih Bahan --</option>');
                
                // Get bahan options via AJAX
                $.ajax({
                    url: '/admin/pembelian/get-bahan-by-suplier/' + id_suplier,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if(data.length > 0) {
                            $.each(data, function(key, bahan) {
                                var selected = (bahan.id_bahan == current_bahan_id) ? 'selected' : '';
                                $('#id_bahan').append('<option value="' + bahan.id_bahan + '" ' + selected + '>' + bahan.nama_bahan + ' (' + bahan.satuan + ')</option>');
                            });
                        } else {
                            $('#id_bahan').append('<option value="">Tidak ada bahan tersedia</option>');
                        }
                    }
                });
            } else {
                $('#id_bahan').empty();
                $('#id_bahan').append('<option value="">-- Pilih Bahan --</option>');
            }
        });
        
        // Trigger change if supplier already selected
        if($('#id_suplier').val()) {
            $('#id_suplier').trigger('change');
        }
    });
</script>
@endpush
@endsection