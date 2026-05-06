<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lecture_progress', function (Blueprint $table) {
            $table->id();
            // FK ke user yang menonton lecture
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // FK ke lecture yang ditonton
            $table->foreignId('lecture_id')->constrained('course_lectures')->cascadeOnDelete();
            // Detik terakhir yang ditonton (untuk resume playback)
            $table->unsignedInteger('watched_seconds')->default(0);
            // Apakah lecture sudah ditandai selesai
            $table->boolean('is_completed')->default(false);
            // Tanggal lecture selesai ditonton
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Composite unique: satu user satu progress per lecture
            $table->unique(['user_id', 'lecture_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecture_progress');
    }
};
