<?php

session_start();
    unset($_SESSION["IDBoPhan"]);
    unset($_SESSION["IDNhanVien"]);
    unset($_SESSION["MatKhau"]);
    unset($_SESSION["HoTenNhanVien"]);
    unset($_SESSION["IDChucVu"]);
    require_once "dbhelp.php";
if(isset($_POST['result']))
{
    $value = $_POST['result'];

    $_SESSION["IDBoPhan"]=$value["bophan"];
    $_SESSION["IDNhanVien"]=$value["user"];
    $_SESSION["MatKhau"] = $value["pass"];
    
    $sql = "SELECT * FROM nhanvien where IDNhanVien = '".$value["user"]."'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);
    $_SESSION["HoTenNhanVien"] = $row['HoTenNhanVien'];
    $_SESSION["IDChucVu"]=$row['IDChucVu'];
    if(isset($_SESSION['link'])){
        $link = $_SESSION['link'];
    }
                    else{
                        $link = "Index.php";
                    }
                    
    echo json_encode(['result'=>$value,'link'=>$link,'code'=>200]);
}
else
       { echo json_encode(['code'=>201]);}
?>