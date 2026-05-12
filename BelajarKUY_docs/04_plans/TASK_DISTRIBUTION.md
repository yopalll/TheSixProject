# 👥 BelajarKUY — Task Distribution

> Pembagian tugas per anggota tim.

---

## Summary Per Anggota

| Anggota | Role | Area Tanggung Jawab | Est. Tasks |
|---------|------|---------------------|------------|
| **Yosua Valentino** | PM, Architect | Setup, DB, integrasi, code review | 10 |
| **Albariqi Tarigan** | Backend Dev | Auth, Course CRUD, Instructor panel | 12 |
| **Ray Nathan** | Backend Dev | Cart, Wishlist, Payment, Coupon | 11 |
| **Vascha U** | Frontend Dev | Tampilan Frontend, Landing page, Student panel | 12 |
| **Quinsha Ilmi** | UI/UX Dev | Tampilan UI/UX, Admin panel, Frontend components | 14 |

---

## Detail Per Anggota

### 1. Yosua Valentino (PM)

```
☐ Init Laravel 12 project
☐ Setup TailwindCSS + Vite config
☐ Create ALL database migrations (~20 files)
☐ Create ALL Eloquent models (~18 models)
☐ Create database seeders (admin, categories, demo courses)
☐ Setup config/midtrans.php
☐ Create MidtransService.php
☐ Setup .env.example with all variables
☐ Code review semua PR
☐ Performance optimization & bug fix final
```

### 2. Albariqi Tarigan (Backend — Auth & Course)

```
☐ Install Laravel Breeze
☐ Customize registration (add role selection)
☐ Implement RoleMiddleware
☐ Setup Google OAuth (Socialite)
☐ Create separate login pages (admin, instructor)
☐ Post-login redirect logic by role
☐ Course CRUD controller (instructor)
☐ Course form + validation (StoreCourseRequest)
☐ Dynamic subcategory loading (AJAX)
☐ Course Section CRUD
☐ Course Lecture CRUD
☐ Instructor dashboard + profile
```

### 3. Ray Nathan (Backend — Commerce)

```
☐ Wishlist add/remove (AJAX controller)
☐ Wishlist page UI
☐ Cart system — add, remove, fetch (AJAX)
☐ Cart page UI with pricing
☐ Checkout page
☐ Midtrans Snap integration (frontend JS)
☐ Payment controller (create snap token)
☐ Payment callback handler (notification URL)
☐ Order creation after successful payment
☐ Coupon CRUD (instructor)
☐ Coupon apply logic at checkout
```

### 4. Vascha U (Frontend)

```
☐ Main layout (app.blade.php) with TailwindCSS
☐ Admin layout (admin.blade.php)
☐ Instructor layout (instructor.blade.php)
☐ Navbar component (responsive, cart badge, user menu)
☐ Footer component
☐ Hero slider section
☐ Category card component
☐ Course card component
☐ Featured courses section
☐ Course detail page (full)
☐ Student dashboard
☐ Student enrolled courses page
```

### 5. Quinsha Ilmi (UI/UX — Admin & Frontend)

```
☐ Category CRUD (admin) + image upload
☐ SubCategory CRUD (admin)
☐ Admin dashboard with stats
☐ Admin course management (approve/reject)
☐ Admin instructor management (approve/block)
☐ Admin order management (list + detail)
☐ Admin user management
☐ Slider CRUD (admin)
☐ Info Box CRUD (admin)
☐ Partner CRUD (admin)
☐ Site Settings CRUD (key-value)
☐ Mail/Midtrans/Google settings page
☐ Review & Rating system
☐ Admin review management (approve/reject)
```

---

## Task Status Legend

```
☐  = Belum dikerjakan
🔄 = Sedang dikerjakan
✅ = Selesai
❌ = Blocked / bermasalah
```

---

## Aturan Kolaborasi

1. **Sebelum mulai task baru** → Pull latest dari `develop`
2. **Setelah selesai task** → Push, buat PR, update `PROGRESS_TRACKER.md`
3. **Jika blocked** → Tulis di PROGRESS_TRACKER dan notify PM (Yosua)
4. **Jika perlu modifikasi file orang lain** → Koordinasi dulu via chat
5. **Jika menggunakan AI agent** → Pastikan agent membaca `AGENT_GUIDELINES.md` terlebih dahulu

---

*Pembagian tugas ini bisa berubah sesuai progress. Update jika ada perubahan.*
