<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
);

$produk = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk")
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard CRUD</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Dashboard CRUD</h2>
<p style="text-align:center;">
    Selamat datang, <?= htmlspecialchars($_SESSION['admin']); ?>!
</p>

<p style="text-align:center;">
    <a href="logout.php">Logout</a>
</p>

<h3 style="text-align:center;">
    Selamat Datang di Sistem CRUD User dan Produk
</h3>

<div style="display:flex; justify-content:center; gap:20px;
flex-wrap:wrap; margin:30px;">

    <div style="background:white; padding:30px;
    border-radius:12px; text-align:center; min-width:200px;">

        <h3>Total User</h3>
        <h1><?= $user['total']; ?></h1>
        <a href="user.php">Kelola User</a>

    </div>

    <div style="background:white; padding:30px;
    border-radius:12px; text-align:center; min-width:200px;">

        <h3>Total Produk</h3>
        <h1><?= $produk['total']; ?></h1>
        <a href="produk.php">Kelola Produk</a>

    </div>

</div>

</body>
</html>