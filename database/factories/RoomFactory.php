<?php

namespace Database\Factories;

use App\Enums\RoomStatus;
use App\Enums\SmokingPreference;
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
            'room_number' => fake()->unique()->randomNumber(4),
            'floor_number' => mt_rand(1, 20),
            'status' => fake()->randomElement(RoomStatus::values()),
            'smoking_preference' => fake()->randomElement(SmokingPreference::values())
        ];
    }
}
