<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_number' => fake()->unique()->randomNumber(3),
            'floor_number' => mt_rand(1, 20),
            'status' => 'available',
            'smoking_preference' => fake()->randomElement(['No_preference','Non_smoking','Smoking'])
        ];
    }
}
