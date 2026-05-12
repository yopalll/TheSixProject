# 🌿 BelajarKUY — Git Workflow

> Panduan branching strategy dan commit rules untuk Tim BelajarKUY.

---

## Branch Strategy

```
main (production-ready)
 └── develop (integration branch)
      ├── feature/auth-system          ← Albariqi
      ├── feature/course-management    ← Albariqi
      ├── feature/payment-midtrans     ← Ray
      ├── feature/cart-wishlist        ← Ray
      ├── feature/landing-page         ← Vascha
      ├── feature/student-dashboard    ← Vascha
      ├── feature/admin-panel          ← Quinsha
      ├── feature/review-system        ← Quinsha
      ├── hotfix/xxx                   ← Bug fixes
      └── chore/xxx                    ← Config, docs, refactor
```

### Branch Rules

| Branch | Siapa yang merge | Aturan |
|--------|-----------------|--------|
| `main` | PM Only (Yosua) | Hanya dari `develop`, setelah testing |
| `develop` | PM / PIC branch | Via Pull Request + 1 approval |
| `feature/*` | PIC masing-masing | Bebas push, PR ke `develop` |
| `hotfix/*` | Siapapun | PR ke `develop` + `main` |

---

## Commit Convention

Format: `[MODUL] Deskripsi singkat`

### Prefix Modul:

| Prefix | Untuk |
|--------|-------|
| `[AUTH]` | Authentication, login, register, role |
| `[COURSE]` | Course CRUD, section, lecture |
| `[CART]` | Cart & wishlist |
| `[PAYMENT]` | Midtrans, checkout, order |
| `[ADMIN]` | Admin panel |
| `[INSTRUCTOR]` | Instructor panel |
| `[STUDENT]` | Student dashboard |
| `[FRONTEND]` | Landing page, UI components |
| `[REVIEW]` | Review & rating |
| `[SETTING]` | Site settings, SMTP, config |
| `[DB]` | Migration, seeder, model |
| `[FIX]` | Bug fix |
| `[DOCS]` | Documentation |
| `[CHORE]` | Refactor, cleanup, config |

### Contoh Commit Messages:

```bash
git commit -m "[AUTH] Implementasi multi-role middleware"
git commit -m "[COURSE] CRUD course dengan section & lecture"
git commit -m "[PAYMENT] Integrasi Midtrans Snap API"
git commit -m "[FIX] Cart tidak menghapus item setelah checkout"
git commit -m "[DB] Tambah migration tabel reviews"
git commit -m "[DOCS] Update progress tracker sprint 2"
```

---

## Workflow Harian

### Sebelum Mulai Kerja:

```bash
# 1. Pindah ke branch develop
git checkout develop

# 2. Pull perubahan terbaru
git pull origin develop

# 3. Pindah ke branch fitur kamu
git checkout feature/nama-fitur

# 4. Merge develop ke branch fitur (supaya up-to-date)
git merge develop
```

### Setelah Selesai Kerja:

```bash
# 1. Stage & commit
git add .
git commit -m "[MODUL] Deskripsi perubahan"

# 2. Push ke remote
git push origin feature/nama-fitur

# 3. Buat Pull Request ke develop (via GitHub/GitLab)
```

---

## Pull Request Rules

1. **Title:** `[MODUL] Ringkasan perubahan`
2. **Description:** Jelaskan apa yang berubah, kenapa, dan bagaimana test-nya
3. **Reviewer:** Tag PM (Yosua) atau anggota lain
4. **Checklist sebelum PR:**
   - [ ] Code berjalan tanpa error
   - [ ] Migration berjalan (`php artisan migrate`)
   - [ ] Tidak ada hardcoded credentials
   - [ ] `PROGRESS_TRACKER.md` sudah di-update
   - [ ] Tidak ada conflict dengan `develop`

---

## Resolving Conflicts

```bash
# 1. Pull develop terbaru
git checkout develop
git pull origin develop

# 2. Kembali ke branch fitur
git checkout feature/nama-fitur

# 3. Merge develop
git merge develop

# 4. Resolve conflicts manually di editor

# 5. Stage & commit
git add .
git commit -m "[CHORE] Resolve merge conflicts dengan develop"
```

---

## Initial Repository Setup (PM Only)

```bash
# 1. Init project
laravel new BelajarKUY --git

# 2. Push ke remote
cd BelajarKUY
git remote add origin https://github.com/xxx/BelajarKUY.git
git push -u origin main

# 3. Buat branch develop
git checkout -b develop
git push -u origin develop

# 4. Set develop sebagai default branch (di GitHub settings)
```

---

*Ikuti workflow ini dengan konsisten agar tidak ada konflik yang membuang waktu.*
