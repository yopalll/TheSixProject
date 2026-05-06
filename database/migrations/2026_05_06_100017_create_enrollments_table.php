<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            // FK ke user (student) yang enroll
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // FK ke kursus yang di-enroll
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            // FK ke order yang memicu enrollment ini
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            // Tanggal enrollment aktif (setelah payment settlement)
            $table->timestamp('enrolled_at')->nullable();
            // Tanggal menyelesaikan seluruh kursus (semua lecture completed)
            $table->timestamp('completed_at')->nullable();
            // Nomor sertifikat unik (generate otomatis saat completed)
            $table->string('certificate_number', 50)->nullable();
            // Tanggal sertifikat diterbitkan
            $table->timestamp('certificate_issued_at')->nullable();
            $table->timestamps();

            // Composite unique: satu user hanya bisa enroll satu kursus sekali
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
