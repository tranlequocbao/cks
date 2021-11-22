<?php 
session_start();
unset($_SESSION["IDBoPhan"]);

require_once "dbhelp.php";
if(isset($_POST['resultt']))
{
    $value = $_POST['resultt'];
    $_SESSION["IDNhanVien"]=$value['user'];
    $_SESSION["MatKhau"]=$value['pass'];
    $_SESSION["IDBoPhan"]=$value['idbophan'];
    echo json_encode(['resultt'=>"OK",'code'=>200]);
}
else
        echo json_encode(['code'=>201]);
?>