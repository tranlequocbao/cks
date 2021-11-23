<?php
require '../vendor/connectDatabase.php';

date_default_timezone_set("Asia/Ho_Chi_Minh");

$data = $_POST['data'];

$resultdata=true;
foreach ($data as $value) {

    for ($i = 0; $i < count($value); $i++) {
       
        if ($value['h18h30'] != null && $value['h18h30'] != "") $h18h30_ = 1;
        else $h18h30_ = 0;

        if ($value['h20h45'] != null && $value['h20h45'] != "") $h20h45_ = 1;
        else $h20h45_ = 0;

        if ($value['h22h15'] != null && $value['h22h15'] != "") $h22h15_ = 1;
        else $h22h15_ = 0;

        if ($value['h24h00'] != null && $value['h24h00'] != "") $h24h00_ = 1;
        else $h24h00_ = 0;

        if ($value['h7h00'] != null && $value['h7h00'] != "") $h7h00_ = 1;
        else $h7h00_ = 0;

        $sql_check = "SELECT COUNT(Msnv) AS count FROM phieutangca WHERE Msnv='" . $value['msnv'] . "' and DAY(date)=" . date('d') . " and MONTH(date)='" . date('m') . "' and YEAR(date)='" . date('Y') . "'";
        try {
            $result = $pdo->query($sql_check);
            if ($row = $result->fetch()) {

                if ((int)$row['count'] > 0) {
                    $sql = "UPDATE phieutangca set Hovaten='" . $value['name'] . "' ,Chucvu='" . $value['chucvu'] . "', Noidung='" . $value['noidung'] . "', Time_18h30='" . $h18h30_ . "',Time_20h45='" . $h20h45_ . "',Time_22h15='" . $h22h15_ . "',Time_24h00='" . $h24h00_ . "',Time_7h00='" . $h7h00_ . "',Diadiem='" . $value['diadiem'] . "',Monan='" . $value['monan'] . "',Ghichu='" . $value['ghichu'] . "' WHERE DAY(date)=" . date('d') . " and MONTH(date)='" . date('m') . "' and YEAR(date)='" . date('Y') . "' and Msnv='" . $value['msnv'] . "'";
                    $pdo->exec($sql);
                   
                } else {
                    $sql = "INSERT INTO phieutangca(Msnv,Hovaten,Chucvu,Noidung,Time_18h30,Time_20h45,Time_22h15,Time_24h00,Time_7h00,Diadiem,Monan,Ghichu) VALUES(" . $value['msnv'] . ",'" . $value['name'] . "','" . $value['chucvu'] . "','" . $value['noidung'] . "'," . $h18h30_ . "," . $h20h45_ . "," . $h22h15_ . "," . $h24h00_ . "," . $h7h00_ . ",'" . $value['diadiem'] . "','" . $value['monan'] . "','" . $value['ghichu'] . "')";
                    if ($value['msnv'] != "" & $value['msnv'] != null) {
                        $pdo->exec($sql);
                        
                        
                    }
                }
            }
        } catch (PDOException $e) {
            $resultdata=false;
        }
    }
}
if($resultdata==true){
    echo json_encode(['code' => 200]);
}
else{
    echo json_encode(['code' => 201]);
                       
}
function IDnhamay($IDnhanvien){
    $sql = "SELECT ";
}