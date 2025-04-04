<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CategoryPost::class;

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
            'category_id' => Category::query()
                ->inRandomOrder()
                ->firstOrCreate()
                ->id,
        ];
    }
}
