# 🏷️ F11: Coupon System

> Sistem kupon diskon oleh instructor.

---

## Fitur

1. Instructor bisa membuat kupon diskon untuk kursusnya
2. Kupon punya nama (kode), persentase diskon, tanggal expired
3. Status aktif/nonaktif
4. Student apply kupon di halaman checkout
5. Validasi: kode valid, belum expired, status aktif

---

## Apply Coupon Logic

```php
public function applyCoupon(Request $request)
{
    $coupon = Coupon::where('name', $request->coupon_code)
        ->where('status', true)
        ->where('validity', '>=', now()->format('Y-m-d'))
        ->first();

    if (!$coupon) {
        return response()->json(['error' => 'Kupon tidak valid atau sudah expired'], 400);
    }

    $discountAmount = ($totalPrice * $coupon->discount) / 100;
    $finalPrice = $totalPrice - $discountAmount;

    return response()->json([
        'success' => true,
        'discount' => $coupon->discount,
        'discount_amount' => $discountAmount,
        'final_price' => $finalPrice,
    ]);
}
```

---

## PIC: Ray Nathan
