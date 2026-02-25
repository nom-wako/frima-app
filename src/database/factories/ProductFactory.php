<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'condition_id' => Condition::inRandomOrder()->first()?->id,
            'name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'description' => $this->faker->realText(100),
            'price' => $this->faker->numberBetween(100, 10000),
            'img_url' => 'https://example.com/test_image.jpg',
            'is_sold' => false,
        ];
    }

    public function withCategories(int $count = 1)
    {
        return $this->afterCreating(function (Product $product) use ($count) {
            $categories = Category::inRandomOrder()->take($count)->get();
            $product->categories()->attach($categories);
        });
    }
}
