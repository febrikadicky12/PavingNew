<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalProduksi extends Model
{
    protected $table = 'total_produksi';
    protected $primaryKey = 'id_totalproduksi';
    public $timestamps = false; // <- ini penting
    
    protected $fillable = [
        'id_karyawan',
        'periode_produksi',
        'id_gaji'
    ];
    
    // Define relationships
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
    
    public function gaji()
    {
        return $this->belongsTo(Gaji::class, 'id_gaji');
    }
    
    
    
    public function produksi()
    {
        return $this->hasMany(Produksi::class, 'id_totalproduksi', 'id_totalproduksi');
    }

      // Relasi ke penggajian
      public function penggajian()
      {
          return $this->hasOne(Penggajian::class, 'id_karyawan', 'id_karyawan')
                      ->whereRaw('DATE(periode_gaji) = DATE(periode_produksi)');
      }
}