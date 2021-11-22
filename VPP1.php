<?php session_start();
require_once "dbhelp.php";
if (!isset($_SESSION["IDNhanVien"])) {
    $_SESSION['link'] = "../Thacomazda-CKDT/VPP.php?p=VPP&id=" . $_GET['id'];
    header('Location: Dangnhap.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Chữ ký điện tử Thaco Auto</title>
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/Stylephieu.css" rel="stylesheet" />
    <link href="Style/chitietvpp.css" rel="stylesheet" />
    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
    <link href="Style/display.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <!-- <script src="js/jquery-3.2.1.slim.min.js"></script> -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</head>
<?php

$ID = $_SESSION["IDNhanVien"];
$sql1 = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query1 = mysqli_query($connect, $sql1);
$row1 = mysqli_fetch_array($query1);

?>

<body>
    <?php
    require "display/header.php";
    ?>

    <div id="content">
        <div id="yeucauvattu">
            <div id="title">
                CHI TIẾT PHIẾU <?php $idphieu = $_GET['id'];
                                ?>
                <button class="inphieu"><a style="text-decoration:none; color:white" href="InphieuVPP.php?p=VPP&inid=<?php echo $_GET['id']; ?>">In phiếu</a></button>
            </div>

            <div class="title" style="font-weight: bold;font-size: 14px;text-align: center;">
                <br />
                PHIẾU ĐỀ NGHỊ CẤP VẬT TƯ VĂN PHÒNG PHẨM
                <br />
                -------oOo-------
            </div>
            <?php
            $infomation = "SELECT * FROM yeucauvpp,nhanvien,bophan, vattu WHERE yeucauvpp.IDNhanVien=nhanvien.IDNhanVien AND nhanvien.IDBoPhan=bophan.IDBoPhan AND IDPhieu='$idphieu' AND vattu.IDVatTu=yeucauvpp.IDVatTu";
            $query = mysqli_query($connect, $infomation);
            $row = mysqli_fetch_array($query);
            $htnv = $row["HoTenNhanVien"];
            $bp = $row["TenBoPhan"];
            ?>
            <div id="noidung" style="width: 90%; margin: auto;">
                <div id="td">
                    <p><strong>Người đề nghị: </strong><?php echo $htnv; ?></p>
                    <p><strong>Xưởng/Bộ phận/Phòng ban: </strong><?php echo $bp; ?></p>
                    <p>Đề nghị Ban lãnh đạo xét duyệt cho cấp một số các vật tư sau:</p>
                </div>
                <br />
                <table class="TableData">
                    <tr class="row header blue">
                        <th class="cell">TT</th>
                        <th class="cell">Tên vật tư</th>
                        <th class="cell">Đơn vị tính</th>
                        <th class="cell">Số lượng</th>
                        <th class="cell">Hạng mục sử dụng</th>
                        <th class="cell">Ghi chú</th>
                    </tr>
                    <?php
                    if ($result = mysqli_query($connect, $infomation)) {
                        if (mysqli_num_rows($result) > 0) {
                            $stt = 1;
                            while ($dong = mysqli_fetch_array($result)) {
                    ?>
                                <tr>
                                    <td style="text-align: center;border:1px solid lightgray; padding: 0px 5px; width: 75px;"><?php echo $stt;
                                                                                                                            $stt++; ?></td>
                                    <td style="text-align: left;border:1px solid lightgray; padding: 0px 5px; width: 250px;"><?php echo $dong['TenVatTu']; ?></td>
                                    <td style="text-align: center;border:1px solid lightgray; width: 100px;"><?php echo $dong['DonViTinh']; ?></td>
                                    <td style="text-align: center;border:1px solid lightgray; width: 80px;"><?php echo $dong['SoLuong']; ?></td>
                                    <td style="text-align: center;border:1px solid lightgray;"><?php echo $dong['HangMucSuDung']; ?></td>
                                    <td style="text-align: center;  width: 200px;border:1px solid lightgray;"><?php echo $dong['GhiChu']; ?></td>
                                </tr>
                            <?php
                            }
                            // Giải phóng bộ nhớ của biến
                            mysqli_free_result($result);
                        } else {
                            ?>
                            <tr>
                                <td colspan="4">No Records.</td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "ERROR: Không thể thực thi câu lệnh $sql. " . mysqli_error($con);
                    }
                    ?>

                </table>
                <br />
                <?php
                    $ngaytao = "SELECT * FROM phieu WHERE IDPhieu='$idphieu'";
                    $queryngaytao = mysqli_query($connect, $ngaytao);
                    $rowngaytao = mysqli_fetch_array($queryngaytao);
                    $thoigiantao = strtotime($rowngaytao['NgayTao']);
                    $ngaytao = date('d', $thoigiantao);
                    $thangtao = date('m', $thoigiantao);
                    $namtao = date('Y', $thoigiantao);
                ?>
                <p style="text-align:right;font-style: italic;">Núi Thành, ngày <?php echo $ngaytao ?> tháng <?php echo $thangtao ?> năm <?php echo $namtao ?> </p>
               

                <table id="duyet" style="border: none;">
                    <tr>
                        <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Duyệt</td>
                        <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Kế toán</td>
                        <td class="txtXemXet" style="width: 25%;border: none;text-align: center;font-weight: bold;">Kiểm tra</td>
                        <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Người lập</td>
                    </tr>





                    <form action="" method="post">
                        <tr>
                            <?php
                            $duyet1 = "SELECT * FROM pheduyet, caidatmau WHERE pheduyet.IDNhanVien=caidatmau.IDNhanVien AND caidatmau.MucDuyet=1 AND pheduyet.IDPhieu='" . $idphieu . "' AND caidatmau.IDLoaiPhieu='P0002'";
                            $query1 = mysqli_query($connect, $duyet1);
                            $row1 = mysqli_fetch_assoc($query1);
                            $daduyet1 = $row1["DaDuyet"];
                            $ngayduyet1 = $row1["NgayDuyet"];
                            $nhanxet1 = $row1["GhiChu"];
                            $duyet2 = "SELECT * FROM pheduyet, caidatmau WHERE pheduyet.IDNhanVien=caidatmau.IDNhanVien AND caidatmau.MucDuyet=2 AND pheduyet.IDPhieu='" . $idphieu . "' AND caidatmau.IDLoaiPhieu='P0002'";
                            $query2 = mysqli_query($connect, $duyet2);
                            $row2 = mysqli_fetch_array($query2);
                            $ngayduyet2 = $row2["NgayDuyet"];
                            $daduyet2 = $row2["DaDuyet"];
                            $nhanxet2 = $row2["GhiChu"];
                            $duyet3 = "SELECT * FROM pheduyet, caidatmau WHERE pheduyet.IDNhanVien=caidatmau.IDNhanVien AND caidatmau.MucDuyet=3 AND pheduyet.IDPhieu='" . $idphieu . "' AND caidatmau.IDLoaiPhieu='P0002'";
                            $query3 = mysqli_query($connect, $duyet3);
                            $row3 = mysqli_fetch_array($query3);
                            $ngayduyet3 = $row3["NgayDuyet"];
                            $daduyet3 = $row3["DaDuyet"];
                            $nhanxet3 = $row3["GhiChu"];
                            if ($row1["DaDuyet"] == "0" && $ngayduyet1 == '0000-00-00 00:00:00') {
                                if ($row1["IDNhanVien"] == $_SESSION["IDNhanVien"]) {
                            ?>
                                    <td style="width: 25%; border: none; text-align: center; height:60px"></td>
                                    <td style="width: 25%; border: none; text-align: center; height:60px"></td>
                                    <td class="txtXemXet" class="txtXemXet" style="width: 25%; border: none; text-align: center; height:60px">
                                        <p><textarea id="ghichu" name="ghichu" cols="30" rows="2" style="font-family: Arial;margin: auto;width: 90%;height: 43px;" placeholder="Nhận xét"></textarea></p>
                                        <p>
                                            <input class="xemlai" type="button" onclick="review()" value="XEM XÉT LẠI"></input>
                                            <input name="dongy" type="button" onclick="cleartable1()" class="dongy" id="dongy" value="ĐỒNG Ý">

                                        </p>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <?php
                                } else {
                                ?>
                                    <td style="width: 25%;border: none;text-align: center; height:60px"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"></td>
                                    <td class="txtXemXet" style="width: 25%;border: none;text-align: center; height:60px"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <?php
                                }
                            } else if ($daduyet1 == '0' && $ngayduyet1 != '0000-00-00 00:00:00') { ?>
                                <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                <td class="txtXemXet" style="width: 30%;border: none;text-align: center;font-weight: bold;">
                                    <img src="Images/REVIEW.jPG" style=" width:30%; padding-bottom: 5%" />
                                </td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="height:100%; width:40%;padding-bottom: 10%" /></td>
                                <?php } else if ($daduyet1 == '1' && $daduyet2 == '0' and $ngayduyet2 == '0000-00-00 00:00:00') {
                                if ($row2["IDNhanVien"] == $_SESSION["IDNhanVien"]) {
                                ?>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px">
                                        <p><textarea id="ghichu" name="ghichu" cols="30" rows="2" style="font-family: Arial;margin: auto;width: 90%;height: 43px;" placeholder="Nhận xét"></textarea></p>
                                        <p>
                                            <input type="button" name="xemlai" onclick="review1()" value="XEM XÉT LẠI" class="xemlai"></input>
                                            <input name="dongy" type="button" onclick="cleartable2()" class="dongy" id="dongy" value="ĐỒNG Ý"></input>
                                        </p>
                                    </td>
                                    <td class="txtXemXet" style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <?php
                                } else {
                                ?>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"></td>
                                    <td class="txtXemXet" style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <?php
                                }
                            } else if ($daduyet1 == '1' && $daduyet2 == '0' and $ngayduyet2 != '0000-00-00 00:00:00') { ?>
                                <td style="width: 25%;border: none;text-align: center;font-weight: bold;"></td>
                                <td style="width: 30%;border: none;text-align: center;font-weight: bold;">
                                    <img src="Images/REVIEW.jPG" style=" width:30%; padding-bottom: 5%" />
                                </td>
                                <td class="txtXemXet" style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="height:70%; width:40%; padding-bottom: 5%" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="height:70%; width:40%; padding-bottom: 5%" /></td>
                                <?php } else if ($daduyet1 == '1' && $daduyet2 == '1' and $daduyet3 == '0' and $ngayduyet3 == '0000-00-00 00:00:00') {
                                if ($row3["IDNhanVien"] == $_SESSION["IDNhanVien"]) { ?>

                                    <td style="width: 25%;border: none;text-align: center;height:60px">
                                        <p><textarea id="ghichu" name="ghichu" cols="30" rows="2" style="font-family: Arial;margin: auto;width: 90%;height: 43px;" placeholder="Nhận xét"></textarea></p>
                                        <p>
                                            <input type="button" onclick="review2()" name="xemlai" value="XEM XÉT LẠI" class="xemlai"></input>
                                            <input name="dongy" type="button" onclick="cleartable3()" class="dongy" id="dongy" value="ĐỒNG Ý"></input>
                                        </p>
                                    </td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                    <td class="txtXemXet" style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <?php

                                } else {
                                ?>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                    <td class="txtXemXet" style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                    <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <?php
                                }
                            } else if ($daduyet1 == '1' && $daduyet2 == '1' and $daduyet3 == '0' and $ngayduyet3 != '0000-00-00 00:00:00') { ?>
                                <td style="width: 30%;border: none;text-align: center;font-weight: bold;">
                                    <img src="Images/REVIEW.jPG" style=" width:30%; padding-bottom: 5%" />
                                </td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="height:100%; width:40%;padding-bottom: 5%" /></td>
                                <td class="txtXemXet" style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="height:100%; width:40%;padding-bottom: 5%" /></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="height:100%; width:40%;padding-bottom: 5%" /></td>
                            <?php } else if ($daduyet3 == '1') { ?>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <td class="txtXemXet" style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                                <td style="width: 25%;border: none;text-align: center;height:60px"><img src="Images/tickOK.png" style="width:60px;height:50px;"></td>
                            <?php
                            }
                            ?>
                        </tr>

                    </form>
                    <tr>
                        <td style="width: 25%;border: none;text-align: center;">
                            <?php
                            $duyet = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=3 AND caidatmau.IDLoaiPhieu='P0002' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $idphieu . "'";
                            $thuchiend = mysqli_query($connect, $duyet);
                            $rowd = mysqli_fetch_array($thuchiend);
                            $htnd = $rowd["HoTenNhanVien"];
                            echo $htnd;
                            ?>
                        </td>
                        <td style="width: 25%;border: none;text-align: center;"><?php
                                                                                $ketoan = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=2 AND caidatmau.IDLoaiPhieu='P0002' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $idphieu . "'";
                                                                                $thuchienkt = mysqli_query($connect, $ketoan);
                                                                                $rowkt = mysqli_fetch_array($thuchienkt);
                                                                                $htnkt = $rowkt["HoTenNhanVien"];
                                                                                echo $htnkt;
                                                                                ?></td>
                         <td class="txtXemXet" style="width: 25%;border: none;text-align: center;"><?php
                                                                                $taoduyet = "SELECT * FROM caidatmau, nhanvien,pheduyet WHERE caidatmau.IDNhanVien=nhanvien.IDNhanVien and caidatmau.MucDuyet=1 AND caidatmau.IDLoaiPhieu='P0002' AND nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDPhieu='" . $idphieu . "'";
                                                                                $thuchientd = mysqli_query($connect, $taoduyet);
                                                                                $rowtd = mysqli_fetch_array($thuchientd);
                                                                                $htntd = $rowtd["HoTenNhanVien"];
                                                                                $msnvtd=$rowtd["IDNhanVien"];
                                                                                echo $htntd;
                                                                                ?></td>
                        <td style="width: 25%;border: none;text-align: center;"><?php
                                                                                $nguoitao = "SELECT * FROM phieu, nhanvien WHERE phieu.IDNhanVien=nhanvien.IDNhanVien AND phieu.IDPhieu='" . $idphieu . "'";
                                                                                $thuchiennt = mysqli_query($connect, $nguoitao);
                                                                                $rownt = mysqli_fetch_array($thuchiennt);
                                                                                $htnnt = $rownt["HoTenNhanVien"];
                                                                                $msnvnt=$rownt["IDNhanVien"];
                                                                                echo $htnnt;
                                                                                ?></td>
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
                        <td class="txtXemXet" style="width: 25%;border: none;text-align: center;"><?php
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
        </div>
    </div>

    <?php
    require "display/footer.php";
    ?>

    <script>
        var idtao=<?php echo $msnvnt?>;
        var idtaoduyet=<?php echo $msnvtd?>;
        if(idtao==idtaoduyet){
            $('.txtXemXet').css('display', 'none');
        }
        else{
            $('.txtXemXet').css('display', 'block');
        }
        function update1(value1) {
            $.ajax({
                url: 'updateVPP.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value1: value1

                },
                success: function(value1) {
                    alert("Duyệt yêu cầu thành công.");

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function update2(value2) {
            $.ajax({
                url: 'updateVPP.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value2: value2
                },
                success: function(value2) {
                    alert("Duyệt yêu cầu thành công.");

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function update3(value3) {
            $.ajax({
                url: 'updateVPP.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value3: value3

                },
                success: function(value3) {
                    alert("Duyệt yêu cầu thành công.");

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }


        function cleartable1() {
            var ghichu = document.getElementById('ghichu').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];

            var result1 = {
                ghichu,
                id
            };
            console.log(result1);

            update1(result1);
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
            cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr22.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr23.innerHTML = "";
            cellr24.innerHTML = "";
            cellr42.innerHTML = "<td> <p style= 'text-align: center; color: green'>" + ghichu + "</p></td>";



        }

        function cleartable2() {
            var ghichu = document.getElementById('ghichu').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result2 = {
                ghichu,
                id
            };

            update2(result2);
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
            cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr22.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr23.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr24.innerHTML = "";
            cellr42.innerHTML = "<td> <p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr43.innerHTML = "<td> <p style= 'text-align: center; color: green;'>" + ghichu + "</p></td>";



        }

        function cleartable3() {
            var ghichu = document.getElementById('ghichu').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result3 = {
                ghichu,
                id
            };

            update3(result3);
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
            cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr22.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr23.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr24.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
            cellr42.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
            cellr43.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet2); ?> + "</p></td>";
            cellr44.innerHTML = "<td><p style= 'text-align: center; color: green;'>" + ghichu + "<p></td>";

        }

        function deny(value4) {
            $.ajax({
                url: 'updateVPP.php',
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

        function review() {
            var ghichu = document.getElementById('ghichu').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                ghichu,
                id
            };
            console.log(result);
            if (ghichu == "") {
                alert("Vui lòng nhập nhận xét.");
            } else {
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
                cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
                cellr22.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width:30%;padding-bottom: 5%;/* margin: auto; */'></td>";
                cellr42.innerHTML = "<td> <p style= 'text-align: center; color: red;'>" + ghichu + "</p></td>";
            }
        }
        //mức duyệt 2 từ chối
        function deny1(value5) {
            $.ajax({
                url: 'updateVPP.php',
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

        function review1() {
            var ghichu = document.getElementById('ghichu').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                ghichu,
                id
            };
            console.log(result);
            if (ghichu == "") {
                alert("Vui lòng nhập nhận xét.");
            } else {
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
                cellr23.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width:30%;padding-bottom: 5%;/* margin: auto; */'></td>";
                cellr22.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
                cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
                cellr42.innerHTML = "<td> <p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
                cellr43.innerHTML = "<td> <p style= 'text-align: center; color: red;'>" + ghichu + "</p></td>";
            }
        }

        function deny2(value6) {
            $.ajax({
                url: 'updateVPP.php',
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    value6: value6
                },
                success: function(value6) {
                    console.log(value)

                },
                error: function(error) {
                    console.log(error.responseText)
                }
            });
        }

        function review2() {
            var ghichu = document.getElementById('ghichu').value;
            var $_GET = <?php echo json_encode($_GET); ?>;
            var id = $_GET['id'];
            var result = {
                ghichu,
                id
            };
            console.log(result);
            if (ghichu == "") {
                alert("Vui lòng nhập nhận xét.");
            } else {
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

                cellr24.innerHTML = "<td><img src='Images/REVIEW.jpg' style='width:30%;padding-bottom: 5%;/* margin: auto; */'></td>";
                cellr23.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
                cellr22.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
                cellr21.innerHTML = "<td style='width: 25%;border: none;text-align: center;height:60px'><img src='Images/tickOK.png' style='height:50px; width:60px;' /></td>";
                cellr42.innerHTML = "<td> <p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet1); ?> + "</p></td>";
                cellr43.innerHTML = "<td> <p style= 'text-align: center; color: green;'>" + <?php echo json_encode($nhanxet2); ?> + "</p></td>";
                cellr44.innerHTML = "<td> <p style= 'text-align: center; color: red;'>" + ghichu + "</p></td>";
            }
        }
    </script>