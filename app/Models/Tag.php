<?php

namespace App\Models;

use Database\Factories\TagFactory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
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
        return $this->belongsToMany(
            Post::class,
            table_name('post') . '_' . table_name('tag')
        );
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->label(trans('tags.fields.name'))
                ->live(true)
                ->afterStateUpdated(fn(Set $set, ?string $state) => $set(
                    'slug',
                    Str::slug($state)
                ))
                ->unique(table_name('tags'), 'name', null, 'id')
                ->required()
                ->maxLength(50),

            TextInput::make('slug')
                ->label(trans('tags.fields.slug'))
                ->unique(cms_config('tags'), 'slug', null, 'id')
                ->readOnly()
                ->maxLength(155),
        ];
    }

    protected static function newFactory(): TagFactory
    {
        return new TagFactory();
    }

    public function getTable(): string
    {
        return table_name('tags');
    }
}
