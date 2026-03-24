<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $words = [
            [
                'word' => 'cat',
                'phonetic_spelling' => 'kæt',
                'phonemes' => ['c', 'a', 't'],
                'example_sentence' => 'The cat is sleeping on the couch.',
            ],
            [
                'word' => 'bat',
                'phonetic_spelling' => 'bæt',
                'phonemes' => ['b', 'a', 't'],
                'example_sentence' => 'The player hit the ball with a wooden bat.',
            ],
            [
                'word' => 'sun',
                'phonetic_spelling' => 'sʌn',
                'phonemes' => ['s', 'u', 'n'],
                'example_sentence' => 'The sun is very bright today.',
            ],
            [
                'word' => 'dog',
                'phonetic_spelling' => 'dɒɡ',
                'phonemes' => ['d', 'o', 'g'],
                'example_sentence' => 'The dog barked at the mailman.',
            ],
            [
                'word' => 'fish',
                'phonetic_spelling' => 'fɪʃ',
                'phonemes' => ['f', 'i', 'sh'],
                'example_sentence' => 'The fish swims in the blue water.',
            ],
        ];

        foreach ($words as $word) {
            \App\Models\Word::updateOrCreate(['word' => $word['word']], $word);
        }
    }
}
