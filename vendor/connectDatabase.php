<?php

$servername = "10.40.12.6";
$database = "chukyso";
$username = "root";
$password = "";
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
