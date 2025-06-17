<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika mengikuti konvensi Laravel)
    protected $table = 'absensis';

    // Field yang boleh diisi secara massal
    protected $fillable = [
        'nama',
        'jam_kedatangan',
        'kehadiran',
        'catatan',
    ];

    // Tipe data cast untuk field tertentu
    protected $casts = [
        'jam_kedatangan' => 'datetime:H:i',
        'kehadiran' => 'boolean',
    ];

    // Relasi: satu Absensi memiliki satu atau banyak Catatan
   
}
