<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'main_category_id' => $this->faker->numberBetween(1, 10),
            'slug' => $this->faker->slug(),
            'image_id' => $this->faker->numberBetween(1, 10),
            'description' => $this->faker->text(),
            'title' => $this->faker->sentence()
        ];
    }
}
