# Prompt untuk AI Model (Opus/GPT-5/Gemini Pro) — Generate Laravel Migrations

Salin-tempel prompt di bawah ini ke AI model yang lebih kuat (Claude Opus 4.6, GPT-5, atau Gemini 2.5 Pro). Prompt ini sudah dirancang agar output migration-nya **deterministik, lengkap, dan siap pakai** untuk project kalian.

---

## 📋 PROMPT UTAMA — COPY MULAI DARI SINI

```
Kamu adalah Senior Laravel Engineer dengan 10+ tahun pengalaman di e-commerce
& EdTech Indonesia. Tugas kamu adalah membuat SELURUH file migration Laravel 11
untuk project LMS bernama "BelajarKuy" — sebuah platform kursus online ala Udemy
yang difokuskan untuk pelajar & mahasiswa Indonesia.

═══════════════════════════════════════════════════════════════
KONTEKS PROJECT
═══════════════════════════════════════════════════════════════

- Framework: Laravel 11 (PHP 8.2+)
- Database: MySQL 8 / MariaDB 10.6
- Reference repo: https://github.com/Shuvouits/YouTubeLMS (Laravel 11 LMS)
- Payment gateway: Midtrans Sandbox (BUKAN Stripe)
- Currency: IDR (Rupiah) — gunakan bigInteger, JANGAN decimal
- Pajak: PPN 11% (regulasi Indonesia)
- Locale: id_ID, timezone Asia/Jakarta

═══════════════════════════════════════════════════════════════
DOMAIN BISNIS
═══════════════════════════════════════════════════════════════

Aktor:
1. STUDENT — beli & ikuti kursus
2. INSTRUCTOR — buat & jual kursus, dapat bagi hasil
3. ADMIN — kelola seluruh platform

Alur utama:
Student daftar → cari kursus by kategori/sub-kategori → tambah ke wishlist
atau cart → checkout (boleh apply coupon) → bayar via Midtrans (QRIS, VA, GoPay,
ShopeePay, Credit Card) → setelah settlement, otomatis ter-enroll → akses
section & lecture → tandai progress → dapat sertifikat.

═══════════════════════════════════════════════════════════════
TABEL YANG HARUS DIBUAT (urut sesuai dependency FK)
═══════════════════════════════════════════════════════════════

Berikut 24 tabel yang HARUS kamu generate. Buat dalam urutan ini agar foreign
key tidak error:

GROUP A — REFERENCE DATA (master)
1. provinces            (id, name, code, timestamps)
2. cities               (id, province_id FK, name, type, timestamps)
3. universities         (id, name, abbreviation, city_id FK nullable, type
                         enum[PTN,PTS,PTKL], timestamps)

GROUP B — USER & AUTH (extend default Laravel users)
4. MODIFY users         tambah: phone, avatar, role enum[student,instructor,admin],
                                bio (text nullable), university_id FK nullable,
                                referral_code (unique), referred_by FK self
                                nullable, deleted_at (soft delete)
5. instructors          (id, user_id FK unique, expertise, ktp_number encrypted,
                         bank_name, bank_account_number encrypted,
                         bank_account_holder, npwp encrypted nullable,
                         revenue_share_percentage default 70, is_verified,
                         verified_at, timestamps)
6. addresses            (id, user_id FK, label, recipient_name, phone,
                         province_id FK, city_id FK, district, postal_code,
                         detail, is_default, timestamps)

GROUP C — CATEGORY & CATALOG
7. categories           (id, name, slug unique, icon, image nullable, order,
                         is_active, timestamps, soft delete)
8. sub_categories       (id, category_id FK, name, slug unique, order, is_active,
                         timestamps)
9. courses              (id, instructor_id FK→users, category_id FK,
                         sub_category_id FK, title, slug unique,
                         short_description, description (longText),
                         thumbnail, preview_video_url nullable,
                         level enum[beginner,intermediate,advanced],
                         language default 'id', price (bigInteger, IDR),
                         discount_price (bigInteger nullable),
                         total_duration_minutes, total_lectures default 0,
                         total_students default 0, average_rating default 0,
                         status enum[draft,pending,published,rejected],
                         published_at nullable, timestamps, soft delete,
                         INDEX(status, published_at), INDEX(category_id, sub_category_id))
10. course_goals        (id, course_id FK cascade, goal, order, timestamps)
11. course_requirements (id, course_id FK cascade, requirement, order, timestamps)
12. course_sections     (id, course_id FK cascade, title, order, timestamps)
13. course_lectures     (id, section_id FK cascade, title, video_url
                         (YouTube/Vimeo/upload), duration_seconds,
                         is_preview boolean, attachment nullable, order,
                         timestamps)

GROUP D — ENGAGEMENT
14. wishlists           (id, user_id FK, course_id FK, timestamps,
                         UNIQUE(user_id, course_id))
15. carts               (id, user_id FK, course_id FK, price_snapshot bigInteger,
                         timestamps, UNIQUE(user_id, course_id))
16. enrollments         (id, user_id FK, course_id FK, order_id FK, enrolled_at,
                         completed_at nullable, certificate_number nullable,
                         certificate_issued_at nullable, timestamps,
                         UNIQUE(user_id, course_id))
17. lecture_progress    (id, user_id FK, lecture_id FK, watched_seconds,
                         is_completed, completed_at nullable, timestamps,
                         UNIQUE(user_id, lecture_id))
18. course_reviews      (id, user_id FK, course_id FK, rating tinyInteger 1-5,
                         comment text nullable, timestamps, soft delete,
                         UNIQUE(user_id, course_id))

GROUP E — TRANSACTION
19. coupons             (id, code unique, type enum[percentage,fixed],
                         value bigInteger, min_purchase bigInteger nullable,
                         max_discount bigInteger nullable, usage_limit nullable,
                         used_count default 0, valid_from, valid_until,
                         is_active, timestamps)
20. orders              (id, order_number unique (format INV/YYYYMM/xxxxx),
                         user_id FK, coupon_id FK nullable, subtotal bigInteger,
                         discount_amount bigInteger default 0,
                         ppn_percentage decimal(5,2) default 11.00,
                         ppn_amount bigInteger, total bigInteger,
                         status enum[pending,paid,expired,cancelled,refunded],
                         expired_at, paid_at nullable, notes text nullable,
                         timestamps, soft delete, INDEX(user_id, status))
21. order_items         (id, order_id FK cascade, course_id FK,
                         course_title_snapshot, price_snapshot bigInteger,
                         instructor_revenue_share bigInteger,
                         platform_revenue_share bigInteger, timestamps)
22. payments            (id, order_id FK, midtrans_order_id unique,
                         transaction_id nullable, payment_type
                         enum[bank_transfer,credit_card,gopay,qris,shopeepay,
                         cstore,other], va_number nullable, bank nullable,
                         gross_amount bigInteger, fraud_status nullable,
                         transaction_status enum[pending,settlement,capture,
                         deny,cancel,expire,failure,refund],
                         settlement_time nullable, raw_response json,
                         timestamps, INDEX(transaction_status))

GROUP F — CMS & SETTINGS
23. sliders             (id, title, subtitle, image, link nullable, button_text,
                         order, is_active, timestamps)
24. partners            (id, name, logo, link, order, is_active, timestamps)
25. site_info           (id, key unique, value text, type
                         enum[text,number,boolean,json], group, timestamps)
26. midtrans_configs    (id, server_key encrypted, client_key, merchant_id,
                         is_production default false, notification_url,
                         finish_redirect_url, timestamps)

═══════════════════════════════════════════════════════════════
ATURAN PENULISAN (WAJIB IKUTI)
═══════════════════════════════════════════════════════════════

1. Penamaan file: `YYYY_MM_DD_HHMMSS_create_<table>_table.php`. Mulai dari
   2026_05_06_100000 dan increment 1 detik tiap file BERURUTAN sesuai daftar.

2. SETIAP migration HARUS punya:
   - `up()` lengkap dengan tipe data yang tepat
   - `down()` yang valid (Schema::dropIfExists untuk simple, dropForeign sebelum
     dropColumn untuk modifikasi)
   - Comment Bahasa Indonesia di atas tiap kolom non-trivial menjelaskan FUNGSI
     bisnis kolom tsb
   - Foreign key dengan onDelete behavior eksplisit (cascade/restrict/set null)
   - Index pada kolom yang akan sering di-WHERE/JOIN/ORDER BY
   - Soft delete (`$table->softDeletes()`) untuk tabel yang butuh audit trail

3. Tipe data:
   - Uang dalam IDR: SELALU `bigInteger` (bukan decimal). Jangan simpan sen.
   - Status & enum: gunakan `enum()` Laravel, JANGAN string biasa
   - JSON column: pakai `json()` (untuk raw_response Midtrans)
   - String pendek (slug, code): `string(100)` + `unique()`
   - Text panjang: `text()` untuk deskripsi, `longText()` untuk konten editor
   - Encrypted field: pakai komentar // ENCRYPTED — actual encryption di Model

4. Foreign key MUST:
   - foreignId('xxx_id')->constrained()->cascadeOnDelete() untuk child wajib
   - foreignId('xxx_id')->nullable()->constrained()->nullOnDelete() untuk optional
   - foreignId('xxx_id')->constrained()->restrictOnDelete() untuk reference data
     (categories, provinces, dll)

5. Composite unique index untuk pivot table (cart, wishlist, enrollment).

6. Pakai $table->id() bukan increments() — Laravel 11 standard.

7. JANGAN buat seeder. Hanya migrations.

═══════════════════════════════════════════════════════════════
OUTPUT FORMAT
═══════════════════════════════════════════════════════════════

Untuk SETIAP migration, output dalam format berikut, TANPA basa-basi tambahan:

──── FILE: database/migrations/2026_05_06_100000_create_provinces_table.php ────
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            // Nama provinsi sesuai data BPS
            $table->string('name', 100);
            // Kode provinsi BPS (2 digit)
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
──── END FILE ────

Setelah SEMUA migration selesai, tutup dengan:

──── SUMMARY ────
- Total migrations: <jumlah>
- Tabel dengan soft delete: <list>
- Foreign key chain order: <urutan migrate>
- Catatan implementasi: <hal yang perlu di-handle di Model/Controller>

═══════════════════════════════════════════════════════════════
TUGAS KAMU SEKARANG
═══════════════════════════════════════════════════════════════

Generate SEMUA 26 migration di atas (24 tabel baru + 1 modify users + reference
data). Tampilkan SATU PER SATU secara berurutan. Mulai dari migration #1
(provinces). Pastikan KONSISTEN, TIDAK ADA SHORTCUT, dan setiap file langsung
copy-paste ready.

Mulai sekarang.
```

