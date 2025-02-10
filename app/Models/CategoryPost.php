<?php

namespace App\Models;

use Database\Factories\CategoryPostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'category_id' => 'integer',
    ];

    protected static function newFactory(): CategoryPostFactory
    {
        return new CategoryPostFactory();
    }

    public function getTable(): string
    {
        return table_name('category') . '_' . table_name('post');
    }
}
