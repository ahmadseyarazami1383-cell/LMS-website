<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'quiz_id' => Quiz::factory(),
            'question_text' => fake()->sentence(8) . '?',
            'points' => fake()->numberBetween(1, 5),
            'order_number' => fake()->numberBetween(1, 20),
        ];
    }
}