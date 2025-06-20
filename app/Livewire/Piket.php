<?php

namespace App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class Piket extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(); // isi default jika ada
    }

    public $name;
    public $tanggal_waktu_piket;
    public $piket = false;
    public $catatan;
    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'tanggal_waktu_piket' => 'required|date',
            'piket' => 'boolean',
            'catatan' => 'nullable|string|max:1000',
        ]);
        
        \App\Models\Piket::create([
            'name' => $this->name,
            'tanggal_waktu_piket' => $this->tanggal_waktu_piket,
            'piket' => $this->piket,
            'catatan' => $this->catatan,
        ]);

        session()->flash('success', 'Piket berhasil disimpan!');

        // Reset form
        $this->reset(['name', 'tanggal_waktu_piket', 'piket', 'catatan']);
    }
    public function mountForm()
    {
        $this->form->fill(); // isi default jika ada
    }
    public function render()
    {
        return view('livewire.piket')
            ->layout('layouts.absensi');
    }
}
