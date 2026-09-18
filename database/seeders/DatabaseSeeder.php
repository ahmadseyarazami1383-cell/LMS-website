<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Rating;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::create([
            'name' => 'Admin',
        ]);

        $teacherRole = Role::create([
            'name' => 'Teacher',
        ]);

        $studentRole = Role::create([
            'name' => 'Student',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        User::create([
            'role_id' => $adminRole->id,
            'name' => 'System Admin',
            'email' => 'admin@lms.test',
            'password' => Hash::make('password'),
            'phone' => '0700000000',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Teachers
        |--------------------------------------------------------------------------
        */

        $teachers = User::factory()
            ->count(5)
            ->create([
                'role_id' => $teacherRole->id,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Students
        |--------------------------------------------------------------------------
        */

        $students = User::factory()
            ->count(20)
            ->create([
                'role_id' => $studentRole->id,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::factory()
            ->count(5)
            ->create();

        /*
        |--------------------------------------------------------------------------
        | Courses
        |--------------------------------------------------------------------------
        */

        foreach ($categories as $category) {

            $courses = Course::factory()
                ->count(2)
                ->create([
                    'category_id' => $category->id,
                    'teacher_id' => $teachers->random()->id,
                    'status' => 'published',
                    'published_at' => now(),
                ]);

            foreach ($courses as $course) {

                /*
                |--------------------------------------------------------------------------
                | Lessons
                |--------------------------------------------------------------------------
                */

                for ($i = 1; $i <= 5; $i++) {

                    $lesson = Lesson::factory()->create([
                        'course_id' => $course->id,
                        'order_number' => $i,
                        'status' => 'published',
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Quiz
                    |--------------------------------------------------------------------------
                    */

                    $quiz = Quiz::factory()->create([
                        'course_id' => $course->id,
                        'lesson_id' => $lesson->id,
                        'status' => 'published',
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Questions
                    |--------------------------------------------------------------------------
                    */

                    for ($q = 1; $q <= 5; $q++) {

                        $question = Question::factory()->create([
                            'quiz_id' => $quiz->id,
                            'order_number' => $q,
                        ]);

                        /*
                        |--------------------------------------------------------------------------
                        | Options
                        |--------------------------------------------------------------------------
                        */

                        for ($o = 1; $o <= 4; $o++) {

                            Option::factory()->create([
                                'question_id' => $question->id,
                                'order_number' => $o,
                                'is_correct' => ($o === 1),
                            ]);
                        }
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Enrollments
                |--------------------------------------------------------------------------
                */

                $courseStudents = $students->random(
                    min(5, $students->count())
                );

                foreach ($courseStudents as $student) {

                    $enrollment = Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'enrolled_at' => now(),
                        'completed_at' => null,
                        'status' => 'active',
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Lesson Progress
                    |--------------------------------------------------------------------------
                    */

                    $courseLessons = $course->lessons;

                    foreach ($courseLessons as $lesson) {

                        LessonProgress::create([
                            'enrollment_id' => $enrollment->id,
                            'lesson_id' => $lesson->id,
                            'completed' => false,
                            'completed_at' => null,
                            'last_viewed_at' => now(),
                        ]);
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Rating
                    |--------------------------------------------------------------------------
                    */

                    Rating::create([
                        'enrollment_id' => $enrollment->id,
                        'rating' => fake()->numberBetween(3, 5),
                        'review' => fake()->sentence(),
                        'status' => 'visible',
                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | Certificate
                    |--------------------------------------------------------------------------
                    */

                    Certificate::create([
                        'enrollment_id' => $enrollment->id,
                        'certificate_number' => 'CERT-' . strtoupper(
                            fake()->unique()->bothify('####??####')
                        ),
                        'issued_at' => now(),
                        'certificate_file' => null,
                        'status' => 'active',
                    ]);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Quiz Attempts & Answers
        |--------------------------------------------------------------------------
        */

        $enrollment = Enrollment::with('student', 'course')->first();

        if ($enrollment) {

            $quiz = Quiz::where('course_id', $enrollment->course_id)->first();

            if ($quiz) {

                $attempt = QuizAttempt::create([
                    'quiz_id' => $quiz->id,
                    'student_id' => $enrollment->student_id,
                    'attempt_number' => 1,
                    'score' => 80,
                    'total_points' => 10,
                    'correct_answers' => 4,
                    'total_questions' => 5,
                    'started_at' => now()->subMinutes(20),
                    'submitted_at' => now(),
                    'status' => 'submitted',
                ]);

                $questions = $quiz->questions;

                foreach ($questions as $question) {

                    $option = $question->options->first();

                    if ($option) {

                        Answer::create([
                            'attempt_id' => $attempt->id,
                            'question_id' => $question->id,
                            'option_id' => $option->id,
                            'is_correct' => $option->is_correct,
                            'points_earned' => $option->is_correct
                                ? $question->points
                                : 0,
                        ]);
                    }
                }
            }
        }
    }
}