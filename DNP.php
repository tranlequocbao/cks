<?php
require("dbhelp.php");
session_start();
if (!isset($_SESSION["IDNhanVien"])) {
    $_SESSION['link'] = "../Thacomazda-CKDT/DNP.php?p=DNP&id=" . $_GET['id'];
    header('Location: Dangnhap.php');
}

$idphieu = $_GET['id'];
$sql = "select * from nhanvien, bophan, chucvu, phieu, loaiphieu, giayxinphep where nhanvien.IDBoPhan = bophan.IDBoPhan and nhanvien.IDChucVu = chucvu.IDChucVu and phieu.IDNhanVien = nhanvien.IDNhanVien and phieu.IDLoaiPhieu = loaiphieu.IDLoaiPhieu and phieu.IDPhieu = giayxinphep.IDPhieu and phieu.IDPhieu = '$_GET[id]' ";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);
$tennhanvien = $row['HoTenNhanVien'];
$idnhanvien = $row['IDNhanVien'];
$chucvu = $row['TenChucVu'];
// $bophan = $row['TenPhongBan'];
$nghitu =  strtotime($row['InTime']);
$gionghi = date('H', $nghitu);
$phutnghi = date('i', $nghitu);
$giophutnghi = date('H:i', $nghitu);
$ngaynghi = date('d/m/Y', $nghitu);
$nghiden = strtotime($row['OutTime']);
$dengio = date('H', $nghiden);
$denphut = date('i', $nghiden);
$dengiophut = date('H:i', $nghiden);
$denngay = date('d/m/Y', $nghiden);
$lydo  = $row['LyDo'];
$nhansubangiao = $row['NhanVienThayThe'];
$ngaytao = strtotime($row['NgayTao']);
$ngay = date('d', $ngaytao);
$thang = date('m', $ngaytao);
$nam = date('Y', $ngaytao);
$ngaythangnam = date('d/m/Y', $ngaytao);
$ghichu = $row['Note'];
$sql5 = "SELECT * FROM giayxinphep , nhanvien WHERE nhanvien.IDNhanVien = giayxinphep.NhanVienNghi and giayxinphep.IDPhieu = '$_GET[id]'";
$result4 = mysqli_query($connect, $sql5);
$row4 = mysqli_fetch_array($result4);
$sql1 = "SELECT * FROM pheduyet,caidatmau,nhanvien where pheduyet.IDNhanVien=caidatmau.IDNhanVien and caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.IDLoaiPhieu='P0001' and caidatmau.MucDuyet='1' and IDPhieu='$_GET[id]'";
$result1 = mysqli_query($connect, $sql1);
$row1 = mysqli_fetch_array($result1);
$sql3 = "SELECT * FROM pheduyet,caidatmau,nhanvien where pheduyet.IDNhanVien=caidatmau.IDNhanVien and caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.IDLoaiPhieu='P0001' and caidatmau.MucDuyet='2' and IDPhieu='$_GET[id]'";
$result3 = mysqli_query($connect, $sql3);
$row3 = mysqli_fetch_array($result3);
$idduyet1 = $row1['IDNhanVien'];
$idduyet2 = $row3['IDNhanVien'];

$sql6 = "SELECT * FROM pheduyet, giayxinphep,nhanvien where pheduyet.IDPhieu = giayxinphep.IDPhieu and nhanvien.IDNhanVien = pheduyet.IDNhanVien and  giayxinphep.NguoiDuyet1 = pheduyet.IDNhanVien and pheduyet.IDPhieu ='$_GET[id]'";
$result6 = mysqli_query($connect, $sql6);
$row6 = mysqli_fetch_array($result6);
$sql7 = "SELECT * FROM pheduyet, giayxinphep,nhanvien where pheduyet.IDPhieu = giayxinphep.IDPhieu and nhanvien.IDNhanVien = pheduyet.IDNhanVien and giayxinphep.NguoiDuyet2 = pheduyet.IDNhanVien and pheduyet.IDPhieu ='$_GET[id]'";
$result7 = mysqli_query($connect, $sql7);
$row7 = mysqli_fetch_array($result7);

