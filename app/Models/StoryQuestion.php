<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryQuestion extends Model
{
    protected $fillable = [
        'story_id',
        'question',
        'options',
        'correct_answer',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
