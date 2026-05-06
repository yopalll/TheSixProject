# SOP — Standard Operating Procedure untuk AI Agents
## Project: BelajarKuy LMS (Kloning Udemy untuk Pasar Indonesia)

> **Audience:** Semua AI agent (Claude, GPT, Gemini, Cursor, Copilot, dll) yang dipakai oleh tim 5 mahasiswa untuk mengerjakan project ini.
> **Versi:** 1.0
> **Tanggal:** 6 Mei 2026
> **Wajib dibaca AI sebelum menulis baris kode pertama.**

---

## 🎯 1. Identitas Project

| Field | Value |
|-------|-------|
| Nama Project | BelajarKuy |
| Deskripsi | LMS (Learning Management System) ala Udemy, fokus pasar pelajar/mahasiswa Indonesia |
| Tech Stack | Laravel 11, MySQL 8, Blade + Tailwind CSS, Vite, Alpine.js |
| Payment Gateway | Midtrans (Sandbox saja untuk fase ini) |
| Currency | IDR (Indonesian Rupiah) |
| Locale | id_ID, timezone Asia/Jakarta |
| Tim | 5 mahasiswa, semuanya pakai AI agents |
| Reference Repo | https://github.com/Shuvouits/YouTubeLMS |
| Repo Tim | https://github.com/Shuvouits/YouTubeLMS.git (di-fork) |

---

## 👥 2. Pembagian Domain per Anggota Tim

Setiap anggota tim "memiliki" 1 domain. AI agent yang membantu anggota tertentu **harus berfokus pada domain tersebut** dan **tidak menyentuh kode di luar domain** tanpa konfirmasi.

| Anggota | Domain | Tabel/File yang dimiliki |
|---------|--------|--------------------------|
| 1 | **User & Auth** | users, instructors, addresses, auth routes, middleware |
| 2 | **Course Domain** | courses, course_sections, course_lectures, course_goals, course_requirements |
| 3 | **Catalog & CMS** | categories, sub_categories, sliders, partners, site_info |
| 4 | **Cart & Order** | carts, wishlists, orders, order_items, coupons, enrollments |
| 5 | **Payment & Settings** | payments, midtrans_configs, lecture_progress, course_reviews |

---

## 📁 3. Struktur Folder Wajib

```
belajarkuy/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/        # Controller untuk role admin
│   │   │   ├── Instructor/   # Controller untuk role instructor
│   │   │   ├── Student/      # Controller untuk role student
│   │   │   └── Api/          # API endpoints (Midtrans webhook, dll)
│   │   ├── Requests/         # Form Request validation
│   │   ├── Middleware/       # Custom middleware (RoleMiddleware, dll)
│   │   └── Resources/        # API Resources jika perlu JSON
│   ├── Models/               # Eloquent models, 1 file per tabel
│   ├── Services/             # Business logic kompleks (MidtransService, EnrollmentService)
│   ├── Repositories/         # Query repository (opsional, kalau query kompleks)
│   ├── Enums/                # PHP 8.1 Enum classes (CourseStatus, OrderStatus)
│   ├── Events/               # Laravel events (OrderPaid, CourseEnrolled)
│   ├── Listeners/            # Event listeners
│   ├── Jobs/                 # Queue jobs (SendCertificate, ProcessRefund)
│   ├── Notifications/        # Email/database notifications
│   └── Helpers/              # Helper functions (formatRupiah, dll)
├── database/
│   ├── migrations/           # Migration files
│   ├── seeders/              # Seeder files
│   └── factories/            # Model factories
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── instructor/
│   │   ├── student/
│   │   ├── components/       # Blade components reusable
│   │   └── layouts/
│   ├── js/
│   └── css/
├── routes/
│   ├── web.php               # Public + student routes
│   ├── admin.php             # Admin routes (prefix /admin)
│   ├── instructor.php        # Instructor routes (prefix /instructor)
│   ├── api.php               # API & webhook routes
│   └── auth.php              # Laravel Breeze auth
└── tests/
    ├── Feature/              # Feature/integration test
    └── Unit/                 # Unit test
```

