# Toko Online — Full Stack Web Development

Project marketplace sederhana berbasis Laravel 11, Inertia.js, dan Vue 3 yang dikembangkan bertahap berdasarkan modul praktikum P1–P7.
link modul : https://drive.google.com/drive/folders/13hBtfSo4lEzuQRpY6MWa5-3NVutL4r9q?usp=sharing

---

# Progress Modul

## P1 — Setup & Arsitektur Project

Pada tahap ini dilakukan:

* Setup Laravel 11
* Setup Inertia.js + Vue 3
* Setup Tailwind CSS
* Struktur folder frontend & backend
* Konfigurasi database MySQL
* Routing dasar aplikasi
* Layout utama aplikasi

---

## P2 — Authentication

Fitur yang dibuat:

* Register
* Login
* Logout
* Middleware auth
* Dashboard user
* Proteksi halaman login

---

## P3 — Middleware & Role

Implementasi:

* Middleware custom role
* Role:

  * Admin
  * Seller
  * Buyer
* Proteksi route berdasarkan role
* Redirect sesuai role user

---

## P4 — CRUD Kategori

Fitur admin:

* Tambah kategori
* Edit kategori
* Hapus kategori
* List kategori
* Validasi form kategori
* Slug kategori
* Icon kategori

---

## P5 — CRUD Produk

Fitur seller:

* Tambah produk
* Edit produk
* Hapus produk
* Status produk
* Relasi kategori produk
* Upload foto produk
* Preview produk

---

## P6 — Katalog Produk

Fitur marketplace:

* Halaman katalog produk
* Search produk
* Filter kategori
* Sort produk
* Pagination
* Detail produk
* Produk terbaru
* Halaman kategori
* Badge produk baru
* View counter produk

---

## P7 — Review Produk

Fitur buyer:

* Review produk
* Rating produk
* Daftar ulasan
* Statistik review

---

## P8 — Checkout & Order Management

Fitur buyer:

* Add to cart
* Keranjang belanja
* Checkout produk
* Pembuatan order otomatis
* Order items
* Riwayat pesanan
* Cancel pesanan
* Filter status pesanan
* Dashboard buyer
* Statistik pembelian
* Pengurangan stok otomatis
* Pengembalian stok saat cancel

---

# Tech Stack

* Laravel 11
* Vue 3
* Inertia.js
* Tailwind CSS
* MySQL
* Vite

---

# Installation

Clone repository:

```bash id="u7k2qx"
git clone https://github.com/USERNAME/toko-online.git
```

Masuk folder project:

```bash id="m4v9rp"
cd toko-online
```

Install dependency:

```bash id="x2n8tm"
composer install
npm install
```

Copy file env:

```bash id="q5r1vk"
cp .env.example .env
```

Generate key:

```bash id="c8m4xp"
php artisan key:generate
```

Migrasi database:

```bash id="p7v2rd"
php artisan migrate --seed
```

Jalankan server:

```bash id="w1q8kn"
php artisan serve
npm run dev
```

---
