<?php

namespace Database\Factories;

use App\Enums\CustomerStatus;
use App\Enums\Sex;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'national_id' => Country::factory(),
            'email' => fake()->unique()->email(),
            'mobile' => $phone = fake()->randomElement([fake()->unique()->phoneNumber(), null]),
            'email_verified_at' => now(),
            'mobile_verified_at' => $phone !== null ? now() : null,
            'password' => static::$password ??= Hash::make('password'),
            'sex' => fake()->randomElement(Sex::values()),
            'birthdate' => null,
            'status' => fake()->randomElement(CustomerStatus::values()),
            'remember_token' => Str::random(10),
        ];
    }
}
