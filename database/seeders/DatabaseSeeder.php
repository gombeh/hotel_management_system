<?php

namespace Database\Seeders;

use App\Enums\Sex;
use App\Models\BedType;
use App\Models\Country;
use App\Models\Facility;
use App\Models\MealPlan;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Services\Permission\PermissionService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaultRoles = ['admin', 'reception', 'manager'];
        array_map(fn($name) => Role::create(['name' => $name]), $defaultRoles);

        User::factory()->create([
            'first_name' => 'Rasoul',
            'last_name' => 'Zinati',
            'email' => 'test@example.com',
            'password' => bcrypt('1234'),
            'sex' => Sex::Male,
            'is_super_admin' => true,
        ]);

        $users = User::factory(100)->create();

        $users->each(fn($user) => $user->assignRole(fake()->randomElements($defaultRoles), mt_rand(1, 3)));

        PermissionService::syncBaseOnPolicies();

        Country::factory(50)->create();

        $bedTypes = [
            'Single' => 1,
            'Standard' => 2,
            'King' => 2,
            'Royal' => 2
        ];

        $bedTypes = array_map(fn($name, $quantity) => BedType::create(['name' => $name, 'capacity' => $quantity]),
            array_keys($bedTypes), $bedTypes);

        $facilities = [
            'Private bathroom',
            'Flat-screen TV',
            'TerraceFree',
            'Wifi',
            'Free toiletries',
            'Shower',
            'Toilet',
            'Hardwood or parquet floors',
            'Towels',
            'Shopping'
        ];

        $facilities = array_map(fn($name) => Facility::create([
            'name' => $name,
        ]), $facilities);

        $roomTypes = RoomType::factory(50)->create();

        $roomTypes->map(function ($roomType) use ($bedTypes, $facilities) {
            $roomType->bedTypes()->sync([fake()->randomElement($bedTypes)->id => ['quantity' => mt_rand(1, 2)]]);
            $roomType->facilities()->sync(fake()->randomElements($facilities, mt_rand(5, 10)));
        });

        $roomTypes->each(function ($roomType) {
            Room::factory(mt_rand(10, 30))->create(['room_type_id' => $roomType->id]);
        });


        $mealPlans = [
            ['code' => 'RO', 'name' => 'Room Only', 'description' => 'No meals included', 'extra_price' => 0.00],
            ['code' => 'BB', 'name' => 'Bed & Breakfast', 'description' => 'Breakfast included', 'extra_price' => 10.00],
            ['code' => 'HB', 'name' => 'Half Board', 'description' => 'Breakfast + Dinner', 'extra_price' => 25.00],
            ['code' => 'FB', 'name' => 'Full Board', 'description' => 'Breakfast + Lunch + Dinner', 'extra_price' => 40.00],
            ['code' => 'AI', 'name' => 'All Inclusive', 'description' => 'All meals + drinks', 'extra_price' => 65.00]
        ];

        foreach ($mealPlans as $mealPlan) {
            MealPlan::create($mealPlan);
        }
    }
}
