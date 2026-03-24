<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = [
        'word',
        'phonetic_spelling',
        'phonemes',
        'example_sentence',
    ];

    protected $casts = [
        'phonemes' => 'array',
    ];

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }
}
