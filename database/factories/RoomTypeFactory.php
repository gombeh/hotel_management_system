<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $name = fake()->unique()->jobTitle(),
            'slug' => Str::slug($name),
            'view' => fake()->randomElement(['Sea View', 'City View', 'Mountain View']),
            'description' => fake()->paragraphs(5, true),
            'size' => fake()->randomElement([12, 15, 20, 30, 50]),
            'max_adult' => $maxAdult = mt_rand(2, 8),
            'max_children'=>  $maxChildren = mt_rand(1, 2),
            'max_total_guests' => $maxAdult + $maxChildren,
            'price' => fake()->randomElement([50, 100, 200, 300, 400, 500, 700, 1000]),
            'extra_bed_price' => 50,
            'status' => 'active'
        ];
    }
}
