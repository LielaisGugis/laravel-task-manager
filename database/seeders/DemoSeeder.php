<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('DemoPassword123!'),
            ]
        );

        $project = $user->projects()->firstOrCreate(
            ['name' => 'School assignments'],
            ['description' => 'Example project created by a seeder.']
        );

        $project->tasks()->firstOrCreate(
            ['title' => 'Build the Laravel website'],
            [
                'description' => 'Implement projects and task CRUD.',
                'is_completed' => true,
            ]
        );

        $project->tasks()->firstOrCreate(
            ['title' => 'Prepare for the demonstration'],
            [
                'description' => 'Review the code and explain each requirement.',
                'is_completed' => false,
            ]
        );
    }
}