**Aturan keras:** AI **tidak boleh** membuat folder/file di luar struktur ini tanpa eksplisit minta izin. Jika ragu, tanya.

---

## ✍️ 4. Standar Penulisan Kode (WAJIB)

### 4.1. PHP & Laravel Convention

- **PSR-12** untuk style PHP. Pakai `./vendor/bin/pint` sebelum commit.
- **Strict types** di setiap file PHP baru: `declare(strict_types=1);` (kecuali file Blade & migration default Laravel).
- **Naming:**
  - Class: `PascalCase` (`CourseController`, `MidtransService`)
  - Method: `camelCase` (`getActiveCourses`, `processPayment`)
  - Variable: `camelCase` (`$courseList`, `$totalAmount`)
  - Constant & Enum case: `SCREAMING_SNAKE_CASE` (`MAX_CART_ITEMS`)
  - DB table: `snake_case` plural (`course_sections`)
  - DB column: `snake_case` singular (`is_published`, `instructor_id`)
  - Route name: `kebab-case` dengan dot grouping (`course.detail`, `admin.course.list`)
  - Blade file: `kebab-case.blade.php`

### 4.2. Eloquent Model

```php
<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'instructor_id', 'category_id', 'sub_category_id',
        'title', 'slug', 'short_description', 'description',
        'thumbnail', 'preview_video_url', 'level', 'price',
        'discount_price', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',          // IDR — bigInteger
            'discount_price' => 'integer',
            'status' => CourseStatus::class,
            'published_at' => 'datetime',
        ];
    }

    // === RELATIONS ===
    public function instructor() { return $this->belongsTo(User::class, 'instructor_id'); }
    public function category() { return $this->belongsTo(Category::class); }
    public function sections() { return $this->hasMany(CourseSection::class)->orderBy('order'); }

    // === SCOPES ===
    public function scopePublished($query) { return $query->where('status', CourseStatus::PUBLISHED); }

    // === ACCESSORS ===
    protected function finalPrice(): Attribute {
        return Attribute::get(fn () => $this->discount_price ?? $this->price);
    }
}
```

### 4.3. Controller — Thin Controller, Fat Service

❌ **Salah:** Logika bisnis di controller.
✅ **Benar:** Controller hanya orchestrate. Business logic di Service.

```php
public function checkout(CheckoutRequest $request, CheckoutService $service)
{
    $order = $service->createOrder(auth()->user(), $request->validated());
    return redirect()->route('payment.show', $order);
}
```

### 4.4. Validation — SELALU pakai Form Request

❌ **Salah:** `$request->validate([...])` di controller.
✅ **Benar:** Buat `app/Http/Requests/StoreCourseRequest.php` lengkap dengan rules + messages Bahasa Indonesia.

### 4.5. Database

- Foreign key WAJIB pakai `foreignId()->constrained()` dengan onDelete behavior eksplisit.
- Soft delete untuk: `users`, `courses`, `orders`, `course_reviews`.
- **Money column = `bigInteger`**. Tidak pernah `decimal` untuk IDR.
- **Status column = enum migration + PHP Enum class** di `app/Enums/`.
- Index wajib di kolom yang sering di-WHERE atau JOIN.

### 4.6. Frontend (Blade)

- **Tailwind only** — JANGAN custom CSS kecuali component yang reusable.
- **Component-first** — pakai `<x-button>`, `<x-card>`, dll. Buat di `resources/views/components/`.
- **Alpine.js** untuk interaktivitas ringan (dropdown, modal). JANGAN pakai jQuery.
- Format Rupiah selalu lewat helper: `{{ rupiah($course->price) }}` → `Rp 199.000`.

### 4.7. Currency & Localization

```php
// app/Helpers/helpers.php
function rupiah(int $amount): string {
    return 'Rp ' . number_format($amount, 0, ',', '.');
}
```

Tanggal selalu `Carbon` dengan locale id: `$date->locale('id')->translatedFormat('d F Y')` → `6 Mei 2026`.

---

