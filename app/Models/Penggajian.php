<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'penggajian';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_penggajian';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_karyawan',
        'id_rekap',
        'id_gaji',
        'periode_gaji',
        'total_produksi',
        'total_gaji',
        'tgl_penggajian',
        'status_penggajian',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'periode_gaji' => 'datetime',
        'tgl_penggajian' => 'date',
        'total_gaji' => 'decimal:0',
    ];

    /**
     * Get the karyawan that owns the penggajian.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    /**
     * Get the rekap absen that owns the penggajian (for monthly employees).
     */
    public function rekapAbsen()
    {
        return $this->belongsTo(RekapAbsen::class, 'id_rekap', 'id_rekap');
    }

    /**
     * Get the gaji that owns the penggajian.
     */
    public function gaji()
    {
        return $this->belongsTo(Gaji::class, 'id_gaji', 'id_gaji');
    }

    /**
     * Get the total produksi record for borongan employees.
     */
    public function totalProduksi()
    {
        return $this->belongsTo(TotalProduksi::class, 'id_karyawan', 'id_karyawan')
                    ->whereRaw('DATE(periode_produksi) = DATE(periode_gaji)');
    }
}