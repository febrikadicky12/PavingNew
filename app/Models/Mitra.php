<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitra_usaha';
    protected $primaryKey = 'id_mitra';
    public $timestamps = false;
    

    protected $fillable = [
        'nama_mitra',
        'alamat',
        'no_telpon', // Sesuaikan dengan database
        'id_produk',
    ];

    // Relasi ke model Produk (jika ada)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
