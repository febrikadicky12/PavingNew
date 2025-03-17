<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model {
    use HasFactory;
    protected $table = 'produksi';
    protected $primaryKey = 'id_produksi';
    protected $fillable = ['id_produk', 'tanggal_produksi', 'jumlah_produksi', 'status_produksi', 'id_bahan', 'id_karyawan', 'id_mesin', 'id_totalproduksi'];
    public function produk() {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}


