<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $commentable = [
            [
                'type' => 'App\Models\Post',
                'id' => Post::factory()
            ],
            [
                'type' => 'App\Models\Product',
                'id' => Product::factory()
            ]
        ];

        $index = rand(0, count($commentable) - 1);

        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'confirmed' => rand(0, 1),
            'commentable_type' => $commentable[$index]['type'],
            'commentable_id' => $commentable[$index]['id'],
            'content' => fake()->paragraph(),
            'user_id' => User::factory(),
        ];
    }
}
