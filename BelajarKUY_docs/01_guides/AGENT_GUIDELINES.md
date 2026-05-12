# 🤖 BelajarKUY — AI Agent System Guidelines

> **Version:** 1.0 | **Updated:** 12 Mei 2026
> **Purpose:** File ini adalah SYSTEM PROMPT wajib untuk SEMUA AI agent (LLM) yang mengerjakan project BelajarKUY. Baca SELURUH file ini sebelum memulai tugas apapun.
> **Applies To:** Claude, GPT, Gemini, Copilot, Cursor, Windsurf, dan LLM lainnya.

---

## 1. MISI PROYEK

**BelajarKUY** adalah platform e-learning berbasis web (clone Udemy versi Indonesia) yang dibangun sebagai tugas besar kuliah. Platform ini memungkinkan:

- **Student** → Mendaftar, browse kursus, beli kursus, belajar, beri review
- **Instructor** → Membuat & mengelola kursus, section, lecture, kupon
- **Admin** → Mengelola seluruh platform (user, kursus, kategori, order, setting)

### Referensi Fitur
Project ini terinspirasi dari [Shuvouits/YouTubeLMS](https://github.com/Shuvouits/YouTubeLMS) (Laravel 11 LMS). Kita membangun versi yang **LEBIH BAIK** menggunakan **Laravel 12** dengan payment gateway **Midtrans** (bukan Stripe).

---

## 2. ARSITEKTUR TEKNIS

### 2.1 Tech Stack

| Layer | Teknologi | Versi |
|-------|-----------|-------|
| **Backend** | Laravel | 12.x |
| **PHP** | PHP | ^8.3 |
| **Database** | MySQL | 8.x |
| **Frontend** | Blade + TailwindCSS | v4 |
| **JS Interactivity** | Alpine.js | ^3.x |
| **Build Tool** | Vite | Latest |
| **Payment** | Midtrans Snap API | v2 |
| **Auth** | Laravel Breeze | Latest |
| **Social Login** | Laravel Socialite (Google) | Latest |
| **Media Storage** | Cloudinary + YouTube (video backup) | Latest |
| **Search** | Meilisearch + Laravel Scout | Latest |
| **Real-time** | Laravel Reverb (WebSocket) | Latest |
| **Email** | Resend (prod) / Mailtrap (dev) | Latest |
| **Admin Panel** | Custom Blade (bukan Filament) | — |
| **Testing** | PHPUnit / Pest | Latest |

### 2.2 Database Schema (Canonical)

> ⚠️ **JANGAN** memodifikasi schema tanpa persetujuan PM. Detail lengkap di `02_architecture/DATABASE_SCHEMA.md`.

```
users                → id, name, email, password, role, photo, phone, address, bio, website, ...
categories           → id, name, slug, image, status
sub_categories       → id, category_id (FK), name, slug
courses              → id, category_id (FK), subcategory_id (FK), instructor_id (FK→users),
                       title, slug, description, price, discount, thumbnail, video_url,
                       duration, bestseller, featured, status
course_goals         → id, course_id (FK), goal
course_sections      → id, course_id (FK), title, sort_order
course_lectures      → id, section_id (FK), title, url, content, duration, sort_order
wishlists            → id, user_id (FK), course_id (FK) — UNIQUE(user_id, course_id)
carts                → id, user_id (FK), course_id (FK) — UNIQUE(user_id, course_id)
coupons              → id, instructor_id (FK), course_id (FK nullable), code, discount_percent,
                       valid_until, max_usage, used_count, status
payments             → id, user_id (FK), midtrans_order_id, midtrans_transaction_id,
                       payment_type, total_amount, status, midtrans_response
orders               → id, payment_id (FK), user_id (FK), course_id (FK),
                       instructor_id (FK denorm), coupon_id (FK nullable),
                       original_price, discount_amount, final_price, status
enrollments          → id, user_id (FK), course_id (FK), order_id (FK), enrolled_at
                       — UNIQUE(user_id, course_id)
lecture_completions  → id, user_id (FK), lecture_id (FK), completed_at
                       — UNIQUE(user_id, lecture_id)
reviews              → id, user_id (FK), course_id (FK), rating, comment, status
                       — UNIQUE(user_id, course_id)
sliders              → id, title, description, image, button_text, button_url, status, sort_order
info_boxes           → id, title, description, icon, sort_order
partners             → id, name, image, status, sort_order
site_infos           → id, key, value
```

### 2.3 Eloquent Models (Yang Harus Dibuat)

Lokasi: `app/Models/`

```
User, Category, SubCategory, Course, CourseGoal, CourseSection,
CourseLecture, Wishlist, Cart, Coupon, Payment, Order,
Enrollment, LectureCompletion, Review,
Slider, InfoBox, Partner, SiteInfo
```

### 2.4 Role System

| Role | Nilai di DB | Akses |
|------|-------------|-------|
| `user` | `user` | Browse, beli kursus, wishlist, review |
| `instructor` | `instructor` | + Buat/edit kursus, section, lecture, kupon |
| `admin` | `admin` | + Kelola semua: user, kursus, kategori, order, settings |

---

## 3. PRIORITAS DEVELOPMENT

Kerjakan sesuai urutan prioritas. **JANGAN** loncat ke prioritas lebih rendah sebelum yang lebih tinggi selesai.

| Priority | Modul | Status | PIC |
|----------|-------|--------|-----|
| **P0** | Project Setup (Laravel 12 + DB) | NOT STARTED | Yosua |
| **P1** | Database Migrations & Models | NOT STARTED | Yosua |
| **P2** | Auth System (Breeze + Role + Google) | NOT STARTED | Albariqi |
| **P3** | Landing Page & Frontend Base | NOT STARTED | Vascha & Quinsha |
| **P4** | Category & SubCategory CRUD | NOT STARTED | Quinsha & Vascha |
| **P5** | Course CRUD (Instructor) | NOT STARTED | Albariqi |
| **P6** | Course Section & Lecture | NOT STARTED | Albariqi |
| **P7** | Cart & Wishlist | NOT STARTED | Ray |
| **P8** | Payment (Midtrans) & Order | NOT STARTED | Ray |
| **P9** | Student Dashboard & Enrolled | NOT STARTED | Vascha & Quinsha |
| **P10** | Review & Rating System | NOT STARTED | Quinsha & Vascha |
| **P11** | Admin Panel (Full) | NOT STARTED | Quinsha & Vascha |
| **P12** | Coupon System | NOT STARTED | Ray |
| **P13** | Site Settings & SMTP | NOT STARTED | Quinsha & Vascha |
| **P14** | Polish, Testing, Deploy | NOT STARTED | ALL |

---

## 4. CODING STANDARDS

### 4.1 Aturan Bahasa

- **Nama fungsi/method:** English only (e.g., `getCoursesByCategory()`)
- **Nama variabel:** English only (e.g., `$courseCount`)
- **Database column:** English (mengikuti schema di atas)
- **Comment & docblock:** English
- **Text UI (label, heading, tombol):** **Bahasa Indonesia** (UX lokal)
- **Nama route:** English dengan kebab-case (e.g., `course-details`)

### 4.2 Konvensi Laravel 12

```php
// ✅ BENAR — Gunakan Eloquent relationships + eager loading
$courses = Course::with(['category', 'instructor', 'sections.lectures'])
    ->where('status', 'active')
    ->paginate(12);

// ❌ SALAH — Raw query + N+1
$courses = DB::table('courses')->get();
foreach ($courses as $course) {
    $course->category = DB::table('categories')->find($course->category_id);
}
```

```php
// ✅ BENAR — Form Request validation
class StoreCourseRequest extends FormRequest {
    public function rules(): array {
        return [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}

// ❌ SALAH — Inline validation di controller (untuk yang kompleks)
```

### 4.3 Konvensi Controller

```
app/Http/Controllers/
├── Frontend/
│   ├── HomeController.php
│   ├── CourseDetailController.php
│   ├── CartController.php
│   ├── CheckoutController.php
│   └── WishlistController.php
├── Backend/
│   ├── Admin/
│   │   ├── DashboardController.php
│   │   ├── CategoryController.php
│   │   ├── CourseController.php
│   │   ├── OrderController.php
│   │   ├── UserController.php
│   │   └── SettingController.php
│   ├── Instructor/
│   │   ├── DashboardController.php
│   │   ├── CourseController.php
│   │   ├── SectionController.php
│   │   ├── LectureController.php
│   │   └── CouponController.php
│   └── Student/
│       ├── DashboardController.php
│       ├── ProfileController.php
│       └── WishlistController.php
├── Auth/
│   └── (Laravel Breeze auto-generated)
└── SocialController.php
```

### 4.4 Konvensi View / Blade

```
resources/views/
├── layouts/
│   ├── app.blade.php            ← Main layout
│   ├── admin.blade.php          ← Admin layout
│   └── instructor.blade.php     ← Instructor layout
├── components/
│   ├── navbar.blade.php
│   ├── footer.blade.php
│   ├── course-card.blade.php
│   ├── category-card.blade.php
│   └── sidebar.blade.php
├── frontend/
│   ├── home.blade.php
│   ├── course-detail.blade.php
│   ├── cart.blade.php
│   └── checkout.blade.php
├── backend/
│   ├── admin/
│   ├── instructor/
│   └── student/
└── auth/
```

### 4.5 Security Rules

1. **JANGAN** expose internal ID di URL → gunakan slug
2. **SELALU** apply middleware `auth` untuk route yang butuh login
3. **SELALU** validasi input — gunakan Form Requests
4. **JANGAN** hardcode credentials — selalu baca dari `.env`
5. **SELALU** gunakan CSRF token di form
6. **JANGAN** trust user input — sanitize & validate everything
7. **Midtrans keys** harus di `.env`, JANGAN di kode

---

## 5. BUSINESS LOGIC KRITIS

### 5.1 Purchase Flow

```
[Browse] → [Add to Cart] → [Checkout] → [Midtrans Payment] → [Callback] → [Order Created] → [Access Course]
```

### 5.2 Midtrans Payment Flow

```php
// 1. User klik "Bayar" → Controller buat Snap Token
// PENTING: is_production SELALU false (sandbox) — project non-komersial
\Midtrans\Config::$serverKey    = config('midtrans.server_key');
\Midtrans\Config::$isProduction = false; // HARDCODED, bukan dari env
\Midtrans\Config::$isSanitized  = true;
\Midtrans\Config::$is3ds        = true;

$params = [
    'transaction_details' => [
        'order_id'     => 'BKUY-' . time() . '-' . auth()->id(),
        'gross_amount' => (int) $totalAmount, // HARUS integer (Rupiah)
    ],
    'customer_details' => [
        'first_name' => auth()->user()->name,
        'email'      => auth()->user()->email,
    ],
    'item_details' => $items, // dari cart, price harus integer
];
$snapToken = \Midtrans\Snap::getSnapToken($params);

// 2. Frontend: load snap.js dari URL SANDBOX (selalu)
//    <script src="https://app.sandbox.midtrans.com/snap/snap.js" ...>
//    snap.pay($snapToken, { onSuccess, onPending, onError, onClose })
// 3. Midtrans kirim callback ke /payment/callback
// 4. Di callback: cek fraud_status (CC) + transaction_status → Update payment + Create orders
```

### 5.3 Enrollment Check

```php
// Cek apakah student sudah beli kursus ini
$isEnrolled = Order::where('user_id', auth()->id())
    ->where('course_id', $courseId)
    ->where('status', 'completed')
    ->exists();
```

### 5.4 Instructor Revenue Calculation

```php
// Instructor dapat 70% dari harga kursus (setelah diskon)
$instructorShare = $order->price * 0.70;
$platformShare = $order->price * 0.30;
```

### 5.5 Course Status Flow

```
draft → pending_review → active → inactive
                      ↗
         admin approve
```

---

## 6. STRICT CONSTRAINTS (NON-NEGOTIABLE)

> ⛔ Aturan ini **TIDAK BOLEH** dilanggar oleh AI agent manapun.

1. **JANGAN** modifikasi migrations yang sudah dibuat tanpa izin PM
2. **JANGAN** install Composer/NPM package baru tanpa izin PM
3. **JANGAN** hapus atau rename file yang sudah ada tanpa izin
4. **JANGAN** mengubah database column names dari schema yang sudah ditetapkan
5. **JANGAN** membuat model yang sudah ada — modifikasi saja jika perlu
6. **SELALU** jalankan `php artisan migrate:status` sebelum propose perubahan schema
7. **JANGAN** hardcode API keys atau credentials
8. **SELALU** bekerja di branch yang sesuai (lihat `GIT_WORKFLOW.md`)
9. **SELALU** update `PROGRESS_TRACKER.md` setelah menyelesaikan task
10. **JANGAN** menggunakan Stripe — kita menggunakan **Midtrans Snap ONLY**
11. **JANGAN** set `Config::$isProduction = true` — project ini **SELALU sandbox**

---

## 7. FORMAT KOMUNIKASI AI AGENT

Saat melaporkan progress, gunakan format ini:

```
TASK: [Nama task yang dikerjakan]
ACTION: [Apa yang dilakukan — file yang dibuat/dimodifikasi]
RESULT: [Hasil — berhasil/gagal + detail]
BLOCKERS: [Hal yang menghambat, jika ada]
NEXT: [Task selanjutnya yang perlu dikerjakan]
```

### Contoh:

```
TASK: Implementasi CartController dengan add/remove/fetch
ACTION: Dibuat app/Http/Controllers/Frontend/CartController.php
        Dibuat resources/views/frontend/cart.blade.php
        Ditambahkan 5 route di routes/web.php
RESULT: Cart berfungsi — add, remove, fetch, coupon apply. Tested manual OK.
BLOCKERS: Tidak ada.
NEXT: [P8] Integrasi Midtrans Snap untuk checkout.
```

---

## 8. PETA FILE PROYEK

```
BelajarKUY/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Frontend/          # HomeController, CartController, CheckoutController, WishlistController
│   │   │   ├── Backend/
│   │   │   │   ├── Admin/         # DashboardController, CategoryController, CourseController, ...
│   │   │   │   ├── Instructor/    # DashboardController, CourseController, SectionController, ...
│   │   │   │   └── Student/       # DashboardController, ProfileController, ...
│   │   │   ├── Auth/              # Breeze auto-generated
│   │   │   └── SocialController.php
│   │   ├── Middleware/
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/              # Form Request classes
│   └── Models/                    # 18 Eloquent models
│
├── database/
│   ├── migrations/                # ~20 migration files
│   ├── seeders/                   # DatabaseSeeder, CategorySeeder, etc.
│   └── factories/                 # Model factories
│
├── resources/views/
│   ├── layouts/                   # app, admin, instructor layouts
│   ├── components/                # Reusable Blade components
│   ├── frontend/                  # Public-facing pages
│   ├── backend/                   # Admin, Instructor, Student panels
│   └── auth/                      # Login, Register, etc.
│
├── routes/
│   ├── web.php                    # All web routes
│   └── auth.php                   # Breeze auth routes
│
├── config/
│   └── midtrans.php               # Midtrans configuration
│
├── public/
│   └── uploads/                   # User uploads (photos, thumbnails)
│
├── BelajarKUY_docs/               # ← Folder dokumentasi ini
│
├── .env                           # Environment variables
├── composer.json
└── package.json
```

---

## 9. CARA UPDATE PROGRESS

Setelah menyelesaikan task apapun, update `06_reports/PROGRESS_TRACKER.md`:

1. Pindahkan item dari `🔴 BELUM DIKERJAKAN` ke `🟢 SELESAI`
2. Update persentase di tabel summary
3. Tambahkan entry dengan timestamp: `> **Update:** DD Mei 2026 — HH:MM WIB oleh [NAMA]`
4. Dokumentasikan known issues yang ditemukan

---

*End of AGENT_GUIDELINES.md — Ini adalah single source of truth untuk semua AI agent di project BelajarKUY.*
