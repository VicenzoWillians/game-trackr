<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user for testing purposes
        User::firstOrCreate(
            ['email' => 'vicenzo@gametrackr.com'],
            [
                'name' => 'Vicenzo Willians',
                'password' => Hash::make('123mudar'), // Encripta a senha com Hash!
            ]
        );
    }
    
}
