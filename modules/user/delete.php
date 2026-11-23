<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validasiCsrf()) {
    http_response_code(400);
    exit('Permintaan hapus tidak valid.');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    exit('ID barang tidak valid.');
}

$stmt = mysqli_prepare($conn, 'SELECT gambar FROM data_barang WHERE id_barang = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$delete = mysqli_prepare($conn, 'DELETE FROM data_barang WHERE id_barang = ?');
mysqli_stmt_bind_param($delete, 'i', $id);
mysqli_stmt_execute($delete);
mysqli_stmt_close($delete);

if ($data) {
    hapusGambar($data['gambar']);
}

setFlash('success', 'Data barang berhasil dihapus.');
header('Location: index.php?page=user/list');
exit;
