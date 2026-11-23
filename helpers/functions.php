<?php
function formatRupiah($angka): string
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

function hitungDiskon($harga, $persen): float
{
    return (float) $harga - ((float) $harga * (float) $persen / 100);
}

function validasiEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function ringkasTeks(string $teks, int $maksimal = 50): string
{
    $teks = trim($teks);
    if (strlen($teks) <= $maksimal) {
        return $teks;
    }
    return substr($teks, 0, $maksimal) . '...';
}

function e($nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validasiCsrf(): bool
{
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

function setFlash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function tampilFlash(): void
{
    if (!empty($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        echo '<div class="' . e($flash['tipe']) . '">' . e($flash['pesan']) . '</div>';
        unset($_SESSION['flash']);
    }
}

function uploadGambar(array $file): ?string
{
    if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload gambar gagal.');
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        throw new RuntimeException('Ukuran gambar maksimal 2 MB.');
    }

    $info = getimagesize($file['tmp_name']);
    if ($info === false) {
        throw new RuntimeException('File harus berupa gambar.');
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = $info['mime'] ?? '';

    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Format gambar harus JPG, PNG, atau WEBP.');
    }

    $namaFile = bin2hex(random_bytes(12)) . '.' . $allowed[$mime];
    $tujuan = __DIR__ . '/../assets/images/' . $namaFile;

    if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
        throw new RuntimeException('Gambar tidak dapat disimpan.');
    }

    return $namaFile;
}

function hapusGambar(?string $namaFile): void
{
    if (!$namaFile) {
        return;
    }

    $path = __DIR__ . '/../assets/images/' . basename($namaFile);
    if (is_file($path)) {
        unlink($path);
    }
}
