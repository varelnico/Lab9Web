<?php
// Koneksi database dipusatkan di satu file dan menggunakan MySQLi
// agar sesuai dengan aplikasi CRUD pada Praktikum 8.
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'latihan1';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    error_log('Koneksi database gagal: ' . mysqli_connect_error());
    http_response_code(500);
    exit('Koneksi ke database gagal. Periksa pengaturan config/database.php.');
}

mysqli_set_charset($conn, 'utf8mb4');
