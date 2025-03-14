<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Sesuaikan dengan nama tabel
    protected $primaryKey = 'id_produk'; // Sesuaikan dengan primary key di database

    protected $fillable = [
        'nama_produk',
        'jenis_produk',
        'harga_produk',
        'ukuran_produk',
        'tipe_harga',
        'stok_produk'
    ];

    public $timestamps = false; // Jika tabel tidak memiliki kolom `created_at` dan `updated_at`
}


