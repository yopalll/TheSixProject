<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // FK ke order terkait
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            // Order ID yang dikirim ke Midtrans (format unik, biasanya = order_number)
            $table->string('midtrans_order_id', 100)->unique();
            // Transaction ID dari response Midtrans (diisi setelah ada respons)
            $table->string('transaction_id', 100)->nullable();
            // Tipe pembayaran yang dipilih user
            $table->enum('payment_type', [
                'bank_transfer', 'credit_card', 'gopay', 'qris',
                'shopeepay', 'cstore', 'other'
            ])->default('other');
            // Nomor Virtual Account (untuk tipe bank_transfer)
            $table->string('va_number', 50)->nullable();
            // Nama bank VA (bca, bni, mandiri, permata, bri)
            $table->string('bank', 20)->nullable();
            // Jumlah bruto yang dibayar (IDR)
            $table->bigInteger('gross_amount')->default(0);
            // Status fraud dari Midtrans (accept, challenge, deny)
            $table->string('fraud_status', 20)->nullable();
            // Status transaksi dari Midtrans callback/notification
            $table->enum('transaction_status', [
                'pending', 'settlement', 'capture', 'deny',
                'cancel', 'expire', 'failure', 'refund'
            ])->default('pending');
            // Waktu settlement dari Midtrans
            $table->timestamp('settlement_time')->nullable();
            // Raw JSON response dari Midtrans (untuk debugging & audit)
            $table->json('raw_response')->nullable();
            $table->timestamps();

            $table->index('transaction_status');
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
