<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database (jika berbeda dari nama model)
     */
    protected $table = 'bahan';

    protected $primaryKey = 'id_bahan'; // Primary key

    public $timestamps = false;

    protected $keyType = 'int'; // Jika id_bahan berupa angka

    /**
     * Kolom yang dapat diisi secara massal (Mass Assignment Protection)
     */
    protected $fillable = [
        'nama_bahan',
        'stock_bahan',
        'jenis_bahan',
        'id_suplier',
        'harga_satuan',
        'satuan',
    ];

    /**
     * Relasi dengan Supplier
     */
    public function suplier()
    {
        return $this->belongsTo(Suplier::class, 'id_suplier', 'id_suplier');
    }

  
public function pembelians()
{
    return $this->hasMany(Pembelian::class, 'id_bahan', 'id_bahan');
}
}

