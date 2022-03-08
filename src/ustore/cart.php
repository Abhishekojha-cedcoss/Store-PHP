<?php
include "../config.php";
include "../classes/DB.php";
session_start();
if (isset($_POST["add-to-cart"])) {
    $id = $_POST["id"];
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }
    if (is_array($_SESSION["cart"])) {
        if (!ispresent($id)) {
            addToCart($id);
        }
    }
}
if (isset($_POST["delete"])) {
    $id = $_POST["pid"];
    if (is_array($_SESSION["cart"])) {
        deleteCart($id);
    }
}

function deleteCart($id)
{
    for ($i = 0; $i < count($_SESSION["cart"]); $i++) {
        if ($_SESSION["cart"][$i]["product_id"] == $id) {
            array_splice($_SESSION["cart"], $i, 1);
        }
    }
}

function addToCart($id)
{
    $stmt = DB::getInstance()->prepare("SELECT * FROM Products WHERE product_id=$id");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($stmt->fetchAll() as $v) {
        $var=$v;
        $var['quantity']=1;
        array_push($_SESSION['cart'], $var);
        // echo "<pre>";
        // print_r($_SESSION["cart"]);
        // echo "</pre>";
    }
}
function ispresent($id)
{
    foreach ($_SESSION['cart'] as $key => $val) {
        if ($id==$val['product_id']) {
            $_SESSION['cart'][$key]['quantity']++;
            return true;
        }
    }
    return false;
}
if (isset($_POST["update"])) {
    $input=$_POST["input"];
    $pid=$_POST["id"];
    foreach ($_SESSION['cart'] as $key => $val) {
        if ($pid==$val['product_id']) {
            $_SESSION['cart'][$key]['quantity']=$input;
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
      <h2>Cart</h2>
    </div>

    <div class="row g-5">
      <div class="col order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill"><?php echo count($_SESSION["cart"]); ?></span>
        </h4>
        <table class="table">
        <?php
          $total = 0;
          $grand=0;
          $html="";
        if (!empty($_SESSION["cart"])) {
            $html='
                  <thead>
                  <tr>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Total</th>
                  <th>Delete</th>
                  </tr>
                  </thead>';
            foreach ($_SESSION["cart"] as $k => $v) {
                    $total=$v["sales_price"]*$v["quantity"];
                    $grand+=$total;

                      $html.='<tr>
                      <td>'.$v["product_name"].'</td>
                      <td>'.$v["sales_price"].'</td>
                      <td>'.$v["quantity"].'
                        <form method="POST">
                        <input type="text" class="w-20" name="input">
                        <input type="hidden" class="w-20" name="id" value="'.$v["product_id"].'">
                        <input type="submit" class="btn btn-secondary ms-1 w-20" name="update" value="update">
                        </form></td>
                        <td>
                        <form method="POST">
                        <input type="hidden" class="w-20" name="pid" value="'.$v["product_id"].'">
                        <input type="submit" class="btn btn-danger ms-1 w-20" name="delete" value="Remove">
                        </form>
                      </td>
                      <td>'.$total.'</td>
                      </tr>';
            }
                  $html.='<tfoot>
                  <tr>
                   <td colspan="5" class="text-end">Total:$'.$grand.'</td>
                  </tr>
                  </tfoot>
                  ';
                  $_SESSION['total']=$grand;
                  echo $html;
        }
            ?>
        </table>
      </div>
    </div>
    <div class="row g-5 align-items-right">
        <div class="col-3">
          
            <form action="checkout.php" method="POST">
                   <button type="submit" class="btn btn-primary">Checkout</button>
            </form>
        </div>
        <div class="col-3">
        <a href="home.php" class="btn btn-info text-white" role="button">Go To Home</a>
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
