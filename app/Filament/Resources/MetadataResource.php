<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MetadataResource\Pages;
use App\Filament\Resources\MetadataResource\RelationManagers;
use App\Models\Metadata;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MetadataResource extends Resource
{
    protected static ?string $model = Metadata::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->label('Nama Metadata')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Metadata')
                    ->sortable()
            ])
            ->filters([
                TextColumn::make('nama')
                ->label('Nama Metadata')
                ->sortable()
        ])
        ->filters([
            Tables\Filters\Filter::make('nama')
                ->form([
                    TextInput::make('nama')
                        ->label('Nama Metadata')
                        ->placeholder('Masukkan nama metadata'),
                ])
                ->query(fn (Builder $query, array $data): Builder => 
                    $query->when(
                        $data['nama'],
                        fn (Builder $query, $nama) => $query->where('nama', 'like', "%{$nama}%")
                    )
                ),
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
            'index' => Pages\ListMetadata::route('/'),
            'create' => Pages\CreateMetadata::route('/create'),
            'edit' => Pages\EditMetadata::route('/{record}/edit'),
        ];
    }
}
