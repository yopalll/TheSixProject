<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            // Nama partner/sponsor
            $table->string('name', 100);
            // Path gambar logo partner
            $table->string('logo');
            // URL website partner
            $table->string('link')->nullable();
            // Urutan tampil di frontend
            $table->unsignedInteger('order')->default(0);
            // Status aktif
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
