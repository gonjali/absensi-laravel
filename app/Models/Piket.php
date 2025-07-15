<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piket extends Model
{
    protected $table = 'piket';

    use HasFactory;

    protected $fillable = [
        'name',
        'piket',
        'hari',
        'catatan',
        'tanggal_waktu_piket',
    ];
    
    protected $casts = [
        
        'tanggal_waktu_pike' => 'datetime:Y-m-d H:i:s',
        
    ];
}
