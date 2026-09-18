<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'lesson_id' => null,
            'title' => fake()->sentence(4),
            'description' => fake()->sentence(),
            'duration' => fake()->numberBetween(10, 60),
            'pass_score' => fake()->randomFloat(2, 50, 80),
            'max_attempts' => fake()->numberBetween(1, 5),
            'status' => fake()->randomElement([
                'draft',
                'published',
            ]),
        ];
    }
}