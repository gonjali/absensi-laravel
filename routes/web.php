<?php

use App\Livewire\Absensi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/absensi', Absensi::class);