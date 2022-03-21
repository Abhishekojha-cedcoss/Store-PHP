<?php
session_start();
session_unset();
session_destroy();
session_abort();
unset($_SESSION["user"]);
unset($_SESSION["cart"]);
header("location: login.php") ;
