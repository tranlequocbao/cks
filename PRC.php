<?php
session_start();
include "dbhelp.php";
if (!isset($_SESSION["IDNhanVien"])) {
    $_SESSION['link'] = "../Thacomazda-CKDT/PRC.php?p=PRC&id=" . $_GET['id'];
    header('Location: Dangnhap.php');
}
$idbophan = $_SESSION['IDBoPhan'];
$sql = "SELECT * FROM phieu,nhanvien,loaiphieu,giayracong,bophan,chucvu WHERE nhanvien.IDChucVu=chucvu.IDChucVu and nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and giayracong.IDNhanVienRaCong=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu and phieu.IDPhieu = giayracong.IDPhieu and phieu.IDPhieu = '$_GET[id]' ";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);
// lấy tên người duyệt
$sql1 = "SELECT * FROM pheduyet,nhanvien where pheduyet.IDNhanVien=nhanvien.IDNhanVien and pheduyet.MucDuyet='1' and IDPhieu='$_GET[id]'";
$result1 = mysqli_query($connect, $sql1);
$row1 = mysqli_fetch_array($result1);
$sql3 = "SELECT * FROM pheduyet,nhanvien where pheduyet.IDNhanVien=nhanvien.IDNhanVien and pheduyet.MucDuyet='2' and IDPhieu='$_GET[id]'";
$result3 = mysqli_query($connect, $sql3);
$row3 = mysqli_fetch_array($result3);
$tenduyet1 = $row1['HoTenNhanVien'];
$tenduyet2 = $row3['HoTenNhanVien'];
$raluc =  strtotime($row['OutTime']);
$giora = date('H', $raluc);
$phutra = date('i', $raluc);
$ngayra = date('d/m/Y', $raluc);
$vaoluc = strtotime($row['InTime']);
$giovao = date('H', $vaoluc);
$phutvao = date('i', $vaoluc);
$ngayvao = date('d/m/Y', $vaoluc);
$taoluc = strtotime($row['NgayTao']);
$thangtao = date('m', $taoluc);
$namtao = date('Y', $taoluc);
$ngaytao = date('d', $taoluc);

