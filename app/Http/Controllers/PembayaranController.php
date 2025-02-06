<?php

// app/Http/Controllers/PembayaranController.php
namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'penjualan_id' => 'required|exists:penjualans,id',
        'tanggal_pembayaran' => 'required|date',
        'jumlah' => 'required|numeric|min:1',
    ]);

    DB::beginTransaction();

    try {
        $penjualan = Penjualan::find($validated['penjualan_id']);

        // Hitung sisa tagihan sebelum pembayaran baru
        $sisa_tagihan = $penjualan->grand_total - $penjualan->pembayaran()->sum('jumlah');

        if ($validated['jumlah'] > $sisa_tagihan) {
            throw new \Exception('Jumlah bayar melebihi sisa tagihan.');
        }

        $pembayaran = Pembayaran::createPembayaran($validated);

        // Update status penjualan (jika perlu)
        $sisa_tagihan_setelah_bayar = $sisa_tagihan - $validated['jumlah'];
        if ($sisa_tagihan_setelah_bayar <= 0) {
            $penjualan->status_pembayaran = 'Lunas';
            $penjualan->save();
        }

        DB::commit();

        // Redirect dengan pesan sukses
        return back()->with('success', 'Pembayaran berhasil disimpan.');
    } catch (\Exception $e) {
        DB::rollBack();

        // Redirect dengan pesan error
        return back()->with('error', 'Pembayaran gagal.');
    }
}
}