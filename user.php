<?php
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (nama, username, password)
              VALUES ('$nama', '$username', '$password')";

    mysqli_query($conn, $query);
    header("Location: users.php");
    exit;
}

if (isset($_POST['edit'])) {
    $id = (int) $_POST['id'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];

    if ($_POST['password'] !== '') {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        mysqli_query($conn, "UPDATE users SET nama='$nama', username='$username', password='$password' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE users SET nama='$nama', username='$username' WHERE id=$id");
    }

    header("Location: user.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];

    mysqli_query($conn, "DELETE FROM users WHERE id = $id");

    header("Location: users.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data User</title>
</head>
<link rel="stylesheet" href="css/style.css">
<body>

<h2>Data User</h2>

<form method="POST">
    <input type="text" name="nama"
           placeholder="Nama lengkap" required>

    <input type="text" name="username"
           placeholder="Username" required>

    <input type="password" name="password"
           placeholder="Password" required>

    <button type="submit" name="tambah">
        Tambah User
    </button>
</form>

<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Username</th>
        <th>Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($data)) : ?>
    <tr>
        <td><?= $row['id']; ?></td>
        <td><?= htmlspecialchars($row['nama']); ?></td>
        <td><?= htmlspecialchars($row['username']); ?></td>
        <td>
            <a href="edit_user.php?id=<?= $row['id']; ?>">
    Edit
</a>

|

<a href="user.php?hapus=<?= $row['id']; ?>"
   onclick="return confirm('Hapus user ini?')">
    Hapus
</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</body>
<script src="js/script.js"></script>
</html>