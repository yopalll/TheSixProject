# 🏠 F02: Landing Page

> Homepage publik BelajarKUY.

---

## Sections (top to bottom)

1. **Navbar** — Logo, menu, search, login/register buttons, cart icon
2. **Hero Slider** — Dynamic slider dari tabel `sliders`
3. **Featured Categories** — Grid kategori populer dari `categories`
4. **Featured Courses** — Carousel kursus featured (`featured = true`)
5. **Best Seller Courses** — Kursus best seller (`bestseller = true`)
6. **Info Boxes** — 3-4 value proposition boxes dari `info_boxes`
7. **Partners** — Logo partner dari `partners`
8. **Footer** — Informasi site dari `site_infos`, links, social media

---

## Data Sources

```php
// HomeController@index
$sliders = Slider::where('status', true)->orderBy('order')->get();
$categories = Category::where('status', true)->withCount('courses')->take(8)->get();
$featuredCourses = Course::active()->featured()->with(['category', 'instructor'])->take(8)->get();
$bestsellerCourses = Course::active()->bestseller()->with(['category', 'instructor'])->take(8)->get();
$infoBoxes = InfoBox::orderBy('order')->get();
$partners = Partner::where('status', true)->orderBy('order')->get();
$siteInfo = SiteInfo::pluck('value', 'key');
```

---

## UI Reference

Mirip landing page Udemy:
- Hero section dengan slider
- Grid kursus dengan card (thumbnail, title, instructor, rating, price)
- Responsive — mobile-first

---

## PIC: Vascha U & Quinsha Ilmi (Frontend)
