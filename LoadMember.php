<?php
session_start();
if(isset($_SESSION['IDNhanVien']))
{
    $idmember = $_SESSION['IDNhanVien'];
}
if(isset($_POST['result'])) {
    $v='';
    $idbophan = $_SESSION['IDBoPhan'];
    $connect = mysqli_connect("localhost","root","","chukyso");
    $value = $_POST['result'];
    $sql="SELECT * FROM `nhanvien` where IDBoPhan like concat('%','$idbophan','%') and IDNhanVien NOT IN(SELECT IDNhanVien from nhanvien WHERE IDNhanVien='$idmember')";

    $query=mysqli_query($connect,$sql);
    $d1=0;$d2=0;
    if($query->num_rows>0){
        while($row=$query->fetch_all(MYSQLI_ASSOC)){
            $v = $row;
            echo json_encode(['result'=>$v,'code'=>200]);
        }
    }
    else
        echo json_encode(['code'=>201]);
}
