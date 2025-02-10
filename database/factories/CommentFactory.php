<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()
                ->inRandomOrder()
                ->firstOrCreate()
                ->id,
            'post_id' => Post::query()
                ->inRandomOrder()
                ->firstOrCreate()
                ->id,
            'comment' => $this->faker->word,
            'approved' => false,
        ];
    }
}