## 🔀 5. Git Workflow (5 orang, harus rapi)

### 5.1. Branch Strategy

```
main                 # Production-ready, protected, hanya merge via PR
develop              # Integration branch, tempat semua feature di-merge
feature/<domain>/<deskripsi>   # Tiap fitur, contoh: feature/course/add-review
fix/<deskripsi>      # Bug fix
hotfix/<deskripsi>   # Urgent fix di main
```

### 5.2. Commit Message — Conventional Commits

```
<type>(<scope>): <subject in Indonesian>

[optional body]
```

**Type:** `feat`, `fix`, `docs`, `style`, `refactor`, `test`, `chore`, `db`

**Contoh:**
```
feat(course): tambah fitur preview video di halaman detail
fix(payment): perbaiki callback Midtrans yang gagal di QRIS
db(migration): tambah kolom certificate_number di enrollments
docs(readme): update cara setup Midtrans sandbox
```

### 5.3. Aturan AI saat Commit

AI agent **wajib**:
- Buat branch baru sebelum koding (jangan langsung commit ke develop/main).
- 1 PR = 1 fitur logis (bukan 1 PR berisi 5 fitur).
- Tulis commit message dalam Bahasa Indonesia, ringkas tapi jelas.
- Sertakan deskripsi PR yang jelas: tujuan, perubahan, cara test.

---

## 🌿 6. Environment & Secrets

### 6.1. .env Variables Wajib

```env
APP_NAME=BelajarKuy
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id

# Midtrans Sandbox
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_NOTIFICATION_URL="${APP_URL}/api/midtrans/notification"

# Mail
MAIL_MAILER=log    # untuk dev, jangan pakai SMTP real
```

### 6.2. Aturan Sensitive Data

- **JANGAN** AI commit `.env` ke git. `.env` ada di `.gitignore`.
- **JANGAN** AI hard-code API key di kode. Selalu `config('services.midtrans.server_key')`.
- KTP, NPWP, no rekening **wajib** di-encrypt pakai Laravel `Crypt::encryptString()`.

---

## 🧪 7. Testing Standard

Tiap fitur baru **wajib** disertai minimal:

- **1 Feature test** untuk happy path (`tests/Feature/`)
- **1 Unit test** untuk Service/business logic kritikal

Contoh nama test:
```
tests/Feature/Course/CreateCourseTest.php
tests/Feature/Payment/MidtransNotificationTest.php
tests/Unit/Services/CheckoutServiceTest.php
```

Run sebelum push: `php artisan test`

---

## 🚦 8. Definition of Done (DoD)

Sebuah fitur baru disebut "selesai" hanya jika **SEMUA** kriteria berikut terpenuhi:

- [ ] Migration jalan clean (`migrate:fresh` no error)
- [ ] Seeder data ter-update (kalau perlu data demo)
- [ ] Model lengkap dengan relations, scopes, casts
- [ ] Controller pakai Form Request untuk validasi
- [ ] Route ter-named dan masuk grup yang benar
- [ ] View pakai layout & component yang sudah ada
- [ ] Format Rupiah dipakai konsisten
- [ ] Minimal 1 feature test ditulis & lulus
- [ ] `./vendor/bin/pint` sudah dijalankan
- [ ] `php artisan test` PASS
- [ ] Commit message conventional, PR ada deskripsi
- [ ] No `dd()`, `dump()`, atau `var_dump()` ketinggalan di kode
- [ ] No komentar TODO yang belum di-resolve di kode production

---

## 🤖 9. Aturan Wajib untuk AI Agent

Semua AI agent yang dipakai tim **WAJIB** mengikuti aturan ini:

### 9.1. Sebelum Menulis Kode
1. **Baca file ini lengkap** sebelum menulis baris pertama.
2. Konfirmasi domain yang sedang dikerjakan (User/Course/Catalog/Cart/Payment).
3. Cek apakah ada Model/Service yang sudah ada untuk dipakai ulang.
4. Tanya jika ada ambiguitas (jangan asumsi sendiri).

