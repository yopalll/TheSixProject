<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Nama kategori (contoh: Programming untuk Pemula, Persiapan UTBK)
            $table->string('name', 100);
            // Slug URL-friendly unik (contoh: programming-untuk-pemula)
            $table->string('slug', 100)->unique();
            // Nama icon class (contoh: fas fa-code) untuk tampilan frontend
            $table->string('icon', 100)->nullable();
            // Path gambar cover kategori
            $table->string('image')->nullable();
            // Urutan tampil di frontend (ascending)
            $table->unsignedInteger('order')->default(0);
            // Status aktif — kategori non-aktif tidak tampil di frontend
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            // Soft delete agar kategori yang dihapus masih bisa di-audit
            $table->softDeletes();

            $table->index('is_active');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
