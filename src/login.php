<?php
include "config.php";
include "classes/DB.php";
include "classes/User.php";
session_start();
error_reporting(0);
if (isset($_SESSION["user"])) {
    unset($_SESSION["user"]);
}
$email = $password = "";
if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $stmt = user\DB::getInstance()->prepare("SELECT `user_id`,email,password,role,Status FROM Users");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    if (!isset($_SESSION["user"])) {
        foreach ($stmt->fetchAll() as $k => $v) {
            $result = "";
            if ($email == $v["email"] && $password == $v["password"]) {
                $_SESSION["user"] = array("email" => $email,
                "password" => $password,
                "role" => $v["role"],
                "status" => $v["Status"],
                "user_id"=>$v["user_id"]);

                if ($_SESSION["user"]["role"] == "admin") {
                    header("location: dashboard.php");
                } elseif ($_SESSION["user"]["role"] == "user") {
                    if ($_SESSION["user"]["status"] == "approved") {
                        header("location: userdash.php");
                    } else {
                          $result1 = "You are not approved to login!";
                    }
                }
            } else {
                 $result = "";
                 $result = "Wrong Password or email!";
            }
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.88.1">
  <title>Signin Template · Bootstrap v5.1</title>

  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="./assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <main class="form-signin">
    <form action="" method="POST">
      <h1 class="h3 mb-3 fw-normal">Sign In</h1>

      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
        <label for="floatingInput">Email address</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Sign in</button>
      <div class="message text-danger">
       <p> <?php if (!empty($result1)) {
            echo $result1;
} else {
          echo $result;
} ?></p>
      </div>
      <p>Don't have a account?</p>
      <a href="signup.php">Sign Up</a>
      <p class="mt-5 mb-3 text-muted">&copy; CEDCOSS Technologies</p>
    </form>

  </main>



</body>

</html>