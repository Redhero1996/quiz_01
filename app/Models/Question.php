<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $casts = [
        'correct_ans' => 'array',
    ];

    protected $fillable = [
        'content',
        'correct_ans',
        'explain',
    ];

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
