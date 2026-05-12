# 🎓 F09: Student Panel

> Dashboard untuk student (user biasa).

---

## Halaman Student

| # | Halaman | Route | Deskripsi |
|---|---------|-------|-----------|
| 1 | Dashboard | `/user/dashboard` | Overview: enrolled courses, recent activity |
| 2 | My Courses | `/user/my-courses` | List kursus yang sudah dibeli |
| 3 | Wishlist | `/user/wishlist` | Kursus yang di-wishlist |
| 4 | Profile | `/user/profile` | Edit nama, foto, phone, address |
| 5 | Settings | `/user/setting` | Change password |

---

## Enrolled Courses Logic

```php
// Ambil kursus yang sudah dibeli oleh student
$enrolledCourses = Course::whereHas('orders', function ($query) {
    $query->where('user_id', auth()->id())
          ->where('status', 'completed');
})->with(['instructor', 'sections.lectures'])->get();
```

---

## PIC: Vascha U & Quinsha Ilmi (Frontend)
