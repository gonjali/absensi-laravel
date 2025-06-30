<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('absensis')->insert([
            [
                'nama' => 'Raka',
                'jam_kedatangan' => '08:00',
                'kehadiran' => true,
                'senin' => 'Hadir',
                'selasa' => 'Hadir',
                'rabu' => 'Tidak Hadir',
                'kamis' => 'Hadir',
                'jumat' => 'Hadir',
                'catatan' => 'Tidak ada catatan',
            ],
            [
                'nama' => 'Andi',
                'jam_kedatangan' => '08:15',
                'kehadiran' => false,
                'senin' => 'Hadir',
                'selasa' => 'Hadir',
                'rabu' => 'Hadir',
                'kamis' => 'Tidak Hadir',
                'jumat' => 'Hadir',
                'catatan' => 'Izin sakit pada hari Kamis',
            ],
        ]);
    }
}
