<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image_emoji',
        'difficulty',
    ];

    public function questions()
    {
        return $this->hasMany(StoryQuestion::class)->orderBy('order');
    }
}
