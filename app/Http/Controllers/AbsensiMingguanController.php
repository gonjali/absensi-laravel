<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Metadata;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
        
        // Hitung total hadir, tidak hadir, dan izin per karyawan
        $totalPerKaryawan = [];
        foreach ($semuaNama as $nama) {
            $totalHadir = 0;
            $totalTidakHadir = 0;
            $totalIzin = 0;
            
            for ($i = 0; $i < 5; $i++) {
                $tanggal = $awalMinggu->copy()->addDays($i)->format('Y-m-d');
                if (isset($absensiMingguan[$nama][$tanggal])) {
                    $absensi = $absensiMingguan[$nama][$tanggal]->first();
                    if ($absensi->kehadiran) {
                        $totalHadir++;
                    } else {
                        // Cek apakah ada catatan izin (status izin)
                        if (!empty(trim($absensi->catatan))) {
                            $totalIzin++;
                        } else {
                            $totalTidakHadir++;
                        }
                    }
                } else {
                    // Jika tidak ada data absensi sama sekali, dianggap tidak hadir
                    $totalTidakHadir++;
                }
            }
            
            $totalPerKaryawan[$nama] = [
                'hadir' => $totalHadir,
                'tidak_hadir' => $totalTidakHadir,
                'izin' => $totalIzin
            ];
        }
        
        // Buat array untuk 5 hari kerja (Senin-Jumat)
        $hariMinggu = [];
        for ($i = 0; $i < 5; $i++) {
            $tanggal = $awalMinggu->copy()->addDays($i);
            $hariMinggu[] = [
                'tanggal' => $tanggal->format('Y-m-d'),
                'hari' => $tanggal->translatedFormat('l'),
                'nama_hari' => $tanggal->translatedFormat('l'),
            ];
        }
        
        return view('absensi-mingguan', compact('semuaNama', 'hariMinggu', 'absensiMingguan', 'awalMinggu', 'akhirMinggu', 'totalPerKaryawan'));
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
        
        // Hitung total hadir, tidak hadir, dan izin per karyawan
        $totalPerKaryawan = [];
        foreach ($semuaNama as $nama) {
            $totalHadir = 0;
            $totalTidakHadir = 0;
            $totalIzin = 0;
            
            for ($i = 0; $i < 5; $i++) {
                $tanggal = $awalMinggu->copy()->addDays($i)->format('Y-m-d');
                if (isset($absensiMingguan[$nama][$tanggal])) {
                    $absensi = $absensiMingguan[$nama][$tanggal]->first();
                    if ($absensi->kehadiran) {
                        $totalHadir++;
                    } else {
                        // Cek apakah ada catatan izin (status izin)
                        if (!empty(trim($absensi->catatan))) {
                            $totalIzin++;
                        } else {
                            $totalTidakHadir++;
                        }
                    }
                } else {
                    // Jika tidak ada data absensi sama sekali, dianggap tidak hadir
                    $totalTidakHadir++;
                }
            }
            
            $totalPerKaryawan[$nama] = [
                'hadir' => $totalHadir,
                'tidak_hadir' => $totalTidakHadir,
                'izin' => $totalIzin
            ];
        }
        
        // Buat array untuk 5 hari kerja (Senin-Jumat)
        $hariMinggu = [];
        for ($i = 0; $i < 5; $i++) {
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
            'totalPerKaryawan' => $totalPerKaryawan,
            'awalMinggu' => $awalMinggu->format('Y-m-d'),
            'akhirMinggu' => $akhirMinggu->format('Y-m-d')
        ]);
    }
    
    public function exportExcel(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));
        $tanggalCarbon = Carbon::parse($tanggal);
        
        $awalMinggu = $tanggalCarbon->copy()->startOfWeek();
        $akhirMinggu = $tanggalCarbon->copy()->endOfWeek();
        
        $semuaNama = Metadata::pluck('nama')->toArray();
        
        $absensiMingguan = Absensi::whereBetween('tanggal', [$awalMinggu->format('Y-m-d'), $akhirMinggu->format('Y-m-d')])
            ->get()
            ->groupBy(['nama', 'tanggal']);
        
        // Hitung total hadir, tidak hadir, dan izin per karyawan
        $totalPerKaryawan = [];
        foreach ($semuaNama as $nama) {
            $totalHadir = 0;
            $totalTidakHadir = 0;
            $totalIzin = 0;
            
            for ($i = 0; $i < 5; $i++) {
                $tanggal = $awalMinggu->copy()->addDays($i)->format('Y-m-d');
                if (isset($absensiMingguan[$nama][$tanggal])) {
                    $absensi = $absensiMingguan[$nama][$tanggal]->first();
                    if ($absensi->kehadiran) {
                        $totalHadir++;
                    } else {
                        // Cek apakah ada catatan izin (status izin)
                        if (!empty(trim($absensi->catatan))) {
                            $totalIzin++;
                        } else {
                            $totalTidakHadir++;
                        }
                    }
                } else {
                    // Jika tidak ada data absensi sama sekali, dianggap tidak hadir
                    $totalTidakHadir++;
                }
            }
            
            $totalPerKaryawan[$nama] = [
                'hadir' => $totalHadir,
                'tidak_hadir' => $totalTidakHadir,
                'izin' => $totalIzin
            ];
        }
        
        // Buat array untuk 5 hari kerja (Senin-Jumat)
        $hariMinggu = [];
        for ($i = 0; $i < 5; $i++) {
            $tanggal = $awalMinggu->copy()->addDays($i);
            $hariMinggu[] = [
                'tanggal' => $tanggal->format('Y-m-d'),
                'hari' => $tanggal->translatedFormat('l'),
                'nama_hari' => $tanggal->translatedFormat('l'),
            ];
        }
        
        // Buat spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set judul
        $sheet->setCellValue('A1', 'REKAP ABSENSI MINGGUAN (5 HARI KERJA)');
        $sheet->mergeCells('A1:' . chr(ord('A') + 7) . '1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Set periode
        $sheet->setCellValue('A2', 'Periode: ' . $awalMinggu->format('d/m/Y') . ' - ' . $akhirMinggu->format('d/m/Y'));
        $sheet->mergeCells('A2:' . chr(ord('A') + 7) . '2');
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Header kolom
        $headers = ['Nama Karyawan'];
        foreach ($hariMinggu as $hari) {
            $headers[] = $hari['nama_hari'] . ' (' . $hari['tanggal'] . ')';
        }
        $headers[] = 'Total Hadir';
        $headers[] = 'Total Izin';
        $headers[] = 'Total Tidak Hadir';
        
        $col = 'A';
        $row = 4;
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->getFont()->setBold(true);
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D1ECF1');
            $col++;
        }
        
        // Data karyawan
        $row = 5;
        foreach ($semuaNama as $nama) {
            $col = 'A';
            $sheet->setCellValue($col . $row, $nama);
            $col++;
            
            foreach ($hariMinggu as $hari) {
                $tanggal = $hari['tanggal'];
                $status = '';
                $jam = '';
                $catatan = '';
                
                if (isset($absensiMingguan[$nama][$tanggal])) {
                    $absensi = $absensiMingguan[$nama][$tanggal]->first();
                    if ($absensi->kehadiran) {
                        $status = '✓';
                        $jam = $absensi->jam_kedatangan;
                        $catatan = $absensi->catatan;
                        $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D4EDDA');
                    } else {
                        if (!empty(trim($absensi->catatan))) {
                            $status = '🟡 IZIN';
                            $catatan = $absensi->catatan;
                            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFF3CD');
                        } else {
                            $status = '✗';
                            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8D7DA');
                        }
                    }
                } else {
                    $status = '✗';
                    $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8D7DA');
                }
                
                $cellValue = $status;
                if ($jam) $cellValue .= ' (' . $jam . ')';
                if ($catatan) $cellValue .= "\n" . $catatan;
                
                $sheet->setCellValue($col . $row, $cellValue);
                $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($col . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle($col . $row)->getAlignment()->setWrapText(true);
                $col++;
            }
            
            // Total hadir
            $sheet->setCellValue($col . $row, $totalPerKaryawan[$nama]['hadir']);
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D4EDDA');
            $col++;
            
            // Total izin
            $sheet->setCellValue($col . $row, $totalPerKaryawan[$nama]['izin']);
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFF3CD');
            $col++;
            
            // Total tidak hadir
            $sheet->setCellValue($col . $row, $totalPerKaryawan[$nama]['tidak_hadir']);
            $sheet->getStyle($col . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8D7DA');
            
            $row++;
        }
        
        // Auto-size columns
        foreach (range('A', chr(ord('A') + count($headers) - 1)) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Border untuk semua data
        $lastRow = $row - 1;
        $lastCol = chr(ord('A') + count($headers) - 1);
        $sheet->getStyle('A4:' . $lastCol . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        // Set nama file
        $filename = 'Absensi_Mingguan_5Hari_' . $awalMinggu->format('Y-m-d') . '_' . $akhirMinggu->format('Y-m-d') . '.xlsx';
        
        // Set header untuk download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Tulis file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
} 