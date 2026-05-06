<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_reviews', function (Blueprint $table) {
            $table->id();
            // FK ke user yang memberikan review
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // FK ke kursus yang di-review
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            // Rating bintang 1-5
            $table->unsignedTinyInteger('rating');
            // Komentar review (opsional, user bisa hanya beri bintang)
            $table->text('comment')->nullable();
            $table->timestamps();
            // Soft delete agar review yang dihapus masih bisa di-audit
            $table->softDeletes();

            // Composite unique: satu user hanya bisa review satu kursus sekali
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_reviews');
    }
};
