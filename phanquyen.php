<?php
require_once "dbhelp.php";
session_start();
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}

$idbophan = $_SESSION['IDBoPhan'];
$ID = $_SESSION["IDNhanVien"];
$sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query1 = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_array($query1);  

if (isset($_GET["member"]) && !empty($_GET["member"])) {
    $s = $_GET["member"];
    $sql4 = "SELECT * from nhanvien where IDNhanVien = '$s'";
    $query4 = mysqli_query($connect, $sql4);
    if (mysqli_num_rows($query4) == 0) {
        $message = "MSNV không đúng!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        $x = $_SESSION["IDNhanVien"];
        $sql3 = "SELECT * FROM `nhanvien`,chucvu,bophan,nhomquyen WHERE nhanvien.IDNhomQuyen=nhomquyen.IDNhom and nhanvien.IDChucVu=chucvu.IDChucVu and nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and nhanvien.IDNhanVien='$x'";
    } else {
        $sql3 = "SELECT * FROM `nhanvien`,chucvu,bophan,nhomquyen WHERE nhanvien.IDNhomQuyen=nhomquyen.IDNhom and nhanvien.IDChucVu=chucvu.IDChucVu and nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and nhanvien.IDNhanVien='$s'";
    }
} else {
    $s = $_SESSION["IDNhanVien"];
    $sql3 = "SELECT * FROM `nhanvien`,chucvu,bophan,nhomquyen WHERE nhanvien.IDNhomQuyen=nhomquyen.IDNhom and nhanvien.IDChucVu=chucvu.IDChucVu and nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and nhanvien.IDNhanVien='$s' and bophan.IDBoPhan='$idbophan'";
}
$result3 = mysqli_query($connect, $sql3);
while ($row = mysqli_fetch_array($result3)) {
    $maPB = $row['IDBoPhan'];
    $tenNV = $row['HoTenNhanVien'];
    $tenPB = $row['TenBoPhan'];
    $tenCV = $row['TenChucVu'];
    $maNV = $row['IDNhanVien'];
    $maNM = $row['IDNhaMay'];
    $manhomquyen = $row['IDNhomQuyen'];
    $tenquyen = $row['TenQuyen'];
}

$IDnhomquyen = $_POST["nhomquyen"];
if (isset($_POST["save"])) {
    $sql6 = "UPDATE `nhanvien` set IDNhomQuyen='" . mysqli_real_escape_string($connect, $IDnhomquyen) . "' Where IDNhanVien='$maNV'";
    mysqli_query($connect, $sql6);
    $message1 = 'Quyền của nhân viên đã được thay đổi';
    echo "<SCRIPT>
        alert('$message1');
        
    </SCRIPT>";
}



?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Phần mềm chữ ký số Thaco Mazda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/phanquyen.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>



</head>

<body style="background: url(images/VPMazda.jpg) no-repeat;">


    <?php
    require "display/header.php";
    ?>

    <div id="ttc">

       

            <div id="title">
                PHÂN QUYỀN
            </div>
            </tr>
            <div style="padding: 20px">
            <table id="customers">
            <tr>
                <td>Mã số nhân viên</td>
                <td>
                    <form action="" method="get">
                        <input type="text" name="member" id="ipidmember" placeholder="<?php echo $maNV ?>" style=" padding: 12px 20px; margin: 8px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; height: 45px;">
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
            <tr>
                <td>Nhóm quyền</td>
                <td>
                    <form action="" method="post">
                        <select id="country" name="nhomquyen">
                            <option selected value="<?php echo $manhomquyen ?>"><?php echo $tenquyen ?></option>
                            <?php
                            $sql5 = "SELECT * FROM nhomquyen WHERE IDNhom != '$manhomquyen'";
                            $result5 = mysqli_query($connect, $sql5);
                            while ($row = mysqli_fetch_array($result5)) {
                            ?>
                                <option value="<?php echo $row["IDNhom"] ?>"><?php echo $row["TenQuyen"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                </td>
            </tr>
        </table>
        <div style="text-align:center">
            <button type=submit name="save" class="btn btn-primary">CẬP NHẬT</button>
        </div>
        </form>
        </div>
    </div>
    </div>
    <?php
    require "display/footer.php";
    ?>