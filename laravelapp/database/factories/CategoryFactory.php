<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(nb: 2, asText: true),
            'description' => $this->faker->optional(0.3)->text(),
            'parent_category_id' => function() {
                return $this->faker->optional(0.5)->randomElement(
                    Category::pluck('id')->toArray()
                );
            }
        ];
    }
}
