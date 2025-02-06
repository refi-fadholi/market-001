<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class HomeController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('marketings')->get(); // Mengambil data dengan relasi
        return view('home', compact('penjualan')); // Kirim data ke view
    }
}
