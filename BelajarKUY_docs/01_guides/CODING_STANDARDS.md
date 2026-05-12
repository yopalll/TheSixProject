# 📏 BelajarKUY — Coding Standards (Laravel 12)

> Standar penulisan kode untuk seluruh tim BelajarKUY. Wajib diikuti oleh semua anggota dan AI agent.

---

## 1. PHP / Laravel Conventions

### 1.1 Naming Conventions

| Elemen | Konvensi | Contoh |
|--------|----------|--------|
| Controller | PascalCase, singular + `Controller` | `CourseController` |
| Model | PascalCase, singular | `Course`, `SubCategory` |
| Migration | snake_case | `create_courses_table` |
| Seeder | PascalCase + `Seeder` | `CategorySeeder` |
| Form Request | PascalCase + `Request` | `StoreCourseRequest` |
| Middleware | PascalCase | `RoleMiddleware` |
| Route name | dot notation | `admin.course.index` |
| View file | kebab-case | `course-detail.blade.php` |
| Config key | snake_case | `midtrans.server_key` |
| DB table | snake_case, plural | `courses`, `course_sections` |
| DB column | snake_case | `course_id`, `created_at` |

### 1.2 Controller Structure

```php
<?php

namespace App\Http\Controllers\Backend\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a listing of the instructor's courses.
     */
    public function index(): View
    {
        $courses = Course::where('instructor_id', auth()->id())
            ->with(['category', 'sections'])
            ->latest()
            ->paginate(10);

        return view('backend.instructor.course.index', compact('courses'));
    }

    /**
     * Store a newly created course.
     */
    public function store(StoreCourseRequest $request): RedirectResponse
    {
        // Logic here
        return redirect()
            ->route('instructor.course.index')
            ->with('success', 'Kursus berhasil dibuat!');
    }
}
```

### 1.3 Model Standards

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'instructor_id',
        'title',
        'slug',
        'description',
        'price',
        'discount',
        'thumbnail',
        'video_url',
        'duration',
        'bestseller',
        'featured',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'integer',
        'bestseller' => 'boolean',
        'featured' => 'boolean',
    ];

    // ============ RELATIONSHIPS ============

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(CourseSection::class)->orderBy('order');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('bestseller', true);
    }

    // ============ ACCESSORS ============

    public function getDiscountedPriceAttribute(): float
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * $this->discount / 100);
        }
        return $this->price;
    }

    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
```

### 1.4 Migration Standards

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories')->nullOnDelete();
            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedTinyInteger('discount')->default(0);
            $table->string('thumbnail')->nullable();
            $table->string('video_url')->nullable();
            $table->string('duration')->nullable();
            $table->boolean('bestseller')->default(false);
            $table->boolean('featured')->default(false);
            $table->enum('status', ['draft', 'pending_review', 'active', 'inactive'])
                  ->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
```

---

## 2. Blade / Frontend Standards

### 2.1 Layout Template

```blade
{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BelajarKUY — Belajar Online Kapan Saja')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />

    @stack('scripts')
</body>
</html>
```

### 2.2 Component Usage

```blade
{{-- Gunakan anonymous Blade components --}}
<x-course-card :course="$course" />
<x-category-card :category="$category" />
<x-alert type="success" :message="session('success')" />
```

### 2.3 Flash Messages

```blade
{{-- Selalu handle flash messages --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
```

---

## 3. Route Standards

```php
// Format: Method → URI → Controller@method → Name

// Frontend (public)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/course/{slug}', [CourseDetailController::class, 'show'])->name('course.detail');

// Auth protected
Route::middleware('auth')->group(function () {
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
});

// Role protected
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('category', AdminCategoryController::class);
});

Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::resource('course', InstructorCourseController::class);
});
```

---

## 4. Error Handling

```php
// Di controller — selalu gunakan try-catch untuk operasi kritikal
public function store(StoreCourseRequest $request): RedirectResponse
{
    try {
        $course = Course::create($request->validated());

        return redirect()
            ->route('instructor.course.index')
            ->with('success', 'Kursus berhasil dibuat!');

    } catch (\Exception $e) {
        Log::error('Course creation failed: ' . $e->getMessage());

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Gagal membuat kursus. Silakan coba lagi.');
    }
}
```

---

## 5. Testing Standards (Minimal)

```php
// tests/Feature/CourseTest.php
test('instructor can create course', function () {
    $instructor = User::factory()->create(['role' => 'instructor']);
    $category = Category::factory()->create();

    $this->actingAs($instructor)
        ->post(route('instructor.course.store'), [
            'title' => 'Laravel untuk Pemula',
            'category_id' => $category->id,
            'price' => 150000,
        ])
        ->assertRedirect(route('instructor.course.index'));

    $this->assertDatabaseHas('courses', ['title' => 'Laravel untuk Pemula']);
});
```

---

*Ikuti standar ini tanpa exception. Konsistensi kode = kecepatan development.*
