<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            // FK ke order — cascade delete saat order dihapus
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            // FK ke kursus yang dibeli
            $table->foreignId('course_id')->constrained()->restrictOnDelete();
            // Snapshot judul kursus saat pembelian (agar tidak berubah jika kursus di-rename)
            $table->string('course_title_snapshot', 255);
            // Snapshot harga kursus saat pembelian (IDR)
            $table->bigInteger('price_snapshot')->default(0);
            // Bagian revenue instructor dari item ini (IDR, dihitung dari revenue_share_percentage)
            $table->bigInteger('instructor_revenue_share')->default(0);
            // Bagian revenue platform dari item ini (IDR)
            $table->bigInteger('platform_revenue_share')->default(0);
            $table->timestamps();

            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
