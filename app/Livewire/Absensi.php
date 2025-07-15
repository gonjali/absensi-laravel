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
    public $kehadiran = false;
    public $catatan;

    // Variabel untuk menampung data Metadata
    public $metadatas = [];

    public function mount(): void
    {
        $this->metadatas = Metadata::all(); // Ambil semua data dari tabel Metadata
        $this->form->fill(); // Isi default jika ada
    }

    public function submit()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'jam_kedatangan' => 'required',
            'kehadiran' => 'boolean',
            'catatan' => $this->kehadiran ? 'nullable|string|max:1000' : 'required|string|max:1000',
        ]);

        ModelsAbsensi::create([
            'nama' => $this->nama,
            'jam_kedatangan' => $this->jam_kedatangan,
            'kehadiran' => $this->kehadiran,
            'catatan' => $this->catatan,
        ]);

        session()->flash('success', 'Absensi berhasil disimpan!');

        // Reset form
        $this->reset(['nama', 'jam_kedatangan', 'kehadiran', 'catatan']);
    }

    public function render()
    {
        return view('livewire.absensi', [
            'metadatas' => $this->metadatas,
        ]);
    }
}
