<?php

include "../config.php";
include "../classes/DB.php";

if (isset($_POST["submit"])) {
    $id=$_POST["id"];
    $stmt = user\DB::getInstance()->prepare("SELECT * FROM Products INNER JOIN Product_category 
    WHERE Products.category_ID=Product_category.category_id AND Products.product_id='$id'");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Item - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../node_modules//bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    </head>
    <body>
        <header>
            <div class="collapse bg-dark" id="navbarHeader">
              <div class="container">
                <div class="row">
                  <div class="col-sm-8 col-md-7 py-4">
                    <h4 class="text-white">Cart</h4>
                    <p class="text-muted">Cart is empty now.</p>
                  </div>
                  <div class="col-sm-4 offset-md-1 py-4">
                    <h4 class="text-white">Contact</h4>
                    <ul class="list-unstyled">
                      <li><a href="#" class="text-white">Follow on Twitter</a></li>
                      <li><a href="#" class="text-white">Like on Facebook</a></li>
                      <li><a href="#" class="text-white">Email me</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="navbar navbar-dark bg-dark shadow-sm">
              <div class="container">
                <a href="#" class="navbar-brand d-flex align-items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" 
                  stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" 
                  stroke-width="2" aria-hidden="true" class="me-2" viewBox="0 0 24 24">
                  <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 
                  3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                  <strong>Shop</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" 
                aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              </div>
            </div>
          </header>
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                <?php foreach ($stmt->fetchAll() as $k => $v) {
                        ?>
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" 
                    <?php echo 'src="../images/'.$v["image"].'"'; ?>  alt="..." /></div>
                    <div class="col-md-6">
                        
                    
                        <div class="small mb-1">SKU: <?php echo $v["product_id"]; ?></div>
                        <h1 class="display-5 fw-bolder"><?php echo $v["product_name"]; ?></h1>
                        <div class="fs-5 mb-5">
                            <span class="text-decoration-line-through">$<?php echo $v["list_price"]; ?></span>
                            <span>$<?php echo $v["sales_price"]; ?></span>
                        </div>
                        <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                          Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati 
                          excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea 
                          iste laborum vero?</p>
                        <div class="d-flex">
                          <form action="cart.php" method="POST" >
                          <input type="hidden" name="id" value="<?php echo $v["product_id"]; ?>">
                            <input class="form-control text-center me-3" id="inputQuantity" 
                            type="num" value="1" style="max-width: 3rem" />
                            <button class="btn btn-primary flex-shrink-0" type="submit" name="add-to-cart">
                                <i class="bi-cart-fill me-1"></i>
                                Add to cart
                            </button>
                        </form>
                        </div>
                    </div>
                    <?php
} ?>
                </div>
            </div>
        </section>
        <!-- Related items section-->

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">&copy; CEDCOSS Technologies</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
