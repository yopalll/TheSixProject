<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            // FK ke user pemilik alamat
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Label alamat (contoh: Rumah, Kos, Kantor)
            $table->string('label', 50)->default('Rumah');
            // Nama penerima di alamat ini
            $table->string('recipient_name', 100);
            // Nomor telepon penerima
            $table->string('phone', 20);
            // FK ke provinsi
            $table->foreignId('province_id')->constrained()->restrictOnDelete();
            // FK ke kota/kabupaten
            $table->foreignId('city_id')->constrained()->restrictOnDelete();
            // Nama kecamatan
            $table->string('district', 100);
            // Kode pos
            $table->string('postal_code', 10);
            // Alamat detail (jalan, nomor rumah, RT/RW, dll)
            $table->text('detail');
            // Apakah ini alamat utama/default user
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
