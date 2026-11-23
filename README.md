# Lab9Web - PHP Modular

Project ini mengerjakan bagian J. Latihan Terstruktur Praktikum 9 dan melakukan refactoring CRUD Data Barang dari Praktikum 8.

## Teknologi
- PHP 8+
- MySQL / MariaDB
- MySQLi (dipertahankan dari Praktikum 8)
- HTML, CSS, JavaScript
- XAMPP atau Laragon

## Cara menjalankan
1. Ekstrak folder `Lab9Web` ke dalam `htdocs`.
2. Jalankan Apache dan MySQL melalui XAMPP.
3. Buka `http://localhost/phpmyadmin`.
4. Import file `database.sql`.
5. Periksa pengaturan database pada `config/database.php` (default XAMPP: root tanpa password).
6. Buka `http://localhost/Lab9Web/`.

## Struktur direktori
```text
Lab9Web/
|-- index.php
|-- config/
|   `-- database.php
|-- views/
|   |-- header.php
|   |-- footer.php
|   |-- dashboard.php
|   |-- home.php
|   |-- profile.php
|   |-- contact.php
|   `-- 404.php
|-- helpers/
|   `-- functions.php
|-- modules/
|   |-- user/
|   |   |-- list.php
|   |   |-- add.php
|   |   |-- edit.php
|   |   `-- delete.php
|   `-- auth/
|       |-- login.php
|       `-- logout.php
|-- assets/
|   |-- css/
|   |   `-- style.css
|   |-- js/
|   |   `-- script.js
|   `-- images/
|-- database.sql
`-- README.md
```

Catatan: Nama folder `modules/user` mengikuti contoh struktur direktori pada PDF Praktikum 9. File CRUD di dalamnya menjalankan pengelolaan `data_barang` dari Praktikum 8.

## Daftar rute
- `index.php` atau `index.php?page=dashboard`
- `index.php?page=home`
- `index.php?page=profile`
- `index.php?page=contact`
- `index.php?page=user/list`
- `index.php?page=user/add`
- `index.php?page=user/edit&id=1`
- `index.php?page=user/delete` (diproses melalui POST)
- `index.php?page=auth/login`
- `index.php?page=auth/logout`

Router menggunakan whitelist. Parameter URL tidak langsung dijadikan path file. Rute yang tidak terdaftar menampilkan halaman 404 dengan HTTP status 404.

## Keterangan pengerjaan Latihan J
1. **Template multi-halaman:** halaman Home, Profil, dan Kontak memakai `views/header.php` serta `views/footer.php`.
2. **Library function:** `helpers/functions.php` menyediakan `formatRupiah()`, `hitungDiskon()`, `validasiEmail()`, dan `ringkasTeks()`. `formatRupiah()` digunakan pada daftar barang.
3. **Router aman:** `index.php` memakai whitelist rute dan halaman 404.
4. **Refactoring CRUD:** CRUD Data Barang Praktikum 8 dipindahkan ke `modules/user/`. Koneksi MySQLi hanya berada di `config/database.php`. Link antarhalaman memakai parameter routing.

## Keamanan dan catatan
- Query tambah, edit, hapus, dan pencarian ID menggunakan prepared statement MySQLi.
- Operasi hapus menggunakan POST dan token CSRF.
- Output teks di-escape menggunakan `htmlspecialchars`.
- Upload gambar dibatasi JPG, PNG, WEBP dengan ukuran maksimal 2 MB.
- Halaman login hanya demonstrasi struktur autentikasi: username `admin`, password `admin123`. Ini bukan autentikasi produksi.
- Function `validasiEmail()` dan `hitungDiskon()` disediakan sebagai library helper untuk digunakan pada halaman lain.

## Pengujian
1. Buka dashboard, Home, Profil, dan Kontak.
2. Uji URL tidak dikenal, misalnya `index.php?page=abc`; halaman 404 harus muncul.
3. Buka Data Barang dan pastikan data contoh tampil.
4. Tambahkan barang baru.
5. Edit barang yang sudah ada.
6. Hapus barang dan pastikan data hilang dari daftar.
7. Pastikan semua halaman memiliki header, navigasi, dan footer yang sama.
