# P9 — Pembayaran dan Status Order

## Deskripsi

Pada modul P9, sistem checkout dikembangkan dengan fitur pembayaran dan manajemen status pesanan. Buyer dapat mengunggah bukti pembayaran setelah checkout, kemudian seller melakukan verifikasi pembayaran dan mengirim pesanan. Buyer juga dapat mengonfirmasi bahwa barang telah diterima.

---

## Fitur Utama

### 1. Upload Bukti Pembayaran (Buyer)

Setelah checkout berhasil, buyer dapat:

* Melihat daftar pesanan
* Membuka halaman pembayaran
* Mengunggah bukti transfer
* Mengirim bukti pembayaran ke seller

Status pesanan berubah:

```text
pending → paid
```

---

### 2. Verifikasi Pembayaran (Seller)

Seller dapat melihat daftar order masuk dan melakukan:

* Verifikasi pembayaran
* Penolakan pembayaran

Jika pembayaran diverifikasi:

```text
paid → processing
```

Jika pembayaran ditolak:

```text
paid → cancelled
```

---

### 3. Pengiriman Pesanan (Seller)

Setelah pembayaran diverifikasi, seller dapat mengirim pesanan.

Status berubah:

```text
processing → shipped
```

---

### 4. Konfirmasi Barang Diterima (Buyer)

Buyer dapat mengonfirmasi bahwa pesanan telah diterima.

Status berubah:

```text
shipped → delivered
```

Field `delivered_at` akan otomatis terisi waktu penerimaan barang.

---

## Alur Status Pesanan

```text
pending
   ↓
paid
   ↓
processing
   ↓
shipped
   ↓
delivered
```

Atau:

```text
pending
   ↓
cancelled
```

```text
paid
   ↓
cancelled
```

---

## Dashboard Buyer

Dashboard buyer menampilkan:

* Total Pesanan
* Pesanan Pending
* Total Belanja

Serta shortcut menuju:

* Produk
* Keranjang
* Pesanan Saya

---

## Dashboard Seller

Dashboard seller menampilkan shortcut:

* Kelola Produk
* Order Masuk

Seller dapat:

* Verifikasi pembayaran
* Menolak pembayaran
* Mengirim pesanan

---

# Latihan Mandiri

## Latihan 1 — Konfirmasi Barang Diterima

Menambahkan fitur konfirmasi pesanan diterima oleh buyer.

### Implementasi

* Route:

```php
POST /orders/{order}/deliver
```

* Controller:

```php
OrderController@deliver
```

### Perubahan Status

```text
shipped → delivered
```

### Data Tambahan

```php
delivered_at = now()
```

---

## Latihan 2 — Flash Notification

Menambahkan notifikasi untuk setiap perubahan status order.

### Buyer

* Checkout berhasil
* Bukti pembayaran berhasil dikirim
* Pesanan dibatalkan
* Pesanan diterima

### Seller

* Pembayaran diverifikasi
* Pembayaran ditolak
* Pesanan berhasil dikirim

---

## Latihan 3 — Riwayat Status Order

Menambahkan sistem pencatatan perubahan status pesanan.

### Tabel Baru

```text
order_status_logs
```

Kolom:

```text
id
order_id
status
note
created_at
updated_at
```

### Relasi

Order:

```php
hasMany(OrderStatusLog::class)
```

OrderStatusLog:

```php
belongsTo(Order::class)
```

### Pencatatan Otomatis

Setiap perubahan status akan membuat log baru.

Contoh:

```text
pending      → Pesanan dibuat
paid         → Bukti pembayaran diterima
processing   → Pembayaran diverifikasi
shipped      → Pesanan dikirim
delivered    → Pesanan diterima pembeli
cancelled    → Pesanan dibatalkan
```

### Timeline Riwayat

Buyer dapat melihat timeline perubahan status pada halaman detail pesanan.

Contoh:

```text
Delivered
Pesanan diterima pembeli
09 Juni 2026 15:20

Shipped
Pesanan dikirim seller
09 Juni 2026 14:45

Processing
Pembayaran diverifikasi seller
09 Juni 2026 14:10

Paid
Bukti pembayaran berhasil dikirim
09 Juni 2026 13:55
```

---

## Teknologi

* Laravel 12
* Inertia.js
* Vue 3
* Tailwind CSS
* MySQL

---

## Hasil Modul

Fitur pembayaran dan manajemen status order berhasil diimplementasikan mulai dari upload bukti pembayaran hingga pesanan diterima oleh buyer, lengkap dengan riwayat perubahan status pesanan.
