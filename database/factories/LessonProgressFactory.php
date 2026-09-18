<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonProgressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'enrollment_id' => Enrollment::factory(),
            'lesson_id' => Lesson::factory(),
            'completed' => fake()->boolean(70),
            'completed_at' => null,
            'last_viewed_at' => now(),
        ];
    }
}