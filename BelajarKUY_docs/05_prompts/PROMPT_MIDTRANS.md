# 🤖 PROMPT: Integrate Midtrans Payment

> Copy-paste prompt ini ke AI agent untuk integrasi Midtrans.
> **PIC: Ray Nathan**

---

## PROMPT

```
Kamu adalah senior Laravel 12 developer. Integrasikan Midtrans Snap API untuk payment di project BelajarKUY (Udemy clone Indonesia).

## PREREQUISITE: Baca file-file berikut terlebih dahulu:
- BelajarKUY_docs/01_guides/AGENT_GUIDELINES.md
- BelajarKUY_docs/03_features/F06_PAYMENT_MIDTRANS.md (WAJIB BACA LENGKAP)
- BelajarKUY_docs/02_architecture/DATABASE_SCHEMA.md (tabel payments, orders, carts)

## CONTEXT:
- Package midtrans/midtrans-php SUDAH terinstall
- config/midtrans.php SUDAH ada
- .env SUDAH punya MIDTRANS_SERVER_KEY, MIDTRANS_CLIENT_KEY, dll
- Model Payment, Order, Cart SUDAH ada
- Cart system SUDAH berfungsi (user bisa add/remove items)

## TASKS:

### 1. MidtransService (app/Services/MidtransService.php)
- Constructor: set Config dari config/midtrans.php
- Method createSnapToken($cartItems, $user, $couponCode = null): string
  - Generate order_id format: BKUY-{timestamp}-{user_id}
  - Calculate gross_amount dari cart items (apply coupon jika ada)
  - Build item_details dari cart items
  - Build customer_details dari user
  - Return Snap::getSnapToken($params)
- Method handleNotification(): Notification
  - Return new Midtrans\Notification()

### 2. CheckoutController (app/Http/Controllers/Frontend/CheckoutController.php)
- index(): Tampilkan halaman checkout dengan cart items
- process(Request): Generate Snap token, return view with token + clientKey
  - Validasi cart tidak kosong
  - Buat Payment record (status=pending)
  - Generate Snap token

### 3. PaymentController atau method di CheckoutController
- callback(Request): Handle Midtrans notification webhook
  - Verifikasi notification
  - Update Payment status berdasarkan transaction_status
  - Jika settlement/capture → handleSuccess()
    - Create Order records dari cart items
    - Clear cart
  - Return response JSON 200
- success(): Tampilkan halaman sukses
- failed(): Tampilkan halaman gagal

### 4. Frontend Snap Integration
- Di checkout.blade.php:
  - Load Midtrans Snap JS (sandbox/production URL)
  - Button "Bayar Sekarang" trigger snap.pay()
  - Handle onSuccess, onPending, onError, onClose callbacks
  - Redirect ke success/failed page

### 5. Routes
```php
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/payment/success', [CheckoutController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [CheckoutController::class, 'failed'])->name('payment.failed');
});

// Webhook (no auth — Midtrans calls this)
Route::post('/payment/callback', [CheckoutController::class, 'callback'])->name('payment.callback');
```

### 6. CSRF Exclusion untuk Callback
Di bootstrap/app.php atau middleware config, exclude `/payment/callback` dari CSRF verification.

## CONSTRAINT:
- JANGAN gunakan Stripe — hanya Midtrans Snap
- Order ID format: BKUY-{timestamp}-{user_id}
- Amount dalam Rupiah (integer, bukan float) — Midtrans butuh integer
- **SELALU hardcode** `Config::$isProduction = false` — project ini SANDBOX ONLY
- Snap URL SELALU sandbox: `https://app.sandbox.midtrans.com/snap/snap.js`
- JANGAN buat conditional production/sandbox — tidak perlu untuk project ini
- SELALU handle `fraud_status` di callback (penting untuk credit card)
- JANGAN hapus cart sebelum payment confirmed (settlement/capture+accept)
- WAJIB buat Payment record saat `process()` (sebelum Snap token), bukan di callback
- CSRF exclusion untuk `/payment/callback` adalah WAJIB

## OUTPUT:
- MidtransService.php
- CheckoutController.php (atau pisah PaymentController)
- checkout.blade.php
- payment-success.blade.php
- payment-failed.blade.php
- Route additions
- CSRF exclusion config
```
