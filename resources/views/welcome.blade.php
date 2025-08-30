@extends('layouts.app')

@section('title', 'Sistem Absensi - Beranda')

@section('content')
<div class="text-center">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Selamat Datang di Sistem Absensi</h1>
        <p class="text-lg text-gray-600">Kelola kehadiran karyawan dengan mudah dan efisien</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
        <!-- Absensi Mingguan Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-blue-500 mb-4">
                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Absensi Mingguan</h3>
                <p class="text-gray-600 mb-4">Lihat rekap kehadiran karyawan per minggu (5 hari kerja) dengan format yang mudah dibaca</p>
            <a href="{{ route('absensi.mingguan') }}" class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Lihat Absensi
            </a>
        </div>

        <!-- Input Absensi Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-green-500 mb-4">
                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Input Absensi</h3>
            <p class="text-gray-600 mb-4">Catat kehadiran karyawan dengan mudah dan cepat</p>
            <a href="/absensi" class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors">
                Input Absensi
            </a>
        </div>

        <!-- Piket Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
            <div class="text-purple-500 mb-4">
                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
            </div>
            <h3 class="text-xl font-semibold text-graykaryawan-800 mb-2">Piket</h3>
            <p class="text-gray-600 mb-4">Catat pelaksanaan piket dan tugas </p>
            <a href="/piket" class="inline-block bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600 transition-colors">
                Input Piket
            </a>
        </div>
                </div>

    <!-- Quick Stats -->
    <div class="mt-12 bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Statistik Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600" id="totalKaryawan">-</div>
                <div class="text-sm text-blue-800">Total Karyawan</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600" id="hadirHariIni">-</div>
                <div class="text-sm text-green-800">Hadir Hari Ini</div>
            </div>
            <div class="text-center p-4 bg-orange-50 rounded-lg">
                <div class="text-2xl font-bold text-orange-600" id="mingguIni">-</div>
                <div class="text-sm text-orange-800">Minggu Ini</div>
                </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load quick stats
    loadQuickStats();
});

async function loadQuickStats() {
    try {
        // Get current week data
        const response = await fetch('/api/absensi-mingguan');
        const data = await response.json();
        
        // Update stats
        document.getElementById('totalKaryawan').textContent = data.semuaNama.length;
        
        // Count today's attendance
        const today = new Date().toISOString().split('T')[0];
        let todayCount = 0;
        data.semuaNama.forEach(nama => {
            if (data.absensiMingguan[nama] && data.absensiMingguan[nama][today]) {
                todayCount++;
            }
        });
        document.getElementById('hadirHariIni').textContent = todayCount;
        
        // Count this week's total attendance
        let weekCount = 0;
        data.semuaNama.forEach(nama => {
            data.hariMingguan.forEach(day => {
                if (data.absensiMingguan[nama] && data.absensiMingguan[nama][day.tanggal]) {
                    weekCount++;
                }
            });
        });
        document.getElementById('mingguIni').textContent = weekCount;
        
    } catch (error) {
        console.error('Error loading stats:', error);
    }
}
</script>
@endsection 