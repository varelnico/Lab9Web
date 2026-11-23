<?php
$error = '';
$nama = '';
$kategori = 'Elektronik';
$hargaJual = '';
$hargaBeli = '';
$stok = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $hargaJual = $_POST['harga_jual'] ?? '';
    $hargaBeli = $_POST['harga_beli'] ?? '';
    $stok = $_POST['stok'] ?? '';

    if (!validasiCsrf()) {
        $error = 'Permintaan tidak valid. Muat ulang halaman.';
    } elseif ($nama === '' || !is_numeric($hargaJual) || !is_numeric($hargaBeli) || !filter_var($stok, FILTER_VALIDATE_INT) || (int)$stok < 0) {
        $error = 'Lengkapi data dengan benar. Harga harus angka dan stok bilangan bulat tidak negatif.';
    } else {
        try {
            $gambar = uploadGambar($_FILES['file_gambar'] ?? []);
            $stmt = mysqli_prepare($conn, 'INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok) VALUES (?, ?, ?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'sssddi', $kategori, $nama, $gambar, $hargaBeli, $hargaJual, $stok);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            setFlash('success', 'Data barang berhasil ditambahkan.');
            header('Location: index.php?page=user/list');
            exit;
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<section class="card form-card">
    <h2>Tambah Barang</h2>
    <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Nama Barang</label>
        <input type="text" name="nama" value="<?= e($nama) ?>" required>

        <label>Kategori</label>
        <select name="kategori">
            <?php foreach (['Komputer', 'Elektronik', 'Hand Phone'] as $item): ?>
                <option value="<?= e($item) ?>" <?= $kategori === $item ? 'selected' : '' ?>><?= e($item) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Harga Jual</label>
        <input type="number" name="harga_jual" min="0" value="<?= e($hargaJual) ?>" required>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" min="0" value="<?= e($hargaBeli) ?>" required>

        <label>Stok</label>
        <input type="number" name="stok" min="0" value="<?= e($stok) ?>" required>

        <label>Gambar Barang (JPG/PNG/WEBP, maksimal 2 MB)</label>
        <input type="file" name="file_gambar" accept=".jpg,.jpeg,.png,.webp">

        <div class="form-actions">
            <button type="submit">Simpan</button>
            <a href="index.php?page=user/list">Batal</a>
        </div>
    </form>
</section>
