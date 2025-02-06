<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenjualanResource;
use App\Models\Penjualan;
use App\Models\Marketing;
use Illuminate\Http\Request;
use Carbon\Carbon;


class PenjualanController extends Controller
{
    public function index() {

        // $penjualans = Penjualan::with('marketings')->orderBy('date', 'asc')->get(); // Pastikan relasi dimuat

        $penjualans = Penjualan::selectRaw("
            marketing_id, 
            strftime('%Y-%m', date) as bulan, 
            SUM(grand_total) as omzet
        ")
        ->groupBy('marketing_id', 'bulan')
        ->with('marketings') // Ambil relasi marketing
        ->orderBy('bulan', 'asc')
        ->get();

        if ($penjualans->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 200);
        }

        return PenjualanResource::collection($penjualans);
    }


    public function getCommission()
    {
        // Array untuk menampung data komisi
        $commissions = [];

        // Ambil semua data marketing
        $marketings = Marketing::all();

        foreach ($marketings as $marketing) {
            // Ambil semua penjualan berdasarkan marketing_id
            $sales = Penjualan::where('marketing_id', $marketing->id)->get();

            foreach ($sales as $sale) {
                $totalOmzet = $sale->grand_total; // Ambil omzet dari penjualan
                $commissionPercentage = 0;
                $commissionNominal = 0;

                // Hitung persentase komisi berdasarkan omzet
                if ($totalOmzet >= 500000000) {
                    $commissionPercentage = 10;
                } elseif ($totalOmzet >= 200000000) {
                    $commissionPercentage = 5;
                } elseif ($totalOmzet >= 100000000) {
                    $commissionPercentage = 2.5;
                }

                // Hitung komisi nominal
                $commissionNominal = ($commissionPercentage / 100) * $totalOmzet;

                // Masukkan hasil perhitungan ke dalam array
                $commissions[] = [
                    'marketing' => $marketing->name,
                    'month' => Carbon::parse($sale->date)->format('F'),
                    'year' => Carbon::parse($sale->date)->year,
                    'omzet' => $totalOmzet,
                    'commission_percentage' => $commissionPercentage,
                    'commission_nominal' => $commissionNominal,
                ];
            }
        }

        // Return data komisi dalam bentuk JSON
        return response()->json($commissions);
    }

    public function store() {

    }

    public function show() {

    }

    public function update() {
        
    }

    public function destroy() {
        
    }
}
