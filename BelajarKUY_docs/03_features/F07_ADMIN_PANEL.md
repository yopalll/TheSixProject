# 🛡️ F07: Admin Panel

> Dashboard dan management panel untuk administrator.

---

## Halaman Admin

| # | Halaman | Route | Deskripsi |
|---|---------|-------|-----------|
| 1 | Dashboard | `/admin/dashboard` | Stats overview: total users, courses, orders, revenue |
| 2 | Category Mgmt | `/admin/category` | CRUD categories + images |
| 3 | SubCategory Mgmt | `/admin/subcategory` | CRUD sub-categories |
| 4 | Course Mgmt | `/admin/course` | List semua kursus, approve/reject, status toggle |
| 5 | Instructor Mgmt | `/admin/instructor` | List instructor, approve/block, status toggle |
| 6 | Order Mgmt | `/admin/order` | List orders, filter by status, detail view |
| 7 | User Mgmt | `/admin/user` | List users (non-instructor), block/unblock |
| 8 | Slider Mgmt | `/admin/slider` | CRUD hero slider |
| 9 | Info Box Mgmt | `/admin/info` | CRUD value proposition boxes |
| 10 | Partner Mgmt | `/admin/partner` | CRUD partner logos |
| 11 | Site Settings | `/admin/site-setting` | Logo, contact info, social media |
| 12 | Mail Settings | `/admin/mail-setting` | SMTP configuration |
| 13 | Midtrans Settings | `/admin/midtrans-setting` | Payment gateway config |
| 14 | Google Settings | `/admin/google-setting` | OAuth credentials |
| 15 | Profile | `/admin/profile` | Edit admin profile |
| 16 | Review Mgmt | `/admin/reviews` | Approve/reject reviews |

---

## Dashboard Stats

```php
$stats = [
    'total_users' => User::where('role', 'user')->count(),
    'total_instructors' => User::where('role', 'instructor')->count(),
    'total_courses' => Course::count(),
    'active_courses' => Course::active()->count(),
    'total_orders' => Order::where('status', 'completed')->count(),
    'total_revenue' => Payment::where('status', 'settlement')->sum('amount'),
    'this_month_revenue' => Payment::where('status', 'settlement')
        ->whereMonth('created_at', now()->month)->sum('amount'),
];
```

---

## PIC: Quinsha Ilmi & Vascha U (UI/UX)
