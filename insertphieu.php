<?php
require("dbhelp.php");
if (isset($_POST['value'])) {
    session_start();

    //lấy tên viết tắt
    function checkAcr()
    {
        
        
        require("dbhelp.php");
        $sql = "select VietTat FROM loaiphieu where IDLoaiPhieu = 'P0001'";
        $query = mysqli_query($connect, $sql);
        $d1 = "";
        if (mysqli_num_rows($query) == 0) {
            $message = "Không có loại phiếu!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            while ($row = $query->fetch_assoc()) {
                $d1 = $row['VietTat'];
            }
        }
        return $d1;
    }
    //tạo id phiếu
    function createID()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $nowtime = date('ymd');
        //$timeinsert = date('Y-m-d H:i:s');
        require("dbhelp.php");
        $sql = "SELECT COUNT(IDPhieu) as ct FROM phieu WHERE IDPhieu like '" . checkAcr() . $nowtime . "%'";
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
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');
    $value = $_POST['value'];
    $idphieu = createID();
    $idnhanvientao = $value['idnguoitao'];
    $nghitu = $value['ngaynghi'];
    $nghiden = $value['nghiden'];
    $lydo = $value['lydooff'];
    $nhansubangiao = $value['nsbangiao'];
    $ghichu = $value['ghichu'];
    $nhanviennghi = $value['idmember'];
    $idduyet1 = $value['idduyet1'];
    $idduyet2 = $value['idduyet2'];
    $sql = "INSERT into phieu(IDPhieu, IDLoaiPhieu, IDNhanVien, NgayTao, UuTien, TuChoi, Gui) VALUES ('" . $idphieu . "', 'P0001', '" . $idnhanvientao . "', '" . $timeinsert . "',0,0,1)";
    $query = mysqli_query($connect, $sql);
    $sql2 = "INSERT INTO giayxinphep(IDPhieu, InTime, OutTime, LyDo, NhanVienThayThe, NhanVienNghi, Note,NguoiDuyet1, NguoiDuyet2) VALUES ('" . $idphieu . "', '" . $nghitu . "', '" . $nghiden . "', '" . $lydo . "', '" . $nhansubangiao . "','" . $nhanviennghi . "', '" . $ghichu . "','" . $idduyet1 . "','" . $idduyet2 . "')";
    $query = mysqli_query($connect, $sql2);
    $sql9 = "INSERT INTO pheduyet(IDPhieu, IDNhanVien, DaDuyet, NgayDuyet, GhiChu, MucDuyet) VALUES ('" . $idphieu . "','" . $idduyet1 . "','0','0','','1')";
    mysqli_query($connect, $sql9);
    $sql10 = "INSERT INTO pheduyet(IDPhieu, IDNhanVien, DaDuyet, NgayDuyet,GhiChu, MucDuyet) VALUES ('" . $idphieu . "','" . $idduyet2 . "','0','0','','2')";
    $query = mysqli_query($connect, $sql10);
    
    //echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql2]);
    //echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql9]);
    //echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql10]);

    $sqlnv = "SELECT * FROM nhanvien WHERE IDNhanVien='$idduyet1'";
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
            <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/DNP.php?p=DNP&id=';
    $message .=  "" . $idphieu . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/DNP.php?p=DNP&id=" . $idphieu . "";
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
    if(mail($to,$subject,$message,$headers))
    {
         echo json_encode(['result'=>'OK','code'=>200,'query'=>$sql]); 
    }
    else
    {
         echo json_encode(['result'=>'NG','code'=>200,'query'=>$sql]); 
    }
    // echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql]);
} else
    echo json_encode(['code' => 201]);
