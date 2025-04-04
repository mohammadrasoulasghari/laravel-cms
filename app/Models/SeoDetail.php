<?php

namespace App\Models;

use Database\Factories\SeoDetailFactory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeoDetail extends Model
{
    use HasFactory;

    const KEYWORDS = [
        'technology',
        'innovation',
        'science',
        'artificial intelligence',
        'machine learning',
        'data science',
        'coding',
        'programming',
        'web development',
        'cybersecurity',
        'digital marketing',
        'social media',
        'business',
        'finance',
        'health',
        'fitness',
        'travel',
        'food',
        'photography',
        'music',
        'movies',
        'fashion',
        'sports',
        'gaming',
        'books',
        'education',
        'history',
        'culture',
    ];

    protected $fillable = [
        'post_id',
        'title',
        'keywords',
        'description',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'user_id' => 'integer',
        'keywords' => 'json',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class)->orderByDesc('id');
    }

    public static function getForm(): array
    {
        return [
            Select::make('post_id')
                ->label(trans('seo.fields.post'))
                ->createOptionForm(Post::getForm())
                ->editOptionForm(Post::getForm())
                ->relationship('post', 'title')
                ->unique(
                    table_name('seo_details'),
                    'post_id',
                    null,
                    'id'
                )
                ->required()
                ->preload()
                ->searchable()
                ->default(request('post_id') ?? '')
                ->columnSpanFull(),
            TextInput::make('title')
                ->label(trans('seo.fields.title'))
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            TagsInput::make('keywords')
                ->label(trans('seo.fields.keywords'))
                ->columnSpanFull(),
            Textarea::make('description')
                ->label(trans('seo.fields.description'))
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),
        ];
    }

    protected static function newFactory(): SeoDetailFactory
    {
        return new SeoDetailFactory();
    }

    public function getTable(): string
    {
        return table_name('seo_details');
    }
}
