<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Tiwis',
            'email' => 'tiwis863@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
