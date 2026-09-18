<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LessonFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'course_id' => Course::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 999),
            'content' => fake()->paragraphs(3, true),
            'video_url' => null,
            'order_number' => fake()->numberBetween(1, 20),
            'duration' => fake()->numberBetween(5, 60),
            'status' => fake()->randomElement([
                'draft',
                'published',
            ]),
        ];
    }
}