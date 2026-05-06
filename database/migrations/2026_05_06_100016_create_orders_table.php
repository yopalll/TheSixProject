<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Nomor invoice unik (format: INV/YYYYMM/xxxxx)
            $table->string('order_number', 30)->unique();
            // FK ke user yang membuat order
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            // FK ke kupon yang dipakai (nullable = tanpa kupon)
            $table->foreignId('coupon_id')->nullable()->constrained()->nullOnDelete();
            // Subtotal sebelum diskon dan pajak (IDR)
            $table->bigInteger('subtotal')->default(0);
            // Jumlah potongan diskon dari kupon (IDR)
            $table->bigInteger('discount_amount')->default(0);
            // Persentase PPN yang berlaku saat transaksi (snapshot, default 11%)
            $table->decimal('ppn_percentage', 5, 2)->default(11.00);
            // Jumlah PPN dalam IDR (dihitung: (subtotal - discount) * ppn_percentage / 100)
            $table->bigInteger('ppn_amount')->default(0);
            // Total yang harus dibayar (subtotal - discount + ppn_amount)
            $table->bigInteger('total')->default(0);
            // Status order: pending, paid, expired, cancelled, refunded
            $table->enum('status', ['pending', 'paid', 'expired', 'cancelled', 'refunded'])->default('pending');
            // Waktu kedaluwarsa order (biasanya 24 jam setelah dibuat)
            $table->timestamp('expired_at')->nullable();
            // Waktu pembayaran berhasil
            $table->timestamp('paid_at')->nullable();
            // Catatan tambahan dari user
            $table->text('notes')->nullable();
            $table->timestamps();
            // Soft delete untuk audit trail transaksi
            $table->softDeletes();

            // Composite index untuk query order per user berdasarkan status
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
