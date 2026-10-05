<?php

use App\Http\Controllers\QuotesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/produk', function () {
    return response()->json([
        [ 
            "id" => 1,
            "nama" => "Buku Lima Sekawan",
            "harga" => 50000,
            "stok" => 5
        ],
        [
            "id" => 2,
            "nama" => "Buku Enam Sekawan",
            "harga" => 60000,
            "stok" => 6
        ],
        [
            "id" => 3,
            "nama" => "Buku Tujuh Sekawan",
            "harga" => 70000,
            "stok" => 7 
        ]
   ] ) ;
});

Route::get('/produk/2', function () {
    return response()->json([
        [ 
            "id" => 2,
            "nama" => "Buku Lima Sekawan",
            "harga" => 50000,
            "stok" => 10
        ]
   ]) ;
});

Route::resource('/', QuotesController::class);