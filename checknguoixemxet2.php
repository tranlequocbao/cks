<?php 
session_start();
require_once "dbhelp.php";

if(isset($_POST['result']))
{
    $v = '';
    $bophan = $_POST['result'];
    $query = mysqli_query($connect,"SELECT * FROM `nhanvien` WHERE (IDChucVu LIKE '%CV002%' AND IDBoPhan like '%$bophan%') OR (IDChucVu LIKE '%CV003%' AND IDBoPhan like '%$bophan%')");
    if($query->num_rows>0){
        while($row=$query->fetch_all(MYSQLI_ASSOC)){
            $v = $row;
            echo json_encode(['result'=>$v,'code'=>200]);
        }
    }
    else
        echo json_encode(['code'=>201]);
}
?>