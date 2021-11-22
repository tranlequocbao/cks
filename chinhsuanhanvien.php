<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Chữ ký điện tử Thaco Auto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />
    <link href="Style/Stylephieu.css" rel="stylesheet" />
    <script src="js/jquery-2.1.4.js"></script>
</head>

<body>
    <?php
    session_start();
    require_once "dbhelp.php";
    // không có session sẽ tự động quay về trang đăng nhập
    if (!isset($_SESSION["IDNhanVien"])) {
        header('Location: Dangnhap.php');
    }
    ?>

    <?php
    require "display/header.php";
    ?>

    <div id="content">
        <form id="yeucauvattu" action="#" method="post">
            <div>

                <div id="title">
                    CHỈNH SỬA THÔNG TIN NHÂN VIÊN
                </div>
                <!-- <form action="" method="post"  enctype="multipart/form-data"> -->

                <div style="background:00529C;width: 60%;margin: auto;">
                    <table>
                        <tr>
                            <td>Mã số nhân viên:</td>
                            <td><input type="text" name="masonhanvien" style="width:100%"></td>
                        </tr>
                        <br />
                        <tr>
                            <td>Họ và tên:</td>
                            <td><input type="text" name="hovaten" style="width:100%"></td>
                        </tr>
                        <br />
                        <tr>
                            <td>Bộ phận:</td>
                            <td>
                                <select id="cboBoPhan" name="bophan">
                                    <?php
                                    $bp = mysqli_query($connect, "SELECT * FROM bophan ORDER BY IDBoPhan ASC")
                                        or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                                    while ($row = mysqli_fetch_assoc($bp)) {
                                    ?>
                                        <option value="<?php echo $row["IDBoPhan"] ?>"><?php echo $row["TenBoPhan"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Chức vụ:</td>
                            <td>
                                <select id="cboChucVu" name="chucvu" style="width:100%">
                                    <?php
                                    $bp = mysqli_query($connect, "SELECT * FROM chucvu ORDER BY IDChucVu ASC")
                                        or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                                    while ($row = mysqli_fetch_assoc($bp)) {
                                    ?>
                                        <option value="<?php echo $row["IDChucVu"] ?>"><?php echo $row["TenChucVu"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" name="Email" style="width:100%"></td>
                        </tr>
                        <tr>
                            <td>Mật khẩu:</td>
                            <td><input type="text" name="matkhau" style="width:100%"></td>
                        </tr>
                    </table>
                </div>

                <div id="duoi" style="    text-align: center;">
                    <button type="submit" class="btn btn-primary" name="process" value="Cập Nhật">
                    </button>
                </div>
            <br>
        </form>
    </div>
    <?php
    require "display/footer.php";
    ?>

    <?php
    if (isset($_POST['process'])) {
        $msnv = $_POST['masonhanvien'];
        $ht = $_POST['hovaten'];
        $bp = $_POST['bophan'];
        $cv = $_POST['chucvu'];
        $mail = $_POST['Email'];
        $mk = $_POST['matkhau'];


        $sqlthemnhanvien = "INSERT INTO `nhanvien`(`IDNhanVien`, `HoTenNhanVien`, `IDChucVu`, `IDBoPhan`, `IDNhomQuyen`, `Email`, `MatKhau`) VALUES ('" . $msnv . "','" . $ht . "','" . $cv . "','" . $bp . "','','" . $mail . "','" . $mk . "')";
        $querythemnhanvien = mysqli_query($connect, $sqlthemnhanvien);
        if (isset($querythemnhanvien)) {
            $message1 = 'Thêm thông tin nhân viên thành công.';
            echo "<SCRIPT>
                alert('$message1');
                </SCRIPT>";
        } else {
            $message2 = 'Thêm thông tin nhân viên thất bại.';
            echo "<SCRIPT>
                alert('$message2');
                </SCRIPT>";
        }
    }
    ?>