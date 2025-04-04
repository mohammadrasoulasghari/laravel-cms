<?php

namespace App\Models;

use Database\Factories\PostTagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'tag_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'      => 'integer',
        'post_id' => 'integer',
        'tag_id'  => 'integer',
    ];

    protected static function newFactory(): PostTagFactory
    {
        return new PostTagFactory;
    }

    public function getTable(): string
    {
        return table_name('post').'_'.table_name('tag');
    }
}
