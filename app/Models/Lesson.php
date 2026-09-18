<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
   use HasFactory;
protected $fillable = [
        'course_id', 'title', 'slug', 'content', 'video_url',
        'order_number', 'duration', 'status',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(LessonFile::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
