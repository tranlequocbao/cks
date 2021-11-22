<?php
session_start();
require_once "dbhelp.php";
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
$ID = $_SESSION["IDNhanVien"];
$sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query1 = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_array($query1);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Chữ ký điện tử Thaco Auto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/Stylephieu.css" rel="stylesheet" />
    <script src="js/jquery-3.2.1.min.js"></script>
    <link href="Style/display.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <!-- <script src="js/jquery-3.2.1.slim.min.js"></script> -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        function ajax(resultt) {
            $.ajax({
                url: 'checkbophan.php',
                type: 'post',
                dataType: 'json',
                data: {
                    resultt: resultt
                },
                success: function(resultt) {
                    document.getElementById('txtBoPhanNhanYeuCau').value = resultt.resultt[0].HoTenNhanVien;
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            })
        }

        function myFuntion() {
            var bptnyc = $('#cboBoPhanTiepNhanYeuCau').val().split(" - ");
            resultt = bptnyc[0];
            // var resultt = document.getElementById('cboBoPhanTiepNhanYeuCau').value;
            ajax(resultt);
        }
    </script>
</head>

<body>
    <?php
    require "display/header.php";
    ?>
    <div id="content">
        <form id="yeucauvattu" action="#" method="post">
            <div>

                <div id="title">
                    PHIẾU YÊU CẦU CÔNG VIỆC
                </div>
                <div id="input">

                    <div id="trai">
                        <p>
                            <label id="text">Mã nhân viên yêu cầu:</label>
                        <form>
                            <input disabled class="textbox" id="MSNV" name="nhap" type="text" value="<?php echo $_SESSION["IDNhanVien"]; ?>">
                        </form>
                        </p>
                        <p>
                            <label id="text">Bộ phận yêu cầu:</label>
                            <?php
                            $bp = $_SESSION["IDBoPhan"];
                            // $db=mysqli_connect('10.40.13.29','root','','chukyso');
                            $sql = mysqli_query($connect, "select * from bophan where IDBoPhan='$bp'")
                                or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                            $row = mysqli_fetch_array($sql);

                            ?>
                            <input disabled class="textbox" id="tenbophan" name="nhap" type="text" value="<?php echo $row["TenBoPhan"]; ?>"></input>
                        </p>
                        <p>
                            <label id="text">Nội dung công việc: <span style="color:red">*</span></label>
                            <textarea name="noidungcongviec" required id="noidungcongviec" style="resize:none" placeholder="Nhập nội dung..."></textarea>
                        </p>
                        <p>
                            <label id="text">Mục đích: <span style="color:red">*</span></label>
                            <textarea name="mucdich" required id="mucdich" style="resize:none" placeholder="Nhập mục đích..."></textarea>
                        </p>




                    </div>

                    <div id="phai">
                        <p>
                            <label id="text">Tên người yêu cầu:</label>

                        <form>
                            <input disabled id="txtHoTen" class="textbox" name="nhap" type="text" value="<?php echo $_SESSION["HoTenNhanVien"]; ?>"></input>
                        </form>
                        </p>
                        <p>
                            <label id="text">Bộ phận tiếp nhận yêu cầu: <span style="color:red">*</span></label>
                            <select id="cboBoPhanTiepNhanYeuCau" class="textbox" name="NhanYeuCau" onchange="myFuntion()" style="width: 90%;" required>
                                <option selected value="">-----Chọn bộ phận/xưởng-----</option>
                                <?php
                                $bp = mysqli_query($connect, "SELECT * FROM bophan ORDER BY IDBoPhan ASC")
                                    or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                                while ($row = mysqli_fetch_assoc($bp)) {
                                ?>
                                    <option value="<?php echo $row["IDBoPhan"]; ?> - <?php echo $row["TenBoPhan"]; ?>"><?php echo $row["TenBoPhan"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </p>
                        <p>
                            <label id="text">Thời gian hoàn thành: <span style="color:red">*</span></label>
                            <input class="textbox"  id="thoigian" name="thoigianhoanthanh" required type="date" 
                            min="<?php date_default_timezone_set('Asia/Ho_Chi_Minh'); echo date('Y-m-d'); ?>"
                            value="<?php date_default_timezone_set('Asia/Ho_Chi_Minh'); echo date('Y-m-d'); ?>">
                        </p>
                        <p>
                            <label id="text">Ghi chú:</label>
                            <textarea name="ghichu1" id="ghichu1" style="resize:none;" placeholder="Nhập ghi chú..."></textarea>
                        </p>

                        <p>
                            <label id="text">Xem xét:</label>
                            <select class="textbox" id="xemxet" name="duyet1" placeholder="">
                                <?php
                                $bophan = $_SESSION["IDBoPhan"];
                                $bp = mysqli_query($connect, "SELECT * FROM `nhanvien` WHERE (IDChucVu LIKE '%CV002%' AND IDBoPhan like '%$bophan%') OR (IDChucVu LIKE '%CV003%' AND IDBoPhan like '%$bophan%')")
                                    or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                                while ($row = mysqli_fetch_assoc($bp)) {
                                ?>
                                    <option value="<?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?>"><?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>


                            <label id="text">Bộ phận nhận yêu cầu:</label>
                            <input id="txtBoPhanNhanYeuCau" name="NhanYeuCau" type="text" placeholder="Chọn bộ phận nhận yêu cầu" required="" disabled="">

                            <label id="text">Duyệt:</label>
                            <select class="textbox" id="duyet" name="duyet3" placeholder="Duyệt">
                                <?php
                                $bp = mysqli_query($connect, "SELECT * FROM `nhanvien` WHERE IDChucVu='CV005' OR IDChucVu='CV007' ORDER BY IDChucVu ASC")
                                    or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                                while ($row = mysqli_fetch_assoc($bp)) {
                                ?>
                                    <option value="<?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?>"><?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </p>
                    </div>


                    <div id="duoi" style="text-align: center;">
                        <p style="text-align: center;height: 50px;"><button type="button" id="button_modal" class="btn btn-primary">TẠO PHIẾU</button></p>

                    </div>
                    <br>

                </div>
            </div>
        </form>



        <div id="id03" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
            <div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0; width: 80%; height: auto; padding-bottom: 2%;">
                <div class="w3-container">
                    <div class="table-responsive" style="min-height: 400px;font-family: Tahoma;font-size: 17px;TEXT-ALIGN: -WEBKIT-CENTER;">
                        <DIV style="padding-top: 2%;">
                            <table style="width: -webkit-fill-available;margin: 1%;">
                                <tr>
                                    <th style="border: 1px solid;">
                                        <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 200px; height: 40px;" />
                                    </th>
                                    <th style="border: 1px solid;">
                                        CÔNG TY TNHH MTV SẢN XUẤT Ô TÔ THACO MAZDA
                                        <br>
                                        <span style="font-style: italic; font-size: 15px;">AUTOMOBILE MANUFACTURING ONE MEMBER CO.,LTD</span>
                                    </th>
                                    <th style="border: 1px solid;">TMAC.OP3-02.1/F03/Rev0</th>
                                </tr>
                            </table>
                        </DIV>
                        <br>
                        
                        <div style="font-weight: bold;font-size: 20px;text-align: center;">
                            PHIẾU YÊU CẦU CÔNG VIỆC
                            <br />
                            ---oOo---
                        </div>
                        
                        <table style="float: left;margin: 0px 3%;  width: 94%;">
                        <tr>
                            <th style="text-align: left;width: 20%;">Đơn vị yêu cầu:</th>
                            <td id="tenphongban"></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Đơn vị thực hiện:</th>
                            <td id="bophantiepnhan"></td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;text-align: left;">Nội dung yêu cầu:</th>
                            <td id="ndyc"></td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;text-align: left;">Mục đích:</th>
                            <td id="mucdich1"></td>
                        </tr>
                     
                        <tr>
                            <th style="text-align: left;">Thời gian hoàn thành:</th>
                            <td><span id="nht1"></span>/<span id="tht1"></span>/<span id="namht1"></span></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td style="text-align: right;font-style: italic;"><p>Núi Thành, ngày <span id="date"></span> tháng <span id="month"></span> năm <span id="year"></span></p></td>
                        </tr>
                            <!-- <p style="padding-left: 3%;"> <span id="bophantiepnhan"> </span></p>
                            <p style="padding-left: 3%;">Nội dung yêu cầu: <span id="ndyc"></span></p>
                            <p style="padding-left: 3%;">Mục đích: <span id="mucdich1"></span></p>
                            <p style="padding-left: 3%;">Thời gian hoàn thành: <span id="nht1"></span>/<span id="tht1"></span>/<span id="namht1"></span></p> -->
                        </table>

                            <table style="text-align: center;width: 100%;">
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Phê Duyệt</td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Bộ phận tiếp nhận</td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Xem Xét</td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Người làm đơn</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="pheduyet"></span></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="bophantn"></span></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="xx"></span></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="nguoitao"></span></td>
                                </tr>
                            </table>
                            <br>
                            <div style="text-align: center; width: 100%;" id="duoi1">
                                <input style="text-align: center; width: 15%;background-color: red;border-color: red;" type="button" id="button" onclick="document.getElementById('id03').style.display='none'" value='QUAY LẠI' class="btn btn-primary"></input>
                                <input style="text-align: center; width: 15%;background-color: green;border-color: green;" type="button" id="button_save" value='XÁC NHẬN' class="btn btn-primary"></input>
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


        var ngduyet = '';
        $(document).ready(function() {
            $("#button_modal").click(function() {


                bp = $('#tenbophan').val();
                $('#tenphongban').text(bp);

                noidung = $('#noidungcongviec').val();
                var ndcv = noidung.replace(/\n\r?/g, ' <br> ');
                document.getElementById("ndyc").innerHTML = ndcv;

                md = $('#mucdich').val();
                mdcv = md.replace(/\n\r?/g, ' <br> ');
                document.getElementById("mucdich1").innerHTML = mdcv;

                quandocnhanyeucau = $('#txtBoPhanNhanYeuCau').val();
                $('#bophantn').text(quandocnhanyeucau);
                console.log(text);
                var tght = $('#thoigian').val().split("-");
                ngayhoanthanh = tght[2];
                thanghoanthanh = tght[1];
                namhoanthanh = tght[0];
                $('#nht1').text(ngayhoanthanh);
                $('#tht1').text(thanghoanthanh);
                $('#namht1').text(namhoanthanh);
                var time = $('#thoigian').val();
                
                var tg = new Date(tght);

                var todate = new Date();
                var t = todate.toISOString();
                var t1 = t.substring(0,10);
                var t2 = t1.split("-");
                var t3 = new Date(t2);
                var date = todate.getDate();
                $('#date').text(date);
                var month = todate.getMonth() + 1;
                $('#month').text(month);
                var year = todate.getFullYear();
                $('#year').text(year);
                console.log(tg);
                console.log(t);
                console.log(t1);
                console.log(t3);
                var timespan = tg.getTime() - t3.getTime();
                console.log(timespan);
                var days =  Math.floor(timespan / (1000 * 60 * 60 * 24));
                console.log(days);
                

                nguoitao = $('#txtHoTen').val();
                $('#nguoitao').text(nguoitao);

                var bophantiepnhanyeucau = $('#cboBoPhanTiepNhanYeuCau').val().split(" - ");
                idbophan = bophantiepnhanyeucau[0];
                var tenbophana = bophantiepnhanyeucau[1];
                $('#bophantiepnhan').text(tenbophana);


                var arry_xemxet = $('#xemxet').val().split(" - ");
                nguoiduyet1 = arry_xemxet[0];
                var idduyet1 = arry_xemxet[1];
                $('#xx').text(nguoiduyet1);



                var arry_duyet3 = $('#duyet').val().split(" - ");
                var nguoiduyet3 = arry_duyet3[0];
                var idduyet3 = arry_duyet3[1];
                $('#pheduyet').text(nguoiduyet3);


                if (noidung == '' || md == '' || quandocnhanyeucau == '') {
                    alert("KHÔNG để trống các nội dung bắt buộc.");
                } else {
                    if (days >-1)
                    {
                    $('#id03').css('display', 'block');
                }
                else {
                    alert("Thời gian hoàn thành không hợp lệ");
                }
                }
            });

            $('#button_save').on('click', function() {
				$('#button_save').css('display', 'none');
                idnguoitao = $('#MSNV').val();
                idbophantao = <?php echo json_encode($_SESSION['IDBoPhan']); ?>;
                tg = $('#thoigian').val();

                ghichu1 = $('#ghichu1').val();

                var arry_xemxet = $('#xemxet').val().split(" - ");
                nguoiduyet1 = arry_xemxet[0];
                var idduyet1 = arry_xemxet[1];
                var arry_duyet3 = $('#duyet').val().split(" - ");
                var nguoiduyet3 = arry_duyet3[0];
                var idduyet3 = arry_duyet3[1];
                var bophantiepnhanyeucau = $('#cboBoPhanTiepNhanYeuCau').val().split(" - ");
                idbophan1 = bophantiepnhanyeucau[0];
                var tenbophana = bophantiepnhanyeucau[1];

                noidung = $('#noidungcongviec').val();
                var ndcv = noidung.replace(/\n\r?/g, ' <br> ');
                md = $('#mucdich').val();
                var mdcv = md.replace(/\n\r?/g, ' <br> ');
                var result = {
                    idnguoitao,
                    idbophantao,
                    idbophan1,
                    ndcv,
                    mdcv,
                    tg,
                    ghichu1,
                    idduyet1,
                    idduyet3
                };
                insert(result);
                
                // location.reload();
            })
        });

        function insert(value) {
            $.ajax({
                url: 'insertphieucongviec.php',
                type: 'post',
                dataType: 'json',
                data: {
                    value: value
                },
                success: function(value) {
                    if(value.result=='OK'){
                                                 thongbao();
                                            }
                                            else{
                                                alert ("Gửi yêu cầu thất bại. Vui lòng tạo lại phiếu yêu cầu");
                                            }
                                            
					
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            })
        }
        function thongbao()
        {
            alert("Phiếu yêu cầu đã được gởi!");
            $('#id03').css('display', 'none');
            location.reload();
        }
    </script>