### 9.2. Saat Menulis Kode
1. Ikuti **semua** standar penulisan di section 4.
2. **Jangan** buat folder/file di luar struktur section 3.
3. **Jangan** pakai library/package baru tanpa konfirmasi (cek `composer.json` dulu).
4. **Selalu** pakai dependency injection, jangan `new SomeClass()` di method.
5. **Selalu** validasi input via Form Request.
6. **Tulis** komentar untuk logic yang non-trivial — dalam Bahasa Indonesia.

### 9.3. Setelah Menulis Kode
1. Tampilkan **diff/full file** + **penjelasan singkat** apa yang berubah & kenapa.
2. Sebutkan **file lain yang terdampak** (cascade changes).
3. Sarankan **test case** yang harus dibuat/dijalankan.
4. Sebutkan **risiko/asumsi** yang dibuat.

### 9.4. Hal yang DILARANG untuk AI
- ❌ Drop tabel atau truncate tanpa konfirmasi eksplisit.
- ❌ Mengubah migration yang sudah di-merge ke develop (buat migration baru, jangan edit yang lama).
- ❌ Menambah dependency npm/composer berat (Bootstrap, jQuery, Vue) — stack sudah ditentukan.
- ❌ Menyimpan password/API key sebagai plain text.
- ❌ Bypass validasi/middleware "biar cepat".
- ❌ Generate data dummy real (KTP/NPWP/no HP betulan).
- ❌ Memakai `Eval`, `exec`, atau dynamic SQL string concatenation.
- ❌ Mengubah file di luar domain yang dimiliki anggota tanpa izin.

### 9.5. Hal yang WAJIB di-Confirm dulu ke User
- Tambah/hapus dependency
- Ubah skema tabel yang sudah ada
- Ubah file di luar domain anggota
- Refactor besar (>3 file sekaligus)
- Tambah middleware atau service provider baru

---

## 📚 10. Referensi & Resources

- Laravel 11 Docs: https://laravel.com/docs/11.x
- Midtrans Sandbox: https://docs.midtrans.com/docs/snap-snap-integration-guide
- Midtrans Test Card: https://docs.midtrans.com/docs/testing-payment-on-sandbox
- Tailwind CSS: https://tailwindcss.com/docs
- Conventional Commits: https://www.conventionalcommits.org/

---

## 🆘 11. Eskalasi

Jika AI menemukan kondisi:
- Konflik antar domain (misal: payment butuh modifikasi User table)
- Ambiguitas business rule
- Bug yang berdampak ke domain lain

→ **Stop koding. Lapor ke user.** Format laporan:

```
[ESKALASI]
Domain: <domain saya>
Domain terdampak: <domain lain>
Masalah: <deskripsi singkat>
Pertanyaan: <apa yang perlu diputuskan>
Rekomendasi: <opsi A / opsi B / opsi C>
```

---

## ✅ 12. Onboarding Checklist untuk AI Baru

Saat anggota tim mulai sesi baru dengan AI agent, berikan AI checklist ini di awal:

```
Halo AI. Sebelum kita mulai:

1. Saya mengerjakan project BelajarKuy (LMS Indonesia, Laravel 11).
2. Domain saya: <USER|COURSE|CATALOG|CART|PAYMENT>.
3. Baca file SOP di docs/SOP_AI_AGENTS_BELAJARKUY.md (paste isinya).
4. Konfirmasi: kamu sudah baca, paham, dan akan ikuti SOP-nya.
5. Setelah konfirmasi, baru kita mulai task hari ini.
```

AI yang tidak konfirmasi membaca SOP → jangan dipakai.

---

## 📝 13. Versi & Maintainer

| Versi | Tanggal | Perubahan | PIC |
|-------|---------|-----------|-----|
| 1.0 | 2026-05-06 | Initial SOP | Tim BelajarKuy |

**Update SOP** wajib lewat PR ke branch `develop`, dengan label `docs/sop`, di-review minimal 2 anggota tim sebelum merge.

---

> **Tanda tangan komitmen tim:** Setiap anggota tim & AI agent yang dipakai sudah membaca dan menyetujui SOP ini.
