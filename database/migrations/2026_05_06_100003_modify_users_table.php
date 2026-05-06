<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nomor telepon user (format Indonesia: 08xxx)
            $table->string('phone', 20)->nullable()->after('email');
            // Path gambar avatar/foto profil user
            $table->string('avatar')->nullable()->after('phone');
            // Role user di platform: student, instructor, atau admin
            $table->enum('role', ['student', 'instructor', 'admin'])->default('student')->after('avatar');
            // Bio singkat user (tampil di profil publik)
            $table->text('bio')->nullable()->after('role');
            // FK ke universitas (nullable, untuk fitur diskon edu dan profil mahasiswa)
            $table->foreignId('university_id')->nullable()->after('bio')->constrained()->nullOnDelete();
            // Kode referral unik milik user ini (untuk program referral mahasiswa)
            $table->string('referral_code', 20)->unique()->nullable()->after('university_id');
            // FK self-reference: ID user yang mereferralkan user ini
            $table->foreignId('referred_by')->nullable()->after('referral_code');
            // Soft delete agar data user tidak hilang permanen (audit trail)
            $table->softDeletes();

            // Self-referencing FK untuk referred_by
            $table->foreign('referred_by')->references('id')->on('users')->nullOnDelete();

            $table->index('role');
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign keys terlebih dahulu
            $table->dropForeign(['university_id']);
            $table->dropForeign(['referred_by']);

            // Lalu drop kolom
            $table->dropColumn([
                'phone',
                'avatar',
                'role',
                'bio',
                'university_id',
                'referral_code',
                'referred_by',
                'deleted_at',
            ]);
        });
    }
};
