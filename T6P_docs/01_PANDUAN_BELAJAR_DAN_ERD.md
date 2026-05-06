# Panduan Belajar Repo YouTubeLMS — Persiapan Presentasi Database

> **Repo sumber:** `https://github.com/Shuvouits/YouTubeLMS`
> **Tech stack:** Laravel 11 + Blade + Tailwind + Vite + MySQL/MariaDB
> **Tujuan:** Presentasi struktur database (ERD) + adaptasi untuk pasar Indonesia

---

## 1. Ringkasan Cepat Repo (yang wajib kalian tahu sebelum presentasi)

Repo ini adalah LMS (Learning Management System) bergaya Udemy dengan **3 peran utama**: Admin, Instructor, dan Student. Yang paling penting untuk presentasi besok adalah **bagian database**, bukan UI. Fokus ke:

- 21 file migration (3 default Laravel + 18 milik project)
- 19 Eloquent Model di `app/Models/`
- Relasi antar tabel (one-to-many, many-to-many lewat pivot)
- Alur bisnis: katalog kursus → keranjang → checkout → pembayaran → enrollment

---

## 2. Daftar Tabel dari Migrations (urut kronologis)

Inilah daftar tabel asli dari repo. Pelajari dulu ini, baru lakukan adaptasi.

| # | Tabel | Fungsi |
|---|-------|--------|
| 1 | `users` | User generic (siswa, instruktur, admin) |
| 2 | `cache`, `jobs` | Default Laravel (queue & cache) |
| 3 | `categories` | Kategori utama kursus (Programming, Design, dll) |
| 4 | `sub_categories` | Sub-kategori (Laravel, Figma, dll) |
| 5 | `sliders` | Banner homepage |
| 6 | `info_boxes` | Highlight di homepage |
| 7 | `courses` | Data utama kursus |
| 8 | `course_goals` | Learning outcomes per kursus |
| 9 | `course_sections` | Bagian/chapter kursus |
| 10 | `course_lectures` | Video/materi tiap section |
| 11 | `wishlists` | Kursus favorit user |
| 12 | `carts` | Keranjang belanja |
| 13 | `coupons` | Kupon diskon |
| 14 | `stripes` | Konfigurasi Stripe (akan kita ganti Midtrans) |
| 15 | `payments` | Catatan pembayaran |
| 16 | `orders` | Order/transaksi |
| 17 | `googles` | Konfigurasi Google login |
| 18 | `smtps` | Konfigurasi email |
| 19 | `partners` | Logo partner di homepage |
| 20 | `site_infos` | Konfigurasi umum site |

---

## 3. ERD Sederhana (versi original repo)

Inilah peta relasi yang harus kalian gambar di whiteboard / slide saat presentasi.

```
users ────┬──< courses (instructor_id)
          ├──< wishlists >── courses
          ├──< carts >── courses
          ├──< orders ──< payments
          └──< course_lectures (progress, opsional)

categories ──< sub_categories ──< courses ──< course_sections ──< course_lectures
                                       └──< course_goals

coupons ──> orders (apply discount)
```

Notasi: `A ──< B` artinya **one-to-many** (1 A punya banyak B). `>──<` artinya **many-to-many** lewat pivot.

**Relasi paling kritikal yang harus dijelaskan:**

1. `User (instructor) 1 → N Course` — satu instruktur bisa punya banyak kursus.
2. `Course 1 → N CourseSection 1 → N CourseLecture` — hierarki kursus 3-level.
3. `User N ↔ N Course` lewat `carts` dan `wishlists` (pivot).
4. `Order N → 1 User`, `Order 1 → N Payment` (untuk cicilan/multi-payment) — tergantung implementasi.
5. `Coupon 1 → N Order` (1 kupon bisa dipakai banyak order).

---

## 4. Adaptasi untuk Pasar Indonesia (poin diferensiasi presentasi)

Ini kelebihan kalian dibanding tutorial aslinya. Tunjukkan **perubahan struktur database**:

### A. Ganti Stripe → Midtrans

Tabel `stripes` dihapus, ganti jadi `midtrans_configs`:

```
midtrans_configs:
  - id
  - server_key (encrypted)
  - client_key
  - merchant_id
  - is_production (boolean) — untuk membedakan sandbox vs production
  - notification_url
  - timestamps
```

