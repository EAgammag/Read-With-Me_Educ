<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelProgress extends Model
{
    protected $table = 'level_progress';

    protected $fillable = [
        'user_id',
        'level_number',
        'content_type',
        'content_id',
        'completed',
        'score',
        'completed_at',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
