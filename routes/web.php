<?php

use App\Livewire\Absensi;
use App\Livewire\Piket;
 // Ensure this is the correct namespace for your Metadata Livewire component
// use App\Livewire\Metadata; // Make sure this file exists at app/Livewire/Metadata.php

// If the class is named differently or in a different namespace, update the import accordingly.
// For example, if the correct class is App\Http\Livewire\Metadata, use:
use App\Http\Livewire\Metadata;
use App\Http\Controllers\MetadataController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Route for metadata Livewire component
Route::get('/absensi', Absensi::class);
Route::get('/piket', Piket::class);
// Route for MetadataController
Route::get('/metadata-controller', [MetadataController::class, 'index'])->name('metadata.index');

// Route for weekly attendance
Route::get('/absensi-mingguan', [App\Http\Controllers\AbsensiMingguanController::class, 'index'])->name('absensi.mingguan');
Route::get('/api/absensi-mingguan', [App\Http\Controllers\AbsensiMingguanController::class, 'getDataMingguan'])->name('absensi.mingguan.api');