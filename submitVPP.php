
<?php
session_start();
require ("dbhelp.php");

if(isset($_POST['user'])){
    $user=$_POST['user'];
    $ustao=$user['usertd'];
    $uskt=$user['userkt'];
    $usd=$user['userd'];


    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $nowtime = date('Y-m-d H:i:s');
    $sql_td = "INSERT INTO `pheduyet`(`IDPhieu`, `IDNhanVien`, `DaDuyet`, `NgayDuyet`, `GhiChu`, MucDuyet) VALUES ('" . createID() . "', '" . $ustao . "','1','" . $nowtime . "','','1')";
    $query_td = mysqli_query($connect, $sql_td);
    $sql_kt = "INSERT INTO `pheduyet`(`IDPhieu`, `IDNhanVien`, `DaDuyet`, `NgayDuyet`, `GhiChu`, MucDuyet) VALUES ('" . createID() . "', '" . $uskt . "','','','','2')";
    $query_kt = mysqli_query($connect, $sql_kt);
    $sql_d = "INSERT INTO `pheduyet`(`IDPhieu`, `IDNhanVien`, `DaDuyet`, `NgayDuyet`, `GhiChu`, MucDuyet) VALUES ('" . createID() . "', '" . $usd . "','','','','3')";
    $query_d = mysqli_query($connect, $sql_d);
    

    $sqlnv = "SELECT * FROM nhanvien WHERE IDNhanVien='" . $uskt . "'";
    $querynv = mysqli_query($connect, $sqlnv);
    $roww = mysqli_fetch_assoc($querynv);
    $emailkt = $roww["Email"];

    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailkt";
    $subject = "Bạn có yêu cầu cần duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
<html> 
<body style="font-size: 20px;font-family: Times New Roman;"> 
    <h2>Kính gửi anh/chị !</h2> 
    <table style="width: 100%; font-size: 20px;font-family: Times New Roman;">
        <tr style="font-weight: bold;"> 
            <td>Anh/Chị có yêu cầu cần được phê duyệt từ hệ thống chữ ký điện tử THACO MAZDA</td> 
        </tr>     
        <tr style=""> 
            <td>Vui lòng nhấn theo đường dẫn bên dưới để duyệt phiếu yêu cầu:</td> 
        </tr> 
        <tr style="font-style: italic;"> 
            <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . createID() . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . createID() . "";
    $message .= '</a></td> 
        </tr>
        <br/>
        <br/>
        <br/>
        <tr style="color: red;font-style: italic;"> 
            <td>Đây là mail tự động, vui lòng không trả lời mail này.</td> 
        </tr> 
        <tr> 
            <td>Trân trọng cảm ơn.</td> 
        </tr> 
    </table> 
    <br/>
    ---------------------------
    
    <p style="font-size: 16px;margin:0px">THACO MAZDA</p>
    <p style="font-size: 16px;margin:0px">Thôn 4, Tam Hiệp, Núi Thành, Quảng Nam</p>
    
</body> 
</html>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . $from;
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql_td]);
    } else {
    echo json_encode(['result' => 'NG', 'code' => 200, 'query' => $sql_td]);
    }
    $sql1 = "INSERT into phieu(IDPhieu, IDLoaiPhieu, IDNhanVien, NgayTao, UuTien, TuChoi, Gui) VALUES ('" . createID() . "', 'P0002', '" . $ustao . "', '" . $nowtime . "',0,0,1)";
    $query1 = mysqli_query($connect, $sql1);
}

if (isset($_POST['usertaoduyet'])) {
    // Chức năng gửi mail

    $usertaoduyet = $_POST['usertaoduyet'];
    $sql_td = "INSERT INTO `pheduyet`(`IDPhieu`, `IDNhanVien`, `DaDuyet`, `NgayDuyet`, `GhiChu`, MucDuyet) VALUES ('" . createID() . "', '" . $usertaoduyet . "','','','','1')";
    $query_td = mysqli_query($connect, $sql_td);

    $sqlnv = "SELECT * FROM nhanvien WHERE IDNhanVien='" . $usertaoduyet . "'";
    $querynv = mysqli_query($connect, $sqlnv);
    $roww = mysqli_fetch_assoc($querynv);
    $emailtaoduyet = $roww["Email"];

    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailtaoduyet";
    $subject = "Bạn có yêu cầu cần duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
<html> 
<body style="font-size: 20px;font-family: Times New Roman;"> 
    <h2>Kính gửi anh/chị !</h2> 
    <table style="width: 100%; font-size: 20px;font-family: Times New Roman;">
        <tr style="font-weight: bold;"> 
            <td>Anh/Chị có yêu cầu cần được phê duyệt từ hệ thống chữ ký điện tử THACO MAZDA</td> 
        </tr>     
        <tr style=""> 
            <td>Vui lòng nhấn theo đường dẫn bên dưới để duyệt phiếu yêu cầu:</td> 
        </tr> 
        <tr style="font-style: italic;"> 
            <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . createID() . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . createID() . "";
    $message .= '</a></td> 
        </tr>
        <br/>
        <br/>
        <br/>
        <tr style="color: red;font-style: italic;"> 
            <td>Đây là mail tự động, vui lòng không trả lời mail này.</td> 
        </tr> 
        <tr> 
            <td>Trân trọng cảm ơn.</td> 
        </tr> 
    </table> 
    <br/>
    ---------------------------
    
    <p style="font-size: 16px;margin:0px">THACO MAZDA</p>
    <p style="font-size: 16px;margin:0px">Thôn 4, Tam Hiệp, Núi Thành, Quảng Nam</p>
    
</body> 
</html>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . $from;
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql_td]);
    } else {
    echo json_encode(['result' => 'NG', 'code' => 200, 'query' => $sql_td]);
    }
}

