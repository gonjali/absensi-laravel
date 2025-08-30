<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Filament\Resources\AbsensiResource\RelationManagers;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationLabel = 'Absensi karyawan';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('metadata.nama')
                    ->relationship('metadata', 'nama')
                    ->required(),
                    

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

    public static function table(Table $table): Table
    {
        return $table
             ->columns([
                TextColumn::make('nama')
                    ->sortable(),
                 TextColumn::make('hari')
                    ->label('Hari')
                   ->sortable()
                  ->formatStateUsing(function ($state) {
                        // Jika field 'hari' adalah integer (1-5), ubah ke nama hari
                       $days = [
                            1 => 'Senin',
                            2 => 'Selasa',
                            3 => 'Rabu',
                           4 => 'Kamis',
                           5 => 'Jumat',
                       ];
                       return $days[$state] ?? $state;
                   })
                     ->searchable(),
                    TextColumn::make('tanggal')
                        ->label('Tanggal')
                        ->date('d-m-Y')
                        ->sortable()
                        ->searchable(),


                TextColumn::make('jam_kedatangan')
                    ->label('Jam Kedatangan')
                    ->time() // Menampilkan hanya jam
                    ->sortable(),

                Tables\Columns\IconColumn::make('kehadiran')
                    ->boolean()
                    ->label('Hadir?'),

                TextColumn::make('catatan')
                    ->label('Catatan')
                    ->wrap()
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}
