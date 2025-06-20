<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PiketresourceResource\Pages;
use App\Filament\Resources\PiketresourceResource\RelationManagers;
use App\Models\Piket;
use App\Models\Piketresource;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PiketresourceResource extends Resource
{
    protected static ?string $model = Piket::class;

    protected static ?string $navigationLabel = 'piket';


    protected static ?string $navigationIcon = 'heroicon-o-trash';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TimePicker::make('tanggal_waktu_piket')
                    ->label('Tanggal dan Waktu Piket')
                    ->required(),
                Toggle::make('piket')
                    ->label('Status Piket')
                    ->required(),
                TextInput::make('catatan')
                    ->label('Catatan')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
               TextColumn::make('tanggal_waktu_piket')
                    ->label('Tanggal'),
                ToggleColumn::make('piket')
                    ->label('Status Piket'),
                TextColumn::make('catatan')
                    ->label('Catatan')
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
            'index' => Pages\ListPiketresources::route('/'),
            'create' => Pages\CreatePiketresource::route('/create'),
            'edit' => Pages\EditPiketresource::route('/{record}/edit'),
        ];
    }
}
