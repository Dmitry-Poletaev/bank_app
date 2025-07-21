<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function (User $user) {
            Account::create([
                'user_id'  => $user->id,
                'balance'  => rand(1_000, 100_000) / 100,
                'currency' => 'USD',
            ]);
        });
    }
}
