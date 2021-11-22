<?php

session_start();
require_once "dbhelp.php";
// không có session sẽ tự động quay về trang đăng nhập
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
$data='';
$dept='';
$order='';
$idnv=$_POST['idnv'];
$query_nv ='select * from nhanvien where IDNhanVien="'.$idnv.'"';
$result=$conn1->query($query_nv);
if($result->num_rows>0){
    while($row=$result->fetch_all(MYSQLI_ASSOC)){
        $data=$row;
    }
   $idbp=$data[0]['IDBoPhan'];
   $idcv=$data[0]['IDChucVu'];
    $query_bp='select TenBoPhan from bophan where IDBoPhan="'.$idbp.'"';
    $result=$conn1->query($query_bp);
    if($result->num_rows>0){
        $row1=$result->fetch_assoc();
        $dept=$row1['TenBoPhan'];
    }
    $query_cv='select TenChucVu from chucvu where IDChucVu="'.$idcv.'"';
    $result=$conn1->query($query_cv);
    if($result->num_rows>0){
        $row2=$result->fetch_assoc();
        $order=$row2['TenChucVu'];
    }
    echo json_encode(['data'=>$data,'dept'=>$dept,'order'=>$order,'code'=>200]);
}
else{
    echo json_encode(['code'=>201]);
}
