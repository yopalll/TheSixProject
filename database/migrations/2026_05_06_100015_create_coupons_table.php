<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            // Kode kupon unik yang diinput user saat checkout (contoh: MERDEKA2026)
            $table->string('code', 50)->unique();
            // Tipe diskon: percentage (persen) atau fixed (potongan tetap IDR)
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            // Nilai diskon (persen atau IDR tergantung type)
            $table->bigInteger('value')->default(0);
            // Minimum pembelian agar kupon bisa digunakan (nullable = tanpa minimum)
            $table->bigInteger('min_purchase')->nullable();
            // Maksimum potongan (untuk tipe percentage, agar diskon tidak terlalu besar)
            $table->bigInteger('max_discount')->nullable();
            // Batas penggunaan kupon (nullable = tanpa batas)
            $table->unsignedInteger('usage_limit')->nullable();
            // Jumlah kali kupon sudah digunakan
            $table->unsignedInteger('used_count')->default(0);
            // Tanggal mulai berlaku kupon
            $table->timestamp('valid_from')->nullable();
            // Tanggal expired kupon
            $table->timestamp('valid_until')->nullable();
            // Status aktif kupon — kupon non-aktif tidak bisa digunakan
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index(['valid_from', 'valid_until']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
