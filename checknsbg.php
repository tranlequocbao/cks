<?php 
require_once "dbhelp.php";
if(isset($_POST['result']))
{
    $v = '';
    $value = $_POST['result'];
    $query = mysqli_query($connect,"select nhanvien.IDNhanVien, nhanvien.MatKhau, nhanvien.HoTenNhanVien, chucvu.TenChucVu, bophan.TenBoPhan from nhanvien, chucvu, bophan where nhanvien.IDChucVu = chucvu.IDChucVu and nhanvien.IDBoPhan = bophan.IDBoPhan and nhanvien.HoTenNhanVien = '$value'");
    if($query->num_rows>0){
        echo json_encode(['result'=>'OK','code'=>200]);
    }
    else
    echo json_encode(['result'=>'NG','code'=>200]);
}
else
    echo json_encode(['code'=>201]);
?>