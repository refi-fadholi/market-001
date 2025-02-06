<?php
// app/Models/Pembayaran.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'penjualan_id',
        'tanggal_pembayaran',
        'jumlah',
    ];

    public static function createPembayaran(array $data)
    {
        return self::create($data);
    }

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}