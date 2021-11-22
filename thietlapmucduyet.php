<?php
session_start();
require_once "dbhelp.php";
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}

if (isset($_GET["nhap"]) && !empty($_GET["nhap"])) {
    $s = $_GET["nhap"];
    $sql = "SELECT * FROM `nhanvien`,chucvu,bophan WHERE nhanvien.IDChucVu=chucvu.IDChucVu and nhanvien.IDBoPhan=bophan.IDBoPhan and nhanvien.IDNhanVien='$s'";
} else {
    $s = $_SESSION["IDNhanVien"];
    $sql = "SELECT * FROM `nhanvien`,chucvu,bophan WHERE nhanvien.IDChucVu=chucvu.IDChucVu and nhanvien.IDBoPhan=bophan.IDBoPhan and nhanvien.IDNhanVien='$s'";
}
$result = mysqli_query($connect, $sql);
while ($row = mysqli_fetch_array($result)) {
    $maPB = $row['IDBoPhan'];
    $tenNV = $row['HoTenNhanVien'];
    $tenPB = $row['TenBoPhan'];
    $tenCV = $row['TenChucVu'];
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

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Phần mềm chữ ký số Thaco Mazda</title>
    <link href="Style/phanquyen.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <!-- <script src="js/jquery-3.2.1.slim.min.js"></script> -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background: url(images/VPMazda.jpg) no-repeat;">
    <?php
    require "display/header.php";
    ?>

    <div id="ttc">
        <table id="customers">
            </td>
            <tr>
                <th>THIẾT LẬP MỨC DUYỆT</th>
                <th></th>
            </tr>
            <tr>
                <td>Mã số nhân viên</td>
                <td>
                    <form action="" method="get">
                        <input type="text" id="fname" name="nhap" placeholder="<?php echo $maNV ?>" style=" width: 60%; height: 30px;justify-content:left;">
                    </form>
                </td>
            </tr>
            <tr>
                <td>Tên nhân viên</td>
                <td><?php echo $tenNV ?></td>
            </tr>
            <tr>
                <td>Bộ phận</td>
                <td><?php echo $tenPB ?></td>
            </tr>
            <tr>
                <td>Chức vụ</td>
                <td><?php echo $tenCV ?></td>
            </tr>
        </table>
        <form action="" method="post">

            <div id="QLtheoloai">

                <fieldset>
                    <legend>Phiếu ra cổng</legend>
                    <table>
                        <tr>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức phê duyệt</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 1</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 2</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 3</td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset>
                    <legend>Giấy xin phép</legend>
                    <table>
                        <tr>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức phê duyệt</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 1</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 2</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 3</td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset>
                    <legend>Phiếu yêu cầu công việc</legend>
                    <table>
                        <tr>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức phê duyệt</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 1</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 2</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 3</td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset>
                    <legend>Phiếu yêu cầu vật tư</legend>
                    <table>
                        <tr>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức phê duyệt</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 1</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 2</td>
                            <td style="width: 230px"><input type="checkbox" id="checkAll" /> Mức kiểm tra 3</td>
                        </tr>
                    </table>
                </fieldset>
            </div>
            <div>
                <button type=submit style="margin-left: 30%;">THAY ĐỔI</button>
                <button type=submit style="margin-left: 10%;">LƯU THÔNG TIN</button>

            </div>
        </form>
    </div>
    <?php
    require "display/footer.php";
    ?>

    