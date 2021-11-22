<?php 
session_start();
require_once "dbhelp.php";
if(isset($_SESSION['IDNhanVien']))
{
    $idmember = $_SESSION['IDNhanVien'];
}
if(isset($_POST['result']))
{
    $v = '';
    $value = $_POST['result'];
    $idbophan = $_SESSION['IDBoPhan'];
    $query = mysqli_query($connect,"select * from nhanvien,bophan,chucvu where nhanvien.IDChucVu = chucvu.IDChucVu and nhanvien.IDBoPhan LIKE CONCAT ('%',bophan.IDBoPhan,'%') and nhanvien.IDNhanVien='$value' and bophan.IDBoPhan='$idbophan'");
    if($query->num_rows>0){
        while($row=$query->fetch_all(MYSQLI_ASSOC)){
            $v = $row;
            echo json_encode(['result'=>$v,'code'=>200,'query'=>$query]);
        }
    }
    else
        echo json_encode(['code'=>201]);
}
?>