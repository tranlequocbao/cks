<?php 
require_once "dbhelp.php";    
//lấy tên viết tắt
if(isset($_POST["value"]))
{	
session_start();
$value = $_POST['value'];			
$thoigianra = $value['ra'];
$thoigianvao = $value['vao'];
$s=$value['idnguoitao'];
$nhanvienracong=$value['idmember'];
$biensoxe = $value['biensoxe'];
$mangtheo = $value['mt'];
$g = $value['gc'];
$lydoracong = $value['lydooff'];
$manvduyet1 = $value['idduyet1'];
$manvduyet2 = $value['idduyet2'];
 // khai báo lấy thời giàn hiền tại
$nowtime = date_create('now',timezone_open('Asia/Ho_Chi_Minh'));
$now = $nowtime ->format( 'Y-m-d' );
$now2 = $nowtime ->format( 'ymd' );
$now3 = $nowtime ->format('Y-m-d H:i:s');
$sql7="SELECT COUNT(IDPhieu) as ct FROM `phieu` WHERE IDLoaiPhieu='P0003' and date(NgayTao)='$now'";
$result7 = mysqli_query($connect,$sql7);
while ($row = mysqli_fetch_array($result7))
{
  $maphieu= 'PRC'.$now2.sprintf('%03d',$row['ct']+1);
} 
//Tạo phieu vao bang giayracong
$sql6 = "insert into giayracong(IDPhieu,IDNhanVienRaCong,OutTime,InTime,LyDo,BSXE,GhiChu,ChuY) values('$maphieu','$nhanvienracong','$thoigianra','$thoigianvao','$lydoracong','$biensoxe','$mangtheo','$g')";
mysqli_query($connect,$sql6);
//Tạo phieu vao bang phieu
$sql8 = "insert into phieu(IDPhieu, IDLoaiPhieu, IDNhanVien, NgayTao, UuTien, TuChoi, Gui) values('$maphieu','P0003','$s','$now3','0','0','0')";
mysqli_query($connect,$sql8);
//Tạo phieu trong bảng phê duyệt
$db = mysqli_connect('localhost', 'root', '', 'chukyso');
$kt = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE IDChucVu LIKE '%CV003%' AND IDNhanvien = '$nhanvienracong' ");
$dem= mysqli_num_rows ($kt);
if($dem != 0)
{
$sql9 = "insert into pheduyet (IDPhieu, IDNhanVien, DaDuyet, NgayDuyet, GhiChu, MucDuyet) values('$maphieu','$manvduyet1','1','$now3','','1')";
}
else
{
$sql9 = "insert into pheduyet (IDPhieu, IDNhanVien, DaDuyet, NgayDuyet, GhiChu, MucDuyet) values('$maphieu','$manvduyet1','','','','1')";
}
mysqli_query($connect,$sql9);
$sql10 = "insert into pheduyet (IDPhieu, IDNhanVien, DaDuyet, NgayDuyet, GhiChu, MucDuyet) values('$maphieu','$manvduyet2','','','','2')";
mysqli_query($connect,$sql10);

//Gửi mail cho QL tạo
$sqlnv="SELECT * FROM nhanvien WHERE IDNhanVien='".mysqli_real_escape_string($connect,$manvduyet1)."'";
$querynv=mysqli_query($connect,$sqlnv);
$roww=mysqli_fetch_assoc($querynv);
$emailtaoduyet=$roww["Email"];

$from="thacomazda-info@thaco.com.vn";
$to="$emailtaoduyet";
$subject="Bạn có yêu cầu cần duyệt";
$subject= "=?utf-8?b?".base64_encode($subject)."?=";   
$message=' 
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
            <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
            $message.=  "".$maphieu. "";
            $message.='">';
            $message.=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=". $maphieu . "";
            $message.='</a></td> 
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
$headers .= "From: ".$from; 
if(mail($to,$subject,$message,$headers))
{
    $message1 = 'Tạo và gửi mail cho cấp trên thành công.';
        echo "<SCRIPT>
            alert('$message1');
        </SCRIPT>"; 
}
else
{
    $message2 = 'Gửi mail cho cấp trên thất bại';
    echo "<SCRIPT>
        alert('$message2');
    </SCRIPT>"; 
}
}
    else
    echo json_encode(['code'=>201]);
