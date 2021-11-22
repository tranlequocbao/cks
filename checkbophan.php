<?php
include "dbhelp.php";
session_start();
if(isset($_POST['resultt'])) {
    $v='';
    $value = $_POST['resultt'];
    $sql="select * from bophan, nhanvien where nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and ((bophan.IDBoPhan ='$value' and nhanvien.IDChucVu LIKE '%CV003%') OR (nhanvien.IDChucVu LIKE '%CV002%' AND bophan.IDBoPhan ='$value')) order by nhanvien.IDChucVu desc";
    $query=mysqli_query($connect,$sql);
    $d1=0;$d2=0;
        if($query->num_rows>0){
            while($row=$query->fetch_all(MYSQLI_ASSOC)){
                $v = $row;
                echo json_encode(['resultt'=>$v,'code'=>200]);
            }
        }
    else
        echo json_encode(['code'=>201]);
    }

    if(isset($_POST['resulttt'])){
        $value = $_POST['resulttt'];
        $a='';
        $sql1="select * from bophan where IDBoPhan='$value'";
        $query1=mysqli_query($connect,$sql1);
        if($query1->num_rows>0){
            while($row1=$query1->fetch_all(MYSQLI_ASSOC)){
                $a = $row1;
                echo json_encode(['resulttt'=>$a,'code'=>200]);
            }
        }
    }
?>