<?php

namespace App\Livewire;

use App\Models\Absensi as ModelsAbsensi;
use App\Models\Metadata;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Absensi extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $nama;
    public $jam_kedatangan;
    public $status_kehadiran = 'hadir';
    public $catatan;

    // Variabel untuk menampung data Metadata
    public $metadatas = [];

    public function mount(): void
    {
        $this->metadatas = Metadata::all(); // Ambil semua data dari tabel Metadata
        $this->jam_kedatangan = now()->format('H:i'); // Set jam otomatis saat ini
        $this->form->fill(); // Isi default jika ada
    }

    public function submit()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'status_kehadiran' => 'required|in:hadir,izin,tidak_hadir',
            'jam_kedatangan' => $this->status_kehadiran === 'hadir' ? 'required' : 'nullable',
            'catatan' => $this->status_kehadiran === 'izin' ? 'required|string|max:1000' : 'nullable|string|max:1000',
        ]);

        // Konversi status kehadiran ke boolean untuk database
        $kehadiran = $this->status_kehadiran === 'hadir';
        
        // Jika izin atau tidak hadir, jam kedatangan kosong
        if ($this->status_kehadiran !== 'hadir') {
            $this->jam_kedatangan = null;
        }

        ModelsAbsensi::create([
            'nama' => $this->nama,
            'jam_kedatangan' => $this->jam_kedatangan,
            'kehadiran' => $kehadiran,
            'catatan' => $this->catatan,
        ]);

        session()->flash('success', 'Absensi berhasil disimpan!');

        // Reset form
        $this->reset(['nama', 'jam_kedatangan', 'status_kehadiran', 'catatan']);
    }

    public function render()
    {
        return view('livewire.absensi', [
            'metadatas' => $this->metadatas,
        ])->layout('layouts.absensi');
    }
}
