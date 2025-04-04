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
        return $this->belongsToMany(Post::class, table_name('category').'_'.table_name('post'));
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label(trans('category.fields.name'))
                ->live(true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $operation, ?string $old, ?string $state) {

                    $set('slug', Str::slug($state));
                })
                ->unique(table_name('categories'), 'name', null, 'id')
                ->required()
                ->maxLength(155),

            TextInput::make('slug')
                ->label(trans('category.fields.slug'))
                ->unique(table_name('categories'), 'slug', null, 'id')
                ->readOnly()
                ->maxLength(255),
        ];
    }

    protected static function newFactory(): CategoryFactory
    {
        return new CategoryFactory;
    }

    public function getTable(): string
    {
        return table_name('categories');
    }
}
