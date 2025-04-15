@extends('layouts.master')

@section('content')
<main id="main" class="main">
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Pembelian</h5>
                <a href="{{ route('admin.pembelian.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.pembelian.store') }}" method="POST">
                @csrf
                
                <!-- SUPPLIER -->
                <div class="form-group mb-3">
                    <label for="id_suplier">Pilih Supplier</label>
                    <select name="id_suplier" id="id_suplier" class="form-control @error('id_suplier') is-invalid @enderror" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($supliers as $suplier)
                            <option value="{{ $suplier->id_suplier }}" {{ old('id_suplier') == $suplier->id_suplier ? 'selected' : '' }}>
                                {{ $suplier->nama_suplier }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_suplier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BAHAN -->
                <div class="form-group mb-3">
                    <label for="id_bahan">Pilih Bahan</label>
                    <select id="id_bahan" class="form-control @error('id_bahan') is-invalid @enderror" name="id_bahan" required>
                        <option value="">-- Pilih Bahan --</option>
                        @foreach($bahans as $bahan)
                            <option value="{{ $bahan->id_bahan }}" {{ old('id_bahan') == $bahan->id_bahan ? 'selected' : '' }}>
                                {{ $bahan->nama_bahan }} (Stok: {{ $bahan->stock_bahan }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_bahan')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- JUMLAH & HARGA -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" min="1" required>
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="harga_total">Harga Total (Rp)</label>
                            <input type="number" name="harga_total" id="harga_total" class="form-control @error('harga_total') is-invalid @enderror" value="{{ old('harga_total') }}" min="0" required>
                            @error('harga_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadBahanBySuplier(suplierId) {
            $('#id_bahan').empty().append('<option value="">Memuat data...</option>');

            $.ajax({
                url: `/admin/pembelian/get-bahan-by-suplier/${suplierId}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#id_bahan').empty().append('<option value="">-- Pilih Bahan --</option>');
                    if (data.length > 0) {
                        $.each(data, function (index, bahan) {
                            $('#id_bahan').append(`<option value="${bahan.id_bahan}">${bahan.nama_bahan} (${bahan.satuan})</option>`);
                        });
                    } else {
                        $('#id_bahan').append('<option value="">Tidak ada bahan tersedia</option>');
                    }
                },
                error: function () {
                    alert('Terjadi kesalahan saat mengambil data bahan.');
                    $('#id_bahan').empty().append('<option value="">-- Pilih Bahan --</option>');
                }
            });
        }

        $('#id_suplier').change(function () {
            const suplierId = $(this).val();
            if (suplierId) {
                loadBahanBySuplier(suplierId);
            } else {
                $('#id_bahan').empty().append('<option value="">-- Pilih Bahan --</option>');
            }
        });

        // Jika sudah dipilih sebelumnya (karena error validation), trigger lagi
        if ($('#id_suplier').val()) {
            $('#id_suplier').trigger('change');
        }
    });
</script>
@endpush
@endsection