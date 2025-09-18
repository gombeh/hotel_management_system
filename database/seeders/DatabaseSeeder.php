<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Rasoul',
            'last_name' => 'Zinati',
            'email' => 'test@gmail.com',
            'password' => bcrypt('1234'),
            'sex' => 'male',
        ]);

         User::factory(100)->create();


         $defaultRoles = ['supper_admin', 'admin', 'reception'];
         array_map(fn($name) => Role::create(['name' => $name]), $defaultRoles);
    }
}
