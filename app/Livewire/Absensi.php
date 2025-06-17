<?php

namespace App\Livewire;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class Absensi extends Component implements HasForms
{
    use InteractsWithForms;

    public $nama = '';
    public $jam_kedatangan = '';
    public $kehadiran = true;
    public $catatan = '';

    public function form(Form $form): Form
    {
          return $form
            ->schema([
                 TextInput::make('nama')
        ->required()
        ->maxLength(225),

    TimePicker::make('jam_kedatangan')
    ->label('jam kedatangan')
        ->required(),

    Toggle::make('kehadiran')
        ->label('Hadir?'),

    Textarea::make('catatan')
        ->label('Catatan')
        ->rows(4)
        ->maxLength(1000),
            ]);
    }

    public function submit()
    {
        $data = $this->form->getState();

        Absensi::create($data);

        $this->form->fill(); // Reset setelah submit

        session()->flash('success', 'Absensi berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.absensi');
    }
}
