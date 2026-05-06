<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('midtrans_configs', function (Blueprint $table) {
            $table->id();
            // Server key Midtrans — ENCRYPTED di Model layer (JANGAN expose di client)
            $table->string('server_key', 255);
            // Client key Midtrans (aman untuk di-expose di frontend Snap.js)
            $table->string('client_key', 255);
            // Merchant ID Midtrans
            $table->string('merchant_id', 100);
            // Mode: false = sandbox (testing), true = production (live)
            $table->boolean('is_production')->default(false);
            // URL endpoint untuk menerima notification callback dari Midtrans
            $table->string('notification_url')->nullable();
            // URL redirect setelah pembayaran selesai di Midtrans
            $table->string('finish_redirect_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('midtrans_configs');
    }
};
