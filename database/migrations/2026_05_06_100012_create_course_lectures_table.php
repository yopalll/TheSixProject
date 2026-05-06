<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_lectures', function (Blueprint $table) {
            $table->id();
            // FK ke section — cascade delete saat section dihapus
            $table->foreignId('section_id')->constrained('course_sections')->cascadeOnDelete();
            // Judul lecture/materi (contoh: Video 1.1 — Instalasi Composer)
            $table->string('title', 255);
            // URL video (YouTube, Vimeo, atau path upload lokal)
            $table->string('video_url')->nullable();
            // Durasi video dalam detik (untuk progress tracking & total durasi kursus)
            $table->unsignedInteger('duration_seconds')->default(0);
            // Apakah lecture ini bisa diakses tanpa enroll (preview gratis)
            $table->boolean('is_preview')->default(false);
            // Path file attachment opsional (PDF, slide, source code, dll)
            $table->string('attachment')->nullable();
            // Urutan lecture dalam section (ascending)
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index('section_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_lectures');
    }
};
