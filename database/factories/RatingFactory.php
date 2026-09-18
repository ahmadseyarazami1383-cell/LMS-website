<?php

namespace Database\Factories;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'enrollment_id' => Enrollment::factory(),
            'rating' => fake()->numberBetween(1, 5),
            'review' => fake()->optional()->sentence(),
            'status' => 'visible',
        ];
    }
}