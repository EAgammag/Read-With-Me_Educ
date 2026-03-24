<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create administrator account
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'administartor@gmail.com',
            'password' => bcrypt('admin1234'),
            'is_admin' => true,
            'level' => 10,
        ]);

        // Seed level content (words, phrases, sentences, stories)
        $this->call([
            LevelContentSeeder::class,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('📧 Admin login: administartor@gmail.com');
        $this->command->info('🔑 Password: admin1234');
        $this->command->info('');
        $this->command->info('ℹ️  Students can now register through the registration form.');
    }
}