//chèn user kế toán
if (isset($_POST['userketoan'])) {
    $userketoan = $_POST['userketoan'];


    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $nowtime = date('Y-m-d H:i:s');
    $sql_kt = "INSERT INTO `pheduyet`(`IDPhieu`, `IDNhanVien`, `DaDuyet`, `NgayDuyet`, `GhiChu`, MucDuyet) VALUES ('" . createID() . "', '" . $userketoan . "','','','','2')";
    $query_kt = mysqli_query($connect, $sql_kt);

    if(isset($query_kt)){
        echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql_kt]);
    }
    else{
        echo json_encode(['result' => 'NG', 'code' => 200, 'query' => $sql_kt]);
    }
    
}
if (isset($_POST['userduyet'])) {
    $userduyet = $_POST['userduyet'];
    $idme = $_SESSION["IDNhanVien"];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $nowtime = date('Y-m-d H:i:s');
    $sql_d = "INSERT INTO `pheduyet`(`IDPhieu`, `IDNhanVien`, `DaDuyet`, `NgayDuyet`, `GhiChu`, MucDuyet) VALUES ('" . createID() . "', '" . $userduyet . "','','','','3')";
    $query_d = mysqli_query($connect, $sql_d);
    if(isset($query_d)){
        echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql_d]);
    }
    else{
        echo json_encode(['result' => 'NG', 'code' => 200, 'query' => $sql_d]);
    }
    // date_default_timezone_set('Asia/Ho_Chi_Minh');
    // $nowtime = date('Y-m-d H:i:s');


    $sql1 = "INSERT into phieu(IDPhieu, IDLoaiPhieu, IDNhanVien, NgayTao, UuTien, TuChoi, Gui) VALUES ('" . createID() . "', 'P0002', '" . $idme . "', '" . $nowtime . "',0,0,1)";
    $query1 = mysqli_query($connect, $sql1);
    // if(isset($query1)){
    //     echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql1]);
    // }
    // elsE{
    //     echo json_encode(['result' => 'NG', 'code' => 200, 'query' => $sql1]);
    // }
    
}

if (isset($_POST['vattus'])) {
    $c = '';
    $idme = $_SESSION["IDNhanVien"];
    $bpme = $_SESSION["IDBoPhan"];
    $timeinsert = date('Y-m-d H:i:s');
    $vattu = $_POST['vattus'];

    foreach ($vattu as $row) {
        $setvattu = "SELECT * FROM vattu WHERE TenVatTu='" . $row["tenvattu"] . "'";
        $qr = mysqli_query($connect, $setvattu);
        $dong = mysqli_fetch_array($qr);
        $idvt = $dong["IDVatTu"];

        $sql = "INSERT INTO `yeucauvpp`(`IDPhieu`, `IDNhanVien`, `IDBoPhan`, `IDVatTu`, `SoLuong`, `HangMucSuDung`, `GhiChu`) VALUES ('" . createID() . "','" . $idme . "','" . $bpme . "','" . $idvt . "','" . $row["soluong"] . "','" . $row["hangmucsudung"] . "','" . $row["ghichu"] . "')";
        $query = mysqli_query($connect, $sql);
        
    }
    if(isset($query)){
        echo json_encode(['result' => 'OK1', 'code' => 200, 'query' => $sql]);
    }
    elsE{
        echo json_encode(['result' => 'NG', 'code' => 200, 'query' => $sql]);
    }
}

function checkAcr()
{

    require ("dbhelp.php");
    $sql = "select VietTat FROM loaiphieu where IDLoaiPhieu = 'P0002'";
    $query = mysqli_query($connect, $sql);
    $d1 = "";
    if (mysqli_num_rows($query) == 0) {
        $message = "Không có loại phiếu";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        while ($row = $query->fetch_assoc()) {
            $d1 = $row['VietTat'];
        }
    }
    return $d1;
}

function createID()
{

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $nowtime = date('ymd');
    $timeinsert = date('Y-m-d H:i:s');
    require ("dbhelp.php");
    $sql = "SELECT COUNT(IDPhieu) as ct FROM `phieu` WHERE IDPhieu like '" . checkAcr() . $nowtime . "%'";
    $query = mysqli_query($connect, $sql);
    $d1 = "0";
    if (mysqli_num_rows($query) == 0) {
        $d1 = checkAcr() . $nowtime . "001";
    } else {
        while ($row2 = $query->fetch_assoc()) {
            $d1 = checkAcr() . $nowtime . sprintf('%03d', $row2['ct'] + 1);
        }
    }
    return $d1;
}
?>