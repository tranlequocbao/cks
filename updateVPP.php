<?php
session_start();
require("dbhelp.php");

if (isset($_POST['value1'])) {
    require("dbhelp.php");
    $value = $_POST['value1'];
    //mail cho kế toán
    $sqlkt = "SELECT * FROM nhanvien,pheduyet WHERE pheduyet.MucDuyet=2 AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value['id'] . "'";
    $querykt = mysqli_query($connect, $sqlkt);
    $rowkt = mysqli_fetch_assoc($querykt);
    $emailketoan = $rowkt["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailketoan";
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
            <tr style="font-style: italic"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value['id'] . "";
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

    $sql1 = "SELECT * FROM pheduyet where pheduyet.MucDuyet=1 and pheduyet.IDPhieu='" . $value['id'] . "'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idtaoduyet = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');
    $ghichu = $value['ghichu'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='1', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $ghichu . "' WHERE IDPhieu = '" . $value['id'] . "' and IDNhanVien = '$idtaoduyet'";
    $query = mysqli_query($connect, $sql4);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);
} else echo json_encode(['code' => 201]);




if (isset($_POST['value2'])) {
    require("dbhelp.php");
    $value = $_POST['value2'];


    //mail cho người phê duyệt
    $sqld = "SELECT * FROM nhanvien,pheduyet WHERE pheduyet.MucDuyet=3 AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value['id'] . "'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value['id'] . "";
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

    $sql2 = "SELECT * FROM pheduyet where pheduyet.MucDuyet=2 and pheduyet.IDPhieu='" . $value['id'] . "'";
    $result2 = mysqli_query($connect, $sql2);
    $row2 = mysqli_fetch_array($result2);
    $idketoan = $row2['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert2 = date('Y-m-d H:i:s');
    $ghichu = $value['ghichu'];
    $sql5 = "UPDATE pheduyet SET DaDuyet ='1', NgayDuyet ='" . $timeinsert2 . "', GhiChu ='" . $ghichu . "' WHERE IDPhieu = '" . $value['id'] . "' and IDNhanVien = '$idketoan'";
    $query5 = mysqli_query($connect, $sql5);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query5' => $sql5]);
} else echo json_encode(['code' => 201]);




if (isset($_POST['value3'])) {
    require("dbhelp.php");
    $value = $_POST['value3'];
    $sql3 = "SELECT * FROM pheduyet where pheduyet.MucDuyet=3 and pheduyet.IDPhieu='" . $value['id'] . "'";
    $result3 = mysqli_query($connect, $sql3);
    $row3 = mysqli_fetch_array($result3);
    $idduyet = $row3['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert3 = date('Y-m-d H:i:s');
    $ghichu = $value['ghichu'];
    $sql6 = "UPDATE pheduyet SET DaDuyet ='1', NgayDuyet ='" . $timeinsert3 . "', GhiChu ='" . $ghichu . "' WHERE IDPhieu = '" . $value['id'] . "' and IDNhanVien = '$idduyet'";
    $query6 = mysqli_query($connect, $sql6);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query6' => $sql6]);



    //mail cho quản lý tạo khi thành công 
    $sqlql = "SELECT * FROM pheduyet where pheduyet.MucDuyet=1 and pheduyet.IDPhieu='" . $value['id'] . "'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value['id'] . "";
    $message .= '</a></td> 
            </tr>
            <br/>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $ghichu . "";
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

    //mail cho Hành chính kho  khi THÀNH CÔNG
    $sqlhck = "SELECT * FROM `nhanvien` WHERE IDChucVu='CV001' AND IDBoPhan='D0005'";
    $queryhck = mysqli_query($connect, $sqlhck);
    $rowhck = mysqli_fetch_assoc($queryhck);
    $emailhck = $rowhck["Email"];
    $from = "thacomazda-info@thaco.com.vn";
    $to = "$emailhck";
    $subject = "Kết quả phê duyệt";
    $subject = "=?utf-8?b?" . base64_encode($subject) . "?=";
    $message = ' 
    <html> 
    <body style="font-size: 20px;font-family: Times New Roman;"> 
        <h2>Kính gửi anh/chị !</h2> 
        <table style="width: 100%; font-size: 20px;font-family: Times New Roman;">
            <tr style="font-weight: bold;"> 
                <td>Có yêu cầu cấp vật tư VPP đã được phê duyệt <span style="color:green">THÀNH CÔNG</span> từ hệ thống chữ ký điện tử THACO MAZDA</td> 
            </tr>     
            <tr style=""> 
                <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value['id'] . "";
    $message .= '</a></td> 
            </tr>
            <br/>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $ghichu . "";
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

    //mail cho người tạo khi thành công
    $sqlt = "SELECT * FROM phieu, nhanvien WHERE phieu.IDPhieu='" . $value['id'] . "' AND phieu.IDNhanVien=nhanvien.IDNhanVien";
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
                <td>Vui lòng nhấn theo đường dẫn bên dưới để xem chi tiết phiếu yêu cầu:</td> 
            </tr> 
            <tr style="font-style: italic;"> 
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value['id'] . "";
    $message .= '</a></td> 
            </tr>
            <br/>
            <tr style="font-style: italic;"><td><a>';
    $message .= "Ghi chú: ";
    $message .=  "" . $ghichu . "";
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
    //Mail cho các bộ phận khác

} else echo json_encode(['code' => 201]);






//mức duyệt 1 từ chối
if (isset($_POST['value4'])) {
    $value4 = $_POST['value4'];
    require("dbhelp.php");
    $sql1 = "SELECT * FROM pheduyet where pheduyet.MucDuyet=1 and pheduyet.IDPhieu='" . $value4['id'] . "'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value4['ghichu'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='0', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value4['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    $sql5 = "UPDATE phieu SET TuChoi = '1' where IDPhieu = '" . $value4['id'] . "' ";
    $query1 = mysqli_query($connect, $sql5);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query1' => $sql5]);


    // mail cho người tạo khi từ chối
    $sqlt = "SELECT * FROM phieu, nhanvien WHERE phieu.IDPhieu='".$value4['id']."' AND phieu.IDNhanVien=nhanvien.IDNhanVien";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value4['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value4['id'] . "";
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
if (isset($_POST['value5'])) {
    $value5 = $_POST['value5'];
    require("dbhelp.php");
    $sql1 = "SELECT * FROM pheduyet where pheduyet.MucDuyet=2 and pheduyet.IDPhieu='" . $value5['id'] . "'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet2 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value5['ghichu'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='0', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value5['id'] . "' and IDNhanVien = '$idduyet2'";
    $query = mysqli_query($connect, $sql4);
    $sql5 = "UPDATE phieu SET TuChoi = '1' where IDPhieu = '" . $value5['id'] . "' ";
    $query1 = mysqli_query($connect, $sql5);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query1' => $sql5]);

    // mail cho người tạo khi thất bại 
    $sqlt = "SELECT * FROM nhanvien,pheduyet WHERE pheduyet.MucDuyet=1 AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value5['id'] . "'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value5['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value5['id'] . "";
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
    $sqlql = "SELECT * FROM pheduyet where pheduyet.MucDuyet=1 and pheduyet.IDPhieu='" . $value5['id'] . "'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value5['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value5['id'] . "";
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
if (isset($_POST['value6'])) {
    $value6 = $_POST['value6'];
    require("dbhelp.php");
    $sql1 = "SELECT * FROM pheduyet where pheduyet.MucDuyet=3 and pheduyet.IDPhieu='" . $value6['id'] . "'";
    $result1 = mysqli_query($connect, $sql1);
    $row1 = mysqli_fetch_array($result1);
    $idduyet1 = $row1['IDNhanVien'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $timeinsert = date('Y-m-d H:i:s');

    $nhanxet = $value6['ghichu'];
    $sql4 = "UPDATE pheduyet SET DaDuyet ='0', NgayDuyet ='" . $timeinsert . "', GhiChu ='" . $nhanxet . "' WHERE IDPhieu = '" . $value6['id'] . "' and IDNhanVien = '$idduyet1'";
    $query = mysqli_query($connect, $sql4);
    $sql5 = "UPDATE phieu SET TuChoi = '1' where IDPhieu = '" . $value6['id'] . "' ";
    $query1 = mysqli_query($connect, $sql5);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query' => $sql4]);
    echo json_encode(['result' => 'OK', 'code' => 200, 'query1' => $sql5]);

    // mail cho người tạo khi thất bại 
    $sqlt = "SELECT * FROM phieu, nhanvien WHERE phieu.IDPhieu='" . $value6['id'] . "' AND phieu.IDNhanVien=nhanvien.IDNhanVien";
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
        <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value6['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value6['id'] . "";
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
    $sqlql = "SELECT * FROM nhanvien,pheduyet WHERE pheduyet.MucDuyet=1 AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $value6['id'] . "'";
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
                <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=';
    $message .=  "" . $value6['id'] . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/VPP.php?p=VPP&id=" . $value6['id'] . "";
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
