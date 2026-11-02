<?php
session_start();
include 'koneksi.php';

$error = '';

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM users WHERE username = ?");

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = $admin['username'];

        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>LOGIN ADMIN</h2>

<form method="POST">

    <h3>My Store</h3>

    <p>Silakan login untuk masuk ke dashboard</p>

    <?php if ($error): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error); ?>
        </p>
    <?php endif; ?>

    <input type="text"
        name="username"
        placeholder="Username"
        required>

    <input type="password"
        name="password"
        placeholder="Password"
        required>

    <button type="submit" name="login">
        Login
    </button>

</form>

</body>
</html>