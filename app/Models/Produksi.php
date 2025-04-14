<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    protected $table = 'produksi';
    protected $primaryKey = 'id_produksi';
    public $timestamps = false;

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

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'id_mesin');
    }

    public function totalProduksi()
    {
        return $this->belongsTo(TotalProduksi::class, 'id_totalproduksi');
    }
}