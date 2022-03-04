<?php
include "config.php";
include "classes/DB.php";
include "classes/User.php";
session_start();
error_reporting(0);
$email=$password="";
if(isset($_POST['submit'])){
    $email=$_POST["email"];;
    $password=$_POST["password"];
    $stmt = DB::getInstance()->prepare("SELECT email,password,role,Status FROM Users");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $k=>$v){
      if($email==$v["email"] && $password==$v["password"]){
        if(!isset($_SESSION["user"])){
          $_SESSION["user"]=array("email"=>$email,"password"=>$password,"role"=>$v["role"]);
        }
            if($v["role"]=="admin"){
              header("location: dashboard.php");
            }
            elseif($v["role"]=="user")
            {
              if($v["Status"]=="approved"){
                header("location: userdash.php");
              }     
              else{
                $result="You are not approved";
                session_unset();
              }    
            }
    }
    else{
      $result="Wrong Password or email!";
      session_unset();
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
    <?php echo $result; ?>
    </div>
    <p>Don't have a account?</p>
    <a href="signup.php">Sign Up</a>
    <p class="mt-5 mb-3 text-muted">&copy; CEDCOSS Technologies</p>
  </form>

</main>


    
  </body>
</html>