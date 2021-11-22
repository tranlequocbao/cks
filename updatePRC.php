<?php
require_once "dbhelp.php";
//mức duyệt 1 đồng ý
if (isset($_POST['value'])) {
    session_start();
    $value = $_POST['value'];
    $idphieu = $value['id'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '1' and pheduyet.IDPhieu ='".$value['id']."'" ;
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='1', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $idphieu . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);


    $sqld = "SELECT * FROM nhanvien,pheduyet WHERE pheduyet.IDNhanVien=nhanvien.IDNhanVien and pheduyet.MucDuyet=2 AND pheduyet.IDPhieu='" . $value['id'] . "'";
    $queryd = mysqli_query($connect, $sqld);
    $rowd = mysqli_fetch_assoc($queryd);
    $emailduyet = $rowd["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailduyet";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
    $message .=  "" . $value['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=" . $value['id'] . "";
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
        $message1 = 'Gửi mail cho cấp trên thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho cấp trên thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
} else echo json_encode(['code' => 201]);



//mức duyệt 2 đồng ý
if (isset($_POST['value1'])) {
    $value1 = $_POST['value1'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '2' and pheduyet.IDPhieu ='".$value1['id']."'" ;
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet2 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value1['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='1', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value1['id'] . "' and IDNhanVien = '$idduyet2'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);

    //Gửi mail cho QL duyệt khi thành công
    $sqlql = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=1 AND caidatmau.IDLoaiPhieu='P0003' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value1['id'] . "'";
    $queryql = mysqli_query($connect, $sqlql);
    $rowql = mysqli_fetch_assoc($queryql);
    $emailql = $rowql["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailql";
    $subject = "Kết quả phê duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
    <html> 
    <body style="font-size: 20px;font-family: Times New Roman;"> 
        <h2>Kính gửi anh/chị !</h2> 
        <table style="width: 100%; font-size: 20px;font-family: Times New Roman;">
            <tr style="font-weight: bold;"> 
                <td>Anh/Chị có yêu cầu đã được phê duyệt <span style="color:green">THÀNH CÔNG</span> từ hệ thống chữ ký điện tử THACO MAZDA</td> 
            </tr>     
           
            <tr style=""> 
                <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
    $message .=  "" . $value1['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=" . $value1['id'] . "";
    $message .= '</a></td> 
            </tr>
            <br/>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $nhanxet . "";
    $message .= '</a></td> 
            </tr>
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
        $message1 = 'Gửi mail cho cấp duyệt 1 thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho cấp duyệt 1 thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
    //Gửi mail về User tạo khi thành công
    $sqlt = "SELECT * FROM phieu, nhanvien, chucvu, bophan WHERE phieu.IDPhieu='" . $value1['id'] . "' AND phieu.IDNhanVien=nhanvien.IDNhanVien AND bophan.IDBoPhan=nhanvien.IDBoPhan AND chucvu.IDChucVu=nhanvien.IDChucVu";
    $queryt = mysqli_query($connect, $sqlt);
    $rowt = mysqli_fetch_assoc($queryt);
    $msnvtao = $rowt['IDNhanVien'];
    $cvtao = $rowt['TenChucVu'];
    $bptao = $rowt['TenBoPhan'];
    $hvttao = $rowt['HoTenNhanVien'];
    $emailtao = $rowt["Email"];

    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailtao";
    $subject = "Kết quả phê duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
    <html> 
    <body style="font-size: 20px;font-family: Times New Roman;"> 
        <h2>Kính gửi anh/chị !</h2> 
        <table style="width: 100%; font-size: 20px;font-family: Times New Roman;">
            <tr style="font-weight: bold;"> 
                <td>Anh/Chị có yêu cầu đã được phê duyệt <span style="color:green">THÀNH CÔNG</span> từ hệ thống chữ ký điện tử THACO MAZDA</td> 
            </tr>
            <tr style=""> 
                <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
    $message .=  "" . $value1['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=" . $value1['id'] . "";
    $message .= '</a></td> 
            </tr>
            <br/>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $nhanxet . "";
    $message .= '</a></td>
            </tr>
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
        $message1 = 'Gửi mail cho người tạo thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho người tạo thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }


    // Gửi mail cho bảo vệ khi thành công  thacomazda-baove@thaco.com.vn

    $emailbv = 'thacomazda-baove@thaco.com.vn';
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailbv";
    $subject = "Kết quả phê duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
    <html> 
    <body style="font-size: 20px;font-family: Times New Roman;"> 
        <h2>Kính gửi anh/chị !</h2> 
        <a style="font-weight: bold;">Có yêu cầu ra cổng đã được phê duyệt <span style="color:green">THÀNH CÔNG</span> từ hệ thống chữ ký điện tử THACO MAZDA</a>
        <table style="width: 100%; font-size: 20px;">
           
            <tr> 
                <td>Thông tin nhân viên ra cổng:</td> 
            </tr>

            <tr><td style="width:150px">MÃ PHIẾU:</td><td><a>';
    $message .=  "" . $value1['id'] . "";
    $message .= '</a></td> 
            </tr>
            <tr><td>MÃ SỐ NHÂN VIÊN:</td><td><a>';
    $message .=  "" . $msnvtao . "";
    $message .= '</a></td> 
            </tr>
            <tr><td>TÊN NHÂN VIÊN:</td><td><a>';
    $message .=  "" . $hvttao . "";
    $message .= '</a></td> 
            </tr>
            <tr><td>CHỨC VỤ:</td><td><a>';
    $message .=  "" . $cvtao . "";
    $message .= '</a></td> 
            </tr>
            <tr><td>BỘ PHẬN</td><td><a>';
    $message .=  "" . $bptao . "";
    $message .= '</a></td> 
            </tr>
            <br/>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $nhanxet . "";
    $message .= '</a></td>
            </tr>
            <br/>
            <tr style=""> 
                <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
    $message .=  "" . $value1['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=" . $value1['id'] . "";
    $message .= '</a></td> 
            </tr>
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
        $message1 = 'Gửi mail cho bảo vệ thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho bảo vệ thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
    //Mail cho các bộ phận khác
} else echo json_encode(['code' => 201]);





//mức duyệt 1 từ chối
if (isset($_POST['value2'])) {
    session_start();
    $value2 = $_POST['value2'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '1' and pheduyet.IDPhieu ='".$value2['id']."'" ;
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value2['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='0', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value2['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    $sql5 = "UPDATE phieu SET TuChoi = '1' where IDPhieu = '" . $value2['id'] . "' ";
    $query1 = mysqli_query($connect, $sql5);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query1' => $sql5]);
    //Gửi mai cho User tạo
    $sqlt = "SELECT * FROM phieu, nhanvien WHERE phieu.IDPhieu='" . $value2['id'] . "' AND phieu.IDNhanVien=nhanvien.IDNhanVien";
    $queryt = mysqli_query($connect, $sqlt);
    $rowt = mysqli_fetch_assoc($queryt);
    $emailtao = $rowt["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailtao";
    $subject = "Kết quả phê duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
    <html> 
    <body style="font-size: 20px;font-family: Times New Roman;"> 
        <h2>Kính gửi anh/chị !</h2> 
        <table style="width: 100%; font-size: 20px;font-family: Times New Roman;">
            <tr style="font-weight: bold;"> 
                <td>Yêu cầu của anh/chị <span style="color:red">KHÔNG ĐƯỢC</span> phê duyệt từ hệ thống chữ ký điện tử THACO MAZDA</td> 
            </tr>
            <tr style=""> 
                <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
    $message .=  "" . $value2['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=" . $value2['id'] . "";
    $message .= '</a></td> 
            </tr>
            <br/>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $nhanxet . "";
    $message .= '</a></td>
            </tr>
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
        $message1 = 'Gửi mail cho người tạo thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho cấp trên thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
} else echo json_encode(['code' => 201]);




//mức duyệt 2 từ chối
if (isset($_POST['value3'])) {
    session_start();
    $value3 = $_POST['value3'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '2' and pheduyet.IDPhieu ='".$value3['id']."'" ;
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet2 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value3['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='0', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value3['id'] . "' and IDNhanVien = '$idduyet2'";
    $query = mysqli_query($connect, $sql4);
    $sql5 = "UPDATE phieu SET TuChoi = '1' where IDPhieu = '" . $value3['id'] . "' ";
    $query1 = mysqli_query($connect, $sql5);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query1' => $sql5]);

    //mail cho QL tạo khi từ chối
    $sqlql = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=1 AND caidatmau.IDLoaiPhieu='P0003' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value3['id'] . "'";
    $queryql = mysqli_query($connect, $sqlql);
    $rowql = mysqli_fetch_assoc($queryql);
    $emailql = $rowql["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailql";
    $subject = "Kết quả phê duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
    <html> 
    <body style="font-size: 20px;font-family: Times New Roman;"> 
        <h2>Kính gửi anh/chị !</h2> 
        <table style="width: 100%; font-size: 20px;font-family: Times New Roman;">
            <tr style="font-weight: bold;"> 
                <td>Yêu cầu của anh/chị <span style="color:red">KHÔNG ĐƯỢC</span> phê duyệt từ hệ thống chữ ký điện tử THACO MAZDA</td> 
            </tr>     
            <tr style=""> 
            <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
        </tr> 
        <tr style="font-style: italic;"> 
            <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
    $message .=  "" . $value3['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=" . $value3['id'] . "";
    $message .= '</a></td> 
        </tr>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $nhanxet . "";
    $message .= '</a></td> 
            </tr>
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
        $message1 = 'Gửi mail cho cấp duyệt 1 thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho cấp duyệt 1 thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
    //mail cho người tạo khi từ chối
    $sqlt = "SELECT * FROM phieu, nhanvien WHERE phieu.IDPhieu='" . $value3['id'] . "' AND phieu.IDNhanVien=nhanvien.IDNhanVien";
    $queryt = mysqli_query($connect, $sqlt);
    $rowt = mysqli_fetch_assoc($queryt);
    $emailtao = $rowt["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailtao";
    $subject = "Kết quả phê duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
    <html> 
    <body style="font-size: 20px;font-family: Times New Roman;"> 
        <h2>Kính gửi anh/chị !</h2> 
        <table style="width: 100%; font-size: 20px;font-family: Times New Roman;">
            <tr style="font-weight: bold;"> 
                <td>Yêu cầu của anh/chị <span style="color:red">KHÔNG ĐƯỢC</span> phê duyệt từ hệ thống chữ ký điện tử THACO MAZDA</td> 
            </tr>
            <tr style=""> 
                <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
    $message .=  "" . $value3['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=" . $value3['id'] . "";
    $message .= '</a></td> 
            </tr>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $nhanxet . "";
    $message .= '</a></td>
            </tr>
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
        $message1 = 'Gửi mail cho người tạo thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho người tạo thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
} else echo json_encode(['code' => 201]);
