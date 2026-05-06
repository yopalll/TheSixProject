<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            // FK ke kategori induk
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            // Nama sub-kategori (contoh: Laravel, Flutter, IELTS)
            $table->string('name', 100);
            // Slug URL-friendly unik (contoh: laravel, flutter)
            $table->string('slug', 100)->unique();
            // Urutan tampil dalam kategori induk (ascending)
            $table->unsignedInteger('order')->default(0);
            // Status aktif — sub-kategori non-aktif tidak tampil di frontend
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
