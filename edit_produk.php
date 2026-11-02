<?php
include 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    die("Produk tidak ditemukan");
}

if (isset($_POST['edit'])) {
    $nama = trim($_POST['nama_produk']);
    $harga = (float) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $deskripsi = trim($_POST['deskripsi']);

    $stmt = mysqli_prepare($conn,
        "UPDATE produk SET nama_produk=?, harga=?, stok=?, deskripsi=? WHERE id=?");

    mysqli_stmt_bind_param(
        $stmt, "sdisi",
        $nama, $harga, $stok, $deskripsi, $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: produk.php");
        exit;
    }

    echo "Gagal mengedit produk.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
</head>
<body>

<h2>Edit Data Produk</h2>

<form method="POST">

    <input type="text" name="nama_produk"
    value="<?= htmlspecialchars($produk['nama_produk']); ?>"
    required>

    <br><br>

    <input type="number" name="harga"
    value="<?= $produk['harga']; ?>"
    min="0" step="0.01" required>

    <br><br>

    <input type="number" name="stok"
    value="<?= $produk['stok']; ?>"
    min="0" required>

    <br><br>

    <textarea name="deskripsi"><?= htmlspecialchars($produk['deskripsi'] ?? ''); ?></textarea>

    <br><br>

    <button type="submit" name="edit">
        Simpan Perubahan
    </button>

</form>

<br>

<a href="produk.php">Kembali</a>

</body>
</html>