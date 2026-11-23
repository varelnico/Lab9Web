<?php
$currentPage = $_GET['page'] ?? 'dashboard';
$isBarangPage = strpos($currentPage, 'user/') === 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab9Web - PHP Modular</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <header class="site-header">
        <div>
            <h1>Lab9Web</h1>
            <p>Aplikasi Data Barang - PHP Modular</p>
        </div>
        <div class="auth-link">
            <?php if (!empty($_SESSION['login'])): ?>
                <span>Halo, <?= e($_SESSION['login']) ?></span>
                <a href="index.php?page=auth/logout">Logout</a>
            <?php else: ?>
                <a href="index.php?page=auth/login">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <nav>
        <a class="<?= $currentPage === 'dashboard' ? 'active' : '' ?>" href="index.php">Dashboard</a>
        <a class="<?= $currentPage === 'home' ? 'active' : '' ?>" href="index.php?page=home">Home</a>
        <a class="<?= $currentPage === 'profile' ? 'active' : '' ?>" href="index.php?page=profile">Profil</a>
        <a class="<?= $currentPage === 'contact' ? 'active' : '' ?>" href="index.php?page=contact">Kontak</a>
        <a class="<?= $isBarangPage ? 'active' : '' ?>" href="index.php?page=user/list">Data Barang</a>
    </nav>

    <main>
        <?php tampilFlash(); ?>
