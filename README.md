# Lab9Web - PHP Modular

### Nama      : Varel Nico Ramadhan
### NIM       : 312510156
### Kelas     : I251B
### Pertemuan : 11

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

# Pengujian
## 1. Buka dashboard, Home, Profil, dan Kontak.
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/827a1be9-74e8-47e0-96d5-2bf39db39d0f" />
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/7d4d2fd8-154b-4605-9b2b-6bb9b553c01e" />
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/c04de819-d3ae-45f0-8e93-9bba0852572d" />
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/b3119ab8-7eba-44a3-b27f-f1f6f9e82d0c" />

## 2. Uji URL tidak dikenal, misalnya `index.php?page=abc`; halaman 404 harus muncul.
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/d5752aaa-b4cb-4b25-8161-69c2bd1bcff8" />

## 3. Buka Data Barang dan pastikan data contoh tampil.
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/b6e7e1bd-94c6-4f96-bcf8-8ba3654fc999" />

## 4. Tambahkan barang baru.
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/122c75c4-e474-4e9e-b0e1-f69cf89feccb" />
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/81ab5df5-ecd6-4db5-b6df-cbaa105eb58e" />

## 5. Edit barang yang sudah ada.
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/1f8b400b-2ec0-409b-8e42-0b1973b14bbc" />
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/15a29f39-191c-45eb-a422-e4b5f9a14c7b" />

## 6. Hapus barang dan pastikan data hilang dari daftar.
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/10f3fff3-546a-4dd9-8c6f-32cb65c8aa19" />
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/a93f4b04-10af-4521-8647-3afb3e18e6b2" />
  
## 7. Pastikan semua halaman memiliki header, navigasi, dan footer yang sama.
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/ebbdc0b7-47ab-4cb0-854f-3c0afa5fc09f" />
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/333a6133-2fb3-4977-bfb6-e10349cc0752" />
  <img width="1920" height="1080" alt="image" src="https://github.com/user-attachments/assets/dd3d3d52-43cb-4178-bfa5-34314c25659d" />
