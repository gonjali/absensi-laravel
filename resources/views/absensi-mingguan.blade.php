@extends('layouts.app')

@section('title', 'Absensi Mingguan')

@section('content')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .attendance-table {
            border-collapse: collapse;
            width: 100%;
        }
        .attendance-table th,
        .attendance-table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
        }
        .attendance-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
        .attendance-table .name-cell {
            text-align: left;
            font-weight: 500;
            background-color: #f9fafb;
        }
        .attendance-table .day-header {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .checkbox-cell {
            width: 60px;
        }
        .checkbox-input {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .present {
            background-color: #dcfce7;
            color: #166534;
        }
        .absent {
            background-color: #fef2f2;
            color: #dc2626;
        }
        .late {
            background-color: #fef3c7;
            color: #92400e;
        }
    </style>

    <div class="bg-white rounded-lg shadow-lg p-6" x-data="weeklyAttendance()">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Absensi Mingguan</h1>
                <div class="flex items-center space-x-4">
                    <input 
                        type="date" 
                        x-model="selectedDate" 
                        @change="loadWeeklyData()"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <button 
                        @click="previousWeek()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
                    >
                        Minggu Sebelumnya
                    </button>
                    <button 
                        @click="nextWeek()"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
                    >
                        Minggu Berikutnya
                    </button>
                </div>
            </div>

            <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                <p class="text-blue-800">
                    <strong>Periode:</strong> 
                    <span x-text="formatDate(weekStart)"></span> - 
                    <span x-text="formatDate(weekEnd)"></span>
                </p>
            </div>

            <!-- Loading indicator -->
            <div x-show="loading" class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
                <p class="mt-2 text-gray-600">Memuat data...</p>
            </div>

            <!-- Attendance table -->
            <div x-show="!loading" class="overflow-x-auto">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th class="name-cell">Nama</th>
                            <template x-for="day in weekDays" :key="day.tanggal">
                                <th class="day-header" x-text="day.nama_hari"></th>
                            </template>
                        </tr>
                        <tr>
                            <th class="name-cell">Tanggal</th>
                            <template x-for="day in weekDays" :key="day.tanggal">
                                <th class="day-header text-sm" x-text="formatDate(day.tanggal)"></th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="nama in allNames" :key="nama">
                            <tr>
                                <td class="name-cell" x-text="nama"></td>
                                <template x-for="day in weekDays" :key="day.tanggal">
                                    <td class="checkbox-cell">
                                        <div class="flex flex-col items-center">
                                            <input 
                                                type="checkbox" 
                                                class="checkbox-input"
                                                :checked="isPresent(nama, day.tanggal)"
                                                disabled
                                            >
                                            <span 
                                                x-show="getAttendanceTime(nama, day.tanggal)"
                                                class="text-xs mt-1"
                                                x-text="getAttendanceTime(nama, day.tanggal)"
                                                :class="getAttendanceClass(nama, day.tanggal)"
                                            ></span>
                                        </div>
                                    </td>
                                </template>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div x-show="!loading" class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-800">Total Hadir</h3>
                    <p class="text-2xl font-bold text-green-600" x-text="totalPresent"></p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-red-800">Total Tidak Hadir</h3>
                    <p class="text-2xl font-bold text-red-600" x-text="totalAbsent"></p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-800">Total Karyawan</h3>
                    <p class="text-2xl font-bold text-blue-600" x-text="allNames.length"></p>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
        function weeklyAttendance() {
            return {
                selectedDate: new Date().toISOString().split('T')[0],
                weekStart: '',
                weekEnd: '',
                weekDays: [],
                allNames: [],
                attendanceData: {},
                loading: true,

                init() {
                    this.loadWeeklyData();
                },

                async loadWeeklyData() {
                    this.loading = true;
                    try {
                        const response = await fetch(`/api/absensi-mingguan?tanggal=${this.selectedDate}`);
                        const data = await response.json();
                        
                        this.weekStart = data.awalMinggu;
                        this.weekEnd = data.akhirMinggu;
                        this.weekDays = data.hariMingguan;
                        this.allNames = data.semuaNama;
                        this.attendanceData = data.absensiMingguan;
                    } catch (error) {
                        console.error('Error loading data:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                previousWeek() {
                    const currentDate = new Date(this.selectedDate);
                    currentDate.setDate(currentDate.getDate() - 7);
                    this.selectedDate = currentDate.toISOString().split('T')[0];
                    this.loadWeeklyData();
                },

                nextWeek() {
                    const currentDate = new Date(this.selectedDate);
                    currentDate.setDate(currentDate.getDate() + 7);
                    this.selectedDate = currentDate.toISOString().split('T')[0];
                    this.loadWeeklyData();
                },

                isPresent(nama, tanggal) {
                    return this.attendanceData[nama] && 
                           this.attendanceData[nama][tanggal] && 
                           this.attendanceData[nama][tanggal].length > 0 &&
                           this.attendanceData[nama][tanggal][0].kehadiran;
                },

                getAttendanceTime(nama, tanggal) {
                    if (this.attendanceData[nama] && 
                        this.attendanceData[nama][tanggal] && 
                        this.attendanceData[nama][tanggal].length > 0) {
                        const absensi = this.attendanceData[nama][tanggal][0];
                        if (absensi.jam_kedatangan) {
                            return absensi.jam_kedatangan;
                        }
                    }
                    return null;
                },

                getAttendanceClass(nama, tanggal) {
                    if (this.attendanceData[nama] && 
                        this.attendanceData[nama][tanggal] && 
                        this.attendanceData[nama][tanggal].length > 0) {
                        const absensi = this.attendanceData[nama][tanggal][0];
                        if (absensi.jam_kedatangan) {
                            const time = new Date(`2000-01-01T${absensi.jam_kedatangan}`);
                            const targetTime = new Date('2000-01-01T08:00:00');
                            
                            if (time > targetTime) {
                                return 'late';
                            } else {
                                return 'present';
                            }
                        }
                    }
                    return '';
                },

                formatDate(dateString) {
                    if (!dateString) return '';
                    const date = new Date(dateString);
                    return date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                },

                get totalPresent() {
                    let count = 0;
                    this.allNames.forEach(nama => {
                        this.weekDays.forEach(day => {
                            if (this.isPresent(nama, day.tanggal)) {
                                count++;
                            }
                        });
                    });
                    return count;
                },

                get totalAbsent() {
                    let count = 0;
                    this.allNames.forEach(nama => {
                        this.weekDays.forEach(day => {
                            if (!this.isPresent(nama, day.tanggal)) {
                                count++;
                            }
                        });
                    });
                    return count;
                }
            }
        }
    </script> 