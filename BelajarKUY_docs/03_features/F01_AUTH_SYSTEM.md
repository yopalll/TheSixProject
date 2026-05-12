# 🔐 F01: Sistem Autentikasi

> Multi-role authentication dengan Laravel Breeze + Google OAuth.

---

## Fitur

1. **Register** — User baru default role `user`
2. **Login** — Email + password
3. **Google OAuth** — Login via Google (Socialite)
4. **Role-based Access** — `user` / `instructor` / `admin`
5. **Role Middleware** — Proteksi route berdasarkan role
6. **Password Reset** — Via email (Breeze default)
7. **Email Verification** — Optional
8. **Profile Management** — Edit nama, foto, phone, address
9. **Password Change** — Di halaman settings
10. **Separate Login Pages** — Admin (`/admin/login`), Instructor (`/instructor/login`), User (default `/login`)

---

## Database

Tabel: `users`

```
id, name, email, password, role (enum: user|instructor|admin),
photo, phone, address, bio, website, email_verified_at,
remember_token, created_at, updated_at
```

---

## Flow Registrasi

```
[Register Page] → [Fill Form] → [Validate] → [Create User (role=user)] → [Login] → [User Dashboard]
```

## Flow Login

```
[Login Page] → [Validate Credentials] → [Check Role] → [Redirect to Dashboard berdasarkan role]
```

## Redirect Logic

```php
// Setelah login, redirect berdasarkan role:
match(auth()->user()->role) {
    'admin' => route('admin.dashboard'),
    'instructor' => route('instructor.dashboard'),
    'user' => route('user.dashboard'),
};
```

## Google OAuth Flow

```
[Klik "Login dengan Google"] → [Redirect ke Google] → [Google Auth] → [Callback]
→ [Cek email di DB] → [Jika ada: Login] / [Jika tidak: Create user + Login]
→ [Redirect ke Dashboard]
```

---

## PIC: Albariqi Tarigan
