# TEFA AutoHub Inventory System

Sistem inventori berbasis web menggunakan PHP OOP, MySQL, HTML, CSS, dan Bootstrap dengan dua role pengguna: `admin` dan `manager`.

## Folder Structure

```text
Sistem Manajemen Inventaris AutoHub/
├── app/
│   ├── controllers/
│   ├── core/
│   ├── models/
│   └── views/
├── config/
├── database/
│   └── schema.sql
├── public/
│   └── assets/css/style.css
├── index.php
└── README.md
```

## Fitur

- Login dengan session dan password hashing
- Role-based access `admin` dan `manager`
- CRUD barang dan supplier
- Transaksi barang masuk dan barang keluar
- Update stok otomatis
- Validasi stok tidak boleh minus
- Dashboard ringkasan inventori
- Warning stok minimum
- Laporan barang, barang masuk, dan barang keluar
- Halaman print untuk laporan

## Cara Menjalankan

1. Buat database MySQL baru dengan nama `tefa_autohub_inventory`.
2. Import file [schema.sql]
3. Sesuaikan kredensial database di [config.php](C:\Users\RAIHAN ABRAR HARTAMA\OneDrive\Documents\New project\config\config.php) jika perlu.
4. Pindahkan proyek ini ke folder web server seperti `htdocs` pada XAMPP atau `www` pada Laragon.
5. Jalankan Apache dan MySQL.
6. Buka URL proyek, misalnya `http://localhost/nama-folder-proyek/`.

## Akun Default

Akun default akan dibuat otomatis saat aplikasi pertama kali dijalankan jika tabel `users` masih kosong:

- Admin: `admin` / `admin123`
- Manager: `manager` / `manager123`

## Catatan

- Nilai peringatan stok minimum diatur di konstanta `STOCK_MINIMUM_ALERT` pada [config.php]
- Manager hanya bisa melihat data dashboard, master data, transaksi, dan laporan tanpa akses CRUD.
- Laporan menggunakan print page browser agar mudah dipakai di lingkungan lokal.