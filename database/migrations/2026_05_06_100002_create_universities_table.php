<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            // Nama lengkap universitas (contoh: Universitas Indonesia)
            $table->string('name', 200);
            // Singkatan populer (contoh: UI, ITB, UGM)
            $table->string('abbreviation', 20)->nullable();
            // FK ke kota lokasi kampus (nullable untuk kampus online/multi-kota)
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            // Tipe perguruan tinggi: PTN, PTS, atau PTKL (Kedinasan/Lainnya)
            $table->enum('type', ['PTN', 'PTS', 'PTKL'])->default('PTS');
            $table->timestamps();

            $table->index('name');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
