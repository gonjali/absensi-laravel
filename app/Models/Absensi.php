<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'nama',
        'hari',
        'tanggal',
        'jam_kedatangan',
        'kehadiran',
        'catatan',
    ];

    protected $casts = [
        'jam_kedatangan' => 'datetime:H:i',
        'kehadiran' => 'boolean',
    ];

    // Relasi ke Metadata
    public function metadata()
    {
        return $this->belongsTo(Metadata::class, 'nama', 'nama');
    }
}
