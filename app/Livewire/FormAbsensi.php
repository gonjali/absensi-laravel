<?php

use App\Livewire\Absensi;
use Livewire\Component;

class AbsensiForm extends Component
{
    public $nama, $jam_kedatangan, $kehadiran = false, $catatan;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'jam_kedatangan' => 'required',
        'kehadiran' => 'boolean',
        'catatan' => 'nullable|string',
    ];

    public function submit()
    {
        $this->validate();

        // Simpan ke database
        Absensi::create([
            'nama' => $this->nama,
            'jam_kedatangan' => $this->jam_kedatangan,
            'kehadiran' => $this->kehadiran,
            'catatan' => $this->catatan,
        ]);

        session()->flash('success', 'Absensi berhasil disimpan.');
        $this->reset(); // Reset form
    }

    public function render()
    {
        return view('livewire.absensi-form');
    }
}
