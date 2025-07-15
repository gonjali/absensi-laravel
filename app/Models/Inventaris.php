<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    protected $table = 'inventaris';
    
    protected $fillable = [
        'nama',
        'merek',
        'tipe',
        'processor',
        'ram',
        'storage',
        'tahun_perolehan',
        'kondisi',
        'status',
        'digunakan_oleh',
        'lokasi',
        'keterangan',
        'foto',
    ];

    protected $casts = [
        'tahun_perolehan' => 'integer',
    ];
}
