<?php

namespace App\Models;

use App\Enums\PostStatus;
use Database\Factories\PostFactory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'sub_title',
        'body',
        'status',
        'published_at',
        'scheduled_for',
        'cover_photo_path',
        'photo_alt_text',
        'user_id',
    ];

    protected array $dates = [
        'scheduled_for',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'            => 'integer',
        'published_at'  => 'datetime',
        'scheduled_for' => 'datetime',
        'status'        => PostStatus::class,
        'user_id'       => 'integer',
    ];

    protected static function newFactory(): PostFactory
    {
        return new PostFactory();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, table_name('category').'_'.table_name('post'));
    }

    public function comments(): hasmany
    {
        return $this->hasMany(Comment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, table_name('post').'_'.table_name('tag'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(cms_config('user.model'), cms_config('user.foreign_key'));
    }

    public function seoDetail(): HasOne
    {
        return $this->hasOne(SeoDetail::class);
    }

    public function isNotPublished(): bool
    {
        return !$this->isStatusPublished();
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', PostStatus::PUBLISHED)->latest('published_at');
    }

    public function scopeScheduled(Builder $query)
    {
        return $query->where('status', PostStatus::SCHEDULED)->latest('scheduled_for');
    }

    public function scopePending(Builder $query)
    {
        return $query->where('status', PostStatus::PENDING)->latest('created_at');
    }

    public function formattedPublishedDate()
    {
        return $this->published_at?->format('d M Y');
    }

    public function isScheduled(): bool
    {
        return $this->status === PostStatus::SCHEDULED;
    }

    public function isStatusPublished(): bool
    {
        return $this->status === PostStatus::PUBLISHED;
    }

    public function relatedPosts($take = 3)
    {
        return $this->whereHas('categories', function ($query) {
            $query->whereIn(table_name('categories').'.id', $this->categories->pluck('id'))
                ->whereNotIn(table_name('posts').'.id', [$this->id]);
        })->published()->with('user')->take($take)->get();
    }

    protected function getFeaturePhotoAttribute(): string
    {
        return asset('storage/'.$this->cover_photo_path);
    }

    public static function getForm(): array
    {
        return [
            Section::make('Blog Details')
                ->label(trans('posts.form.blog_details'))
                ->schema([
                    Fieldset::make('Titles')
                        ->label(trans('posts.form.titles'))
                        ->schema([
                            Select::make('category_id')
                                ->label(trans('posts.form.category'))
                                ->multiple()
                                ->preload()
                                ->createOptionForm(Category::getForm())
                                ->searchable()
                                ->relationship('categories', 'name')
                                ->columnSpanFull(),

                            TextInput::make('title')
                                ->label(trans('posts.form.title'))
                                ->live(true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set(
                                    'slug',
                                    Str::slug($state)
                                ))
                                ->required()
                                ->unique(cms_config('posts'), 'title', null, 'id')
                                ->maxLength(255),

                            TextInput::make('slug')
                                ->label(trans('posts.form.slug'))
                                ->maxLength(255),

                            Textarea::make('sub_title')
                                ->label(trans('posts.form.sub_title'))
                                ->maxLength(255)
                                ->columnSpanFull(),

                            Select::make('tag_id')
                                ->label(trans('posts.form.tags'))
                                ->multiple()
                                ->preload()
                                ->createOptionForm(Tag::getForm())
                                ->searchable()
                                ->relationship('tags', 'name')
                                ->columnSpanFull(),
                        ]),
                    TiptapEditor::make('body')
                        ->label(trans('posts.form.body'))
                        ->profile('default')
                        ->disableFloatingMenus()
                        ->extraInputAttributes(['style' => 'max-height: 30rem; min-height: 24rem'])
                        ->required()
                        ->columnSpanFull(),
                    Fieldset::make('Feature Image')
                        ->label(trans('posts.form.feature_image'))
                        ->schema([
                            FileUpload::make('cover_photo_path')
                                ->label(trans('posts.form.cover_photo'))
                                ->directory('/blog-feature-images')
                                ->hint('This cover image is used in your blog post as a feature image. Recommended image size 1200 X 628')
                                ->image()
                                ->preserveFilenames()
                                ->imageEditor()
                                ->maxSize(1024 * 5)
                                ->rules('dimensions:max_width=1920,max_height=1004')
                                ->required(),
                            TextInput::make('photo_alt_text')
                                ->label(trans('posts.form.photo_alt_text'))
                                ->required(),
                        ])->columns(1),

                    Fieldset::make('Status')
                        ->label(trans('posts.form.status'))
                        ->schema([

                            ToggleButtons::make('status')
                                ->label(trans('posts.form.status'))
                                ->live()
                                ->inline()
                                ->options(PostStatus::class)
                                ->required(),

                            DateTimePicker::make('scheduled_for')
                                ->label(trans('posts.form.scheduled_for'))
                                ->visible(function ($get) {
                                    return $get('status') === PostStatus::SCHEDULED->value;
                                })
                                ->required(function ($get) {
                                    return $get('status') === PostStatus::SCHEDULED->value;
                                })
                                ->minDate(now()->addMinutes(5))
                                ->native(false),
                        ]),
                    Select::make(cms_config('user.foreign_key'))
                        ->label(trans('posts.form.author'))
                        ->relationship('user', cms_config('user.columns.name'))
                        ->nullable(false)
                        ->default(auth()->id()),

                ]),
        ];
    }

    public function getTable(): string
    {
        return table_name('posts');
    }
}
