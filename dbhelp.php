<?php
    $connect = mysqli_connect('10.40.12.6','root','','chukyso');
    mysqli_set_charset($connect,"utf8mb4");

    if (mysqli_connect_errno()) {
        echo "<script type='text/javascript'>alert('Không có kết nối đến cơ sở dữ liệu');</script>"; die;
        exit();
      }
      $servername = "10.40.12.6";
      $username = "root";
      $password = "";
      $db="chukyso";
      $conn1 = mysqli_connect($servername, $username, $password,$db);
    //22222else{ echo "Kết nối thất bại"; }
?>
