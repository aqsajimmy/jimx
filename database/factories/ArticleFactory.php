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
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph(5),
            'slug' => $this->faker->slug,
            'image' => "https://placehold.co/600x400/6E5DC6/white",
            'is_published' => $this->faker->boolean,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'author_id' => \App\Models\User::inRandomOrder()->first()->id,
            'created_at' => now(),
        ];
    }
}
