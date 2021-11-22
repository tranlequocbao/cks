<?php

session_start();
require_once "dbhelp.php";
// không có session sẽ tự động quay về trang đăng nhập
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
$dept = '';
$order = '';
$name = $_POST['name'];
$iddept = $_POST['dept'];
$idorder = $_POST['order'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$id = $_POST['idnv'];
$query_dept = 'select IDBoPhan from bophan where TenBoPhan="' . $iddept . '"';
$result = $conn1->query($query_dept);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $dept = $row['IDBoPhan'];
}

$query_order = 'select IDChucVu from chucvu where TenChucVu="' . $idorder . '"';
$result = $conn1->query($query_order);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $order = $row['IDChucVu'];
}

if ($pass != '')
    $query = 'update nhanvien set HoTenNhanVien="' . $name . '",IDChucVu="' . $order . '",IDBoPhan="' . $dept . '",Email="' . $email . '",MatKhau="' . $pass . '" where IDNhanVien="' . $id . '"';
else
    $query = 'update nhanvien set HoTenNhanVien="' . $name . '",IDChucVu="' . $order . '",IDBoPhan="' . $dept . '",Email="' . $email . '" where IDNhanVien="' . $id . '"';
$result = $conn1->query($query);
if (mysqli_query($conn1, $query)) {
    echo json_encode(['code' => 200]);
} else echo json_encode(['code' => 201]);

return;
