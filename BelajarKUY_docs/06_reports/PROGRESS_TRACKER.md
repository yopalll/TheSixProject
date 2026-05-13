# 📊 BelajarKUY — Progress Tracker

> Log progress setiap sesi kerja. Update file ini SETELAH setiap sesi.

---

> **Update terakhir:** 13 Mei 2026 — 23:00 WIB oleh Kiro (AI Agent)

---

## Summary

| Modul | Progress | Status |
|-------|----------|--------|
| Project Setup | 100% | 🟢 Selesai |
| Database (Migrations + Models) | 50% | 🟡 On Progress |
| Auth System | 0% | 🔴 Belum |
| Landing Page | 0% | 🔴 Belum |
| Category CRUD | 0% | 🔴 Belum |
| Course CRUD (Instructor) | 0% | 🔴 Belum |
| Cart & Wishlist | 0% | 🔴 Belum |
| Payment (Midtrans) | 0% | 🔴 Belum |
| Student Dashboard | 0% | 🔴 Belum |
| Admin Panel | 0% | 🔴 Belum |
| Review & Rating | 0% | 🔴 Belum |
| Coupon System | 0% | 🔴 Belum |
| Site Settings | 0% | 🔴 Belum |
| **OVERALL** | **10%** | **🟡 On Progress** |

---

## 🟢 SELESAI

- Init Laravel 12 project
- Setup TailwindCSS + Vite
- Semua 19 database migrations (Schema v2) — termasuk enrollments & lecture_completions baru
- ERD HTML interaktif di BelajarKUY_docs/07_extras/ERD_BelajarKUY.html

---

## 🔄 SEDANG DIKERJAKAN

_(Belum ada item yang sedang dikerjakan)_

---

## 🔴 BELUM DIKERJAKAN

### Phase 1: Foundation
- [x] Init Laravel 12 project
- [x] Setup TailwindCSS + Vite
- [x] Create all database migrations (19 tables — Schema v2)
- [x] ERD HTML di BelajarKUY_docs
- [ ] Create all Eloquent models (~18)
- [ ] Create database seeders
- [ ] Install & configure Breeze
- [ ] Implement RoleMiddleware
- [ ] Google OAuth setup
- [ ] Separate login pages per role
- [ ] Post-login redirect logic

### Phase 2: Core Features
- [ ] Main layout (app.blade.php)
- [ ] Navbar component
- [ ] Footer component
- [ ] Course card component
- [ ] Category card component
- [ ] Landing page (full)
- [ ] Course detail page
- [ ] Category CRUD (admin)
- [ ] SubCategory CRUD (admin)
- [ ] Course CRUD (instructor)
- [ ] Course Section & Lecture CRUD

### Phase 3: Commerce
- [ ] Wishlist system (AJAX)
- [ ] Cart system (AJAX)
- [ ] Cart page UI
- [ ] Checkout page
- [ ] Midtrans Snap integration
- [ ] Payment callback handler
- [ ] Order creation after payment
- [ ] Coupon system

### Phase 4: Panels
- [ ] Student dashboard
- [ ] Student enrolled courses
- [ ] Student profile & settings
- [ ] Admin dashboard (stats)
- [ ] Admin course management
- [ ] Admin instructor management
- [ ] Admin order management
- [ ] Admin user management
- [ ] Admin slider/info/partner CRUD
- [ ] Admin settings pages
- [ ] Instructor dashboard
- [ ] Instructor profile & settings

### Phase 5: Polish
- [ ] Review & rating system
- [ ] Admin review management
- [ ] Site settings CRUD
- [ ] Responsive design check
- [ ] Bug fixing
- [ ] Performance optimization
- [ ] Final testing
- [ ] Documentation

---

## 📝 Session Logs

### Session 1 — 12 Mei 2026 (Yosua)
- Created: BelajarKUY_docs folder dengan semua dokumentasi
- Cloned: Reference repo (YouTubeLMS) ke reference_repo/
- Status: Documentation phase complete. Ready to start coding.
- Next: Init Laravel 12 project (P0)

### Session 3 — 13 Mei 2026 (Kiro)
- Created: 19 database migration files sesuai DATABASE_SCHEMA.md v2
- Fixed: Duplicate index bug pada semua FK columns (foreignId() sudah auto-create index)
- Fixed: dropIndex syntax di add_fields_to_users migration
- Created: ERD HTML interaktif di BelajarKUY_docs/07_extras/ERD_BelajarKUY.html
- Updated: PROGRESS_TRACKER.md
- Status: Migrations phase complete. Ready for Eloquent models.
- Next: Create all Eloquent models (~18) dengan relationships
- Created: `01_guides/UI_UX_GUIDELINES.md` sebagai panduan tim desainer & frontend.
- Updated: `00_INDEX.md` untuk mencatat dokumen panduan baru.
- Status: Planning phase for UI/UX is ready.
- Next: Menunggu sketsa desain untuk mulai implementasi frontend.

---

## ⚠️ Known Issues

_(Belum ada known issues)_

---

## 📌 Notes

- Semua anggota tim menggunakan AI/LLM untuk coding (vibecoding)
- AI agent WAJIB membaca `01_guides/AGENT_GUIDELINES.md` sebelum mulai
- Prompt templates tersedia di `05_prompts/`
- Reference project: `reference_repo/` (YouTubeLMS — Laravel 11)

---

*Format update: `> **Update:** DD Mei 2026 — HH:MM WIB oleh [NAMA]`*
