# LMS ER Diagram — Week 3

```mermaid
erDiagram
    ROLES ||--o{ USERS : has
    CATEGORIES ||--o{ COURSES : contains
    USERS ||--o{ COURSES : teaches
    COURSES ||--o{ LESSONS : contains
    LESSONS ||--o{ LESSON_FILES : has
    USERS ||--o{ ENROLLMENTS : makes
    COURSES ||--o{ ENROLLMENTS : receives
    COURSES ||--o{ QUIZZES : has
    LESSONS ||--o{ QUIZZES : may_have
    QUIZZES ||--o{ QUESTIONS : contains
    QUESTIONS ||--o{ OPTIONS : has
    USERS ||--o{ QUIZ_ATTEMPTS : makes
    QUIZZES ||--o{ QUIZ_ATTEMPTS : receives
    QUIZ_ATTEMPTS ||--o{ ANSWERS : contains
    QUESTIONS ||--o{ ANSWERS : answered
    OPTIONS ||--o{ ANSWERS : selected
    ENROLLMENTS ||--o{ LESSON_PROGRESS : tracks
    LESSONS ||--o{ LESSON_PROGRESS : tracks
    ENROLLMENTS ||--o| RATINGS : gives
    ENROLLMENTS ||--o| CERTIFICATES : earns

    ROLES {
        bigint id PK
        varchar name UK
        timestamp created_at
        timestamp updated_at
    }
    USERS {
        bigint id PK
        bigint role_id FK
        varchar name
        varchar email UK
        varchar password
        varchar phone
        varchar profile_image
        text bio
        enum status
        timestamp email_verified_at
        timestamp created_at
        timestamp updated_at
    }
    CATEGORIES {
        bigint id PK
        varchar name UK
        varchar slug UK
        text description
        varchar image
        enum status
        timestamp created_at
        timestamp updated_at
    }
    COURSES {
        bigint id PK
        bigint category_id FK
        bigint teacher_id FK
        varchar title
        varchar slug UK
        longtext description
        varchar thumbnail
        enum level
        decimal price
        int duration
        enum status
        timestamp published_at
        timestamp created_at
        timestamp updated_at
    }
    LESSONS {
        bigint id PK
        bigint course_id FK
        varchar title
        varchar slug
        longtext content
        varchar video_url
        int order_number
        int duration
        enum status
        timestamp created_at
        timestamp updated_at
    }
    LESSON_FILES {
        bigint id PK
        bigint lesson_id FK
        varchar original_name
        varchar file_name
        varchar file_path
        varchar file_type
        bigint file_size
        timestamp created_at
        timestamp updated_at
    }
    ENROLLMENTS {
        bigint id PK
        bigint student_id FK
        bigint course_id FK
        timestamp enrolled_at
        timestamp completed_at
        enum status
        timestamp created_at
        timestamp updated_at
    }
    QUIZZES {
        bigint id PK
        bigint course_id FK
        bigint lesson_id FK
        varchar title
        text description
        int duration
        decimal pass_score
        int max_attempts
        enum status
        timestamp created_at
        timestamp updated_at
    }
    QUESTIONS {
        bigint id PK
        bigint quiz_id FK
        text question_text
        decimal points
        int order_number
        timestamp created_at
        timestamp updated_at
    }
    OPTIONS {
        bigint id PK
        bigint question_id FK
        text option_text
        boolean is_correct
        int order_number
        timestamp created_at
        timestamp updated_at
    }
    QUIZ_ATTEMPTS {
        bigint id PK
        bigint quiz_id FK
        bigint student_id FK
        int attempt_number
        decimal score
        decimal total_points
        int correct_answers
        int total_questions
        timestamp started_at
        timestamp submitted_at
        enum status
        timestamp created_at
        timestamp updated_at
    }
    ANSWERS {
        bigint id PK
        bigint attempt_id FK
        bigint question_id FK
        bigint option_id FK
        boolean is_correct
        decimal points_earned
        timestamp created_at
        timestamp updated_at
    }
    LESSON_PROGRESS {
        bigint id PK
        bigint enrollment_id FK
        bigint lesson_id FK
        boolean completed
        timestamp completed_at
        timestamp last_viewed_at
        timestamp created_at
        timestamp updated_at
    }
    RATINGS {
        bigint id PK
        bigint enrollment_id FK UK
        tinyint rating
        text review
        enum status
        timestamp created_at
        timestamp updated_at
    }
    CERTIFICATES {
        bigint id PK
        bigint enrollment_id FK UK
        varchar certificate_number UK
        timestamp issued_at
        varchar certificate_file
        enum status
        timestamp created_at
        timestamp updated_at
    }
```

## Project relationship notes

- `roles` 1:N `users`
- `categories` 1:N `courses`
- `users` (teacher role) 1:N `courses`
- `courses` 1:N `lessons`
- `lessons` 1:N `lesson_files`
- `users` (student role) N:N `courses` through `enrollments`
- `courses` 1:N `quizzes`
- `lessons` 1:N `quizzes` (lesson_id is nullable)
- `quizzes` 1:N `questions`
- `questions` 1:N `options`
- `users` (student role) 1:N `quiz_attempts`
- `quizzes` 1:N `quiz_attempts`
- `quiz_attempts` 1:N `answers`
- `enrollments` 1:N `lesson_progress`
- `enrollments` 1:1 `ratings`
- `enrollments` 1:1 `certificates`

`teacher_id` and `student_id` both reference `users.id`; Laravel authorization/validation must ensure the selected user has the correct role.
