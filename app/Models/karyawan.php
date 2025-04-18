<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'karyawan';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_karyawan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'no_telp',
        'status',
    ];

    /**
     * Get the user associated with the karyawan.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'nama', 'name');
    }

    // App\Models\Karyawan.php
public function rekapAbsen()
{
    return $this->hasMany(RekapAbsen::class, 'id_karyawan', 'id_karyawan');
}

}