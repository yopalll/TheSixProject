<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('course_requirements', function (Blueprint $table) {
            $table->id();
            // FK ke kursus — cascade delete saat kursus dihapus
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            // Deskripsi prasyarat (contoh: Sudah paham dasar HTML & CSS)
            $table->string('requirement', 500);
            // Urutan tampil di halaman detail kursus
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();

            $table->index('course_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_requirements');
    }
};
