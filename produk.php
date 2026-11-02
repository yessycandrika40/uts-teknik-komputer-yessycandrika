<?php
include 'koneksi.php';

// TAMBAH PRODUK
if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama_produk']);
    $harga = (float) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $deskripsi = trim($_POST['deskripsi']);

    $stmt = mysqli_prepare($conn, 
        "INSERT INTO produk (nama_produk, harga, stok, deskripsi) VALUES (?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, "sdis", $nama, $harga, $stok, $deskripsi);
    mysqli_stmt_execute($stmt);

    header("Location: produk.php");
    exit;
}

// HAPUS PRODUK
if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];

    mysqli_query($conn, "DELETE FROM produk WHERE id = $id");

    header("Location: produk.php");
    exit;
}

// TAMPIL PRODUK
$data = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Produk</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Data Produk</h2>

<form method="POST">
    <input type="text" name="nama_produk"
        placeholder="Nama Produk" required>

    <br><br>

    <input type="number" name="harga"
        placeholder="Harga" min="0" step="0.01" required>

    <br><br>

    <input type="number" name="stok"
        placeholder="Stok" min="0" required>

    <br><br>

    <textarea name="deskripsi"
        placeholder="Deskripsi Produk"></textarea>

    <br><br>

    <button type="submit" name="tambah">
        Tambah Produk
    </button>
</form>

<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($data)) : ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= htmlspecialchars($row['nama_produk']); ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td><?= $row['stok']; ?></td>
        <td><?= htmlspecialchars($row['deskripsi'] ?? ''); ?></td>
        <td>
            <a href="edit_produk.php?id=<?= $row['id']; ?>">Edit</a> |
            <a href="produk.php?hapus=<?= $row['id']; ?>"
               onclick="return confirm('Hapus produk ini?')">
               Hapus
            </a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
<script src="js/script.js"></script>
</html>