<?php
$sql = "SELECT * FROM data_barang ORDER BY id_barang DESC";
$result = mysqli_query($conn, $sql);
?>
<section class="card">
    <div class="heading-row">
        <h2>Data Barang</h2>
        <a class="button" href="index.php?page=user/add">+ Tambah Barang</a>
    </div>

    <p>Daftar barang yang tersimpan di database latihan1.</p>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <?php if (!empty($row['gambar'])): ?>
                            <img class="product-image" src="assets/images/<?= e($row['gambar']) ?>" alt="<?= e($row['nama']) ?>">
                        <?php else: ?>
                            <span>-</span>
                        <?php endif; ?>
                    </td>
                    <td><?= e($row['nama']) ?></td>
                    <td><?= e($row['kategori']) ?></td>
                    <td><?= formatRupiah($row['harga_jual']) ?></td>
                    <td><?= formatRupiah($row['harga_beli']) ?></td>
                    <td><?= (int) $row['stok'] ?></td>
                    <td class="actions">
                        <a href="index.php?page=user/edit&id=<?= (int) $row['id_barang'] ?>">Edit</a>
                        <form method="post" action="index.php?page=user/delete" onsubmit="return konfirmasiHapus();">
                            <input type="hidden" name="id" value="<?= (int) $row['id_barang'] ?>">
                            <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
                            <button class="link-button" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">Belum ada data barang.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
