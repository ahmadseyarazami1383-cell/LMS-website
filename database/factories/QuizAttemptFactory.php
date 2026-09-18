<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizAttemptFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'student_id' => User::factory(),
            'attempt_number' => 1,
            'score' => fake()->randomFloat(2, 0, 100),
            'total_points' => 10,
            'correct_answers' => fake()->numberBetween(0, 10),
            'total_questions' => 10,
            'started_at' => now()->subMinutes(30),
            'submitted_at' => now(),
            'status' => 'submitted',
        ];
    }
}