<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'suplier';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_suplier';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'nama_suplier',
        'alamat',
        'no_telp',
    ];

    /**
     * Get the materials supplied by this supplier.
     */
    public function bahans()
    {
        return $this->hasMany(Bahan::class, 'id_suplier', 'id_suplier');
    }
    
    // Relationship with purchases
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class, 'id_suplier', 'id_suplier');
    }
}