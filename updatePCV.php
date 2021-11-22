<?php
require  ("dbhelp.php");

session_start();
if (isset($_POST['value'])) {
    $value = $_POST['value'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '1' and pheduyet.IDPhieu ='".$value['id']."'";
    // SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '1' and pheduyet.IDPhieu ='".$value['id']."'
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='1', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);

    //GỬI MAIL CHO BỘ PHẬN THỰC HIỆN YÊU CẦU
    $sqlbpth = "SELECT * FROM pheduyet,caidatmau,nhanvien where pheduyet.IDNhanVien=caidatmau.IDNhanVien and caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.IDLoaiPhieu='P0004' and caidatmau.MucDuyet='1' and IDPhieu='" . $value['id'] . "' AND pheduyet.MucDuyet='2'";
    $querybpth = mysqli_query($connect, $sqlbpth);
    $rowbpth = mysqli_fetch_assoc($querybpth);
    $emailbpth = $rowbpth["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailbpth";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value['id'] . "";
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
        $message1 = 'Gửi mail cho bộ phận thực hiện thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho bộ phận thực hiện thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
} else echo json_encode(['code' => 201]);


// muc duyet 2 dong y
if (isset($_POST['value1'])) {
    $value1 = $_POST['value1'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '2' and pheduyet.IDPhieu ='".$value1['id']."'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value1['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='1', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value1['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);

    //Gửi mail cho lãnh đạo duyệt
    $sqld = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=2 AND caidatmau.IDLoaiPhieu='P0001' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value1['id'] . "'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value1['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value1['id'] . "";
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








// mức duyệt 3 đồng ý
if (isset($_POST['value2'])) {
    $value2 = $_POST['value2'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '3' and pheduyet.IDPhieu ='".$value2['id']."'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value2['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='1', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value2['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);

    //Gửi mail cho người tạo khi thành công
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
                <td>Anh/Chị có yêu cầu đã được phê duyệt <span style="color:green">THÀNH CÔNG</span> từ hệ thống chữ ký điện tử THACO MAZDA</td> 
            </tr>     
            <tr style=""> 
                <td>Vui lòng nhấn theo đường dẫn bên dưới để duyệt phiếu yêu cầu:</td> 
            </tr> 
            <tr style=""> 
                <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value2['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value2['id'] . "";
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

    //Gửi mail cho QL tạo
    $sqlql = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=1 AND caidatmau.IDLoaiPhieu='P0002' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value2['id'] . "'";
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
            <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value2['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value2['id'] . "";
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
        $message2 = 'Gửi mail cho cấp trên thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }

    //Gửi cho QL thực hiện
    $sqlbpth = "SELECT * FROM pheduyet,caidatmau,nhanvien where pheduyet.IDNhanVien=caidatmau.IDNhanVien and caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.IDLoaiPhieu='P0004' and caidatmau.MucDuyet='1' and IDPhieu='" . $value2['id'] . "' AND pheduyet.MucDuyet='2'";
    $querybpth = mysqli_query($connect, $sqlbpth);
    $rowbpth = mysqli_fetch_assoc($querybpth);
    $emailbpth = $rowbpth["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailbpth";
    $subject = "Bạn có yêu cầu cần duyệt";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value2['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value2['id'] . "";
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
        $message1 = 'Gửi mail cho bộ phận thực hiện thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho bộ phận thực hiện thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
} else echo json_encode(['code' => 201]);

//mức duyệt 1 từ chối
if (isset($_POST['value3'])) {
    $value3 = $_POST['value3'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '1' and pheduyet.IDPhieu ='".$value3['id']."'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value3['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='0', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value3['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);

    //Gửi mail cho người tạo khi thất bại
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value3['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value3['id'] . "";
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
if (isset($_POST['value4'])) {
    $value4 = $_POST['value4'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '2' and pheduyet.IDPhieu ='".$value4['id']."'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value4['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='0', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value4['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);

    // mail cho người tạo khi thất bại 
    $sqlt = "SELECT * FROM phieu, nhanvien WHERE phieu.IDPhieu='" . $value4['id'] . "' AND phieu.IDNhanVien=nhanvien.IDNhanVien";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value4['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value4['id'] . "";
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

    // mail cho QL Tạo khi thất bại
    $sqlql = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=1 AND caidatmau.IDLoaiPhieu='P0002' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value4['id'] . "'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value4['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value4['id'] . "";
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
        $message1 = 'Gửi mail cho QL tạo thành công.';
        echo "<SCRIPT>
            alert('$message1');
        </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho QL tạo thất bại';
        echo "<SCRIPT>
        alert('$message2');
    </SCRIPT>";
    }
} else echo json_encode(['code' => 201]);

//mức duyệt 3 từ chối
if (isset($_POST['value5'])) {
    $value5 = $_POST['value5'];
    // $con = mysqli_connect("localhost","root","","chukyso");
    $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '3' and pheduyet.IDPhieu ='".$value5['id']."'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value5['nhanxet'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='0', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value5['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);


    // mail cho người tạo khi thất bại 
    $sqlt = "SELECT * FROM phieu, nhanvien WHERE phieu.IDPhieu='" . $value5['id'] . "' AND phieu.IDNhanVien=nhanvien.IDNhanVien";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value5['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value5['id'] . "";
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

    // mail cho QL Tạo khi thất bại
    $sqlql = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=1 AND caidatmau.IDLoaiPhieu='P0002' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value5['id'] . "'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value5['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value5['id'] . "";
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
        $message1 = 'Gửi mail cho QL tạo thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho QL tạo thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }

    $sqlbpth = "SELECT * FROM pheduyet,caidatmau,nhanvien where pheduyet.IDNhanVien=caidatmau.IDNhanVien and caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.IDLoaiPhieu='P0004' and caidatmau.MucDuyet='1' and IDPhieu='" . $value5['id'] . "' AND pheduyet.MucDuyet='2'";
    $querybpth = mysqli_query($connect, $sqlbpth);
    $rowbpth = mysqli_fetch_assoc($querybpth);
    $emailbpth = $rowbpth["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailbpth";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=';
    $message .=  "" . $value5['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PCV.php?p=PCV&id=" . $value5['id'] . "";
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
        $message1 = 'Gửi mail cho bộ phận thực hiện thành công.';
        echo "<SCRIPT>
                alert('$message1');
            </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho bộ phận thực hiện thất bại';
        echo "<SCRIPT>
            alert('$message2');
        </SCRIPT>";
    }
} else echo json_encode(['code' => 201]);
