<?php
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    echo '<section class="card"><p>ID barang tidak valid.</p></section>';
    return;
}

$stmt = mysqli_prepare($conn, 'SELECT * FROM data_barang WHERE id_barang = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$barang = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$barang) {
    http_response_code(404);
    echo '<section class="card"><p>Data barang tidak ditemukan.</p></section>';
    return;
}

$error = '';
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
            $gambarBaru = uploadGambar($_FILES['file_gambar'] ?? []);
            if ($gambarBaru) {
                $update = mysqli_prepare($conn, 'UPDATE data_barang SET nama=?, kategori=?, harga_jual=?, harga_beli=?, stok=?, gambar=? WHERE id_barang=?');
                mysqli_stmt_bind_param($update, 'ssddisi', $nama, $kategori, $hargaJual, $hargaBeli, $stok, $gambarBaru, $id);
            } else {
                $update = mysqli_prepare($conn, 'UPDATE data_barang SET nama=?, kategori=?, harga_jual=?, harga_beli=?, stok=? WHERE id_barang=?');
                mysqli_stmt_bind_param($update, 'ssddii', $nama, $kategori, $hargaJual, $hargaBeli, $stok, $id);
            }
            mysqli_stmt_execute($update);
            mysqli_stmt_close($update);

            if ($gambarBaru) {
                hapusGambar($barang['gambar']);
            }

            setFlash('success', 'Data barang berhasil diperbarui.');
            header('Location: index.php?page=user/list');
            exit;
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }

    $barang['nama'] = $nama;
    $barang['kategori'] = $kategori;
    $barang['harga_jual'] = $hargaJual;
    $barang['harga_beli'] = $hargaBeli;
    $barang['stok'] = $stok;
}
?>
<section class="card form-card">
    <h2>Edit Barang</h2>
    <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Nama Barang</label>
        <input type="text" name="nama" value="<?= e($barang['nama']) ?>" required>

        <label>Kategori</label>
        <select name="kategori">
            <?php foreach (['Komputer', 'Elektronik', 'Hand Phone'] as $item): ?>
                <option value="<?= e($item) ?>" <?= $barang['kategori'] === $item ? 'selected' : '' ?>><?= e($item) ?></option>
            <?php endforeach; ?>
        </select>

        <label>Harga Jual</label>
        <input type="number" name="harga_jual" min="0" value="<?= e($barang['harga_jual']) ?>" required>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" min="0" value="<?= e($barang['harga_beli']) ?>" required>

        <label>Stok</label>
        <input type="number" name="stok" min="0" value="<?= e($barang['stok']) ?>" required>

        <label>Ganti Gambar (opsional)</label>
        <input type="file" name="file_gambar" accept=".jpg,.jpeg,.png,.webp">

        <div class="form-actions">
            <button type="submit">Perbarui</button>
            <a href="index.php?page=user/list">Batal</a>
        </div>
    </form>
</section>
