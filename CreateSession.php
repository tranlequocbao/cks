<?php 
session_start();
// unset($_SESSION["IDBoPhan"]);
unset($_SESSION["IDNhanVien"]);
unset($_SESSION["MatKhau"]);
unset($_SESSION["HoTenNhanVien"]);
unset($_SESSION["IDChucVu"]);
require_once "dbhelp.php";
if(isset($_POST['result']))
{
    $value = $_POST['result'];
    //$_SESSION["HoTenNhanVien"]=$value['hoten'];
    $_SESSION["IDNhanVien"]=$value['ms'];
    //$_SESSION["IDChucVu"]=$value['chucvu'];
    $_SESSION["IDBoPhan"]=$value['idbophan'];
    $_SESSION["MatKhau"] = $value['matkhau'];
    $sql = "SELECT * FROM nhanvien where IDNhanVien = '".$value['ms']."'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);
    $_SESSION["HoTenNhanVien"] = $row['HoTenNhanVien'];
    $_SESSION["IDChucVu"]=$row['IDChucVu'];
                    if(isset($_SESSION['link']))
                    $link = $_SESSION['link'];
                    else
                    $link = "Index.php";
                $v = array('msnv' => $value['ms'],'iddep'=>$value['idbophan'] );
    echo json_encode(['result'=>$v,'code'=>200]);
}
else
        echo json_encode(['code'=>201]);
?>