# 🛣️ BelajarKUY — API Routes

> Semua routes yang harus diimplementasikan di `routes/web.php`.

---

## Route Summary

| Grup | Jumlah Routes | Middleware |
|------|---------------|-----------|
| Public (Frontend) | ~10 | none |
| Auth (Breeze) | ~10 | guest / auth |
| Student Panel | ~8 | auth, role:user |
| Instructor Panel | ~15 | auth, role:instructor |
| Admin Panel | ~25 | auth, role:admin |
| **TOTAL** | **~68 routes** | |

---

## 1. Public Routes (No Auth)

```php
// Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Course Detail
Route::get('/course/{slug}', [CourseDetailController::class, 'show'])->name('course.detail');

// Google OAuth
Route::get('/auth/google', [SocialController::class, 'googleLogin'])->name('auth.google');
Route::get('/auth/google-callback', [SocialController::class, 'googleCallback'])->name('auth.google.callback');

// Wishlist (AJAX - tapi butuh auth check di controller)
Route::get('/wishlist/all', [WishlistController::class, 'getAll']);
Route::post('/wishlist/add', [WishlistController::class, 'add']);

// Cart (AJAX)
Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
Route::get('/cart/all', [CartController::class, 'getAll']);
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove', [CartController::class, 'remove']);
Route::get('/cart/fetch', [CartController::class, 'fetch']);

// Search (Meilisearch via Laravel Scout)
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/api/search', [SearchController::class, 'liveSearch'])->name('search.live');
```

---

## 2. Auth Routes (Laravel Breeze — auto-generated)

```php
// Di routes/auth.php (auto-generated oleh Breeze)
Route::get('/login', ...)->name('login');
Route::post('/login', ...);
Route::get('/register', ...)->name('register');
Route::post('/register', ...);
Route::post('/logout', ...)->name('logout');
Route::get('/forgot-password', ...)->name('password.request');
Route::post('/forgot-password', ...)->name('password.email');
Route::get('/reset-password/{token}', ...)->name('password.reset');
Route::post('/reset-password', ...)->name('password.update');
Route::get('/verify-email', ...)->name('verification.notice');
Route::get('/verify-email/{id}/{hash}', ...)->name('verification.verify');
```

---

## 3. Auth Protected Routes (Generic)

```php
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Coupon
    Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');

    // Payment Midtrans
    Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
});
```

---

## 4. Student Routes (`/user/*`)

```php
Route::middleware(['auth', 'verified', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [StudentDashboardController::class, 'destroy'])->name('logout');

        // Profile
        Route::get('/profile', [StudentProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [StudentProfileController::class, 'update'])->name('profile.update');
        Route::get('/setting', [StudentProfileController::class, 'setting'])->name('setting');
        Route::post('/password/update', [StudentProfileController::class, 'passwordUpdate'])->name('password.update');

        // Wishlist
        Route::get('/wishlist', [StudentWishlistController::class, 'index'])->name('wishlist');
        Route::delete('/wishlist/{id}', [StudentWishlistController::class, 'destroy'])->name('wishlist.destroy');

        // My Courses (enrolled)
        Route::get('/my-courses', [StudentDashboardController::class, 'myCourses'])->name('courses');
    });
```

---

## 5. Instructor Routes (`/instructor/*`)

```php
Route::get('/instructor/login', [InstructorController::class, 'login'])->name('instructor.login');
Route::get('/instructor/register', [InstructorController::class, 'register'])->name('instructor.register');

Route::middleware(['auth', 'verified', 'role:instructor'])
    ->prefix('instructor')
    ->name('instructor.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [InstructorDashboardController::class, 'destroy'])->name('logout');

        // Profile
        Route::get('/profile', [InstructorProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [InstructorProfileController::class, 'update'])->name('profile.update');
        Route::get('/setting', [InstructorProfileController::class, 'setting'])->name('setting');
        Route::post('/password/update', [InstructorProfileController::class, 'passwordUpdate'])->name('password.update');

        // Course CRUD
        Route::resource('course', InstructorCourseController::class);
        Route::get('/get-subcategories/{categoryId}', [InstructorCourseController::class, 'getSubcategories']);

        // Section CRUD
        Route::resource('section', InstructorSectionController::class);

        // Lecture CRUD
        Route::resource('lecture', InstructorLectureController::class);

        // Coupon CRUD
        Route::resource('coupon', InstructorCouponController::class);

        // Orders (instructor's sales)
        Route::get('/orders', [InstructorDashboardController::class, 'orders'])->name('orders');
    });
```

---

## 6. Admin Routes (`/admin/*`)

```php
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminDashboardController::class, 'destroy'])->name('logout');

        // Profile
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::get('/setting', [AdminProfileController::class, 'setting'])->name('setting');
        Route::post('/password/update', [AdminProfileController::class, 'passwordUpdate'])->name('password.update');

        // Category & SubCategory
        Route::resource('category', AdminCategoryController::class);
        Route::resource('subcategory', AdminSubcategoryController::class);

        // Course Management
        Route::resource('course', AdminCourseController::class);
        Route::post('/course/status', [AdminCourseController::class, 'updateStatus'])->name('course.status');

        // Instructor Management
        Route::resource('instructor', AdminInstructorController::class);
        Route::post('/instructor/status', [AdminInstructorController::class, 'updateStatus'])->name('instructor.status');
        Route::get('/instructor/active', [AdminInstructorController::class, 'activeList'])->name('instructor.active');

        // Order Management
        Route::resource('order', AdminOrderController::class);

        // Slider
        Route::resource('slider', AdminSliderController::class);

        // Info Box
        Route::resource('info', AdminInfoBoxController::class);

        // Partner
        Route::resource('partner', AdminPartnerController::class);

        // Site Settings
        Route::resource('site-setting', AdminSiteSettingController::class);

        // Settings
        Route::get('/mail-setting', [AdminSettingController::class, 'mailSetting'])->name('mail.setting');
        Route::put('/mail-setting/update', [AdminSettingController::class, 'updateMail'])->name('mail.update');

        Route::get('/midtrans-setting', [AdminSettingController::class, 'midtransSetting'])->name('midtrans.setting');
        Route::post('/midtrans-setting/update', [AdminSettingController::class, 'updateMidtrans'])->name('midtrans.update');

        Route::get('/google-setting', [AdminSettingController::class, 'googleSetting'])->name('google.setting');
        Route::post('/google-setting/update', [AdminSettingController::class, 'updateGoogle'])->name('google.update');

        // Review Management
        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::post('/reviews/{id}/status', [AdminReviewController::class, 'updateStatus'])->name('reviews.status');
    });
```

---

## Middleware Registration

Di `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

Di `app/Http/Middleware/RoleMiddleware.php`:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
```

---

*Semua routes harus mengikuti konvensi ini. Jangan membuat route di luar file `routes/web.php`.*
