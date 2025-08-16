<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Template>
 */
class TemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //base on the Template model
            'name' => $this->faker->word . rand(1, 100),
            'slug' => $this->faker->slug,
            'image' => "https://placehold.co/600x400/6E5DC6/white",
            'description' => $this->faker->sentence,
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'file_name' => rand(0, 10) . "-" . $this->faker->word . '.zip',
            'file_url' => $this->faker->url,
            'file_size' => $this->faker->numberBetween(1000, 100000),
            'demo_url' => $this->faker->url,
            'downloads' => $this->faker->numberBetween(0, 1000),
            'price' => $this->faker->numberBetween(0, 100),
            'status' => $this->faker->numberBetween(0, 1),
            'discount' => $this->faker->numberBetween(0, 100),
            'author_id' => \App\Models\User::inRandomOrder()->first()->id,
            'created_at' => now(),
        ];
    }
}
