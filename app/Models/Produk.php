<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model {
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;
    protected $fillable = ['nama_produk', 'jenis_produk', 'harga_produk', 'ukuran_produk', 'tipe_harga', 'stok_produk'];
    public function produksi() {
        return $this->hasMany(Produksi::class, 'id_produk');
    }
}


