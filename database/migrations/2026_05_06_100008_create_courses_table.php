<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            // FK ke user instructor yang membuat kursus
            $table->foreignId('instructor_id')->constrained('users')->restrictOnDelete();
            // FK ke kategori utama kursus
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            // FK ke sub-kategori kursus
            $table->foreignId('sub_category_id')->constrained()->restrictOnDelete();
            // Judul kursus (contoh: Belajar Laravel 11 dari Nol)
            $table->string('title', 255);
            // Slug URL-friendly unik untuk SEO
            $table->string('slug', 255)->unique();
            // Deskripsi singkat untuk card/listing (max ~200 karakter)
            $table->string('short_description', 500)->nullable();
            // Deskripsi lengkap kursus (rich text editor, bisa sangat panjang)
            $table->longText('description')->nullable();
            // Path gambar thumbnail kursus
            $table->string('thumbnail')->nullable();
            // URL video preview/trailer kursus (YouTube/Vimeo embed)
            $table->string('preview_video_url')->nullable();
            // Level kesulitan kursus
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            // Bahasa pengantar kursus (default: Indonesia)
            $table->string('language', 10)->default('id');
            // Harga kursus dalam IDR (bigInteger karena IDR tidak pakai sen)
            $table->bigInteger('price')->default(0);
            // Harga setelah diskon (nullable = tidak ada diskon aktif)
            $table->bigInteger('discount_price')->nullable();
            // Total durasi semua lecture dalam menit (dihitung otomatis)
            $table->unsignedInteger('total_duration_minutes')->default(0);
            // Total jumlah lecture (dihitung otomatis saat lecture ditambah/hapus)
            $table->unsignedInteger('total_lectures')->default(0);
            // Total student yang enroll (counter cache untuk performa)
            $table->unsignedInteger('total_students')->default(0);
            // Rating rata-rata (0.00-5.00, dihitung dari course_reviews)
            $table->decimal('average_rating', 3, 2)->default(0.00);
            // Status kursus: draft, pending review, published, atau rejected
            $table->enum('status', ['draft', 'pending', 'published', 'rejected'])->default('draft');
            // Tanggal pertama kali dipublish
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            // Soft delete agar kursus yang dihapus masih punya audit trail
            $table->softDeletes();

            // Composite index untuk query listing kursus published
            $table->index(['status', 'published_at']);
            // Composite index untuk filter kursus per kategori
            $table->index(['category_id', 'sub_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
