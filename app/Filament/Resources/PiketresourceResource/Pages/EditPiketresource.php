<?php

namespace App\Filament\Resources\PiketresourceResource\Pages;

use App\Filament\Resources\PiketresourceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPiketresource extends EditRecord
{
    protected static string $resource = PiketresourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
