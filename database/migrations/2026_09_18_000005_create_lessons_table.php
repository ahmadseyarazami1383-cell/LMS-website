<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('title', 200);
            $table->string('slug', 220);
            $table->longText('content');
            $table->string('video_url', 500)->nullable();
            $table->unsignedInteger('order_number')->default(1);
            $table->unsignedInteger('duration')->nullable()->comment('Duration in minutes');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();

            $table->unique(['course_id', 'slug']);
            $table->unique(['course_id', 'order_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
