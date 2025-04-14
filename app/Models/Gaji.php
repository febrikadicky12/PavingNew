<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = 'gaji';
    protected $primaryKey = 'id_gaji';
    protected $fillable = [
        'jenis_karyawan',
        'gaji_pokok',
        'tarif_produksi',
        'potongan_izin',
        'potongan_alpa'
    ];
    
    // If you don't use timestamps in this table
    public $timestamps = false;
    
   
    public function totalProduksi()
{
    return $this->hasMany(TotalProduksi::class, 'id_gaji');
}

}