<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            // Nama provinsi sesuai data BPS (Badan Pusat Statistik)
            $table->string('name', 100);
            // Kode provinsi BPS (2 digit, contoh: 31 = DKI Jakarta)
            $table->string('code', 2)->unique();
            $table->timestamps();

            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
