<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<?php
require_once "dbhelp.php";
if (session_id() === '')
    session_start();

//lay du lieu len
$u = $_POST['username'];
$p = $_POST['password'];

$u = stripcslashes($u);
$p = stripcslashes($p);


if ($u == "" || $p == "") {
    // echo "<script type='text/javascript'>alert('Đăng nhập thất bại, vui lòng kiểm tra lại thông tin đăng nhập');</script>";
    $message = 'Vui lòng nhập thông tin đăng nhập.';

    echo "<SCRIPT>
            alert('$message')
            window.location.replace('Index.php');
        </SCRIPT>";
} else {
    // Tim user va pass co trong csdl ko?

    $sql = mysqli_query($connect, "select * from nhanvien where IDNhanVien='$u' and MatKhau='$p'")
        or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
    $row = mysqli_fetch_array($sql);
    if ($row == 0) {
        $message1 = 'Thông tin đăng nhập không đúng, Vui lòng kiểm tra lại.';
        echo "<SCRIPT>
                    alert('$message1')
                    window.location.replace('Index.php');
                </SCRIPT>";
    } else {
        $_SESSION["HoTenNhanVien"] = $row["HoTenNhanVien"];
        $_SESSION["IDNhanVien"] = $row["IDNhanVien"];
        $_SESSION["IDChucVu"] = $row["IDChucVu"];
        $_SESSION["IDBoPhan"] = $row["IDBoPhan"];
        $_SESSION["MatKhau"] = $row["MatKhau"];
        if (isset($_SESSION['link']))
            header("Location: " . $_SESSION['link']);
        else
            header("Location: Index.php");
    }
}
?>