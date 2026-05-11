<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; // Importación correcta al inicio

Route::get('/', function () {
    return view('welcome');
});

// Esta única línea habilita todas las funciones del CRUD (ver, crear, borrar, etc.)
Route::resource('products', ProductController::class);