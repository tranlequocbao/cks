<?php 
session_start();
require_once "dbhelp.php";
if(isset($_POST['result']))
{
    $v = '';
    $value = $_POST['result'];
    $msnv = $value['msnv'];
    $query = mysqli_query($connect,"select * from nhanvien where nhanvien.IDNhanVien = '$msnv'");
    if($query->num_rows>0){
        while($row=$query->fetch_all(MYSQLI_ASSOC)){
            $v = $row;
            
        }
        echo json_encode(['result'=>$v,'code'=>200]);
    }
    else
    echo json_encode(['result'=>"NONE",'code'=>200]);
}
else
        echo json_encode(['code'=>201]);
?>