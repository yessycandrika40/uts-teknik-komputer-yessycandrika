<?php
include 'koneksi.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    die("ID user tidak valid");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User tidak ditemukan");
}

if (isset($_POST['edit'])) {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($password !== '') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "UPDATE users SET nama=?, username=?, password=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "sssi", $nama, $username, $hash, $id);
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE users SET nama=?, username=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssi", $nama, $username, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: user.php");
        exit;
    }

    echo "Gagal mengedit user.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>

<h2>Edit Data User</h2>

<form method="POST">
    <input type="text" name="nama"
        value="<?= htmlspecialchars($user['nama']); ?>" required>

    <br><br>

    <input type="text" name="username"
        value="<?= htmlspecialchars($user['username']); ?>" required>

    <br><br>

    <input type="password" name="password"
        placeholder="Password baru (kosongkan jika tidak diubah)">

    <br><br>

    <button type="submit" name="edit">Simpan Perubahan</button>
</form>

<br>

<a href="user.php">Kembali</a>

</body>
</html>