---

## 📌 Catatan Penggunaan Prompt Ini

### Cara Pakai

1. **Buka AI yang lebih kuat** (Claude Opus 4.6, GPT-5, atau Gemini 2.5 Pro karena migrasi banyak — perlu context window besar).
2. **Copy seluruh prompt** mulai dari `Kamu adalah Senior Laravel Engineer...` sampai `Mulai sekarang.`
3. Jika output terpotong, kirim pesan: `"lanjutkan dari migration #X"`.

### Validasi Output AI

Setelah AI selesai generate, lakukan checklist ini:

- [ ] Jumlah file migration = 26
- [ ] Tidak ada FK yang reference tabel yang belum ada (cek urutan timestamp file)
- [ ] Semua kolom uang pakai `bigInteger` bukan `decimal`
- [ ] Semua FK ada `onDelete` behavior eksplisit
- [ ] `migrate:fresh` jalan tanpa error: `php artisan migrate:fresh`
- [ ] `migrate:rollback` juga jalan tanpa error

### Jika Ada Error

Kirim balik error message ke AI dengan prompt:

```
Migration <nama_file> gagal dengan error:
<paste full error message>

Fix migration tersebut. Output ulang full file lengkap (jangan diff/patch).
```

### Untuk Seeder

Setelah migrations OK, gunakan prompt lanjutan:

```
Gunakan struktur tabel yang sudah kamu generate sebelumnya. Sekarang buat
DatabaseSeeder + factory untuk:
- 34 provinces Indonesia (dummy lengkap)
- 50 universities populer Indonesia
- 8 categories realistis untuk mahasiswa Indonesia
- 30 sub_categories
- 5 instructor demo (lengkap dengan KTP/NPWP dummy)
- 20 courses dummy lengkap dengan sections+lectures
- 1 admin demo

Format output: file Seeder & Factory lengkap, copy-paste ready.
```
