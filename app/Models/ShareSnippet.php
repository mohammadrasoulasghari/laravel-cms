<?php

namespace App\Models;

use Database\Factories\ShareSnippetFactory;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareSnippet extends Model
{
    use HasFactory;

    public function getTable(): string
    {
        return table_name('share_snippets');
    }

    protected $fillable = [
        'script_code',
        'html_code',
    ];

    protected $casts = [
        'script_code' => 'string',
        'html_code' => 'string',
    ];

    public function scopeActive(Builder $query)
    {
        return $query->where('active', true);
    }

    public static function getForm(): array
    {
        return [
            Textarea::make('script_code')
                ->label('JS Script')
                ->required(),
            Textarea::make('html_code')
                ->required(),
            Toggle::make('active'),
        ];
    }

    protected static function newFactory(): ShareSnippetFactory
    {
        return new ShareSnippetFactory();
    }
}
