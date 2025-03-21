<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\FurnitureGood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FurnitureGood>
 */
class FurnitureGoodFactory extends Factory
{
    protected $model = FurnitureGood::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(nb: 3, asText: true),
            'description' => $this->faker->optional(0.6)->text(),
            'price' => $this->faker->randomFloat(2, 500, 30000),
            'category_id' => $this->faker->randomElement(Category::pluck('id')->toArray())
        ];
    }
}