$ID = $_SESSION["IDNhanVien"];
$sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID'";
$query1 = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_array($query1);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Ch??? k?? ??i???n t??? Thaco Auto</title>
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/Donxinnghiphep.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />
    <link href="Style/chitietdnp.css" rel="stylesheet" />
    <script src="js/jquery-3.2.1.min.js"></script>

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
        <div id="yeucauvattu" method="post">
            <div id="title">
                <p style=" width: auto;  float: left;">CHI TI???T PHI???U </p>
                <button class="inphieu"><a style="text-decoration:none; color:white" href="InphieuDNP.php?p=DNP&inid=<?php echo $_GET['id']; ?>">In phi???u</a></button>
            </div>

            <form id="input">

                <div class="title" style="font-weight: bold;font-size: 20px;text-align: center; font-family: Times New Roman;">
                    ????N XIN NGH??? PH??P
                    <br>
                    <b>K??nh g???i: </b> Ban Gi??m ?????c
                </div>
                <br />
                <div id="noidung">
                    <div id="td">
                        <table id="tb">
                            <tr>
                                <td style="width: 60%;"><b>T??i t??n l??: </b> <?php echo $row4['HoTenNhanVien']; ?> </td>
                                <td style="width: 60%;"><strong>MSNV: </strong> <?php echo $row['IDNhanVien']; ?> </td>
                            </tr>
                            <tr>
                                <td><strong>Ph??ng/ Ban: </strong><?php echo $row['TenBoPhan']; ?> </td>
                                <td><strong>Ch???c v???: </strong><?php echo $row['TenChucVu']; ?> </td>
                            </tr>

                        </table>
                        <br>
                        <p>Nay t??i l??m ????n n??y k??nh tr??nh Ban Gi??m ?????c cho t??i ???????c <span style="font-weight: bold;">ngh??? ph??p:</span></p>
                        <p>T??? <?php echo $gionghi; ?> gi??? <?php echo $phutnghi; ?> ph??t, ng??y <?php echo $ngaynghi; ?> ?????n <?php echo $dengio; ?> gi??? <?php echo $denphut; ?> ph??t, ng??y <?php echo $denngay; ?></p>
                        <p><span style="font-weight: bold;">L?? do:</span> <?php echo $lydo; ?></p>
                        <p>T??i ???? b??n giao c??ng vi???c trong th???i gian ngh??? ph??p l???i cho <span style="font-weight: bold;">??ng (b??): <?php echo $nhansubangiao; ?></span></p>
                        <p><span style="font-weight: bold;">??ng (b??): <?php echo $nhansubangiao; ?> </span> s??? thay th??? t??i ho??n th??nh t???t nhi???m v??? ???????c giao theo quy ?????nh.</p>
                        <p>K??nh tr??nh ban gi??m ?????c xem x??t ph?? duy???t.</p>
                        <p>Tr??n tr???ng!</p> <br>

                        <div id="finish">
                            <P style="font-style: italic;">N??i Th??nh, ng??y <?php echo $ngay; ?> th??ng <?php echo $thang; ?> n??m <?php echo $nam; ?></P>
                        </div>

                    </div>
                    <br />
                    <table id="duyet" style="border: none;">
                        <tr>
                            <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Ph?? Duy???t</td>
                            <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Xem X??t</td>
                            <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Ng?????i l???p</td>
                        </tr>
                        <?php
                        require("dbhelp.php");
                        // $con = mysqli_connect("localhost","root","","chukyso");
                        $sql1 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '1' and pheduyet.IDPhieu ='$_GET[id]'";
                        $result1 = mysqli_query($connect, $sql1);
                        $row1 = mysqli_fetch_array($result1);
                        $sql2 = "SELECT * FROM nhanvien, phieu where nhanvien.IDNhanVien = phieu.IDNhanVien and phieu.IDPhieu = '$_GET[id]'";
                        $result2 = mysqli_query($connect, $sql2);
                        $row2 = mysqli_fetch_array($result2);
                        $sql3 = "SELECT * FROM pheduyet, nhanvien where nhanvien.IDNhanVien = pheduyet.IDNhanVien and  pheduyet.MucDuyet = '2' and pheduyet.IDPhieu ='$_GET[id]'";
                        $result3 = mysqli_query($connect, $sql3);
                        $row3 = mysqli_fetch_array($result3);
                        $daduyet1 = $row1['DaDuyet'];
                        $idduyet1 = $row1['IDNhanVien'];
                        $daduyet2 = $row3['DaDuyet'];
                        $idduyet2 = $row3['IDNhanVien'];
                        $ngayduyet1 = $row1['NgayDuyet'];
                        $ngayduyet2 = $row3['NgayDuyet'];
                        $nhanxet1 = $row1['GhiChu'];
                        $nhanxet2 = $row3['GhiChu'];

                        if ($daduyet1 == '0' && $ngayduyet1 == '0000-00-00 00:00:00') {
                            if ($idduyet1 == $_SESSION['IDNhanVien']) { ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 30%;border: none;text-align: center;font-weight: bold;">
                                        <p><textarea id="nhanxet" name="nhanxet" style="width: 100%; font-family: Arial;" value="" placeholder="Nh???n x??t"></textarea> </p>
                                        <p><input class="xoa" name="xoa" type="button" onclick="review()" value="XEM X??T L???I">
                                            <input name="dongy" type="button" onclick="cleartable2()" class="dongy" id="dongy" value="?????NG ??">
                                        </p>
                                    </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%; " /></td>
                                </tr>
                            <?php } else { ?>

                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                    <td style="width: 30%;border: none;text-align: center;font-weight: bold;"> </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%; " /></td>
                                </tr>
                            <?php }
                        } else if ($daduyet1 == '0' && $ngayduyet1 != '0000-00-00 00:00:00') { ?>
                            <tr>
                                <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                <td style="width: 30%;border: none;text-align: center;font-weight: bold;"><img src="Images/REVIEW.jPG" style=" width:30%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                            </tr>

                            <?php } else if ($daduyet1 == '1' && $daduyet2 == '0' and $ngayduyet2 == '0000-00-00 00:00:00') {
                            if ($idduyet2 == $_SESSION['IDNhanVien']) {
                            ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;">
                                        <p>
                                            <textarea id="nhanxet" name="nhanxet" style="width: 100%; font-family: Arial;" value="" placeholder="Nh???n x??t"></textarea>
                                        <p>
                                        <p><input class="xoa" name="xoa" type="button" onclick="review1()" value="XEM X??T L???I">
                                            <input name="dongy" type="button" onclick="cleartable()" class="dongy" id="dongy" value="?????NG ??">
                                        </p>
                                        </p>
                                    </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%; " /> </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%; " /></td>
                                </tr>
                            <?php } else { ?>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                                </tr>
                            <?php  }
                        } else if ($daduyet1 == '1' && $daduyet2 == '0' and $ngayduyet2 != '0000-00-00 00:00:00') { ?>
                            <tr>
                                <td style="width: 30%;border: none;text-align: center;font-weight: bold;"><img src="Images/REVIEW.jPG" style=" width:30%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                            </tr>

                        <?php } else if ($daduyet1 == '1' && $daduyet2 == '1') {
                        ?>
                            <tr>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /> </td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:30%;" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style=" width:30%;" /></td>
                            </tr>
                        <?php }
                        ?>
                        <tr>
                            <td style="width: 25%;border: none;text-align: center;"><?php echo $row3['HoTenNhanVien']; ?></td>
                            <td style="width: 25%;border: none;text-align: center;"><?php echo $row1['HoTenNhanVien']; ?></td>
                            <td style="width: 25%;border: none;text-align: center;"><?php echo $row2['HoTenNhanVien']; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%;border: none;text-align: center;"><?php
                                                                                    if ($nhanxet2 == NULL) {
                                                                                        $nhanxet2;
                                                                                    } else {
                                                                                        if ($daduyet2 == '1') { ?>
                                        <p style="color: green;"><?php echo  $nhanxet2; ?></p>

                                    <?php } else if ($daduyet2 == '0') { ?>
                                        <p style="color: red;"><?php echo  $nhanxet2; ?></p>
                                <?php }
                                                                                    }
                                ?>
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
                            <td style="width: 25%;border: none;text-align: center;"><?php
                                                                                    if ($ghichu == NULL) {
                                                                                        $ghichu;
                                                                                    } else {
                                                                                        echo  $ghichu;
                                                                                    }
                                                                                    ?></td>
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
        function update(value) {
            $.ajax({
                url: 'updateDNP.php',
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
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);

            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; margin-left: 35%;' /></td>";
            cellr22.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; margin-left: 35%;' /></td>";
            cellr41.innerHTML = "<td><p style= 'text-align: center;'>" + <?php echo json_encode($ghichu); ?> + "</p></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green'>" + nhanxet + "</p></td>";
        }

        function update1(value1) {
            $.ajax({
                url: 'updateDNP.php',
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
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; margin-left: 35%;' /></td>";
            cellr22.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; margin-left: 35%;' /></td>";
            cellr23.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; margin-left: 35%;' /></td>";
            cellr41.innerHTML = "<td><p style= 'text-align: center;'>" + <?php echo json_encode($ghichu); ?> + "</p></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr43.innerHTML = "<td><p style= 'text-align: center; color: green'>" + nhanxet + "</p></td>";
        }

        function deny(value2) {
            $.ajax({
                url: 'updateDNP.php',
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
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style=' width:23%;margin-left: 35%;' /></td>";
            cellr22.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width:30%;margin-left: 34%;/* margin: auto; */'></td>";
            cellr41.innerHTML = "<td><p style= 'text-align: center;'>" + <?php echo json_encode($ghichu); ?> + "</p></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: red'>" + nhanxet + "</p></td>";
        }

        function deny1(value3) {
            $.ajax({
                url: 'updateDNP.php',
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
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            var cellr43 = row4.insertCell(0);
            cellr23.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width:30%;padding-bottom: 5%;margin-left: 34%;/* margin: auto; */'></td>";
            cellr22.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr21.innerHTML = "<td><img src='Images/tickOK.png' style=' width:30%; padding-bottom: 5%; margin-left: 30%;' /></td>";
            cellr41.innerHTML = "<td><p style= 'text-align: center;'>" + <?php echo json_encode($ghichu); ?> + "</p></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr43.innerHTML = "<td><p style= 'text-align: center; color: red'>" + nhanxet + "</p></td>";
        }
    </script>