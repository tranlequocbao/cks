<?php

use function PHPSTORM_META\elementType;

session_start();
require_once "dbhelp.php";
// không có session sẽ tự động quay về trang đăng nhập
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}

$idnv=$_POST['idnv'];

$query='delete from nhanvien where IDNhanvien="'.$idnv.'"';
$result=$conn1->query(($query));
if(mysqli_query($conn1,$query)){
    echo json_encode(['code'=>200]);
}
else echo json_encode(['code'=>201]);
