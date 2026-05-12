# 🤖 PROMPT: Generate Database Migrations (AI-Ready)

> Prompt deterministik untuk AI — salin 1:1 ke AI agent untuk generate semua migration files.
> File ini lebih detail dari PROMPT_MIGRATIONS.md — berisi exact column specs.

---

## PROMPT

```
Kamu adalah Laravel 12 migration generator. Generate SEMUA migration files untuk project BelajarKUY.

ATURAN KETAT:
1. Gunakan anonymous class migration (return new class extends Migration)
2. Gunakan $table->id() untuk primary key
3. Gunakan $table->foreignId('xxx')->constrained()->cascadeOnDelete() untuk FK
4. Semua file harus bisa dijalankan dengan `php artisan migrate` TANPA ERROR
5. Urutan file HARUS benar (parent tables dulu, child tables belakangan)
6. Gunakan enum untuk status fields
7. Harga dalam decimal(12,2) — mendukung Rupiah hingga miliaran

GENERATE FILE-FILE BERIKUT:

---

### File 1: xxxx_xx_xx_000001_add_fields_to_users_table.php

Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['user', 'instructor', 'admin'])->default('user')->after('password');
    $table->string('photo', 255)->nullable()->after('role');
    $table->string('phone', 20)->nullable()->after('photo');
    $table->text('address')->nullable()->after('phone');
    $table->text('bio')->nullable()->after('address');
    $table->string('website', 255)->nullable()->after('bio');
});

down(): dropColumn(['role', 'photo', 'phone', 'address', 'bio', 'website'])

---

### File 2: xxxx_xx_xx_000002_create_categories_table.php

$table->id();
$table->string('name');
$table->string('slug')->unique();
$table->string('image')->nullable();
$table->boolean('status')->default(true);
$table->timestamps();

---

### File 3: xxxx_xx_xx_000003_create_sub_categories_table.php

$table->id();
$table->foreignId('category_id')->constrained()->cascadeOnDelete();
$table->string('name');
$table->string('slug')->unique();
$table->timestamps();

---

### File 4: xxxx_xx_xx_000004_create_sliders_table.php

$table->id();
$table->string('title');
$table->text('description')->nullable();
$table->string('image');
$table->string('button_text')->nullable();
$table->string('button_url')->nullable();
$table->boolean('status')->default(true);
$table->unsignedInteger('order')->default(0);
$table->timestamps();

---

### File 5: xxxx_xx_xx_000005_create_info_boxes_table.php

$table->id();
$table->string('title');
$table->text('description')->nullable();
$table->string('icon')->nullable();
$table->unsignedInteger('order')->default(0);
$table->timestamps();

---

### File 6: xxxx_xx_xx_000006_create_partners_table.php

$table->id();
$table->string('name');
$table->string('image');
$table->boolean('status')->default(true);
$table->unsignedInteger('order')->default(0);
$table->timestamps();

---

### File 7: xxxx_xx_xx_000007_create_site_infos_table.php

$table->id();
$table->string('key')->unique();
$table->text('value')->nullable();
$table->timestamps();

---

### File 8: xxxx_xx_xx_000008_create_midtrans_configs_table.php

$table->id();
$table->string('server_key');
$table->string('client_key');
$table->boolean('is_production')->default(false);
$table->string('merchant_id')->nullable();
$table->timestamps();

---

### File 9: xxxx_xx_xx_000009_create_courses_table.php

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
$table->string('duration', 50)->nullable();
$table->boolean('bestseller')->default(false);
$table->boolean('featured')->default(false);
$table->enum('status', ['draft', 'pending_review', 'active', 'inactive'])->default('draft');
$table->timestamps();

---

### File 10: xxxx_xx_xx_000010_create_course_goals_table.php

$table->id();
$table->foreignId('course_id')->constrained()->cascadeOnDelete();
$table->string('goal');
$table->timestamps();

---

### File 11: xxxx_xx_xx_000011_create_course_sections_table.php

$table->id();
$table->foreignId('course_id')->constrained()->cascadeOnDelete();
$table->string('title');
$table->unsignedInteger('order')->default(0);
$table->timestamps();

---

### File 12: xxxx_xx_xx_000012_create_course_lectures_table.php

$table->id();
$table->foreignId('section_id')->constrained('course_sections')->cascadeOnDelete();
$table->string('title');
$table->string('url', 500)->nullable();
$table->text('content')->nullable();
$table->string('duration', 50)->nullable();
$table->unsignedInteger('order')->default(0);
$table->timestamps();

---

### File 13: xxxx_xx_xx_000013_create_wishlists_table.php

$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('course_id')->constrained()->cascadeOnDelete();
$table->timestamps();
$table->unique(['user_id', 'course_id']);

---

### File 14: xxxx_xx_xx_000014_create_carts_table.php

$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('course_id')->constrained()->cascadeOnDelete();
$table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
$table->decimal('price', 12, 2);
$table->timestamps();

---

### File 15: xxxx_xx_xx_000015_create_coupons_table.php

$table->id();
$table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
$table->string('name', 100)->unique();
$table->unsignedInteger('discount');
$table->date('validity');
$table->boolean('status')->default(true);
$table->timestamps();

---

### File 16: xxxx_xx_xx_000016_create_payments_table.php

$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->string('midtrans_order_id', 100)->unique();
$table->string('midtrans_transaction_id', 100)->nullable();
$table->string('payment_type', 50)->nullable();
$table->decimal('amount', 12, 2);
$table->enum('status', ['pending', 'settlement', 'capture', 'deny', 'cancel', 'expire', 'failure', 'refund'])->default('pending');
$table->json('midtrans_response')->nullable();
$table->timestamps();

---

### File 17: xxxx_xx_xx_000017_create_orders_table.php

$table->id();
$table->foreignId('payment_id')->constrained()->cascadeOnDelete();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('course_id')->constrained()->cascadeOnDelete();
$table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
$table->decimal('price', 12, 2);
$table->enum('status', ['pending', 'completed', 'cancelled', 'refunded'])->default('pending');
$table->timestamps();

---

### File 18: xxxx_xx_xx_000018_create_reviews_table.php

$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('course_id')->constrained()->cascadeOnDelete();
$table->unsignedTinyInteger('rating');
$table->text('comment')->nullable();
$table->boolean('status')->default(false);
$table->timestamps();

---

OUTPUT: Generate setiap file sebagai PHP migration file yang lengkap dan runnable.
```
