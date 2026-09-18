<?php

namespace Database\Factories;

use App\Models\QuizAttempt;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'attempt_id' => QuizAttempt::factory(),
            'question_id' => Question::factory(),
            'option_id' => Option::factory(),
            'is_correct' => false,
            'points_earned' => 0,
        ];
    }
}