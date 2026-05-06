<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            // FK ke user yang menambah wishlist
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // FK ke kursus yang di-wishlist
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // Composite unique: satu user hanya bisa wishlist satu kursus sekali
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
