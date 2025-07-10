<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
            'name'     => 'Demo User',
            'email'    => 'user@example.com',
            'password' => Hash::make('securePassword123'), // MUST be hashed
        ]);
    }
}
