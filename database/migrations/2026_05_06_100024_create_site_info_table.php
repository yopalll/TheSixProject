<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('site_info', function (Blueprint $table) {
            $table->id();
            // Key konfigurasi unik (contoh: site_name, ppn_percentage, contact_email)
            $table->string('key', 100)->unique();
            // Nilai konfigurasi (disimpan sebagai text, di-cast sesuai type di Model)
            $table->text('value')->nullable();
            // Tipe data nilai: text, number, boolean, json
            $table->enum('type', ['text', 'number', 'boolean', 'json'])->default('text');
            // Grup konfigurasi untuk pengelompokan di admin panel (contoh: general, payment, seo)
            $table->string('group', 50)->default('general');
            $table->timestamps();

            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_info');
    }
};
