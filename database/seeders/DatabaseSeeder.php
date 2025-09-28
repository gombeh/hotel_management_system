<?php

namespace Database\Seeders;

use App\Models\BedType;
use App\Models\Country;
use App\Models\Facility;
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
            'sex' => 'male',
            'is_super_admin' => true,
        ]);

         $users = User::factory(100)->create();

         $users->each(fn($user) => $user->assignRole(fake()->randomElements($defaultRoles), mt_rand(1,3)));

         PermissionService::syncBaseOnPolicies();

         Country::factory(50)->create();

         $bedTypes = [
             'Single' => 1,
             'Standard' => 2,
             'King' => 2,
             'Royal' => 2
         ];

         foreach ($bedTypes as $type => $capacity) {
             BedType::Create([
                 'name' => $type,
                 'capacity' => $capacity,
             ]);
         }

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
         ];

         foreach ($facilities as $facility) {
             Facility::create([
                 'name' => $facility,
             ]);
         }

         $roomTypes = RoomType::factory(50)->create();

    }
}
