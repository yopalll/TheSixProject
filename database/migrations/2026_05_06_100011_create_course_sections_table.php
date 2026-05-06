<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            // FK ke kursus — cascade delete saat kursus dihapus
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            // Judul section/chapter (contoh: Bab 1 — Instalasi & Setup)
            $table->string('title', 255);
            // Urutan section dalam kursus (ascending)
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index('course_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_sections');
    }
};
