<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user
        $user = User::create([
            'name' => 'Qudus Oyetola',
            'email' => 'qudus@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Create preferences for this user
        UserPreference::create([
            'user_id' => $user->id,
            'sources' => ['NewsAPI', 'The Guardian', 'BBC'],
            'categories' => ['Technology', 'Health', 'Business'],
            'authors' => ['Author One', 'Author Two'],
        ]);
    }
}
