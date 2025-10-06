<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class DevUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => 'Developer',
            'email'             => 'dev@test.com',
            'password'          => bcrypt('123456'),
            'email_verified_at' => now(),
            'role' => 1,
            'remember_token' => Str::random(20),
        ]);
    }
}
