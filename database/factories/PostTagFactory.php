<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostTag::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::query()
                ->inRandomOrder()
                ->firstOrCreate()
                ->id,
            'tag_id' => Tag::query()
                ->inRandomOrder()
                ->firstOrCreate()
                ->id,
        ];
    }
}
