# LMS Week 3 — Database Design, Migrations & Eloquent

This package is prepared for the LMS project and follows the Week 3 lab requirements:
ERD, one migration per entity, `$fillable`, Tinker sample data, verification, and Git commands.

## Important

If the Laravel project already contains the default `create_users_table` migration, DO NOT keep two
migrations that both create `users`. Replace/merge the default users migration with the provided one.

## Copy

Copy:
- `database/migrations/*.php` -> your Laravel project's `database/migrations/`
- `app/Models/*.php` -> your Laravel project's `app/Models/`
- `docs/ERD.md` -> your Laravel project's `docs/`

## Commands

```bash
php artisan migrate
php artisan migrate:status
php artisan tinker
```

## Tinker sample data

```php
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use App\Models\Answer;
```

Create records in dependency order:

```php
$teacherRole = Role::create(['name' => 'Teacher']);
$studentRole = Role::create(['name' => 'Student']);
$adminRole = Role::create(['name' => 'Admin']);

$teacher = User::create([
    'role_id' => $teacherRole->id,
    'name' => 'Test Teacher',
    'email' => 'teacher@example.com',
    'password' => 'password',
]);

$student = User::create([
    'role_id' => $studentRole->id,
    'name' => 'Test Student',
    'email' => 'student@example.com',
    'password' => 'password',
]);

$category = Category::create([
    'name' => 'Programming',
    'slug' => 'programming',
]);

$course = Course::create([
    'category_id' => $category->id,
    'teacher_id' => $teacher->id,
    'title' => 'Laravel Basics',
    'slug' => 'laravel-basics',
    'description' => 'Introduction to Laravel.',
    'level' => 'Beginner',
    'price' => 0,
    'status' => 'published',
]);

$lesson = Lesson::create([
    'course_id' => $course->id,
    'title' => 'Introduction to Laravel',
    'slug' => 'introduction-to-laravel',
    'content' => 'Laravel introduction lesson.',
    'order_number' => 1,
    'status' => 'published',
]);

$enrollment = Enrollment::create([
    'student_id' => $student->id,
    'course_id' => $course->id,
]);

$quiz = Quiz::create([
    'course_id' => $course->id,
    'lesson_id' => $lesson->id,
    'title' => 'Laravel Quiz',
    'pass_score' => 50,
    'status' => 'published',
]);

$question = Question::create([
    'quiz_id' => $quiz->id,
    'question_text' => 'Laravel is built with which language?',
    'points' => 1,
    'order_number' => 1,
]);

Option::create([
    'question_id' => $question->id,
    'option_text' => 'PHP',
    'is_correct' => true,
    'order_number' => 1,
]);

Option::create([
    'question_id' => $question->id,
    'option_text' => 'Python',
    'is_correct' => false,
    'order_number' => 2,
]);

$attempt = QuizAttempt::create([
    'quiz_id' => $quiz->id,
    'student_id' => $student->id,
    'attempt_number' => 1,
    'started_at' => now(),
    'status' => 'submitted',
    'total_questions' => 1,
    'correct_answers' => 1,
    'total_points' => 1,
    'score' => 100,
]);

$correctOption = $question->options()->where('is_correct', true)->first();

Answer::create([
    'attempt_id' => $attempt->id,
    'question_id' => $question->id,
    'option_id' => $correctOption->id,
    'is_correct' => true,
    'points_earned' => 1,
]);
```

## Verification queries

```php
Role::count();
User::count();
Category::count();
Course::count();
Lesson::count();
Enrollment::count();
Quiz::count();
Question::count();
Option::count();
QuizAttempt::count();
Answer::count();

Course::with('teacher', 'category', 'lessons')->first();
$student->enrollments()->with('course')->get();
$quiz->questions()->with('options')->get();
$attempt->answers()->with('question', 'option')->get();
```

Exit:
```php
exit
```

## Git

```bash
git status
git add database/migrations/ app/Models/ docs/
git commit -m "Add LMS database migrations and Eloquent models"
git push
```

Teammates:
```bash
git pull
php artisan migrate
```

For development only, if the database can be destroyed:
```bash
php artisan migrate:fresh
```

## Week 3 checklist

- [x] ER diagram finalized in `docs/ERD.md`
- [x] One migration per LMS entity
- [x] Foreign keys defined with `foreignId()->constrained()`
- [x] `$fillable` added to every model
- [x] Tinker sample records prepared
- [x] Query/verification commands prepared
- [x] Git commit/push commands prepared
- [ ] Run commands inside the actual Laravel project and take the required screenshots
