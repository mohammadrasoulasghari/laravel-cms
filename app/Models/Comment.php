<?php

namespace App\Models;

use Database\Factories\CommentFactory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'approved',
        'approved_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'post_id' => 'integer',
        'approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(cms_config('user.model'), 'user_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    protected static function newFactory(): CommentFactory
    {
        return new CommentFactory();
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('approved', true);
    }

    public static function getForm(): array
    {
        return [
            Select::make('user_id')
                ->label(trans('comment.fields.user'))
                ->relationship('user', cms_config('user.columns.name'))
                ->required(),
            Select::make('post_id')
                ->label(trans('comment.fields.post'))
                ->relationship('post', 'title')
                ->required(),
            Textarea::make('comment')
                ->label(trans('comment.fields.comment'))
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),
            Toggle::make('approved')
                ->label(trans('comment.fields.approved')),
        ];
    }

    public function getTable(): string
    {
        return table_name('comments');
    }
}
