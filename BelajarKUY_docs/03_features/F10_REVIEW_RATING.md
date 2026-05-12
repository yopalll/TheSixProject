# ⭐ F10: Review & Rating System

> Sistem review dan rating kursus.

---

## Fitur

1. Student yang sudah beli kursus bisa memberi review (1-5 bintang + komentar)
2. 1 student, 1 review per kursus
3. Review bisa di-approve/reject oleh admin
4. Average rating ditampilkan di course card & detail page
5. Review list ditampilkan di halaman course detail

---

## Business Rules

```php
// Cek apakah student berhak review
$canReview = Order::where('user_id', auth()->id())
    ->where('course_id', $courseId)
    ->where('status', 'completed')
    ->exists();

$alreadyReviewed = Review::where('user_id', auth()->id())
    ->where('course_id', $courseId)
    ->exists();

$showReviewForm = $canReview && !$alreadyReviewed;
```

---

## PIC: Quinsha Ilmi & Vascha U (UI/UX)
