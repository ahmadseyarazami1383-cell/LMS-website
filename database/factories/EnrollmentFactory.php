<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => User::factory(),
            'course_id' => Course::factory(),
            'enrolled_at' => now(),
            'completed_at' => null,
            'status' => 'active',
        ];
    }
}