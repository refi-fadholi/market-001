<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PembayaranController;

use App\Models\Pembayaran;

Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/pembayaran', [PembayaranController::class, 'store']);

Route::get('/pembayaran', function () {
    return view('pembayaran', [PembayaranController::class, 'index']);
});


Route::post('/pembayaran', [PembayaranController::class, 'store']);


