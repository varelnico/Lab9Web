<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!validasiCsrf()) {
        $error = 'Permintaan tidak valid. Muat ulang halaman.';
    } elseif ($username === 'admin' && $password === 'admin123') {
        // Akun demo untuk menunjukkan alur login pada struktur folder.
        session_regenerate_id(true);
        $_SESSION['login'] = 'admin';
        setFlash('success', 'Login berhasil.');
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah.';
    }
}
?>
<section class="card form-card">
    <h2>Login Demo</h2>
    <p>Username: <strong>admin</strong> | Password: <strong>admin123</strong></p>
    <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
    </form>
</section>
