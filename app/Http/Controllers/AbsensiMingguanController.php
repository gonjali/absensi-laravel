<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Metadata;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiMingguanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari request atau gunakan tanggal hari ini
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));
        $tanggalCarbon = Carbon::parse($tanggal);
        
        // Hitung awal dan akhir minggu
        $awalMinggu = $tanggalCarbon->copy()->startOfWeek();
        $akhirMinggu = $tanggalCarbon->copy()->endOfWeek();
        
        // Ambil semua nama dari metadata
        $semuaNama = Metadata::pluck('nama')->toArray();
        
        // Ambil data absensi untuk minggu tersebut
        $absensiMingguan = Absensi::whereBetween('tanggal', [$awalMinggu->format('Y-m-d'), $akhirMinggu->format('Y-m-d')])
            ->get()
            ->groupBy(['nama', 'tanggal']);
        
        // Buat array untuk setiap hari dalam minggu
        $hariMinggu = [];
        for ($i = 0; $i < 7; $i++) {
            $tanggal = $awalMinggu->copy()->addDays($i);
            $hariMinggu[] = [
                'tanggal' => $tanggal->format('Y-m-d'),
                'hari' => $tanggal->translatedFormat('l'),
                'nama_hari' => $tanggal->translatedFormat('l'),
            ];
        }
        
        return view('absensi-mingguan', compact('semuaNama', 'hariMinggu', 'absensiMingguan', 'awalMinggu', 'akhirMinggu'));
    }
    
    public function getDataMingguan(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));
        $tanggalCarbon = Carbon::parse($tanggal);
        
        $awalMinggu = $tanggalCarbon->copy()->startOfWeek();
        $akhirMinggu = $tanggalCarbon->copy()->endOfWeek();
        
        $semuaNama = Metadata::pluck('nama')->toArray();
        
        $absensiMingguan = Absensi::whereBetween('tanggal', [$awalMinggu->format('Y-m-d'), $akhirMinggu->format('Y-m-d')])
            ->get()
            ->groupBy(['nama', 'tanggal']);
        
        $hariMinggu = [];
        for ($i = 0; $i < 7; $i++) {
            $tanggal = $awalMinggu->copy()->addDays($i);
            $hariMinggu[] = [
                'tanggal' => $tanggal->format('Y-m-d'),
                'hari' => $tanggal->translatedFormat('l'),
                'nama_hari' => $tanggal->translatedFormat('l'),
            ];
        }
        
        return response()->json([
            'semuaNama' => $semuaNama,
            'hariMingguan' => $hariMinggu,
            'absensiMingguan' => $absensiMingguan,
            'awalMinggu' => $awalMinggu->format('Y-m-d'),
            'akhirMinggu' => $akhirMinggu->format('Y-m-d')
        ]);
    }
} 