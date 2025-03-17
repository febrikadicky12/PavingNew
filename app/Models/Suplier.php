<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;

    protected $table = 'suplier'; // Ubah jika tabel di DB bernama 'supliers'
    protected $primaryKey = 'id_suplier'; // Pastikan sesuai dengan kolom primary key di DB
    public $timestamps = false; // Pastikan ada kolom created_at & updated_at, jika tidak ubah ke false

    protected $fillable = [
        'nama_suplier', 'alamat', 'no_telp',
    ];

    // Jika kolom timestamp di DB menggunakan nama berbeda
    // const CREATED_AT = 'tanggal_dibuat';
    // const UPDATED_AT = 'tanggal_diperbarui';
}
