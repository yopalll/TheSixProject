<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            // FK ke provinsi induk
            $table->foreignId('province_id')->constrained()->restrictOnDelete();
            // Nama kota/kabupaten sesuai data BPS
            $table->string('name', 100);
            // Tipe wilayah: Kota atau Kabupaten
            $table->string('type', 20)->default('Kota');
            $table->timestamps();

            $table->index('province_id');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
