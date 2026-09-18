<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'category_id' => Category::factory(),
            'teacher_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(100, 999),
            'description' => fake()->paragraph(),
            'thumbnail' => null,
            'level' => fake()->randomElement([
                'Beginner',
                'Intermediate',
                'Advanced',
            ]),
            'price' => fake()->randomFloat(2, 0, 100),
            'duration' => fake()->numberBetween(30, 300),
            'status' => 'draft',
            'published_at' => null,
        ];
    }
}