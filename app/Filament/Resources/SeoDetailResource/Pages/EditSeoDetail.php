<?php

namespace App\Filament\Resources\SeoDetailResource\Pages;

use App\Filament\Resources\SeoDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeoDetail extends EditRecord
{
    protected static string $resource = SeoDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
