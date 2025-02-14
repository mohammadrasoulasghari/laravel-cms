<?php

namespace App\Filament\Resources\SeoDetailResource\Pages;

use App\Filament\Resources\SeoDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeoDetails extends ListRecords
{
    protected static string $resource = SeoDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
