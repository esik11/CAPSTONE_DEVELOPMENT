<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AssistantUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test assistant account
        User::create([
            'name' => 'Maria Santos',
            'email' => 'assistant@clinic.com',
            'password' => Hash::make('password'),
            'role' => 'assistant',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Assistant user created: assistant@clinic.com / password');
    }
}
