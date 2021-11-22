<?php
session_start();
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
require_once "dbhelp.php";
$idbophan = $_SESSION['IDBoPhan'];
$ID = $_SESSION["IDNhanVien"];
$sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query1 = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_array($query1);

if (isset($_GET["nhap"]) && !empty($_GET["nhap"])) {
    $s = $_GET["nhap"];
    $sql = "SELECT * FROM `nhanvien`,chucvu,bophan WHERE nhanvien.IDChucVu=chucvu.IDChucVu and nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and nhanvien.IDNhanVien='$s' and bophan.IDBoPhan='$idbophan'";
} else {
    $s = $_SESSION["IDNhanVien"];
    $sql = "SELECT * FROM `nhanvien`,chucvu,bophan WHERE nhanvien.IDChucVu=chucvu.IDChucVu and nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and nhanvien.IDNhanVien='$s' and bophan.IDBoPhan='$idbophan'";
}
$result = mysqli_query($connect, $sql);
while ($row = mysqli_fetch_array($result)) {
    $maPB = $row['IDBoPhan'];
    $tenNV = $row['HoTenNhanVien'];
    $tenPB = $row['TenBoPhan'];
    $tenCV = $row['TenChucVu'];
    $maCV = $row['IDChucVu'];
    $maNV = $row['IDNhanVien'];
    $maNM = $row['IDNhaMay'];
}
/// lấy tên quản lý 
$sql2 = "SELECT * FROM `nhanvien`,bophan WHERE (nhanvien.IDBoPhan=bophan.IDBoPhan and nhanvien.IDBoPhan='$maPB' and nhanvien.IDChucVu like 'CV003%')OR(nhanvien.IDBoPhan=bophan.IDBoPhan and nhanvien.IDBoPhan='$maPB' and nhanvien.IDChucVu like 'CV002%')";
$result2 = mysqli_query($connect, $sql2);
// lấy tên duyệt 
$sql4 = "SELECT * FROM `nhanvien`,bophan WHERE (nhanvien.IDBoPhan=bophan.IDBoPhan and bophan.IDNhaMay='$maNM' and nhanvien.IDChucVu like 'CV005')OR(nhanvien.IDBoPhan=bophan.IDBoPhan and bophan.IDNhaMay='$maNM' and nhanvien.IDChucVu like 'CV007')";
$result4 = mysqli_query($connect, $sql4);
// tạo phiếu
if (isset($_POST["send"])) {
    $thoigianra = mysqli_escape_string($connect, $_POST["thoigianra"]);
    $thoigianvao = mysqli_escape_string($connect, $_POST["thoigianvao"]);
    $biensoxe = mysqli_escape_string($connect, $_POST["biensoxe"]);
    $mangtheo = mysqli_escape_string($connect, $_POST["mangtheo"]);
    $lydoracong = mysqli_escape_string($connect, $_POST["lydoracong"]);
    $manvduyet1 = $_POST["duyet1"];
    $manvduyet2 = $_POST["duyet2"];
    // khai báo lấy thời giàn hiền tại
    $nowtime = date_create('now', timezone_open('Asia/Ho_Chi_Minh'));
    $now = $nowtime->format('Y-m-d');
    $now2 = $nowtime->format('ymd');
    $now3 = $nowtime->format('Y-m-d H:i:s');
    $sql7 = "SELECT COUNT(IDPhieu) as ct FROM `phieu` WHERE IDLoaiPhieu='P0003' and date(NgayTao)='$now'";
    $result7 = mysqli_query($connect, $sql7);
    while ($row = mysqli_fetch_array($result7)) {
        $maphieu = 'PRC' . $now2 . sprintf('%03d', $row['ct'] + 1);
    }
    //Tạo phieu vao bang giayracong
    $sql6 = "insert into giayracong(IDPhieu,OutTime,InTime,LyDo,BSXE,GhiChu) values('$maphieu','$thoigianra','$thoigianvao','$lydoracong','$biensoxe','$mangtheo')";
    mysqli_query($connect, $sql6);
    //Tạo phieu vao bang phieu
    $sql8 = "insert into phieu(IDPhieu, IDLoaiPhieu, IDNhanVien, NgayTao, UuTien, TuChoi, Gui) values('$maphieu','P0003','$s','$now3','0','0','0')";
    mysqli_query($connect, $sql8);
    //Tạo phieu trong bảng phê duyệt
    $sql9 = "insert into pheduyet (IDPhieu, IDNhanVien, DaDuyet, NgayDuyet, GhiChu) values('$maphieu','" . mysqli_real_escape_string($connect, $manvduyet1) . "','','','')";
    mysqli_query($connect, $sql9);
    $sql10 = "insert into pheduyet (IDPhieu, IDNhanVien, DaDuyet, NgayDuyet, GhiChu) values('$maphieu','" . mysqli_real_escape_string($connect, $manvduyet2) . "','','','')";
    mysqli_query($connect, $sql10);

    //Gửi mail cho QL tạo
    $sqlnv = "SELECT * FROM nhanvien WHERE IDNhanVien='" . mysqli_real_escape_string($connect, $manvduyet1) . "'";
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
                    <td><a href="http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=';
    $message .=  "" . $maphieu . "";
    $message .= '">';
    $message .=  "http://113.174.246.52:8080/Thacomazda-CKDT/PRC.php?p=PRC&id=" . $maphieu . "";
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
        $message1 = 'Tạo và gửi mail cho cấp trên thành công.';
        echo "<SCRIPT>
                    alert('$message1');
                </SCRIPT>";
    } else {
        $message2 = 'Gửi mail cho cấp trên thất bại';
        echo "<SCRIPT>
                alert('$message2');
            </SCRIPT>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Phần mềm chữ ký số Thaco Mazda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="css/phieuracong.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <link href="Style/display.css" rel="stylesheet" />
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>

<body>

    <?php
    require "display/header.php";
    ?>
    <?php
    require "display/footer.php";
    ?>
    <div id="ttc">
        <div id="title">
            GIẤY RA CỔNG
        </div>
<div style="padding: 20px;">
        <form action="" method="get">
            <p style="margin-top: 16px;">
                <label for="fname" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Mã nhân viên : </label>
                <?php  $chucvu = $_SESSION['IDChucVu'];
                        if ($chucvu == "CV008")
                        { ?>
                            <input class="textbox" name="nhap" id="idmember" value="<?php echo $maNV; ?>" type="text2" disabled = "">
                        <?php } 
                        else {
                        ?>
                        <input class="textbox" name="nhap" id="idmember" value="<?php echo $maNV; ?>" type="text2">
                        <?php } ?>
               
            </p>
        </form>
        <p style="margin-top: 16px;">
            <label for="fname" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Tên nhân viên : </label>
            <input class="textbox" id="namemember" name="tennhanvien" value="<?php echo $tenNV ?>" type="text2" disabled="">

        </p>
        <p style="margin-top: 16px;">
            <label for="fname" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Bộ phận : </label>
            <input class="textbox" id="namedept" name="tennhanvien" value="<?php echo $tenPB ?>" type="text2" disabled="">

        </p>
        <p style="margin-top: 16px;">
            <label for="fname" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Chức vụ : </label>
            <input class="textbox" id="namecv" name="tennhanvien" value="<?php echo $tenCV ?>" type="text2" required="" disabled="">
        </p>

        <form action="" method="post">
            <div id="bttime">
                <div class='outtime' id='datetimepicker1'>
                    <p style="margin-top: 16px;">
                        <label for="fname" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Thời gian ra cổng: <span style="color:red">*</span></label>
                        <input id="nghitu" name=" thoigianra" required="" type="datetime-local" style="text-align: left;" value="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                                                    echo date('Y-m-d\TH:i'); ?>" min="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                                                                                        echo date('Y-m-d\TH:i'); ?>">
                    </p>
                </div>
                <div class='outtime' id='datetimepicker1'>
                    <p style="margin-top: 16px;">
                        <label for="fname" style="margin-top: 10px; margin-bottom: 10px;font-weight: bold;">Thời gian vào cổng:</label>
                        <input id="nghiden" name="thoigianvao" value="" type="datetime-local" style="text-align: left; ">
                    </p>
                </div>
            </div>
            <p style="margin-top: 16px;">
                <label for="fname" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Biển số xe : </label>
                <input type="text2" id="bsx" name="biensoxe" placeholder="(Nếu có)">
            </p>
            <p style="margin-top: 16px;">
                <label for="fname" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Mang theo: </label>
                <input type="text2" id="mangtheo" name="mangtheo" placeholder="(Nếu có)">
            </p>
            <p style="margin-top: 16px;">
                <label for="fname" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Ghi chú: </label>
                <input type="text2" id="ghichu" name="ghichu" placeholder="(Nếu có)">
            </p>
            <p style="margin-top: 16px;">
                <label for="country" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Lý do ra cổng:<span style="color:red">*</span></label>
                <input type="text2" id="lydo" name="lydoracong" required="" placeholder="Lý do">
            </p>
            <p style="margin-top: 16px;">
                <label for="country" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Xem xét:</label>
                <select id="nguoiduyet1" name="duyet1" type="text2">
                <?php
                            // $bophan = $_SESSION['IDBoPhan'];
                            // $idchucvu = $_SESSION['IDChucVu'];
                            $db = mysqli_connect('localhost', 'root', '', 'chukyso');
                            $kt = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE (IDChucVu LIKE '%CV002%' AND IDNhanvien = '$maNV') or (IDChucVu LIKE '%CV003%' AND IDNhanvien = '$maNV') ");
                            $dem= mysqli_num_rows ($kt);
                            if($dem != 0)
                            {
                                $bp = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE IDChucVu LIKE '%CV003%' AND IDBoPhan like '%$maPB%'")
                                or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                            }
                            else 
                            {
                            $bp = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE (IDChucVu LIKE '%CV002%' AND IDBoPhan like '%$maPB%') OR (IDChucVu LIKE '%CV003%' AND IDBoPhan like '%$maPB%')")
                            or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                            }
                            while ($row = mysqli_fetch_assoc($bp)) {
                            ?>
                                <option value="<?php echo $row["IDNhanVien"] . "-" . $row["HoTenNhanVien"]; ?>"> <?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                            <?php
                            } 
                            ?>
                </select>
            </p>
            <p style="margin-top: 16px;">
                <label for="country" style="margin-top: 10px;margin-bottom: 10px;font-weight: bold;">Phê duyệt:</label>
                <select id="nguoiduyet2" name="duyet2" type="text2">
                <?php
                            $db = mysqli_connect('localhost', 'root', '', 'chukyso');
                            $bp = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE IDChucVu='CV005' OR IDChucVu='CV007' ORDER BY IDChucVu ASC")
                                or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                            while ($row = mysqli_fetch_assoc($bp)) {
                            ?>
                                <option value="<?php echo $row["IDNhanVien"] . "-" . $row["HoTenNhanVien"]; ?>"><?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                            <?php
                            } 
                            ?>
                </select>
            </p>
            <input type="submit2" name="taophieu" id="button_modal" value="TẠO PHIẾU" style="justify-content: center; text-align:center">
        </form>
        </div>
        <!-- <confirm -->
        <div id="id03" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
            <div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0; width: 45%; height: auto; padding-bottom: 2%; padding-top: 0.5%;">
                <div class="w3-container">
                    <div style="width: 90%; height: auto; margin-left:auto;margin-right:auto">
                        <table style='width: -webkit-fill-available;'>
                            <tr>
                                <th style="text-align: left; width:40%">
                                    <!-- <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 200px; height: 40px;" /> -->
                                    <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 200px; height: 40px;" />
                                </th>
                                <th style="text-align: center;">
                                    CÔNG TY TNHH MTV SẢN XUẤT
                                    <br>
                                    Ô TÔ THACO MAZDA
                                    <br>
                                </th>
                            </tr>
                        </table>
                        <br>

                        <div class="title" style="font-weight: bold;font-size: 22px;text-align: center;">
                            GIẤY RA CỔNG
                        </div>
                        <br>
                        <div>
                            <table ">
      <tr>
              <td style=" font-weight: bold;">
                                <p style="margin: 3px;">Họ tên:</p>
                                </td>
                                <td><span id="tennv"> </span> </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">MSNV: </p>
                                    </td>
                                    <td><span id="manv"> </span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">Phòng/Ban: </p>
                                    </td>
                                    <td><span id="tenphongban"> </span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">Chức vụ:</p>
                                    </td>
                                    <td> <span id="tencv"> </span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">Biển số xe:</p>
                                    </td>
                                    <td><span id="BSX"> </span> </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">Lý do ra cổng:</p>
                                    </td>
                                    <td><span id="lydonghi"> </span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">Có mang theo:</p>
                                    </td>
                                    <td><span id="mtheo"> </span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">Ghi chú:</p>
                                    </td>
                                    <td><span id="gchu"> </span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">Ra lúc:</p>
                                    </td>
                                    <!-- <td><span id="tugio"> </span> giờ <span id="tuphut"></span> phút, ngày <span id="tungay"> </span> tháng <span id="tuthang"> </span> năm <span id="tunam"> </span>.</td> -->
                                    <td><span id="raluc"></span></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">
                                        <p style="margin: 3px;">Vào lại (nếu có):</p>
                                    </td>
                                    <td><span id="vaoluc"></span></td>
                                    <!-- <td><span id="dengio">  giờ </span><span id="denphut">phút, ngày </span>  <span id="denngay"> </span> tháng <span id="denthang"> </span> năm <span id="dennam"> </span>.</td> -->
                                </tr>
                            </table>
                            <div style=" text-align:right;font-style: italic; ">Núi Thành, Ngày <span id="date"></span> tháng <span id="month"> </span> năm <span id="year"> </span> </div>
                            <br />

                            <table style="border: none;margin: auto;">
                                <tr>
                                    <td style="width: 20%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Phê duyệt</td>
                                    <td style="width: 20%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Xem xét</td>
                                </tr>
                                <tr>
                                    <td style="border: none;text-align: center;font-weight: bold;"><span id="pheduyet"></span> </td>
                                    <td style="border: none;text-align: center;font-weight: bold;"><span id="xemxet"></span></td>
                                </tr>
                            </table>
                            <br>
                            <div style="text-align: center" id="duoi">
                                <input style="text-align: center; width: 160px;background-color: red;border-color: red; " type="button" id="button" onclick="document.getElementById('id03').style.display='none'" value='QUAY LẠI' class="btn btn-primary"></input>
                                <input style="text-align: center; width: 160px;background-color: green;border-color: green;" type="button" id="button_save"  value='XÁC NHẬN' class="btn btn-primary" ></input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <script>
                var ngduyet = '';
                $(document).ready(function() {
                    $("#button_modal").click(function() {
                        idmember = $('#idmember').val();
                        $('#manv').text(idmember);
                        var namemember = $('#namemember').val();
                        $('#tennv').text(namemember);
                        var namedept = $('#namedept').val();
                        $('#tenphongban').text(namedept);
                        var namecv = $('#namecv').val();
                        $('#tencv').text(namecv);
                        biensoxe = $('#bsx').val();
                        $('#BSX').text(biensoxe);
                        mt = $('#mangtheo').val();
                        $('#mtheo').text(mt);
                        gc = $('#ghichu').val();
                        $('#gchu').text(gc);

                        ra = $('#nghitu').val();
                        var TGra = new Date(ra).toLocaleString('en-GB');
                        
                        ngaynghi = $('#nghitu').val();
                        var ngay_arry = ngaynghi.split("-");
                        var nam = ngay_arry[0];
                        var thang = ngay_arry[1];
                        var ngay_arry = ngay_arry[2].split("T");
                        var ngay = ngay_arry[0];
                        var gio_ary = ngay_arry[1].split(":");
                        var gio = gio_ary[0];
                        var phut = gio_ary[1];
                        $('#raluc').text(gio +' giờ '+phut+' phút, ngày '+ ngay+' tháng '+ thang+' năm '+nam);

                        vao = $('#nghiden').val();
                        var TGvao = new Date(vao).toLocaleString('en-GB');                    
                        

                        if (vao == '') {
                            $('#vaoluc').text('Không xác định');
                        } 
                        else 
                        {
                            nghiden = $('#nghiden').val();
                            var nghiden_arry = nghiden.split("-");
                            var dennam = nghiden_arry[0];
                            var denthang = nghiden_arry[1];
                            var ngaygio_arry = nghiden_arry[2].split("T");
                            var denngay = ngaygio_arry[0];
                            var giophut_arry = ngaygio_arry[1].split(":");
                            var dengio = giophut_arry[0];
                            var denphut = giophut_arry[1];
                            $('#vaoluc').text(dengio +' giờ '+denphut+' phút, ngày '+ denngay+' tháng '+ denthang+' năm '+dennam);
                        }
                        var todate = new Date();

                        // var todate = new Date();
                        var date = todate.getDate();
                        $('#date').text(date);
                        var month = todate.getMonth() + 1;
                        $('#month').text(month);
                        var year = todate.getFullYear();
                        $('#year').text(year);

                        lydooff = $('#lydo').val();
                        $('#lydonghi').text(lydooff);
                        var arry_nguoiduyet1 = $('#nguoiduyet1').val().split("-");
                        idduyet1 = arry_nguoiduyet1[0];
                        var nguoiduyet1 = arry_nguoiduyet1[1];
                        $('#xemxet').text(nguoiduyet1);
                        var arry_nguoiduyet2 = $('#nguoiduyet2').val().split("-");
                        var nguoiduyet2 = arry_nguoiduyet2[1];
                        idduyet2 = arry_nguoiduyet2[0];
                        $('#pheduyet').text(nguoiduyet2);
                        var nguoitao = <?php echo json_encode($_SESSION['HoTenNhanVien']); ?>;
                        idnguoitao = <?php echo json_encode($_SESSION['IDNhanVien']); ?>;
                        $('#nguoitao').text(nguoitao);
                        // so sanh thời gian ra vào cổng

                        var date1 = new Date(ra).getTime();
                        var date2 = new Date(vao).getTime();
                        var date3 = new Date().getTime();

                        var diff = date2 - date1;
                        var diff2 = date1 - date3;
                        var mins = Math.floor(diff / (1000 * 60));
                        var mins2 = Math.floor(diff2 / (1000 * 60));

                        if(idmember == '')
                        {
                            alert("Vui lòng nhập mã số nhân viên!");
                                document.getElementById('idmember').value = '';
                        }
                        else{
                        if (ra =='') 
                        {
                            alert("Vui lòng nhập thời gian ra cổng!");
                        } 
                        if (mins2 < -2) 
                        {
                            alert("Thời gian ra cổng không được trước thời gian hiện tại!");
                        } 
                        else 
                        {
                            if(vao=='' || mins > 2) 
                                {
                                    if (lydooff == '') {
                                        alert("Vui lòng nhập lý do ra cổng!");
                                    } else {

                                        $('#id03').css('display', 'block');
                                    }
                                }
                            else
                                {alert("Thời gian vào cổng phải sau thời gian ra cổng!");}
                        }}
                    });
                    $('#button_save').click(function() {
                        var result = {
                            idnguoitao,
                            ra,
                            vao,
                            lydooff,
                            biensoxe,
                            mt,
                            gc,
                            idmember,
                            idduyet1,
                            idduyet2
                        };
                        insertphieu(result);
                        alert("Phiếu yêu cầu đã được gởi!");
                        location.reload();
                        // window.open(location.reload(true));
                    })

                    function insertphieu(value) {
                        $.ajax({
                            url: 'insertphieuracong.php',
                            type: 'post',
                            dataType: 'json',
                            cache: false,
                            data: {
                                value: value
                            },
                            success: function(value) {
                                console.log(value.value)
                            },
                            error: function(error) {
                                console.log(error.responseText)
                            }
                        });
                    }
                });

                function ajax(result) {
                    $.ajax({
                        url: 'checkmember1.php',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            result: result
                        },
                        success: function(result) {
                            if (typeof result.result == 'undefined') {
                                alert("Mã nhân viên không tồn tại");
                                document.getElementById('idmember').value = '';
                                document.getElementById('namemember').value = '';
                                document.getElementById('namedept').value = '';
                                document.getElementById('namecv').value = '';
                                location.reload();
                            } else {
                                console.log(result.result);
                                document.getElementById('namemember').value = result.result[0].HoTenNhanVien;
                                document.getElementById('namedept').value = result.result[0].TenBoPhan;
                                document.getElementById('namecv').value = result.result[0].TenChucVu;
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        }

                    })
                }
                $(document).ready(function() {

                    $("#idmember").change(function() {
                        var result = document.getElementById("idmember").value;
                        ajax(result);
                    });
                });
            </script>
            <script>
                function userInfo() {
                    document.getElementById('id01').style.display = 'block';
                }

                function changePass() {
                    document.getElementById('id02').style.display = 'block';
                }

                function updatepass(value) {
                    $.ajax({
                        url: 'updatepass.php',
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            value: value
                        },
                        success: function(value) {
                            console.log(value.value)

                        },
                        error: function(error) {
                            console.log(error.responseText)
                        }
                    });
                }

                function change() {
                    var oldpass = document.getElementById('oldpass').value;
                    var newpass = document.getElementById('newpass').value;
                    var confirmpass = document.getElementById('confirmpass').value;
                    var currentpass = <?php echo json_encode($_SESSION['MatKhau']); ?>;
                    console.log(newpass);
                    if (oldpass !== '') {
                        if (currentpass === oldpass) {
                            if (newpass !== '') {
                                if (newpass !== confirmpass) {
                                    alert('Vui lòng xác nhận mật khẩu giống nhau');
                                } else {
                                    var idnhanvien = <?php echo json_encode($_SESSION['IDNhanVien']); ?>;
                                    var result = {
                                        newpass,
                                        idnhanvien
                                    };
                                    console.log(result);
                                    updatepass(result);
                                    alert('Mật khẩu đã được cập nhật');
                                }
                            } else {
                                alert('Vui lòng nhập mật khẩu mới');
                            }
                        } else {
                            alert('Mật khẩu hiện tại không đúng');
                        }
                    } else {
                        alert('Vui lòng nhập mật khẩu hiện tại');
                    }
                }
            </script>