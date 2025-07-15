<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventarisResource\Pages;
use App\Filament\Resources\InventarisResource\RelationManagers;
use App\Models\Inventaris;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventarisResource extends Resource
{
    protected static ?string $model = Inventaris::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            TextInput::make('nama')->required()->label('Nama Laptop'),
            TextInput::make('tipe'),
            TextInput::make('processor'),
            TextInput::make('ram'),
            TextInput::make('merek')->label('Merek Laptop'),
            TextInput::make('lokasi')->label('Lokasi Laptop'),
            TextInput::make('storage'),
            TextInput::make('tahun_perolehan'),
            Select::make('kondisi')->options([
                'baru' => 'Baru',
                'baik' => 'Baik',
                'rusak_ringan' => 'Rusak Ringan',
                'rusak_berat' => 'Rusak Berat',
            ])->default('baik'),
            Select::make('status')->options([
                'tersedia' => 'Tersedia',
                'dipakai' => 'Dipakai',
                'rusak' => 'Rusak',
            ])->default('tersedia'),
            TextInput::make('digunakan_oleh')->label('Dipakai oleh'),
            Textarea::make('keterangan')->label('Keterangan Tambahan'),
            FileUpload::make('foto')->image()->directory('laptop-fotos'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('tipe'),
            TextColumn::make('ram'),
            ImageColumn::make('foto')
                ->label('Foto')
                ->disk('public')
                ->height(50)
                ->width(100)
                ->circular(false)
                ->extraImgAttributes(['style' => 'object-fit:contain;']),

            Tables\Columns\BadgeColumn::make('kondisi')->colors([
                'success' => 'baik',
                'info' => 'baru',
                'warning' => 'rusak_ringan',
                'danger' => 'rusak_berat',
            ]),
            Tables\Columns\BadgeColumn::make('status')->colors([
                'success' => 'tersedia',
                'warning' => 'dipakai',
                'danger' => 'rusak',
            ]),
            Tables\Columns\TextColumn::make('digunakan_oleh'),
        ])
            
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                'tersedia' => 'Tersedia',
                'dipakai' => 'Dipakai',
                'rusak' => 'Rusak',
            ]),
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
            'index' => Pages\ListInventaris::route('/'),
            'create' => Pages\CreateInventaris::route('/create'),
            'edit' => Pages\EditInventaris::route('/{record}/edit'),
        ];
    }
}
