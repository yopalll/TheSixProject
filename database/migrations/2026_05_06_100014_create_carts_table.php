<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            // FK ke user pemilik keranjang
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // FK ke kursus yang ada di keranjang
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            // Snapshot harga saat ditambah ke cart (IDR) — mencegah perubahan harga setelah add to cart
            $table->bigInteger('price_snapshot')->default(0);
            $table->timestamps();

            // Composite unique: satu user hanya bisa menambah satu kursus ke cart sekali
            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
