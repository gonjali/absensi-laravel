<?php

namespace App\Observers;

use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiObserver
{
    /**
     * Handle the Absensi "creating" event.
     */
    public function creating(Absensi $absensi): void
    {
        // Auto-set hari berdasarkan tanggal
        if ($absensi->tanggal && !$absensi->hari) {
            $absensi->hari = Carbon::parse($absensi->tanggal)->translatedFormat('l');
        }
    }

    /**
     * Handle the Absensi "updating" event.
     */
    public function updating(Absensi $absensi): void
    {
        // Auto-update hari jika tanggal berubah
        if ($absensi->isDirty('tanggal')) {
            $absensi->hari = Carbon::parse($absensi->tanggal)->translatedFormat('l');
        }
    }
} 