<?php

include "../config.php";
include "../classes/DB.php";
session_start();

if (!isset($_POST["search"])) {
    $stmt = user\DB::getInstance()->prepare("SELECT * FROM Products INNER JOIN Product_category WHERE 
    Products.category_ID=Product_category.category_id");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
} else {
    $input=$_POST["input"];
    $sel=$_POST["select"];
    if (!empty($input)&& !empty($sel)) {
        $stmt = user\DB::getInstance()->prepare("SELECT * FROM Products INNER JOIN Product_category 
        WHERE Products.category_ID=Product_category.category_id 
        AND (Products.product_id LIKE '$input%' OR Products.product_name LIKE 
        '$input%' OR  Product_category.category_name LIKE '$input%')
    ORDER BY $sel");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } elseif (empty($input) && !empty($sel)) {
        $stmt = user\DB::getInstance()->prepare("SELECT * FROM Products INNER JOIN Product_category 
        WHERE Products.category_ID=Product_category.category_id ORDER BY $sel");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } elseif (empty($sel) && !empty($input)) {
          $stmt = user\DB::getInstance()->prepare("SELECT * FROM Products INNER JOIN Product_category 
          WHERE Products.category_ID=Product_category.category_id 
          AND (Products.product_id LIKE '$input%' OR Products.product_name LIKE 
          '$input%' OR  Product_category.category_name LIKE '$input%')");
          $stmt->execute();
          $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    } else {
        $stmt = user\DB::getInstance()->prepare("SELECT * FROM Products INNER JOIN Product_category 
        WHERE Products.category_ID=Product_category.category_id");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    }

}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Home · Bootstrap v5.1</title>
    

    <!-- Bootstrap core CSS -->
    <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


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
  <body>
    
<header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-white">Cart</h4>
          <p class="text-muted">Cart has <?php if (isset($_SESSION["cart"])) {
                echo count($_SESSION["cart"]);
} else {
            echo "0";
} ?> items</p>
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
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" 
        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="me-2" 
        viewBox="0 0 24 24">
        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
        <circle cx="12" cy="13" r="4"/></svg>
        <strong>Shop</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" 
      aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</header>

<main>

  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">My Shop</h1>
        <p class="lead text-muted">Something short and leading about the collection below—its contents, 
          the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
        <p>
          <a href="#" class="btn btn-primary my-2">Shop Now</a>
          <a href="cart.php" class="btn btn-secondary my-2">View Cart</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-light">
      <div class="container overflow-hidden">
        <form class="row row-cols-lg-auto align-items-center mt-0 mb-3" method="POST">
            <div class="col-lg-6 col-12">
              <label class="visually-hidden" for="inlineFormInputGroupUsername">Search</label>
              <div class="input-group">
                <input type="text" class="form-control" id="inlineFormInputGroupUsername" name="input" 
                placeholder="Product, SKU, Category">
              </div>
            </div>
          
            <div class="col-lg-3 col-12">
              <label class="visually-hidden" for="inlineFormSelectPref">Sort By</label>
              <select class="form-select" id="inlineFormSelectPref" name="select">
                <option selected value="">Sort By</option>
                <option value="sales_price">Price</option>
                <option value="product_id">Recently Added</option>
                <option value="category_name">Category</option>
              </select>
            </div>
          
            <div class="col-lg-3 col-12">
              <button type="submit" class="btn btn-primary w-100" name="search">Search</button>
            </div>
          </form>
      </div>
             
            <?php

            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
            } else {
                $pageno = 1;
            }
            $no_of_records_per_page = 2;
            $offset = ($pageno-1) * $no_of_records_per_page;
            $stmt = user\DB::getInstance()->prepare("SELECT COUNT(*) FROM Products");
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($stmt->fetchAll()[0] as $k => $v) {
                $total_rows = $v[0];
            }
            $total_pages = ceil($total_rows / $no_of_records_per_page);
            $stm = user\DB::getInstance()->prepare("SELECT * FROM Products INNER JOIN Product_category WHERE 
            Products.category_ID=Product_category.category_id LIMIT $offset, $no_of_records_per_page");
            $stm->execute();
                ?>
              <div class="container">
              <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                  
                            <?php
                                            $html="";
                            foreach ($stm->fetchAll() as $k => $v) {
                                $html.='
                    <div class="col">
                    <div class="card shadow-sm">
                    <img src="../images/'.$v["image"].'" alt="">
        
                    <div class="card-body">
                    <h5>'.$v["product_name"].'</h5>
                    <p class="card-text">'.$v["category_name"].'</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <p><strong>$'.$v["sales_price"].'</strong>&nbsp;<del><small 
                      class="link-danger">$'.$v["list_price"].'</small></del></p>
                      <form action="single-product.php" method="POST">
                      <input type="hidden" name="id" value="'.$v["product_id"].'">
                      <input class="btn btn-success" type="submit" name="submit" value="View Details">
                      </form>
                      <form action="cart.php" method="POST">
                      <input type="hidden" name="id" value="'.$v["product_id"].'">
                      <input class="btn btn-primary" type="submit" name="add-to-cart" value="Add To Cart">
                      </form>
                    </div>
                  </div>
                </div>
              </div>';
                            }
                            echo $html;
                  
                            ?>
          </div>
            
          <br>
          <div class="row text-center">
            <nav aria-label="Page navigation example">
            <ul class="pagination">
            <div class="btn-group" role="group" aria-label="Basic example">
                <li><a href="?pageno=1" class="btn btn-secondary">First</a></li>
                <li class="<?php if ($pageno <= 1) {
                    echo 'disabled';
} ?>">
                    <a href="<?php if ($pageno <= 1) {
                        echo '#';
} else {
    echo "?pageno=".($pageno - 1);
} ?>" class="btn btn-secondary">Prev</a>
                </li>
                <li class="<?php if ($pageno >= $total_pages) {
                    echo 'disabled';
} ?>">
                    <a href="<?php if ($pageno >= $total_pages) {
                        echo '#';
} else {
    echo "?pageno=".($pageno + 1);
} ?>" class="btn btn-secondary">Next</a>
                </li>
                <li><a href="?pageno=<?php echo $total_pages; ?>" class="btn btn-secondary">Last</a></li>
    </ul>
              </nav>
          </div>
          </div>
</div>
</div>
</main>

<footer class="text-muted py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">Back to top</a>
    </p>
    <p class="mb-1">&copy; CEDCOSS Technologies</p>
  </div>
</footer>


    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
    crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="script1.js"></script>
      
  </body>
</html>
