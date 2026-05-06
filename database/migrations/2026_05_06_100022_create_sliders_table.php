<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            // Judul slider/banner homepage
            $table->string('title', 200);
            // Subtitle/tagline banner
            $table->string('subtitle', 500)->nullable();
            // Path gambar banner
            $table->string('image');
            // URL tujuan saat banner diklik (nullable = tidak ada link)
            $table->string('link')->nullable();
            // Teks tombol CTA di banner
            $table->string('button_text', 50)->nullable();
            // Urutan tampil slider (ascending)
            $table->unsignedInteger('order')->default(0);
            // Status aktif — slider non-aktif tidak tampil di homepage
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
