# 🛒 F05: Cart & Wishlist

> Sistem keranjang belanja dan wishlist.

---

## Wishlist

1. **Add to Wishlist** — Toggle wishlist via AJAX (logged in users only)
2. **View Wishlist** — List kursus di wishlist user
3. **Remove from Wishlist** — Hapus item dari wishlist
4. **Wishlist Count** — Badge counter di navbar
5. **Prevent Duplicate** — 1 user, 1 course, 1 entry

## Cart

1. **Add to Cart** — Tambah kursus ke keranjang (AJAX)
2. **View Cart** — Halaman cart (`/cart`)
3. **Remove from Cart** — Hapus item dari cart
4. **Cart Count** — Badge counter di navbar (realtime)
5. **Prevent Duplicate** — Cek jika kursus sudah di cart
6. **Prevent Re-purchase** — Cek jika kursus sudah dibeli (enrolled)
7. **Auto Price** — Harga otomatis dari `courses.price` dengan discount

---

## AJAX Endpoints

```
POST   /wishlist/add      → { course_id }
GET    /wishlist/all       → JSON list wishlists
DELETE /user/wishlist/{id} → Remove wishlist

POST   /cart/add           → { course_id, instructor_id, price }
GET    /cart/all            → JSON list cart items
GET    /cart/fetch          → JSON cart items for navbar badge
POST   /cart/remove         → { id }
```

---

## PIC: Ray Nathan
