<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            // FK ke users — satu user hanya bisa jadi satu instructor (unique)
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            // Bidang keahlian instructor (contoh: Web Development, Data Science)
            $table->string('expertise', 200)->nullable();
            // Nomor KTP instructor — ENCRYPTED di Model layer untuk keamanan data
            $table->string('ktp_number', 100)->nullable();
            // Nama bank untuk pencairan revenue (contoh: BCA, Mandiri)
            $table->string('bank_name', 50)->nullable();
            // Nomor rekening — ENCRYPTED di Model layer untuk keamanan data
            $table->string('bank_account_number', 100)->nullable();
            // Nama pemilik rekening sesuai buku tabungan
            $table->string('bank_account_holder', 100)->nullable();
            // NPWP instructor (opsional) — ENCRYPTED di Model layer
            $table->string('npwp', 100)->nullable();
            // Persentase bagi hasil instructor (default 70%, platform dapat 30%)
            $table->unsignedTinyInteger('revenue_share_percentage')->default(70);
            // Status verifikasi instructor oleh admin
            $table->boolean('is_verified')->default(false);
            // Tanggal verifikasi oleh admin
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
