<?php

use Illuminate\Support\Facades\Route;

Route::get('/presentacion', function () {
    return view('ejemplos');
});
