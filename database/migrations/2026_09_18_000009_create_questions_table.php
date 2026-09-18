<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('question_text');
            $table->decimal('points', 6, 2)->default(1);
            $table->unsignedInteger('order_number')->default(1);
            $table->timestamps();

            $table->unique(['quiz_id', 'order_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
