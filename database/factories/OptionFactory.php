<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'question_id' => Question::factory(),
            'option_text' => fake()->sentence(5),
            'is_correct' => false,
            'order_number' => fake()->numberBetween(1, 4),
        ];
    }
}