Tabel `payments` ditambah kolom yang sesuai Midtrans:

```
payments (tambahan kolom):
  - midtrans_order_id (string, unique)
  - transaction_id (string, nullable)
  - payment_type (enum: bank_transfer, gopay, qris, shopeepay, credit_card, cstore)
  - va_number (nullable) — untuk virtual account
  - bank (nullable) — bca, bni, mandiri, permata, bri
  - fraud_status
  - settlement_time (timestamp, nullable)
  - status (enum: pending, settlement, capture, deny, cancel, expire, failure, refund)
```

### B. Sesuaikan Currency & Pajak Indonesia

Tabel `courses` & `orders`:

```
- price disimpan dalam IDR (integer/bigint, bukan decimal — karena IDR tidak pakai sen)
- ppn_percentage (default 11) di tabel orders/site_infos
- ppn_amount, subtotal, total — dipisah biar audit trail jelas
```

### C. Kategori Kursus untuk Mahasiswa Indonesia

Seed data kategori yang relevan (bukan generic global):

- "Persiapan UTBK & SNBT"
- "Skripsi & Tugas Akhir" (LaTeX, Mendeley, SPSS, Python untuk skripsi)
- "Bahasa Inggris IELTS/TOEFL"
- "Programming untuk Pemula" (Laravel, Next.js, Flutter)
- "Desain Grafis (Figma, Canva)"
- "Persiapan Kerja & Magang" (CV ATS, LinkedIn, Excel kantor)
- "Sertifikasi BNSP"

### D. Tambahan Tabel Khas Indonesia

```
provinces, cities — untuk alamat siswa (referensi data BPS)
universities — agar siswa bisa link ke kampus mereka (untuk diskon edu)
referral_codes — sistem referral antar mahasiswa
```

---

## 5. Yang Harus Tiap Anggota Tim Pelajari (5 orang, dibagi rata)

| Anggota | Fokus | File yang dibaca |
|---------|-------|------------------|
| 1 — User & Auth | `users`, role logic, social login | `User.php`, `routes/auth.php`, `SocialController` |
| 2 — Course Domain | Hierarki course→section→lecture | `Course.php`, `CourseSection.php`, `CourseLecture.php`, `CourseGoal.php` migrations |
| 3 — Catalog | Category, SubCategory, Slider, Partner | `Category.php`, `SubCategory.php`, controller backend |
| 4 — Cart & Checkout | Cart, Wishlist, Coupon, Order | `Cart.php`, `Order.php`, `Coupon.php`, `CheckoutController` |
| 5 — Payment & Settings | Payment, Stripe→Midtrans, SiteInfo | `Payment.php`, `Stripe.php`, `SiteInfo.php` |

Tiap orang **wajib bisa menjelaskan**:
1. Kolom apa saja di tabelnya
2. Foreign key ke tabel mana
3. Index apa yang dipakai
4. Use-case real (kapan tabel itu di-INSERT/UPDATE)

---

## 6. Checklist Presentasi Database (besok)

- [ ] Slide 1: Latar belakang — kenapa LMS, kenapa adaptasi Indonesia
- [ ] Slide 2: Tech stack & arsitektur high level
- [ ] Slide 3: ERD lengkap (gambar/draw.io)
- [ ] Slide 4–6: Detail per domain (User, Course, Transaction)
- [ ] Slide 7: Perbedaan vs repo asli (Midtrans, IDR, kategori lokal)
- [ ] Slide 8: Demo migration jalan (`php artisan migrate:fresh --seed`)
- [ ] Slide 9: Q&A — siapkan jawaban: kenapa pakai pivot? kenapa soft delete? kenapa enum?

---

## 7. Tips Presentasi

1. **Jangan baca slide.** Ceritakan alur user: "Mahasiswa daftar → cari kursus → masuk cart → bayar via QRIS Midtrans → enrollment otomatis."
2. **Siapkan 1 query JOIN kompleks** untuk demo (misal: top 5 kursus terlaris bulan ini lewat join orders + courses).
3. **Hafalkan minimal 3 alasan** kenapa tabel dipisah (normalisasi 3NF, performance index, separation of concerns).
4. **Dokumentasikan asumsi.** Misal: "Kami asumsikan 1 order = 1 atau lebih course (bukan 1 course = 1 order) karena cart bisa multi-item."

Semoga sukses besok! 🚀
