<?php
session_start();

require_once("koneksi.php");

// verify user password hash
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// login user
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $sql);

    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if(verifyPassword($password, $user["password"])) {
            $_SESSION["username"] = $username;
            header("Location: index.php");
        } else {
            $error = "Username atau password salah";
        }
    } else {
        $error = "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Username" required>
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <br>
        <button type="submit">Login</button>
    </form>
    <?php if(isset($error)) : ?>
        <p style="color: red; font-style: italic"><?= $error ?></p>
    <?php endif; ?>
</body>
</html>