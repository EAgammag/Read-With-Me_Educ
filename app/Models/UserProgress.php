<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'word_id',
        'attempts',
        'correct_attempts',
        'mastered',
        'last_practiced_at',
    ];

    protected $casts = [
        'mastered' => 'boolean',
        'last_practiced_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    public function getAccuracyAttribute()
    {
        if ($this->attempts === 0) return 0;
        return round(($this->correct_attempts / $this->attempts) * 100);
    }
}
