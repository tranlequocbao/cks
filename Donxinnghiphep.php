<?php session_start();
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
require_once "dbhelp.php";
$ID = $_SESSION["IDNhanVien"];
$sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query1 = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_array($query1);

//check tên viết tắt
function checkAcr()
{
    $con = mysqli_connect("localhost", "root", "", "chukyso");
    $sql = "select VietTat FROM loaiphieu where IDLoaiPhieu = 'P0001'";
    $query = mysqli_query($con, $sql);
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
    $con = mysqli_connect("localhost", "root", "", "chukyso");
    $sql = "SELECT COUNT(IDPhieu) as ct FROM phieu WHERE IDPhieu like '" . checkAcr() . $nowtime . "%'";
    $query = mysqli_query($con, $sql);
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
//click button lưu và gởi
if (isset($_POST['send'])) {
    if ($_POST['member'] == null) {
        echo "<script type='text/javascript'>alert('Vui lòng điền thông tin nhân viên');</script>";
    } else {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $timeinsert = date('Y-m-d H:i:s');
        $nghitu = $_POST['nghitu'];
        $nghiden = $_POST['nghiden'];
        $lydo = $_POST['lydo'];
        $ghichu = $_POST['ghichu'];
        $nhansubangiao = $_POST['nhansubangiao'];
        $idduyet1 = $_POST['duyet1'];
        $idduyet2 = $_POST['duyet2'];
        $idme = $_POST['member'];
        $idnhanvientao = $_SESSION['IDNhanVien'];
        $idphieu = createID();
        $con = mysqli_connect("localhost", "root", "", "chukyso");
        $sql = "INSERT into phieu(IDPhieu, IDLoaiPhieu, IDNhanVien, NgayTao, UuTien, TuChoi, Gui) VALUES ('" . $idphieu . "', 'P0001', '" . $idnhanvientao . "', '" . $timeinsert . "',0,0,1)";
        $query = mysqli_query($con, $sql);
        $sql2 = "INSERT INTO giayxinphep(IDPhieu, InTime, OutTime, LyDo, NhanVienThayThe, NhanVienNghi, GhiChu) VALUES ('" . $idphieu . "', '" . $nghitu . "', '" . $nghiden . "', '" . $lydo . "', '" . $nhansubangiao . "','" . $idme . "', '" . $ghichu . "')";
        $query = mysqli_query($con, $sql2);
        $sql9 = "INSERT INTO pheduyet(IDPhieu, IDNhanVien, DaDuyet, NgayDuyet, GhiChu) VALUES ('" . $idphieu . "','" . mysqli_real_escape_string($con, $idduyet1) . "','0','0','')";
        mysqli_query($con, $sql9);
        $sql10 = "INSERT INTO pheduyet(IDPhieu, IDNhanVien, DaDuyet, NgayDuyet,GhiChu) VALUES ('" . $idphieu . "','" . mysqli_real_escape_string($con, $idduyet2) . "','0','0','')";
        $query = mysqli_query($con, $sql10);

        $sqlnv = "SELECT * FROM nhanvien WHERE IDNhanVien='" . mysqli_real_escape_string($con, $idduyet1) . "'";
        $querynv = mysqli_query($con, $sqlnv);
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
        if (mail($to, $subject, $message, $headers)) {
            $message1 = 'Tạo phiếu và gửi mail cho cấp trên thành công.';
            echo "<SCRIPT>
            alert('$message1');
        </SCRIPT>";
        } else {
            $message2 = 'Tạo phiếu không thành công';
            echo "<SCRIPT>
        alert('$message2');
    </SCRIPT>";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Chữ ký điện tử Thaco Auto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/Stylephieu.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />

    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>

<body>
    <?php
    require "display/header.php";
    ?>
    <div id="content">
        <div id="yeucauvattu">
            <div id="title">
                GIẤY XIN PHÉP
            </div>
            <form id="input" autocomplete="off" method="post">
                <div id="trai">
                    <p>
                        <label id="text">Mã số nhân viên:</label>
                        <?php  $chucvu = $_SESSION['IDChucVu'];
                        if ($chucvu == "CV008")
                        { ?>
                            <input class="textbox" name="member" id="ipidmember" value="<?php echo $_SESSION['IDNhanVien']; ?>" type="text" disabled = "">
                        <?php } 
                        else {
                        ?>
                        <input class="textbox" name="member" id="ipidmember" value="<?php echo $_SESSION['IDNhanVien']; ?>" type="text">
                        <?php } ?>
                    </p>
                    <p>
                        <label id="text">Tên nhân viên:</label>
                        <input class="textbox" id="namemember" name="tennhanvien" value="<?php echo $_SESSION['HoTenNhanVien']; ?>" type="text" required="" disabled="">
                    </p>
                    <p>
                        <label id="text">Nghỉ từ: <span style="color:red">*</span></label>
                        <input name="nghitu" onchange="SelectDay()" class="datetime" id="nghitu" value="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                    echo date('Y-m-d\T07:30'); ?>" min="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                                                                                        echo date('Y-m-d\TH:i'); ?>" type="datetime-local" required="">
                    </p>
                    <p>
                        <label id="text">Nghỉ đến: <span style="color:red">*</span></label>
                        <input name="nghiden" class="datetime" id="nghiden" value="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                    echo date('Y-m-d\T16:30'); ?>" min="<?php date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                                                                                            echo date('Y-m-d\TH:i'); ?>" type="datetime-local" required="">
                    </p>
                    <p class="autocomplete">
                        <label id="text">Nhân sự bàn giao: <span style="color:red">*</span></label>
                        <input name="nhansubangiao" class="textbox" id="idmember2" type="text">
                    </p>
                    <p>
                        <label id="text">Ghi chú: </label>
                        <input name="ghichu" class="textbox" id="ghichu" type="text">
                    </p>
                </div>

                <div id="phai">
                    <p>
                        <label id="text">Phòng ban/Xưởng:</label>
                        <input class="textbox" id="namedept" value="<?php

                                                                    $db = mysqli_connect('localhost', 'root', '', 'chukyso');
                                                                    $bp = $_SESSION['IDBoPhan'];
                                                                    // Tim user va pass co trong csdl ko?
                                                                    $bophan = mysqli_query($db, "select * from bophan where IDBoPhan='$bp'")
                                                                        or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                                                                    $row = mysqli_fetch_array($bophan);
                                                                    echo $row["TenBoPhan"] ?>" type="text" required="" disabled="">
                    </p>
                    <p>
                        <label id="text">Chức vụ:</label>
                        <input class="textbox" id="namecv" value="<?php

                                                                    $db = mysqli_connect('localhost', 'root', '', 'chukyso');
                                                                    $cv = $_SESSION['IDChucVu'];
                                                                    // Tim user va pass co trong csdl ko?
                                                                    $bophan = mysqli_query($db, "select * from chucvu where IDChucVu='$cv'")
                                                                        or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                                                                    $row = mysqli_fetch_array($bophan);
                                                                    echo $row["TenChucVu"] ?>" type="text" required="" disabled="">
                    </p>
                    <p>
                        <label id="text">Lý do nghỉ: <span style="color:red">*</span></label>
                        <textarea name="lydo" class="textbox" id="lydo" style="resize:none;height:120px;" placeholder="Nhập lý do nghỉ" required=""></textarea> </p>

                     <p>   <label id="text">Xem xét:</label>
                        <select class="textbox" id="nguoiduyet1" name="duyet1" placeholder="">
                            <?php
                            $bophan = $_SESSION['IDBoPhan'];
                            $idchucvu = $_SESSION['IDChucVu'];
                            $db = mysqli_connect('localhost', 'root', '', 'chukyso');
                            if ($idchucvu == "CV003" or $idchucvu == "CV0031" or $idchucvu == "CV0032" or $idchucvu == "CV0033")
                            {
                                $bp = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE IDChucVu='CV005' OR IDChucVu='CV007' ORDER BY IDChucVu ASC")
                                or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                                while ($row = mysqli_fetch_assoc($bp)) {
                            ?>
                                <option value="<?php echo $row["IDNhanVien"] . "-" . $row["HoTenNhanVien"]; ?>"><?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                            <?php
                                }
                            }
                            else
                            {
                            $bp = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE (IDChucVu LIKE '%CV002%' AND IDBoPhan like '%$bophan%') OR (IDChucVu LIKE '%CV003%' AND IDBoPhan like '%$bophan%')")
                                or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                            while ($row = mysqli_fetch_assoc($bp)) {
                            ?>
                                <option value="<?php echo $row["IDNhanVien"] . "-" . $row["HoTenNhanVien"]; ?>"> <?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                            <?php
                            } }
                            ?>
                        </select></p>

                     <p>   <label id="text" >Phê duyệt:</label>
                        <select class="textbox" id="nguoiduyet2" name="duyet2" placeholder="Duyệt">
                    <?php
                    $db = mysqli_connect('localhost', 'root', '', 'chukyso');
                    if ($idchucvu == "CV003" or $idchucvu == "CV0031" or $idchucvu == "CV0032" or $idchucvu == "CV0033")
                    {
                        $bp = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE IDChucVu='CV009'")
                        or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                    while ($row = mysqli_fetch_assoc($bp)) {
                    ?>
                        <option value="<?php echo $row["IDNhanVien"] . "-" . $row["HoTenNhanVien"]; ?>"><?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                    <?php
                    }
                    }
                    else {
                    $bp = mysqli_query($db, "SELECT * FROM `nhanvien` WHERE IDChucVu='CV005' OR IDChucVu='CV007' ORDER BY IDChucVu ASC")
                        or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($db));
                    while ($row = mysqli_fetch_assoc($bp)) {
                    ?>
                        <option value="<?php echo $row["IDNhanVien"] . "-" . $row["HoTenNhanVien"]; ?>"><?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                    <?php
                    } }
                    ?>
                        </select>
                    </p>
                </div>

                <div id="duoi">
                    <!--<p>
                        <label id="text"></label>
                        <input id="textbox" type="text" required="">
                    </p>-->

                    <!-- <p style="text-align: center;"><input id="button" name="send" type="submit" class="btn btn-primary" value="TẠO PHIẾU"></input></p> -->
                    <p style="/* float: right; *//* height: 50px; *//* margin-right: 50px; */text-align: center;"><input style="text-align: center;" id="button_modal" value="TẠO PHIẾU" class="btn btn-primary"></input></p>
                    <!-- <p style="float: right;height: 50px;margin-right: 50px;"><input id="button" name="save" type="submit" class="btn btn-primary" value="Lưu Phiếu Yêu Cầu"></input></p> -->


                </div>

                <br>

            </form>
        </div>
        <div id="id03" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
            <div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0; width: 60%; height: auto; padding-bottom:2%;">
                <div class="w3-container">
                    <!-- <button onclick="document.getElementById('id01').style.display='none'" class="btn btn-danger" style="background: red; float: right; border: none; width: 34px; height: 40px;">X</button>
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c">
                        <h6 class="m-0 font-weight-bold" style="color: #fffcd5;padding: 10px;"></h6>
                    </div> -->
                    <div class="table-responsive" style="min-height: 400px;font-family: Tahoma;font-size: 17px;TEXT-ALIGN: -WEBKIT-CENTER;">
                        <DIV style="padding-top: 3%;">
                            <table style="width: 100%;">
                                <tr>
                                    <th>
                                        <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 200px; height: 40px; margin-left:-18%; margin-top: -6%" />
                                    </th>
                                    <th style="text-align: center;">
                                        CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM
                                        <br>
                                        Độc lập - Tự do - Hạnh phúc
                                        <br>
                                        ______***______
                                    </th>
                                </tr>
                            </table>
                        </DIV>
                        <br>
                        <br>
                        <div style="font-weight: bold;font-size: 20px;text-align: center;">
                            ĐƠN XIN NGHỈ PHÉP
                            <BR>
                            Kính gửi: BAN GIÁM ĐỐC
                        </div>
                        <br>
                        <div>
                            <DIV id="phan1">
                                <DIV id="lef" style="width: 51%;float: left;margin-left: 4%;text-align: left;">
                                    <p><span style="font-weight: bold;">Tôi tên là: </span> <span id="tennv"> </span></p>
                                    <p><span style="font-weight: bold;">Phòng ban/Xưởng: </span> <span id="tenphongban"> </span></p>
                                </DIV>
                                <DIV id="righ" style="width: 45%;float: right;padding-right: 3%;padding-left: 2%;text-align: left;">
                                    <p><span style="font-weight: bold;">Mã số nhân viên: </span> <span id="manv"> </span></p>
                                    <p><span style="font-weight: bold;">Chức vụ: </span> <span id="tencv"> </span></p>
                                </DIV>
                            </DIV>
                            <div id="phan2" style="text-align: left;margin-left: 4%;">
                                <p>Nay tôi viết đơn này kính trình Ban giám đốc cho tôi được <span style="font-weight: bold;">nghỉ phép</span>:</p>
                                <p>Từ <span id="tugio"></span> giờ <span id="tuphut"> </span> phút, ngày <span id="tungay"></span> tháng <span id="tuthang"></span> năm <span id="tunam"></span> đến <span id="dengio"></span> giờ <span id="denphut"></span> phút, ngày <span id="denngay"></span> tháng <span id="denthang"></span> năm <span id="dennam"></span></p>
                                <p><span style="font-weight: bold;">Lý do:</span> <span id="lydonghi"></span> </p>
                                <p>Tôi đã bàn giao công việc trong thời gian nghỉ phép lại cho <span style="font-weight: bold;">ông (bà)</span>: <span style="font-weight: bold;" id="nvbangiao"></span></p>
                                <p><span style="font-weight: bold;">Ông (bà)</span>: <span style="font-weight: bold;" id="nvbangiao1"></span> sẽ thay thế tôi hoàn thành tốt nhiệm vụ được giao theo quy định.</p>
                                <p>Kính trình Ban giám đốc xem xét phê duyệt.</p>
                                <p>Trân trọng!</p>
                            </div>
                            <div id="phan3" style="text-align: right;margin-right: 10%;font-style: italic;">
                                <p>Núi Thành, ngày <span id="date"></span> tháng <span id="month"></span> năm <span id="year"></span></p>
                            </div>
                            <table style="text-align: center;width: 100%;">
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Phê Duyệt</td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Xem Xét</td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Người lập </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="pheduyet"></span></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="xemxet"></span></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="nguoitao"></span></td>
                                </tr>
                            </table>
                            <br>
                            <div style="text-align: center; width: 70%" id="duoi">
                                <input style="text-align: center; width: 160px;background-color: red;border-color: red;margin-right:30px;" type="button" id="button" onclick="document.getElementById('id03').style.display='none'" value='QUAY LẠI' class="btn btn-primary"></input>
                                <input style="text-align: center; width: 160px;background-color: green;border-color: green;margin-left:30px;" type="button" id="button_save" value='XÁC NHẬN' class="btn btn-primary" ></input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require "display/footer.php";
    ?>

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/main.js"></script>
    <!-- onchange mã nv -->

    <script>
        var ngduyet = '';
        $(document).ready(function() {
            $("#button_modal").click(function() {

                idmember = $('#ipidmember').val();
                $('#manv').text(idmember);
                var namemember = $('#namemember').val();
                $('#tennv').text(namemember);
                var namedept = $('#namedept').val();
                $('#tenphongban').text(namedept);
                var namecv = $('#namecv').val();
                $('#tencv').text(namecv);
                ngaynghi = $('#nghitu').val();
                var ngay_arry = ngaynghi.split("-");
                var nam = ngay_arry[0];
                var thang = ngay_arry[1];
                var ngay_arry = ngay_arry[2].split("T");
                var ngay = ngay_arry[0];
                var gio_ary = ngay_arry[1].split(":");
                var gio = gio_ary[0];
                var phut = gio_ary[1];
                $('#tugio').text(gio);
                $('#tuphut').text(phut);
                $('#tungay').text(ngay);
                $('#tuthang').text(thang);
                $('#tunam').text(nam);
                var daynghitu = document.getElementById('nghitu').value.replace('T', ' ');

                nghiden = $('#nghiden').val();
                var nghiden_arry = nghiden.split("-");
                var dennam = nghiden_arry[0];
                var denthang = nghiden_arry[1];
                var ngaygio_arry = nghiden_arry[2].split("T");
                var denngay = ngaygio_arry[0];
                var giophut_arry = ngaygio_arry[1].split(":");
                var dengio = giophut_arry[0];
                var denphut = giophut_arry[1];
                $('#dengio').text(dengio);
                $('#denphut').text(denphut);
                $('#denngay').text(denngay);
                $('#denthang').text(denthang);
                $('#dennam').text(dennam);
                var daynghiden = nghiden.replace('T', ' ');
                var time11 = new Date(daynghitu);
                var time22 = new Date(daynghiden);
                var timespan = time22.getTime() - time11.getTime();
                console.log(time11);

                var todate = new Date();
                var date = todate.getDate();
                $('#date').text(date);
                var month = todate.getMonth() + 1;
                $('#month').text(month);
                var year = todate.getFullYear();
                $('#year').text(year);
                var timspan2 = time11.getTime() - todate.getTime();
                var days = Math.floor(timspan2 / (1000 * 60 * 60 * 24));

                ghichu = $('#ghichu').val();
                lydooff = $('#lydo').val();
                $('#lydonghi').text(lydooff);
                nsbangiao = $('#idmember2').val();
                $('#nvbangiao').text(nsbangiao);
                $('#nvbangiao1').text(nsbangiao);
                var res = document.getElementById('idmember2').value;
                var Checkns = $.ajax({
                url: 'checknsbg.php',
                type: 'post',
                dataType: 'json',
                data: {
                    result: res
                }
            });
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
                
                    if (idmember !== '')
                    {
                        if (days >= -1)
                        {
                            if (timespan / 1000 < 14400) {
                                alert("Vui lòng nhập thời gian nghỉ ít nhất 4 giờ!");
                            } else {
                                if (lydooff !== '') {
                                    Checkns.done(function(data){
                                        console.log(data);
                                        if(data.result=='OK')
                                        {
                                            $('#id03').css('display', 'block');
                                        }
                                        else
                                        {
                                            alert("Nhân sự bàn giao không hợp lệ!");
                                        }
                                    });
                                } else {
                                alert("Vui lòng nhập lý do nghỉ!");
                            }
                        }
                    }
                    else {
                        alert("Vui lòng chọn ngày nghỉ bắt đầu từ hôm nay!");
                    }
                    }
                    else {
                        alert("Vui lòng nhập mã nhân viên!");
                    }
                    
            });
            $('#button_save').on('click', function() {
                var result = {
                    idnguoitao,
                    ngaynghi,
                    nghiden,
                    lydooff,
                    nsbangiao,
                    ghichu,
                    idmember,
                    idduyet1,
                    idduyet2
                };
                insertphieu(result);
                
                //location.reload();
            })
        });

        //change ngày nghỉ từ
        function SelectDay() {
            var time = document.getElementById('nghitu').value.substring(0,10);
            var timei = time + ' 00:00:00';
            var day = new Date().toISOString();
            var currentday2 = day.substring(0,10)+ ' 00:00:00';
            var currenntday = new Date(currentday2);
            var time1 = new Date(timei);
            var timespan = time1.getTime() - currenntday.getTime();
            var days = Math.floor(timespan / (1000 * 60 * 60 * 24));
            if (days >= 1)
            {
                // document.getElementById('nghitu').value = time+ 'T07:30';
                // document.getElementById('nghiden').value = time+ 'T16:30';
            }
            
        }

        function insertphieu(value) {
            $.ajax({
                url: 'insertphieu.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value: value
                },
                success: function(value) {
                    console.log(value.result)
                    if(value.result=='OK')
                    thongbao();
                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }
        function thongbao()
        {
            alert("Phiếu yêu cầu đã được gởi!");
            $('#id03').css('display', 'none');
            location.reload();
        }
        function ajax(result) {
            $.ajax({
                url: 'checkmember1.php',
                type: 'post',
                dataType: 'json',
                data: {
                    result: result
                },
                success: function(result) {
                    console.log(result);
                    if (typeof result.result == 'undefined') {
                        alert("Mã nhân viên không hợp lệ");
                        document.getElementById('ipidmember').value = '';
                        document.getElementById('namemember').value = '';
                        document.getElementById('namedept').value = '';
                        document.getElementById('namecv').value = '';
                    } else {
                        console.log(result.result);
                        document.getElementById('namemember').value = result.result[0].HoTenNhanVien;
                        document.getElementById('namedept').value = result.result[0].TenBoPhan;
                        document.getElementById('namecv').value = result.result[0].TenChucVu;
                        changexx(result.result[0].IDChucVu);
                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }

            });
        }
        // function checknsbg(result) {
        //     return new Promise(function(resolve,reject){
        //     $.ajax({
        //         url: 'checknsbg.php',
        //         type: 'post',
        //         dataType: 'json',
        //         data: {
        //             result:result
        //         },
        //         success: function(result) {
        //             console.log(result.result);
        //             resolve(result.result);
        //         },
        //         error: function(error) {
        //             console.log(error)
        //         }
        //     });
        // });
        // }
        
        function checknguoixemxet1(result)
        {
            $.ajax({
                url: 'checknguoixemxet1.php',
                type: 'post',
                dataType: 'json',
                data: {
                    result: result
                },
                success: function(result) {
                    if (typeof result.result == 'undefined') {
                        alert("Không có người xem xét");
                        $('#nguoiduyet1').empty();
                        
                        
                    } else {
                        console.log(result.result);
                        $('#nguoiduyet1').empty();
                        for(var i=0;i<result.result.length;i++)
                        {
                        $('#nguoiduyet1').append(`<option value="${result.result[i].IDNhanVien+ "-" + result.result[i].HoTenNhanVien}">
                                       ${result.result[i].HoTenNhanVien+ "-" + result.result[i].IDNhanVien}
                                  </option>`); 
                        }
                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });
        }
        function checknguoixemxet2(result)
        {
            $.ajax({
                url: 'checknguoixemxet2.php',
                type: 'post',
                dataType: 'json',
                data: {
                    result: result
                },
                success: function(result) {
                    if (typeof result.result == 'undefined') {
                        alert("Không có người xem xét");
                        $('#nguoiduyet1').empty();
                        
                        
                    } else {
                        console.log(result.result);
                        $('#nguoiduyet1').empty();
                        for(var i=0;i<result.result.length;i++)
                        {
                        $('#nguoiduyet1').append(`<option value="${result.result[i].IDNhanVien + "-" + result.result[i].HoTenNhanVien}">
                                       ${result.result[i].HoTenNhanVien+ "-" + result.result[i].IDNhanVien}
                                  </option>`); 
                        }
                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });
        }
        function checknguoiduyet1(result)
        {
            $.ajax({
                url: 'checknguoiduyet1.php',
                type: 'post',
                dataType: 'json',
                data: {
                    result: result
                },
                success: function(result) {
                    if (typeof result.result == 'undefined') {
                        alert("Không có người duyệt");
                        document.getElementById('nguoiduyet2').value = '';    
                        
                    } else {
                        console.log(result.result);
                        $('#nguoiduyet2').empty();
                        for(var i=0;i<result.result.length;i++)
                        {
                        $('#nguoiduyet2').append(`<option value="${result.result[i].IDNhanVien+ "-" + result.result[i].HoTenNhanVien}">
                                       ${result.result[i].HoTenNhanVien+ "-" + result.result[i].IDNhanVien}
                                  </option>`); 
                        } 
                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });
        }
        function checknguoiduyet2(result)
        {
            $.ajax({
                url: 'checknguoiduyet2.php',
                type: 'post',
                dataType: 'json',
                data: {
                    result: result
                },
                success: function(result) {
                    if (typeof result.result == 'undefined') {
                        alert("Không có người duyệt");
                        document.getElementById('nguoiduyet2').value = '';    
                        
                    } else {
                        console.log(result.result);
                        $('#nguoiduyet2').empty();
                        for(var i=0;i<result.result.length;i++)
                        {
                        $('#nguoiduyet2').append(`<option value="${result.result[i].IDNhanVien+ "-" + result.result[i].HoTenNhanVien}">
                                       ${result.result[i].HoTenNhanVien+ "-" + result.result[i].IDNhanVien}
                                  </option>`); 
                        } 
                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            });
        }

        $(document).ready(function() {

            $("#ipidmember").change(function() {
                var result = document.getElementById("ipidmember").value;
                ajax(result);
            });
        });

        function changexx(idchucvu)
        {
            console.log('doi nguoi duyet');
            var result = <?php echo json_encode($_SESSION['IDBoPhan']); ?>;
            console.log(idchucvu);
            if(idchucvu == "CV003" || idchucvu == "CV0031" || idchucvu == "CV0032" || idchucvu == "CV0033")
                {
                    checknguoixemxet1(result);
                    checknguoiduyet1(result);
                }
            else{
                checknguoixemxet2(result);
                checknguoiduyet2(result);

            }
        }

        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });

            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        function ajax2(result) {
            var ret = [];
            $.ajax({
                url: 'LoadMember.php',
                type: 'post',
                dataType: 'json',
                data: {
                    result: result
                },
                success: function(result) {
                    result.result.forEach(myfuntion);
                },
                error: function(error) {}
            })

            function myfuntion(item) {
                ret.push(item.HoTenNhanVien);
            }
            return ret;
        }
        var countries = ajax2("idchange");
        autocomplete(document.getElementById("idmember2"), countries);

        function GetData() {
            $('#tbData>tbody>tr').each(function() {
                var $tbs = $(this).find('td');
                var $nd = $tbs.eq(1).find('option:selected').val();
                var $nd2 = $tbs.eq(0).find('label').type();
                console.log($nd2);
                alert($nd2);
            })
        }
    </script>