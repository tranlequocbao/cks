<?php
session_start();
require_once "dbhelp.php";
if(isset($_POST['result'])) {
    $v='';
    // $con = mysqli_connect('10.40.13.29','root','','chukyso');
    $value = $_POST['result'];
    $sql="select * from vattu where TenVatTu='$value'";
    $query=mysqli_query($connect,$sql);
    $d1=0;$d2=0;
    //while ($row2=$query->fetch_assoc())
    //{
        //$d1 = $row2['Material_ID'];
        //$d2=$row2['unit'];
   // }
        if($query->num_rows>0){
            while($row=$query->fetch_all(MYSQLI_ASSOC)){
                $v = $row;
                echo json_encode(['result'=>$v,'code'=>200]);
            }
        }
    else
        echo json_encode(['result'=>'NG','code'=>201]);
    }
    else{
        echo json_encode(['code'=>201]);
    }
?>