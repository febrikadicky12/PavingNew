@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Data Gaji</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gaji.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.gaji.update', $gaji->id_gaji) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="jenis_karyawan">Jenis Karyawan</label>
                            <select class="form-control" id="jenis_karyawan" name="jenis_karyawan" required>
                                <option value="">-- Pilih Jenis Karyawan --</option>
                                <option value="bulanan" {{ $gaji->jenis_karyawan == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                                <option value="borongan" {{ $gaji->jenis_karyawan == 'borongan' ? 'selected' : '' }}>Borongan</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="gaji_pokok">Gaji Pokok</label>
                            <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" value="{{ $gaji->gaji_pokok }}" min="0" step="0.01">
                            <small class="text-muted">Kosongkan untuk karyawan borongan</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="tarif_produksi">Tarif Produksi</label>
                            <input type="number" class="form-control" id="tarif_produksi" name="tarif_produksi" value="{{ $gaji->tarif_produksi }}" min="0" step="0.01" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="potongan_izin">Potongan Izin</label>
                            <input type="number" class="form-control" id="potongan_izin" name="potongan_izin" value="{{ $gaji->potongan_izin }}" min="0" step="0.01">
                            <small class="text-muted">Kosongkan jika tidak ada potongan izin</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="potongan_alpa">Potongan Alpa</label>
                            <input type="number" class="form-control" id="potongan_alpa" name="potongan_alpa" value="{{ $gaji->potongan_alpa }}" min="0" step="0.01">
                            <small class="text-muted">Kosongkan jika tidak ada potongan alpa</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        // Toggle visibility of gaji_pokok based on jenis_karyawan
        $('#jenis_karyawan').change(function() {
            if ($(this).val() === 'borongan') {
                $('#gaji_pokok').prop('required', false).val('');
                $('#gaji_pokok').closest('.form-group').fadeOut();
            } else {
                $('#gaji_pokok').prop('required', true);
                $('#gaji_pokok').closest('.form-group').fadeIn();
            }
        });
        
        // Trigger on page load
        $('#jenis_karyawan').trigger('change');
    });
</script>
@endsection