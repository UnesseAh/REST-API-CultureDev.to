<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => fake()->name(),
            "description" => fake()->name(),
            "content" => fake()->name(),
            "category_id" => fake()->numberBetween(1, 3),
            "tag_id" =>fake()->numberBetween(1, 2),
            "user_id" => fake()->numberBetween(1, 3),
        ];
    }
}
