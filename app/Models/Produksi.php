<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model {
    use HasFactory;

    protected $table = 'produksi';
    protected $primaryKey = 'id_produksi';
    public $timestamps = false; // Tambahkan jika tabel tidak memiliki created_at dan updated_at

    protected $fillable = [
        'id_produk', 
        'tanggal_produksi', 
        'jumlah_produksi', 
        'status_produksi', 
        'id_bahan', 
        'id_karyawan', 
        'id_mesin', 
        'id_totalproduksi'
    ];

    // Relasi ke Produk
    public function produk() {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    // Relasi ke Bahan
    public function bahan() {
        return $this->belongsTo(Bahan::class, 'id_bahan', 'id_bahan');
    }

    // Relasi ke Karyawan
    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    // Relasi ke Mesin
    public function mesin() {
        return $this->belongsTo(Mesin::class, 'id_mesin', 'id');
    }
}