$ID = $_SESSION["IDNhanVien"];
$sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query1 = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_array($query1);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Phần mềm chữ ký số Thaco Mazda</title>
    <link href="Style/PRC.css" rel="stylesheet" />
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/Donxinnghiphep.css" rel="stylesheet" />
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

    <div id="content"><BR>
        <div id="yeucauvattu">
            <div id="title">
                <p style=" width: auto;  float: left;">CHI TIẾT PHIẾU </p>
                <button class="inphieu"><a style="text-decoration:none; color:white" href="InphieuPRC.php?p=PRC&inid=<?php echo $_GET['id']; ?>">In phiếu</a></button>
            </div>

            <form id="input" method="post">
                <table>
                    <div class="title" style="font-weight: bold;font-size: 20px;text-align: center; font-family: Times New Roman;">
                        PHIẾU RA CỔNG </div>
                    <br>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Họ tên:</p>
                        </td>
                        <td><?php echo $row['HoTenNhanVien']; ?> </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">MSNV:</p>
                        </td>
                        <td><?php echo $row['IDNhanVien']; ?> </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Phòng ban:</p>
                        </td>
                        <td><?php echo $row['TenBoPhan']; ?> </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Chức vụ:</p>
                        </td>
                        <td><?php echo $row['TenChucVu']; ?> </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Biển số:</p>
                        </td>
                        <td> <?php echo $row['BSXE']; ?> </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Lý do ra cổng:</p>
                        </td>
                        <td><?php echo $row['LyDo']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Có mang theo:</p>
                        </td>
                        <td><?php echo $row['GhiChu']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Ghi chú:</p>
                        </td>
                        <td><?php echo $row['ChuY']; ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Ra lúc:</p>
                        </td>
                        <td><?php echo $giora ?> giờ <?php echo $phutra ?> phút, ngày <?php echo $ngayra ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;">
                            <p style="margin: 3px;">Vào lại (nếu có):</p>
                        </td>
                        <?php if ($row['InTime'] == '0000-00-00 00:00:00.000000') { ?>
                            <td>Chưa xác định</td>
                        <?php } else { ?>
                            <td><?php echo $giovao ?> giờ <?php echo $phutvao ?> phút, ngày <?php echo $ngayvao ?></td>
                        <?php
                        }
                        ?>
                    </tr>

                </table>
                <div style=" text-align:right; font-style: italic;">Núi Thành, ngày <?php echo $ngaytao ?> tháng <?php echo $thangtao ?> năm <?php echo $namtao ?></div>
                <br />
                <table id="duyet" style="margin: auto; width: -webkit-fill-available;">
                    <tr>
                        <th style=" text-align:center;width: 50%; ">LÃNH ĐẠO CÔNG TY</th>
                        <th style=" text-align:center;width: 50%; ">PHỤ TRÁCH BỘ PHẬN</th>
                    </tr>
                    <?php
                    // $con = mysqli_connect("localhost","root","","chukyso");
                    $sql4 = "SELECT * FROM pheduyet,nhanvien where pheduyet.IDNhanVien=nhanvien.IDNhanVien and pheduyet.MucDuyet='1' and IDPhieu='$_GET[id]'";
                    $result4 = mysqli_query($connect, $sql4);
                    $row4 = mysqli_fetch_array($result4);
                    $sql5 = "SELECT * FROM pheduyet,nhanvien where pheduyet.IDNhanVien=nhanvien.IDNhanVien and pheduyet.MucDuyet='2' and IDPhieu='$_GET[id]'";
                    $result5 = mysqli_query($connect, $sql5);
                    $row5 = mysqli_fetch_array($result5);
                    $idduyet1 = $row4['IDNhanVien'];
                    $daduyet1 = $row4['DaDuyet'];
                    $ngayduyet1 = $row4['NgayDuyet'];
                    $nhanxet1 = $row4['GhiChu'];
                    $idduyet2 = $row5['IDNhanVien'];
                    $daduyet2 = $row5['DaDuyet'];
                    $ngayduyet2 = $row5['NgayDuyet'];
                    $nhanxet2 = $row5['GhiChu'];
                    if ($daduyet1 == '0' && $ngayduyet1 == '0000-00-00 00:00:00') {
                        if ($idduyet1 == $_SESSION['IDNhanVien']) { ?>
                            <tr>
                                <th style=" text-align:center;width: 50%; "></th>
                                <th style=" text-align:center;width: 50%; ">
                                    <p><textarea id="nhanxet" name="nhanxet" style="width: 90%; font-family: Arial;" value="" placeholder="Nhận xét"></textarea> </p>
                                    <p><input class="xoa" name="xoa" type="button" onclick="review()" value="Xem xét lại">
                                        <input name="dongy" type="button" onclick="cleartable2()" class="dongy" id="dongy" value="Đồng ý">
                                    </p>
                                </th>

                            </tr>
                        <?php } else { ?>
                            <tr>
                                <th height="50px" ; style=" text-align:center;width: 50%; "></th>
                                <th style=" text-align:center;width: 50%; "></th>
                            </tr>
                        <?php     }
                    } else if ($daduyet1 == '0' && $ngayduyet1 != '0000-00-00 00:00:00') { ?>
                        <tr>
                            <th style=" text-align:center;width: 50%; "></th>

                            <th style=" text-align:center;width: 50%; ">
                                <p><img src="Images/REVIEW.jPG" style=" width:18%;" /></p>
                            </th>
                        </tr>
                        <?php } else if ($daduyet1 == '1' && $daduyet2 == '0' and $ngayduyet2 == '0000-00-00 00:00:00') {
                        if ($idduyet2 == $_SESSION['IDNhanVien']) { ?>
                            <tr>
                                <th style=" text-align:center;width: 50%; ">
                                    <p><textarea id="nhanxet" name="nhanxet" style="width: 100%; font-family: Arial;" value="" placeholder="Nhận xét"></textarea> </p>
                                    <p><input class="xoa" name="xoa" type="button" onclick="review1()" value="Xem xét lại">
                                        <input name="dongy" type="button" onclick="cleartable()" class="dongy" id="dongy" value="Đồng ý">
                                    </p>
                                </th>
                                <th style=" text-align:center;width: 50%; ">
                                    <p><img src="Images/tickOK.png" style="width:18%;" /></p>
                                </th>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <th style=" text-align:center;width: 50%; "></th>
                                <th style=" text-align:center;width: 50%; "><img src="Images/tickOK.png" style="width:18%;" /></th>
                            </tr>
                        <?php }
                    } else if ($daduyet1 == '1' && $daduyet2 == '0' and $ngayduyet2 != '0000-00-00 00:00:00') { ?>
                        <tr>
                            <th style=" text-align:center;width: 50%; "><img src="Images/REVIEW.jPG" style=" width:18%;" /></th>
                            <th style=" text-align:center;width: 50%; "><img src="Images/tickOK.png" style="width:17%;" /></th>
                        </tr>
                    <?php } else if ($daduyet1 == '1' && $daduyet2 == '1') { ?>
                        <tr>
                            <th style=" text-align:center;width: 50%; "><img src="Images/tickOK.png" style="width:18%;" /></th>
                            <th style=" text-align:center;width: 50%; "><img src="Images/tickOK.png" style="width:18%;" /></th>
                        </tr>
                    <?php }
                    ?>
                    <tr>
                        <th style=" text-align:center;width: 50%; "><?php echo $tenduyet2; ?></th>
                        <th style=" text-align:center;width: 50%; "><?php echo $tenduyet1; ?></th>
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
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <?php
    require "display/footer.php";
    ?>
    <script>
        function update(value) {
            $.ajax({
                url: 'updatePRC.php',
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
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            //cellr21.innerHTML="<img src='Images/tickOK.jpg' style='height:50px; width:40%; padding-bottom: 5%; margin-left: 30%;' />";
            cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;margin-left: 40%;' /></td>";
            cellr41.innerHTML = "<td><p style= 'text-align: center; color: green'>" + nhanxet + "</p></td>";
        }

        function update1(value1) {
            $.ajax({
                url: 'updatePRC.php',
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
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;margin-left: 40%;' /></td>";
            cellr22.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;margin-left: 42%;' /></td>";
            cellr41.innerHTML = "<td><p style= 'text-align: center; color: green'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green'>" + nhanxet + "</p></td>";
        }
        //mức duyệt 1 từ chối
        function deny(value2) {
            $.ajax({
                url: 'updatePRC.php',
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
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            cellr21.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width:26%;padding-bottom: 5%;margin-left: 34%;/* margin: auto; */'></td>";
            cellr41.innerHTML = "<td><p style= 'text-align: center; color: red'>" + nhanxet + "</p></td>";
        }
        //mức duyệt 2 từ chối
        function deny1(value3) {
            $.ajax({
                url: 'updatePRC.php',
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
            table.deleteRow(3);
            var row4 = table.insertRow(3);
            var cellr41 = row4.insertCell(0);
            var cellr42 = row4.insertCell(0);
            cellr22.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width: 18%;margin-left: 38%;'></td>";
            cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px;width:60px;margin-left: 40%;' /></td>";
            cellr41.innerHTML = "<p style= 'text-align: center; color: green'>" + <?php echo json_encode($nhanxet1); ?> + "</p>";
            cellr42.innerHTML = "<p style= 'text-align: center; color: red'>" + nhanxet + "</p>";
        }
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