<?php

use App\Http\Controllers\Api\MarketingController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\PembayaranController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('marketings', MarketingController::class);
Route::apiResource('penjualans', PenjualanController::class);

Route::post('/pembayaran', [PembayaranController::class, 'store']);
Route::get('/pembayaran/status/{penjualan_id}', [PembayaranController::class, 'getStatus']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
