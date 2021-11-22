<?php 
session_start();
require_once "dbhelp.php";

if(isset($_POST['result']))
{
    $v = '';
    $value = $_POST['result'];
    $query = mysqli_query($connect,"SELECT * FROM `nhanvien` WHERE IDChucVu='CV005' OR IDChucVu='CV007' ORDER BY IDChucVu ASC");
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