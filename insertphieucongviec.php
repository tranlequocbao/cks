<?php
require("dbhelp.php");
if(isset($_POST['value']))
{


    $value = $_POST['value'];
    
    // laythongtin = {idnguoitao, idbophantao, idbophan, noidung, md, tg, ghichu, idduyet1, idduyet3};
    $idme = $value['idnguoitao'];

    $nyc=$value['idbophan1'];
    
    $sqlnhanyeucau="SELECT * FROM `nhanvien` WHERE (IDBoPhan like '%".$nyc."%' and IDChucVu like '%CV003%') or (IDBoPhan like '%".$nyc."%' and IDChucVu like '%CV002%') order by nhanvien.IDChucVu desc limit 1";
        $query=mysqli_query($connect,$sqlnhanyeucau);
        $rownhanyeucau=mysqli_fetch_assoc($query);
        $idnhanyeucau=$rownhanyeucau['IDNhanVien'];

    $idduyet1 = $value['idduyet1'];     
    $idduyet3 = $value['idduyet3']; 
    $tght= $value['tg'];
    $ndcv=$value['ndcv'];
    $md=$value['mdcv'];
    $gc=$value['ghichu1'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $nowtime = date('Y-m-d H:i:s');
	
	$level=1;
    $names = [$idduyet1, $idnhanyeucau, $idduyet3];
    
	// tạo trong bảng riêng
    foreach($names as $value){
        $insert_pheduyet="INSERT INTO `pheduyet`(`IDPhieu`, `IDNhanVien`, `DaDuyet`, `NgayDuyet`, `GhiChu`, `MucDuyet`) VALUES ('" . createID() . "','".$value."','0','0','0','".$level."')";
        $query_insert_pheduyet = mysqli_query($connect, $insert_pheduyet);
        echo json_encode(['result'=>$insert_pheduyet]); 
        
        $level++;
    }
    
    
    $sql2="INSERT INTO `yeucaucongviec`(`IDPhieu`, `IDBoPhanNhanYeuCau`, `NgayHoanThanh`, `NoiDungCongViec`, `MucDich`, `GhiChu1`) VALUES ('".createID() ."','".$nyc."','".$tght."','".$ndcv."','".$md."','".$gc."')";
    $query2=mysqli_query($connect,$sql2);
    echo json_encode(['result1'=>$sql2]); 

    //tạo trong bản phiếu   
    
    $sqlnv="SELECT * FROM nhanvien WHERE IDNhanVien='".$idduyet1."'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
                $message.=  "". createID() . "";
                $message.='">';
                $message.=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=". createID() . "";
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
    


    $sql="INSERT INTO phieu(IDPhieu, IDLoaiPhieu, IDNhanVien, NgayTao, UuTien, TuChoi, Gui) VALUES ('".createID() ."','P0004','" . $idme . "','" . $nowtime . "',0,0,1)";
    $query=mysqli_query($connect,$sql);
    echo json_encode(['result2'=>$sql]); 
    if(mail($to,$subject,$message,$headers))
    {
         echo json_encode(['result'=>'OK','code'=>200]); 
    }
    else
    {
         echo json_encode(['result'=>'NG','code'=>200]); 
    }

}












function checkAcr()
    {
        require("dbhelp.php");
        $sql = "select VietTat FROM loaiphieu where IDLoaiPhieu = 'P0004'";
        $query=mysqli_query($connect,$sql);
        $d1="";
        if(mysqli_num_rows($query)==0)
        {
            $message = "Không có loại phiếu";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
            while ($row=$query->fetch_assoc()) {
                $d1 = $row['VietTat'];
            }
        }
        return $d1;
    }


    function createID(){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $nowtime = date('ymd');
        $timeinsert = date('Y-m-d H:i:s');
        require("dbhelp.php");
        $sql="SELECT COUNT(IDPhieu) as ct FROM `phieu` WHERE IDPhieu like '".checkAcr().$nowtime."%'";
        $query=mysqli_query($connect,$sql);
        $d1="0";
        if(mysqli_num_rows($query)==0)
        {
            $d1 = checkAcr().$nowtime."001";
        }
        else {
            while ($row2=$query->fetch_assoc())
            {
                $d1 = checkAcr().$nowtime.sprintf('%03d',$row2['ct']+1);
            }
        }
        return $d1;
    }
