<?php

namespace App\Filament\Resources\ShareSnippetResource\Pages;

use App\Filament\Resources\ShareSnippetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListShareSnippets extends ListRecords
{
    protected static string $resource = ShareSnippetResource::class;

    protected ?string $subheading = 'لطفاً برای دریافت کد اسکریپت و کد HTML مربوط به اسنیپت‌های اشتراک‌گذاری به آدرس https://platform.sharethis.com مراجعه نمایید';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableDescription(): string|Htmlable|null
    {
        return 'Share Snippets';
    }
}
