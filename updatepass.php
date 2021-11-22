<?php 
    require_once "dbhelp.php";
    if(isset($_POST['value']))
    {
        session_start();
        $value = $_POST['value'];
        $newpass = $value['newpass'];
        $idnhanvien = $value['idmember'];
        $sql = "UPDATE nhanvien set MatKhau = '$newpass',PassReset=1 where IDNhanVien = '$idnhanvien'";
        $query = mysqli_query($connect, $sql);
        $query = mysqli_query($connect,"select * from nhanvien where nhanvien.IDNhanVien = '$idnhanvien'");
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
