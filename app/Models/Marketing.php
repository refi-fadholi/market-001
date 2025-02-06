<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    /** @use HasFactory<\Database\Factories\MarketingFactory> */
    use HasFactory;

    protected $table = 'marketings'; // Nama tabel di database
    protected $fillable = ['name']; // Kolom yang bisa diisi

    // Relasi ke tabel penjualan (Marketing memiliki banyak Penjualan)
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'marketing_id');
    }
}
