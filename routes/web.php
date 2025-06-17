<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/absensi', function () {
//     return view('absensi');
// });

Route::get('/absensi', AbsensiForm::class);