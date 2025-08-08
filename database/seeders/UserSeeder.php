<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'user_name' => 'admin',
            'password' => bcrypt('11111111'),
            'full_name' => 'Administrator',
            'role' => 'admin'
        ]);
    }
}
