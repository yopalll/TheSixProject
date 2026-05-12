# 🤖 PROMPT: Build Frontend Pages

> Copy-paste prompt ini ke AI agent untuk membangun halaman frontend.
> **PIC: Vascha U & Quinsha Ilmi (Frontend)**

---

## PROMPT

```
Kamu adalah senior Laravel + TailwindCSS developer. Bangun halaman-halaman frontend untuk project BelajarKUY (Udemy clone Indonesia).

## PREREQUISITE: Baca file-file berikut terlebih dahulu:
- BelajarKUY_docs/01_guides/AGENT_GUIDELINES.md
- BelajarKUY_docs/01_guides/CODING_STANDARDS.md (section Blade/Frontend)
- BelajarKUY_docs/03_features/F02_LANDING_PAGE.md

## CONTEXT:
- Laravel 12 + Blade + TailwindCSS v4
- Alpine.js tersedia untuk interactivity
- SweetAlert2 tersedia untuk notifications
- Semua model dan relationship sudah ada
- Database sudah terisi data (seeder)

## TASKS:

### 1. Main Layout (resources/views/layouts/app.blade.php)
- HTML5 boilerplate, lang="id"
- Vite CSS/JS includes
- CSRF meta tag
- @yield('title'), @yield('content')
- @stack('styles'), @stack('scripts')
- Include <x-navbar /> dan <x-footer />
- Modern, clean design — terinspirasi dari Udemy

### 2. Navbar Component (resources/views/components/navbar.blade.php)
- Logo "BelajarKUY" di kiri
- Menu: Beranda, Kategori (dropdown), Kursus
- Search bar di tengah
- Kanan: Cart icon (dengan badge count), Wishlist icon
- Jika guest: tombol "Masuk" dan "Daftar"
- Jika auth: dropdown user (nama, foto, Dashboard, Profile, Logout)
- Responsive (hamburger menu di mobile)
- **Search bar dengan live search** (Alpine.js + Meilisearch API — lihat `07_extras/MODERN_TECH_STACK_RECOMMENDATIONS.md` section 4)

### 3. Footer Component (resources/views/components/footer.blade.php)
- 4 kolom: About, Links, Kategori Populer, Kontak
- Social media icons
- Copyright text
- Data dari SiteInfo model

### 4. Course Card Component (resources/views/components/course-card.blade.php)
- Props: $course
- Thumbnail image
- Category badge
- Title (truncated)
- Instructor name
- Star rating (average)
- Price (dengan diskon jika ada — coret harga asli)
- Bestseller badge (jika applicable)
- Hover effect (shadow + scale)

### 5. Landing Page (resources/views/frontend/home.blade.php)
Section 1: Hero Slider (dari tabel sliders)
Section 2: Kategori Populer (grid 4x2 cards)
Section 3: Kursus Unggulan (carousel/grid course cards, featured=true)
Section 4: Kursus Best Seller (carousel/grid, bestseller=true)
Section 5: Mengapa BelajarKUY? (info boxes)
Section 6: Partner Kami (logo carousel)

### 6. Course Detail Page (resources/views/frontend/course-detail.blade.php)
- Hero section: thumbnail, title, description, rating, students count, instructor
- Sidebar: price, buy button, add to cart, add to wishlist
- Tabs: Deskripsi, Kurikulum (sections + lectures), Review
- Kurikulum: accordion sections → list lectures
- Review: list reviews + form (jika eligible)
- Related courses section

### 7. HomeController (app/Http/Controllers/Frontend/HomeController.php)
```php
public function index()
{
    $sliders = Slider::where('status', true)->orderBy('order')->get();
    $categories = Category::active()->withCount('courses')->take(8)->get();
    $featuredCourses = Course::active()->featured()
        ->with(['category', 'instructor', 'reviews'])->take(8)->get();
    $bestsellerCourses = Course::active()->bestseller()
        ->with(['category', 'instructor', 'reviews'])->take(8)->get();
    $infoBoxes = InfoBox::orderBy('order')->get();
    $partners = Partner::where('status', true)->orderBy('order')->get();

    return view('frontend.home', compact(
        'sliders', 'categories', 'featuredCourses',
        'bestsellerCourses', 'infoBoxes', 'partners'
    ));
}
```

## DESIGN GUIDELINES:
- Warna utama: Indigo (#4F46E5) atau Purple (#7C3AED)
- Warna aksen: Amber/Orange untuk CTA buttons
- Background: White + Light Gray sections
- Font: Inter atau system-ui
- Responsive: mobile-first
- Animasi subtle: hover effects, transition, fade-in
- Kartu kursus mirip style Udemy

## CONSTRAINT:
- HANYA TailwindCSS (jangan tambah CSS custom kecuali sangat perlu)
- Alpine.js untuk dropdown, accordion, slider
- Text UI dalam Bahasa Indonesia
- Gunakan @extends('layouts.app'), @section('content')
- Gunakan <x-component /> syntax untuk reusable components
- Semua gambar dari database (URL Cloudinary), jangan hardcode
- Video kursus embed dari YouTube (URL di `course_lectures.url`)
- Gunakan live search component di navbar (Alpine.js + Meilisearch API — lihat `07_extras/`)

## OUTPUT:
- Layout file
- Semua component files
- Home page view
- Course detail page view
- HomeController
- CourseDetailController
- Route additions
```
