<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Word;
use App\Models\UserProgress;
use App\Models\LevelProgress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RealisticDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        UserProgress::truncate();
        LevelProgress::truncate();
        User::where('is_admin', false)->delete();

        // Create realistic students with varied data
        $students = [
            [
                'name' => 'Emma Johnson',
                'email' => 'emma.j@school.com',
                'level' => 3,
                'age' => 8,
                'sex' => 'Female',
                'year_level' => 'Grade 3',
                'section' => 'A',
                'words_to_master' => 25,
                'practice_sessions' => 45,
            ],
            [
                'name' => 'Liam Smith',
                'email' => 'liam.s@school.com',
                'level' => 2,
                'age' => 7,
                'sex' => 'Male',
                'year_level' => 'Grade 2',
                'section' => 'B',
                'words_to_master' => 18,
                'practice_sessions' => 32,
            ],
            [
                'name' => 'Olivia Martinez',
                'email' => 'olivia.m@school.com',
                'level' => 4,
                'age' => 9,
                'sex' => 'Female',
                'year_level' => 'Grade 4',
                'section' => 'A',
                'words_to_master' => 30,
                'practice_sessions' => 58,
            ],
            [
                'name' => 'Noah Williams',
                'email' => 'noah.w@school.com',
                'level' => 2,
                'age' => 7,
                'sex' => 'Male',
                'year_level' => 'Grade 2',
                'section' => 'A',
                'words_to_master' => 15,
                'practice_sessions' => 28,
            ],
            [
                'name' => 'Sophia Brown',
                'email' => 'sophia.b@school.com',
                'level' => 3,
                'age' => 8,
                'sex' => 'Female',
                'year_level' => 'Grade 3',
                'section' => 'B',
                'words_to_master' => 22,
                'practice_sessions' => 40,
            ],
            [
                'name' => 'Mason Davis',
                'email' => 'mason.d@school.com',
                'level' => 1,
                'age' => 6,
                'sex' => 'Male',
                'year_level' => 'Grade 1',
                'section' => 'C',
                'words_to_master' => 8,
                'practice_sessions' => 15,
            ],
            [
                'name' => 'Isabella Garcia',
                'email' => 'isabella.g@school.com',
                'level' => 3,
                'age' => 8,
                'sex' => 'Female',
                'year_level' => 'Grade 3',
                'section' => 'A',
                'words_to_master' => 20,
                'practice_sessions' => 38,
            ],
            [
                'name' => 'Ethan Rodriguez',
                'email' => 'ethan.r@school.com',
                'level' => 2,
                'age' => 7,
                'sex' => 'Male',
                'year_level' => 'Grade 2',
                'section' => 'C',
                'words_to_master' => 12,
                'practice_sessions' => 22,
            ],
            [
                'name' => 'Ava Wilson',
                'email' => 'ava.w@school.com',
                'level' => 4,
                'age' => 9,
                'sex' => 'Female',
                'year_level' => 'Grade 4',
                'section' => 'B',
                'words_to_master' => 28,
                'practice_sessions' => 52,
            ],
            [
                'name' => 'Lucas Anderson',
                'email' => 'lucas.a@school.com',
                'level' => 1,
                'age' => 6,
                'sex' => 'Male',
                'year_level' => 'Grade 1',
                'section' => 'B',
                'words_to_master' => 10,
                'practice_sessions' => 18,
            ],
            [
                'name' => 'Mia Taylor',
                'email' => 'mia.t@school.com',
                'level' => 3,
                'age' => 8,
                'sex' => 'Female',
                'year_level' => 'Grade 3',
                'section' => 'C',
                'words_to_master' => 24,
                'practice_sessions' => 43,
            ],
            [
                'name' => 'James Thomas',
                'email' => 'james.t@school.com',
                'level' => 2,
                'age' => 7,
                'sex' => 'Male',
                'year_level' => 'Grade 2',
                'section' => 'A',
                'words_to_master' => 16,
                'practice_sessions' => 30,
            ],
            [
                'name' => 'Charlotte Lee',
                'email' => 'charlotte.l@school.com',
                'level' => 5,
                'age' => 10,
                'sex' => 'Female',
                'year_level' => 'Grade 5',
                'section' => 'A',
                'words_to_master' => 30,
                'practice_sessions' => 65,
            ],
            [
                'name' => 'Benjamin White',
                'email' => 'benjamin.w@school.com',
                'level' => 1,
                'age' => 6,
                'sex' => 'Male',
                'year_level' => 'Grade 1',
                'section' => 'A',
                'words_to_master' => 7,
                'practice_sessions' => 12,
            ],
            [
                'name' => 'Amelia Harris',
                'email' => 'amelia.h@school.com',
                'level' => 4,
                'age' => 9,
                'sex' => 'Female',
                'year_level' => 'Grade 4',
                'section' => 'C',
                'words_to_master' => 27,
                'practice_sessions' => 50,
            ],
        ];

        $allWords = Word::all();
        
        foreach ($students as $studentData) {
            // Extract practice data
            $wordsToMaster = $studentData['words_to_master'];
            $practiceSessions = $studentData['practice_sessions'];
            unset($studentData['words_to_master'], $studentData['practice_sessions']);

            // Create user
            $user = User::create(array_merge($studentData, [
                'password' => Hash::make('password'),
                'birthdate' => now()->subYears($studentData['age'])->subMonths(rand(0, 11)),
                'total_words_practiced' => $practiceSessions,
            ]));

            $this->command->info("Created student: {$user->name} (Level {$user->level})");

            // Create user progress for words
            $selectedWords = $allWords->random(min($wordsToMaster + 10, $allWords->count()));
            
            $createdProgress = 0;
            foreach ($selectedWords as $index => $word) {
                $isMastered = $index < $wordsToMaster;
                $attempts = $isMastered 
                    ? rand(5, 15) 
                    : rand(1, 4);
                
                $correctAttempts = $isMastered 
                    ? (int)($attempts * rand(85, 100) / 100) 
                    : (int)($attempts * rand(40, 70) / 100);

                UserProgress::create([
                    'user_id' => $user->id,
                    'word_id' => $word->id,
                    'attempts' => $attempts,
                    'correct_attempts' => $correctAttempts,
                    'mastered' => $isMastered,
                    'last_practiced_at' => now()->subDays(rand(0, 30)),
                ]);

                $createdProgress++;
            }

            $this->command->info("  - Created {$createdProgress} word progress records ({$wordsToMaster} mastered)");

            // Create level progress
            for ($level = 1; $level < $user->level; $level++) {
                LevelProgress::create([
                    'user_id' => $user->id,
                    'level_number' => $level,
                    'content_type' => 'word',
                    'content_id' => $allWords->random()->id,
                    'completed' => true,
                    'score' => rand(75, 100),
                    'completed_at' => now()->subDays(rand(30, 90)),
                ]);
            }
        }

        $this->command->info("\n✅ Successfully seeded {$this->countUsers()} students with realistic data!");
        $this->command->info("📊 Total words mastered: " . UserProgress::where('mastered', true)->count());
        $this->command->info("🎯 Total practice sessions: " . UserProgress::sum('attempts'));
    }

    private function countUsers(): int
    {
        return User::where('is_admin', false)->count();
    }
}
