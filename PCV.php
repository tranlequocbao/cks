<?php
session_start();
if (!isset($_SESSION["IDNhanVien"])) {
    $_SESSION['link'] = "../Thacomazda-CKDT/PCV.php?p=PCV&id=" . $_GET['id'];
    header('Location: Dangnhap.php');
}
require ("dbhelp.php");

$sql = "SELECT * FROM phieu,nhanvien,bophan,loaiphieu,yeucaucongviec WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu and phieu.IDPhieu = yeucaucongviec.IDPhieu AND bophan.IDBoPhan=nhanvien.IDBoPhan and phieu.IDPhieu = '$_GET[id]' ";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);

$tenbpnhan = "SELECT * FROM bophan where IDBoPhan='" . $row['IDBoPhanNhanYeuCau'] . "'";
$xuly = mysqli_query($connect, $tenbpnhan);
$laytenbpnhan = mysqli_fetch_array($xuly);
$ngaytao = strtotime($row['NgayTao']);
$ngay = date('d', $ngaytao);
$thang = date('m', $ngaytao);
$nam = date('Y', $ngaytao);

$hoanthanh = strtotime($row['NgayHoanThanh']);
$ngayhoanthanh = date('d', $hoanthanh);
$thanghoanthanh = date('m', $hoanthanh);
$namhoanthanh = date('Y', $hoanthanh);

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
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/Donxinnghiphep.css" rel="stylesheet" />
    <link href="Style/chitietdnp.css" rel="stylesheet" />
    <script src="js/jquery-3.2.1.min.js"></script>
    <link href="Style/display.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <!-- <script src="js/jquery-3.2.1.slim.min.js"></script> -->
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
                <p style=" width: auto;  float: left;">CHI TIẾT PHIẾU</p>
                <button class="inphieu"><a style="text-decoration:none; color:white" href="InphieuPCV.php?p=PCV&inid=<?php echo $_GET['id']; ?>">In phiếu</a></button>
            </div>

            <form id="input" method="post">

                <div class="title" style="font-weight: bold;font-size: 20px;text-align: center; font-family: Times New Roman;">
                    PHIẾU YÊU CẦU CÔNG VIỆC

                </div>
                <br />
                <div id="noidung">
                    <div id="tb">

                        <table style="float: left;margin: 0px 3%;  width: 94%;">
                        <tr>
                            <th style="text-align: left;width: 30%;">Đơn vị yêu cầu:</th>
                            <td id="tenphongban"><?php echo $row['TenBoPhan']; ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Đơn vị thực hiện:</th>
                            <td id="bophantiepnhan"><?php echo $laytenbpnhan['TenBoPhan'] ?></td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;text-align: left;">Nội dung yêu cầu:</th>
                            <td id="ndyc"><?php echo $row['NoiDungCongViec'];?></td>
                        </tr>
                        <tr>
                            <th style="vertical-align: top;text-align: left;">Mục đích:</th>
                            <td id="mucdich1"><?php echo $row['MucDich']; ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Thời gian hoàn thành:</th>
                            <td><?php echo $ngayhoanthanh ?>/<?php echo $thanghoanthanh ?>/<?php echo $namhoanthanh ?></td>
                        </tr>
                        <tr>
                            <th style="text-align: left;">Ghi chú:</th>
                            <td><?php echo $row['GhiChu1']; ?></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td style="text-align: right;font-style: italic;"><p>Núi Thành, ngày <?php echo $ngay; ?> tháng <?php echo $thang; ?>  năm <?php echo $nam; ?> </p></td>
                        </tr>

                        <!-- <p><strong>Đơn vị yêu cầu:</strong>
                            <?php echo $row['TenBoPhan']; ?>
                        </p>
                        <p><strong>Đơn vị thực hiện:</strong> <?php echo $laytenbpnhan['TenBoPhan'] ?></p>
                        <br />
                        <th style="vertical-align: top;text-align: left;">Nội dung yêu cầu:<?php echo $row['NoiDungCongViec'];?></th> -->
                            
                        <!-- <p><strong>1. Nội dung yêu cầu: </strong><?php echo $row['NoiDungCongViec']; ?></p>
                        <p><strong>2. Mục đích: </strong><?php echo $row['MucDich']; ?></p>
                        <p><strong>3. Thời gian hoàn thành:</strong> <?php echo $ngayhoanthanh ?>/<?php echo $thanghoanthanh ?>/<?php echo $namhoanthanh ?>.</p>
                        <p><strong>4. Ghi chú: </strong><?php echo $row['GhiChu1']; ?></p> -->
                    </div>

                    <!-- <div style=" text-align: right; margin-right: 48px;">
                        <span style="font-style: italic;"> Núi Thành, ngày <?php echo $ngay ?> tháng <?php echo $thang ?> năm <?php echo $nam ?></span>
                    </div> -->
                    <br />
                    <table id="duyet" style="border: none;">
                        <tr>
                            <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Duyệt</td>
                            <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Bộ phận nhận</td>
                            <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Bộ phận tạo</td>
                            <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Nhân viên tạo</td>
                        </tr>
                        <?php
                        $sql1 = "SELECT * FROM pheduyet,caidatmau,nhanvien where pheduyet.IDNhanVien=nhanvien.IDNhanVien and  pheduyet.MucDuyet='1' and IDPhieu='" . $_GET['id'] . "'";
                        $result1 = mysqli_query($connect, $sql1);
                        $row1 = mysqli_fetch_array($result1);

                        $sql2 = "SELECT * FROM pheduyet,caidatmau,nhanvien where pheduyet.IDNhanVien=nhanvien.IDNhanVien and  pheduyet.MucDuyet='2' and IDPhieu='" . $_GET['id'] . "'";
                        $result2 = mysqli_query($connect, $sql2);
                        $row2 = mysqli_fetch_array($result2);

                        $sql3 = "SELECT * FROM pheduyet,caidatmau,nhanvien where pheduyet.IDNhanVien=nhanvien.IDNhanVien and  pheduyet.MucDuyet='3' and IDPhieu='" . $_GET['id'] . "'";
                        $result3 = mysqli_query($connect, $sql3);
                        $row3 = mysqli_fetch_array($result3);

                        $daduyet1 = $row1['DaDuyet'];
                        $idduyet1 = $row1['IDNhanVien'];
                        $ngayduyet1 = $row1['NgayDuyet'];
                        $nhanxet1 = $row1['GhiChu'];

                        $daduyet2 = $row2['DaDuyet'];
                        $idduyet2 = $row2['IDNhanVien'];
                        $ngayduyet2 = $row2['NgayDuyet'];
                        $nhanxet2 = $row2['GhiChu'];

                        $daduyet3 = $row3['DaDuyet'];
                        $idduyet3 = $row3['IDNhanVien'];
                        $ngayduyet3 = $row3['NgayDuyet'];
                        $nhanxet3 = $row3['GhiChu'];

                        if ($daduyet1 == '0' && $ngayduyet1 == '0000-00-00 00:00:00') {
                            if ($idduyet1 == $_SESSION['IDNhanVien']) { ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 30%;border: none;text-align: center;font-weight: bold;">
                                        <p><textarea id="nhanxet" name="nhanxet" style="width: 100%; font-family: Arial;" value="" placeholder="Nhận xét"></textarea> </p>
                                        <p><input class="xoa" name="xoa" type="button" onclick="review()" value="XEM XÉT LẠI">
                                            <input name="dongy" type="button" onclick="cleartable2()" class="dongy" id="dongy" value="ĐỒNG Ý">
                                        </p>
                                    </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 30%;border: none;text-align: center;font-weight: bold;"> </td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%; " /></td>
                                </tr>
                            <?php  }
                        } else if ($daduyet1 == '0' && $ngayduyet1 != '0000-00-00 00:00:00') { ?>
                            <tr>
                                <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                <td style="width: 30%;border: none;text-align: center;font-weight: bold;">
                                    <img src="Images/REVIEW.jPG" style=" width:30%; padding-bottom: 5%" />
                                </td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                            </tr>
                            <?php } else if ($daduyet1 == '1' && $daduyet2 == '0' and $ngayduyet2 == '0000-00-00 00:00:00') {
                            if ($idduyet2 == $_SESSION['IDNhanVien']) { ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;">
                                        <p>
                                            <textarea id="nhanxet" name="nhanxet" style="width: 100%; font-family: Arial;" value="" placeholder="Nhận xét"></textarea>
                                        </p>
                                        <p><input class="xoa" name="xoa" type="button" onclick="review1()" value="XEM XÉT LẠI">
                                            <input name="dongy" type="button" onclick="cleartable()" class="dongy" id="dongy" value="ĐỒNG Ý">
                                        </p>
                                    </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /> </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 30%;border: none;text-align: center;font-weight: bold;"><img src="Images/tickOK.png" style="width:30%;" /></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%;" /></td>
                                </tr>
                            <?php }
                        } else if ($daduyet1 == '1' && $daduyet2 == '0' and $ngayduyet2 != '0000-00-00 00:00:00') { ?>
                            <tr>
                                <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                <td style="width: 30%;border: none;text-align: center;font-weight: bold;">
                                    <img src="Images/REVIEW.jPG" style=" width:30%; padding-bottom: 5%" />
                                </td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%;" /></td>
                            </tr>
                            <?php } else if ($daduyet1 == '1' && $daduyet2 == '1' and $daduyet3 == '0' and $ngayduyet3 == '0000-00-00 00:00:00') {
                            if ($idduyet3 == $_SESSION['IDNhanVien']) { ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;">
                                        <p>
                                            <textarea id="nhanxet" name="nhanxet" style="width: 100%; font-family: Arial;" value="" placeholder="Nhận xét"></textarea>
                                        </p>
                                        <p><input class="xoa" name="xoa" type="button" onclick="review2()" value="XEM XÉT LẠI">
                                            <input name="dongy" type="button" onclick="cleartable3()" class="dongy" id="dongy" value="ĐỒNG Ý">
                                        </p>
                                    </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%; " /> </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%; " /> </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%;" /></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%;" /> </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%;" /> </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%;" /></td>
                                </tr>
                            <?php  }
                        } else if ($daduyet1 == '1' && $daduyet2 == '1' and $daduyet3 == '0' and $ngayduyet3 != '0000-00-00 00:00:00') { ?>
                            <tr>
                                <td style="width: 30%;border: none;text-align: center;font-weight: bold;">
                                    <img src="Images/REVIEW.jPG" style=" width:30%; padding-bottom: 5%" />
                                </td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%;" /></td>
                            </tr>
                        <?php } else if ($daduyet3 == '1') { ?>
                            <tr>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:40%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:40%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:40%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:40%;" /></td>
                            </tr>
                        <?php }
                        ?>
                        <tr>
                            <td style="width: 25%;border: none;text-align: center;"><?php echo $row3["HoTenNhanVien"]; ?></td>
                            <td style="width: 25%;border: none;text-align: center;"><?php echo $row2["HoTenNhanVien"]; ?></td>
                            <td style="width: 25%;border: none;text-align: center;"><?php echo $row1["HoTenNhanVien"]; ?></td>
                            <td style="width: 25%;border: none;text-align: center;"><?php echo $row["HoTenNhanVien"]; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;border: none;text-align: center;"><?php
                                                                                    if ($nhanxet3 == NULL) {
                                                                                        $nhanxet3;
                                                                                    } else {
                                                                                        if ($daduyet3 == '1') { ?>
                                        <p style="color: green;"><?php echo  $nhanxet3; ?></p>
                                    <?php } else if ($daduyet3 == '0') { ?>
                                        <p style="color: red;"><?php echo  $nhanxet3; ?></p>
                                <?php }
                                                                                    } ?>
                            </td>
                            <td style="width: 25%;border: none;text-align: center;"><?php
                                                                                    if ($nhanxet2 == NULL) {
                                                                                        $nhanxet2;
                                                                                    } else {
                                                                                        if ($daduyet2 == '1') { ?>
                                        <p style="color: green;"><?php echo  $nhanxet2; ?></p>
                                    <?php } else if ($daduyet2 == '0') { ?>
                                        <p style="color: red;"><?php echo  $nhanxet2; ?></p>
                                <?php }
                                                                                    } ?>
                            </td>
                            <td style="width: 25%;border: none;text-align: center;"><?php
                                                                                    if ($nhanxet1 != NULL) {
                                                                                        if ($daduyet1 == '1') { ?>
                                        <p style="color: green;"><?php echo  $nhanxet1; ?></p>
                                    <?php } else if ($daduyet1 == '0') { ?>
                                        <p style="color: red;"><?php echo  $nhanxet1; ?></p>
                                <?php }
                                                                                    } else {
                                                                                        $nhanxet1;
                                                                                    }
                                ?>
                            </td>
                            <td style="width: 25%;border: none;text-align: center;"></td>
                        </tr>
                    </table>
                </div>
                <br>
            </form>
        </div>
    </div>
    <?php
    require "display/footer.php";
    ?>
    <script>
        //mức duyệt 1 đồng ý
        function update(value) {
            $.ajax({
                url: 'updatePCV.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value: value
                },
                success: function(value) {
                    console.log(value)

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function cleartable2() {
            var nhanxet = document.getElementById('nhanxet').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                nhanxet,
                id
            };
            console.log(result);
            update(result);
            var table = document.getElementById('duyet');
            table.deleteRow(1);
            var row2 = table.insertRow(1);
            var cellr21 = row2.insertCell(0);
            var cellr22 = row2.insertCell(0);
            var cellr23 = row2.insertCell(0);
            var cellr24 = row2.insertCell(0);
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            var cellr44 = row4.insertCell(0);
            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style='width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr22.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green'>" + nhanxet + "</p></td>";

        }
        //mức duyệt 2 đồng ý
        function update1(value1) {
            $.ajax({
                url: 'updatePCV.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value1: value1
                },
                success: function(value1) {
                    console.log(value)
                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function cleartable() {
            var nhanxet = document.getElementById('nhanxet').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                nhanxet,
                id
            };
            console.log(result);
            update1(result);
            var table = document.getElementById('duyet');
            table.deleteRow(1);
            var row2 = table.insertRow(1);
            var cellr21 = row2.insertCell(0);
            var cellr22 = row2.insertCell(0);
            var cellr23 = row2.insertCell(0);
            var cellr24 = row2.insertCell(0);
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            var cellr44 = row4.insertCell(0);
            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style='width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr22.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr23.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr43.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + nhanxet + "</p></td>";
        }
        //mức duyệt 3 đồng ý
        function update2(value2) {
            $.ajax({
                url: 'updatePCV.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value2: value2
                },
                success: function(value2) {
                    console.log(value)

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function cleartable3() {
            var nhanxet = document.getElementById('nhanxet').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                nhanxet,
                id
            };
            console.log(result);
            update2(result);
            var table = document.getElementById('duyet');
            table.deleteRow(1);
            var row2 = table.insertRow(1);
            var cellr21 = row2.insertCell(0);
            var cellr22 = row2.insertCell(0);
            var cellr23 = row2.insertCell(0);
            var cellr24 = row2.insertCell(0);
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            var cellr44 = row4.insertCell(0);

            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style='width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr22.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr23.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr24.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr43.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet2); ?> + "</p></td>";
            cellr44.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + nhanxet + "</p>";
        }
        //mức duyệt 1 từ chối
        function deny(value3) {
            $.ajax({
                url: 'updatePCV.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value3: value3

                },
                success: function(value3) {
                    console.log(value)

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function review() {
            var nhanxet = document.getElementById('nhanxet').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                nhanxet,
                id
            };
            console.log(result);
            deny(result);
            var table = document.getElementById('duyet');
            table.deleteRow(1);
            var row2 = table.insertRow(1);
            var cellr21 = row2.insertCell(0);
            var cellr22 = row2.insertCell(0);
            var cellr23 = row2.insertCell(0);
            var cellr24 = row2.insertCell(0);
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            var cellr44 = row4.insertCell(0);
            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style='width:30%; margin-left: 30%;' /></td>";
            cellr22.innerHTML = "<td><p><img src='Images/REVIEW.jpg' style='width:30%;margin-left: 34%;/* margin: auto; */'></p></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: red'>" + nhanxet + "</p></td>";
        }
        //mức duyệt 2 từ chối
        function deny1(value4) {
            $.ajax({
                url: 'updatePCV.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value4: value4
                },
                success: function(value4) {
                    console.log(value)

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function review1() {
            var nhanxet = document.getElementById('nhanxet').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                nhanxet,
                id
            };
            console.log(result);
            deny1(result);
            var table = document.getElementById('duyet');
            table.deleteRow(1);
            var row2 = table.insertRow(1);
            var cellr21 = row2.insertCell(0);
            var cellr22 = row2.insertCell(0);
            var cellr23 = row2.insertCell(0);
            var cellr24 = row2.insertCell(0);
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            var cellr44 = row4.insertCell(0);

            cellr23.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width:30%;margin-left: 34%;/* margin: auto; */'></td>";
            cellr22.innerHTML = "<td><img src='Images/tickOK.png' style='width:30%; margin-left: 30%;' /></td>";
            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style='width:30%;  margin-left: 30%;' /></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr43.innerHTML = "<td><p style= 'text-align: center; color: red;'>" + nhanxet + "</p></td>";
        }

        function deny2(value5) {
            $.ajax({
                url: 'updatePCV.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value5: value5
                },
                success: function(value5) {
                    console.log(value)

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function review2() {
            var nhanxet = document.getElementById('nhanxet').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                nhanxet,
                id
            };
            console.log(result);
            deny2(result);
            var table = document.getElementById('duyet');
            table.deleteRow(1);
            var row2 = table.insertRow(1);
            var cellr21 = row2.insertCell(0);
            var cellr22 = row2.insertCell(0);
            var cellr23 = row2.insertCell(0);
            var cellr24 = row2.insertCell(0);
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            var cellr44 = row4.insertCell(0);

            cellr24.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width:30%;padding-bottom: 5%;margin-left: 34%;/* margin: auto; */'></td>";
            cellr23.innerHTML = "<td><img src='Images/tickOK.png' style=' width:40%;  margin-left: 30%;' /></td>";
            cellr22.innerHTML = "<td><img src='Images/tickOK.png' style=' width:40%;  margin-left: 30%;' /></td>";
            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style=' width:40%;  margin-left: 30%;' /></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr43.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet2); ?> + "</p></td>";
            cellr44.innerHTML = "<td><p style= 'text-align: center; color: red;'>" + nhanxet + "</p>";
        }
    </script>