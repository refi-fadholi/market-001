<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualans,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
        ]);

        $penjualan = Penjualan::findOrFail($request->penjualan_id);
        $totalDibayar = Pembayaran::where('penjualan_id', $penjualan->id)->sum('jumlah');
        $sisaBayar = $penjualan->grand_total - $totalDibayar;

        if ($request->jumlah > $sisaBayar) {
            return response()->json(['message' => 'Jumlah pembayaran melebihi sisa yang belum dibayar'], 400);
        }

        $pembayaran = Pembayaran::create([
            'penjualan_id' => $request->penjualan_id,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah' => $request->jumlah,
        ]);

        return response()->json([
            'message' => 'Pembayaran berhasil',
            'pembayaran' => $pembayaran
        ]);
    }

    public function getStatus($penjualan_id)
    {
        $penjualan = Penjualan::findOrFail($penjualan_id);
        $totalDibayar = Pembayaran::where('penjualan_id', $penjualan_id)->sum('jumlah');
        $sisaBayar = $penjualan->grand_total - $totalDibayar;
        $status = ($sisaBayar <= 0) ? 'Lunas' : 'Belum Lunas';

        return response()->json([
            'penjualan_id' => $penjualan_id,
            'total_tagihan' => $penjualan->grand_total,
            'total_dibayar' => $totalDibayar,
            'sisa_bayar' => $sisaBayar,
            'status' => $status
        ]);
    }
}
