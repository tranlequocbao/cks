<?php
    session_start();
    require_once "dbhelp.php";
    if (!isset($_SESSION["IDNhanVien"])) {
        header('Location: Dangnhap.php');
    }
    $ID = $_SESSION["IDNhanVien"];
    $sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
    $query1 = mysqli_query($connect, $sql);
    $row1 = mysqli_fetch_array($query1);
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Chữ ký điện tử Thaco Auto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="Style/StypeIndex.css" rel="stylesheet"/> -->
    <script src="js/jquery-2.1.4.js"></script>
    <link href="Style/display.css" rel="stylesheet"/>
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <!-- <script src="js/jquery-3.2.1.slim.min.js"></script> -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

<img src="Images/Index.jpg" style="width:100%; background-repeat: no-repeat;background-size: cover;">


<?php
    require "display/header.php";
?>
    <?php
        require "display/footer.php";
    ?>