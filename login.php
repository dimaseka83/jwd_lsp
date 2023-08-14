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
            header("Location: admin/kegiatan");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<style>
    /* Additional CSS styles */

    body {
  background: #007bff;
  background: linear-gradient(to right, #0062E6, #33AEFF);
}

.btn-login {
  font-size: 0.9rem;
  letter-spacing: 0.05rem;
  padding: 0.75rem 1rem;
}
</style>
<!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card border-0 shadow rounded-3 my-5">
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Sign In</h5>
            <?php if(isset($error)) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">
              <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Username</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
              </div>

              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold" type="submit">Sign
                  in</button>
              </div>
             
            </form>
                     <!-- to sign out page -->
            <p class="text-center mt-3">Don't have an account? <a href="register.php">Sign Out</a></p>
            <p class="text-center mt-3"><a href="index.php">Back to Home</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
   
</body>
</html>