<?php

use App\Http\Controllers\QuranController;
use Illuminate\Support\Facades\Route;

// Route Quotes utama ditangani oleh QuotesController

// Portal Islami (eQuran.id Integration)
Route::get('/', [QuranController::class, 'index'])->name('quran.index');
Route::get('/quran/{quran}', [QuranController::class, 'show'])->name('quran.show');

Route::get('/doa', [QuranController::class, 'doa'])->name('doa.index');
Route::get('/doa/{id}', [QuranController::class, 'doaDetail'])->name('doa.show');

Route::get('/jadwal-sholat', [QuranController::class, 'shalat'])->name('shalat.index');
Route::post('/api/shalat/kabkota', [QuranController::class, 'getKabKota'])->name('shalat.kabkota');
Route::post('/api/shalat/jadwal', [QuranController::class, 'getJadwal'])->name('shalat.jadwal');