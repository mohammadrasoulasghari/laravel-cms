<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, cms_config('tables.prefix').'category_'.cms_config('tables.prefix').'post');
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->live(true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $operation, ?string $old, ?string $state) {

                    $set('slug', Str::slug($state));
                })
                ->unique(cms_config('tables.prefix').'categories', 'name', null, 'id')
                ->required()
                ->maxLength(155),

            TextInput::make('slug')
                ->unique(cms_config('tables.prefix').'categories', 'slug', null, 'id')
                ->readOnly()
                ->maxLength(255),
        ];
    }

    protected static function newFactory(): CategoryFactory
    {
        return new CategoryFactory();
    }

    public function getTable(): string
    {
        return table_name('categories');
    }
}
