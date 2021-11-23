<?php

$servername = "localhost";
$database = "chukyso";
$username = "root";
$password = "M@zda@123";
$charset = "utf8mb4";

try {
  $dsn = "mysql:host=$servername;dbname=$database;charset=$charset";
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
  echo "Connection failed: ". $e->getMessage();
}
?>
