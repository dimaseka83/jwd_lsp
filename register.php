<?php 
session_start();

require_once("koneksi.php");
// hashing password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}
// register user

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = hashPassword($_POST["password"]);

    $sql = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($koneksi, $sql);

    if($result) {
        $_SESSION["username"] = $username;
        header("Location: login.php");
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
    <title>Register</title>
</head>
<body>
<h2>Register</h2>
    <form action="" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Username" required>
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password" required>
        <br>
        <button type="submit">Register</button>
    </form>
    <?php if(isset($error)) : ?>
        <p style="color: red; font-style: italic"><?= $error ?></p>
    <?php endif; ?>
</body>
</html>