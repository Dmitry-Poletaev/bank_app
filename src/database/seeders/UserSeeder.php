<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserSeeder extends Seeder
{
    private const int TOTAL_USERS = 23;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < self::TOTAL_USERS; $i++) {
            User::create([
                'name'       => $faker->name,
                'email'      => $faker->unique()->safeEmail,
                'age'        => $faker->numberBetween(18, 60),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
