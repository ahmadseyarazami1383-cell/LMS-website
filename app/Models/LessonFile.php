<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'lesson_id', 'original_name', 'file_name',
        'file_path', 'file_type', 'file_size',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
