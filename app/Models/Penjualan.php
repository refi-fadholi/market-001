<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    /** @use HasFactory<\Database\Factories\PenjualanFactory> */
    use HasFactory;

    protected $table = 'penjualans'; // Nama tabel di database
    
    protected $fillable = [
        'transaction_number',
        'marketing_id',
        'date',
        'cargo_fee',
        'total_balance',
        'grand_total'
    ];

    // Relasi ke tabel marketing
    public function marketings()
    {
        return $this->belongsTo(Marketing::class, 'marketing_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

}
