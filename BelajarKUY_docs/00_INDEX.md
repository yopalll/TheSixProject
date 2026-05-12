# 📚 BelajarKUY — Dokumentasi Proyek (Master Index)

> **Project:** BelajarKUY — Platform E-Learning Indonesia (Udemy Clone)
> **Tech Stack:** Laravel 12 + MySQL + Midtrans + TailwindCSS v4 + Alpine.js + Cloudinary + Meilisearch + Laravel Reverb + Resend
> **Team:** 5 Anggota | **Deadline:** Tugas Besar Kuliah
> **Created:** 12 Mei 2026 | **Last Updated:** 12 Mei 2026

---

## 🗂️ Struktur Folder Dokumentasi

```
BelajarKUY_docs/
│
├── 00_INDEX.md                          ← KAMU DI SINI
│
├── 01_guides/
│   ├── AGENT_GUIDELINES.md              ← System prompt untuk SEMUA AI agent
│   ├── SETUP_GUIDE.md                   ← Cara install & setup project
│   ├── GIT_WORKFLOW.md                  ← Branching strategy & commit rules
│   └── CODING_STANDARDS.md              ← Konvensi kode Laravel 12
│
├── 02_architecture/
│   ├── TECH_STACK.md                    ← Detail tech stack & versi
│   ├── DATABASE_SCHEMA.md               ← ERD & detail semua tabel
│   ├── DATABASE_MIGRATIONS_PROMPT.md    ← Prompt AI untuk generate migrations
│   ├── FOLDER_STRUCTURE.md              ← Struktur folder Laravel
│   └── API_ROUTES.md                    ← Semua routes & endpoint
│
├── 03_features/
│   ├── F01_AUTH_SYSTEM.md               ← Register, Login, Multi-role, Google OAuth
│   ├── F02_LANDING_PAGE.md              ← Homepage, Slider, Info Boxes
│   ├── F03_COURSE_MANAGEMENT.md         ← CRUD Course (Instructor)
│   ├── F04_CATEGORY_SYSTEM.md           ← Kategori & Sub-kategori
│   ├── F05_CART_WISHLIST.md             ← Keranjang & Wishlist
│   ├── F06_PAYMENT_MIDTRANS.md          ← Integrasi Midtrans Snap
│   ├── F07_ADMIN_PANEL.md              ← Dashboard & Management Admin
│   ├── F08_INSTRUCTOR_PANEL.md         ← Dashboard & Course Mgmt Instructor
│   ├── F09_STUDENT_PANEL.md            ← Dashboard, Enrolled Courses, Progress
│   ├── F10_REVIEW_RATING.md            ← Sistem Review & Rating
│   ├── F11_COUPON_SYSTEM.md            ← Kupon diskon
│   └── F12_SITE_SETTINGS.md            ← Settings, SMTP, Partner, Info Box
│
├── 04_plans/
│   ├── MASTER_ROADMAP.md               ← Timeline & milestone utama
│   ├── SPRINT_PLAN.md                  ← Sprint breakdown per minggu
│   └── TASK_DISTRIBUTION.md            ← Pembagian tugas per anggota
│
├── 05_prompts/
│   ├── PROMPT_SETUP_PROJECT.md         ← Prompt AI: Init Laravel 12 project
│   ├── PROMPT_MIGRATIONS.md            ← Prompt AI: Generate all migrations
│   ├── PROMPT_MODELS.md                ← Prompt AI: Generate all Eloquent models
│   ├── PROMPT_AUTH.md                   ← Prompt AI: Build auth system
│   ├── PROMPT_MIDTRANS.md              ← Prompt AI: Integrate Midtrans
│   ├── PROMPT_FRONTEND.md              ← Prompt AI: Build frontend pages
│   └── PROMPT_ADMIN_PANEL.md           ← Prompt AI: Build admin panel
│
└── 06_reports/
    └── PROGRESS_TRACKER.md             ← Log progress tiap sesi kerja
```

---

## 👥 Tim Pengembang

| # | Nama | Role | Tanggung Jawab Utama |
|---|------|------|---------------------|
| 1 | **Yosua Valentino** | Project Manager | Arsitektur, integrasi, code review |
| 2 | **Albariqi Tarigan** | Backend Developer | Auth, course management, instructor panel |
| 3 | **Ray Nathan** | Backend Developer | Payment (Midtrans), cart, order system |
| 4 | **Vascha U** | Frontend Developer | Tampilan Frontend, Landing page, Blade templates |
| 5 | **Quinsha Ilmi** | UI/UX Developer | Tampilan UI/UX, Admin panel UI, Frontend |

---

## 🚀 Quick Start untuk Anggota Baru

1. **Baca** `01_guides/AGENT_GUIDELINES.md` — Wajib dibaca oleh semua AI agent
2. **Setup** project sesuai `01_guides/SETUP_GUIDE.md`
3. **Pahami** database di `02_architecture/DATABASE_SCHEMA.md`
4. **Cek tugas** di `04_plans/TASK_DISTRIBUTION.md`
5. **Gunakan prompt** di folder `05_prompts/` untuk generate kode via AI

---

## ⚠️ ATURAN PENTING

1. **SELALU** baca `AGENT_GUIDELINES.md` sebelum mulai coding
2. **JANGAN** modifikasi migration yang sudah dibuat tanpa persetujuan PM
3. **SELALU** commit dengan format: `[MODUL] Deskripsi singkat`
4. **JANGAN** push ke `main` langsung — selalu via branch + PR
5. **UPDATE** `06_reports/PROGRESS_TRACKER.md` setelah setiap sesi kerja
