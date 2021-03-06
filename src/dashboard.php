<?php
session_start();
include "config.php";
include "classes/DB.php";
if (!isset($_SESSION["user"])) {
    header("location: login.php");
}
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 4;
$offset = ($pageno-1) * $no_of_records_per_page;
$stmt5 = user\DB::getInstance()->prepare("SELECT COUNT(*) FROM Users WHERE NOT role='admin'");
$stmt5->execute();
$result = $stmt5->setFetchMode(PDO::FETCH_ASSOC);
foreach ($stmt5->fetchAll()[0] as $k => $v) {
    $total_rows = $v[0];
}
$total_pages = ceil($total_rows / $no_of_records_per_page);
$stm = user\DB::getInstance()->prepare("SELECT * FROM Users WHERE NOT role='admin' LIMIT $offset, 
$no_of_records_per_page");
$stm->execute();

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $stm = user\DB::getInstance()->prepare("SELECT Status FROM Users WHERE user_id='$id'");
    $stm->execute();
    foreach ($stm->fetchAll() as $k => $v) {
        if ($v["Status"] == "pending") {
            $stmt1 = user\DB::getInstance()->prepare("UPDATE Users SET Status='approved' WHERE user_id='$id'");
            $stmt1->execute();
            header("location: dashboard.php");
        }
        if ($v["Status"] == "approved") {
            $stmt1 = user\DB::getInstance()->prepare("UPDATE Users SET Status='pending' WHERE user_id='$id'");
            $stmt1->execute();
            header("location: dashboard.php");
        }
    }
}
if (isset($_POST["submit1"])) {
    $id1 = $_POST["del"];
    $stmt2 = user\DB::getInstance()->prepare("DELETE FROM Users WHERE user_id='$id1'");
    $stmt2->execute();
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
  <title>Dashboard Template · Bootstrap v5.1</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/dashboard/">



  <!-- Bootstrap core CSS -->
  <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">


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
  <link href="./assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" 
    data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" 
    aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">
        <a class="nav-link px-3" href="signout.php">Sign out</a>
      </div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="dashboard.php">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="orderadmin.php">
                <span data-feather="file"></span>
                Orders
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="products.php">
                <span data-feather="shopping-cart"></span>
                Products
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="bar-chart-2"></span>
                Reports
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span data-feather="layers"></span>
                Integrations
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center 
        pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
        </div>

        <h2>Section title</h2>
        <div class="table-responsive">
            <?php
            
            $html = "";
            $html .= '<table class="table table-striped table-sm">     
        <tr>
          <th scope="col">User Id</th>
          <th scope="col">Username</th>
          <th scope="col">Firstname</th>
          <th scope="col">Lastname</th>
          <th scope="col">status</th>
          <th scope="col">Change Status</th>
          <th scope="col">Delete</th>
        </tr>
      
      ';
            foreach ($stm->fetchAll() as $k => $v) {
                $html .= '<tr>
        <td>' . $v["user_id"] . '</td>
        <td>' . $v["username"] . '</td>
        <td>' . $v["firstName"] . '</td>
        <td>' . $v["lastname"] . '</td>
        <td>' . $v["Status"] . '</td>
        <td><form action="" method="POST">
        <input type="hidden" name="id" value="' . $v["user_id"] . '">
        <button type="submit" name="submit" class="userEdit btn btn-info">Edit</button>
        </form></td>
        <td><form action="" method="POST">
        <input type="hidden" name="del" value="' . $v["user_id"] . '">
        <button type="submit" class="btn btn-danger" name="submit1"> Delete</button></form></td>
        </tr>';
            }
            $html .= '</table>';
            echo $html;

            ?>
         <div class="row text-center">
            <nav aria-label="Page navigation example">
            <ul class="pagination">
            <div class="btn-group" role="group" aria-label="Basic example">
            <li <?php if ($pageno <= 1) {
                    echo 'hidden';
} ?>>
                    <a href="<?php if ($pageno <= 1) {
                        echo '#';
} else {
    echo "?pageno=".($pageno - 1);
} ?>" class="btn btn-secondary">Prev</a>
                </li>

<?php
for ($page=1; $page <= $total_pages; $page++) :
            ?>

              <li><a href='<?php echo "?pageno=$page"; ?>' class="btn btn-secondary">
                <?php  echo $page; ?>
               </a></li>

                <?php
endfor ;
                ?>
              <li <?php if ($pageno >= $total_pages) {
                    echo 'hidden';
} ?>>
                    <a href="<?php if ($pageno >= $total_pages) {
                        echo '#';
} else {
    echo "dashboard.php?pageno=".($pageno + 1);
} ?>" class="btn btn-secondary">Next</a>
                </li>
                    </ul>
              </nav>
          </div>
          </div>
                <br>
                <br>
          <form action="addNewUser.php" method="POST">
            <button class="btn btn-info" type="submit">Add New User</button>
          </form>
        </div>
      </main>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.js" 
  integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" 
  crossorigin="anonymous"></script>
  <script src="adminscript.js"> </script>

</body>

</html>