<?php

$host="localhost";
$user = "root";
$password ="";
$vt="shop";

$connectionlink=mysqli_connect($host,$user,$password,$vt);
mysqli_set_charset($connectionlink,"utf8mb4");

?>