<?php
session_start();
include "../config.php";
include "../classes/DB.php";
if (isset($_SESSION["user"])) {
    $email = $_SESSION["user"]["email"];
    $stmt = user\DB::getInstance()->prepare("SELECT * FROM Users WHERE email='$email'");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $arr=$stmt->fetchAll()[0];
}
if (isset($_POST["submit"])) {
    $address=$_POST["address"];
    $id=$_POST["id"];
    // $pname=array($_SESSION['cart']['product_name']);
    // $sales=$_SESSION['cart']['sales_price'];
    // $qty=$_SESSION['cart']['quantity'];
    $id=$arr['user_id'];
    $cart=json_encode($_SESSION["cart"]);
    if (!isset($_SESSION["user"])) {
          echo "Please Login first";
          header("location: ../login.php");
    } else {
        $stmt1 = user\DB::getInstance()->prepare(
            "INSERT INTO `Orders`(`user_id`, `Product_Detail`, `shipping_address`, `status`)
            VALUES ($id,'$cart','$address','pending')"
        );
        $stmt1->execute();
        echo "Order Placed";
        echo "Please wait for 5 seconds!";
        unset($_SESSION["cart"]);
    }
    header("refresh:5; URL= ../orders.php");
    die();
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
  <title>Checkout example · Bootstrap v5.1</title>


  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"
   integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" 
   crossorigin="anonymous">


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
</head>

<body class="bg-light">

  <div class="container">
    <main>
      <div class="py-5 text-center">
        <h2>Checkout</h2>
      </div>

      <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-primary">Your cart</span>
            <span class="badge bg-primary rounded-pill"><?php if (isset($_SESSION["cart"])) {
                echo count($_SESSION["cart"]);
} else {
      echo "0";
}
    ?></span>
          </h4>
          <ul class="list-group mb-3">
            <?php
            if (isset($_SESSION["cart"])) {
                $html = "" ;
                foreach ($_SESSION["cart"] as $k => $v) {
                    $html .= '<li class="list-group-item d-flex justify-content-between lh-sm">
              <div>
                <h6 class="my-0">' . $v["product_name"] . '</h6>
                <small class="text-muted">Brief description</small>
              </div>
              <span class="text-muted">$' . $v["sales_price"] . '</span>
            </li>';
                }
            
                echo $html;
            }
            ?>

            <li class="list-group-item d-flex justify-content-between bg-light">
              <div class="text-success">
                <h6 class="my-0">Promo code</h6>
                <small>EXAMPLECODE</small>
              </div>
              <span class="text-success">−$5</span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong><?php if (isset($_SESSION["total"])) {
                                echo ($_SESSION["total"]);
}?>  
                                </strong>
            </li>
          </ul>


          <form class="card p-2">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Promo code">
              <button type="submit" class="btn btn-secondary">Redeem</button>
            </div>
          </form>
          <br>
          <div class="col">
            <a href="home.php" class="btn btn-info text-white" role="button">Go back to Home</a>
          </div>
          <br>
          <div class="col">
            <a href="../userdash.php" class="btn btn-success text-white">Go to Dashboard</a>
          </div>

        </div>
        <div class="col-md-7 col-lg-8">
          <h4 class="mb-3">Billing address</h4>
          <form class="needs-validation" novalidate method="POST">
            <div class="row g-3">
              <div class="col-sm-6">
                <label for="firstName" class="form-label">First name</label>
                <input type="text" class="form-control" id="firstName" placeholder="" 
                name="firstname" value="<?php if (isset($arr["firstName"])) {
                    echo($arr["firstName"]);
}?>" required>
                <input type="hidden" value="<?php print_r($arr["user_id"]); ?>" name="id">
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>

              <div class="col-sm-6">
                <label for="lastName" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lastName" placeholder=""
                 name="lastname" value="<?php if (isset($arr["lastname"])) {
                        echo($arr["lastname"]);
} ?>" required>
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>


              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="<?php if (isset($arr["email"])) {
                    echo($arr["email"]);
}?>" name="email">
                <div class="invalid-feedback">
                  Please enter a valid email address for shipping updates.
                </div>
              </div>

              <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" placeholder="1234 Main St" name="address" required>
                <div class="invalid-feedback">
                  Please enter your shipping address.
                </div>
              </div>

            <hr class="my-4">

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="same-address">
              <label class="form-check-label" for="same-address">
                Shipping address is the same as my billing address</label>
            </div>

            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="save-info">
              <label class="form-check-label" for="save-info">Save this information for next time</label>
            </div>



            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" name="submit" type="submit">Place Order</button>
          </form>
        </div>
      </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017–2021 Company Name</p>
      <ul class="list-inline">
        <li class="list-inline-item"><a href="#">Privacy</a></li>
        <li class="list-inline-item"><a href="#">Terms</a></li>
        <li class="list-inline-item"><a href="#">Support</a></li>
      </ul>
    </footer>
  </div>


  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" 
  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
  crossorigin="anonymous"></script>
  <script src="./assets/js/form-validation.js"></script>
</body>

</html>