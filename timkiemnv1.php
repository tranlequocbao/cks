<?php

session_start();
require_once "dbhelp.php";
// không có session sẽ tự động quay về trang đăng nhập
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
$i = 1;
$dk = $_POST['dieukien'];
$dept = $_POST['iddept'];
$query_search = "SELECT * FROM `nhanvien`,chucvu,bophan WHERE nhanvien.IDBoPhan = bophan.IDBoPhan and nhanvien.IDChucVu = chucvu.IDChucVu and nhanvien.IDBoPhan='$dept' and nhanvien.IDNhanVien like '%$dk%'";
$result = $conn1->query($query_search);
if ($result && $result->num_rows > 0) {
    while ($row2 = $result->fetch_assoc()) {
?>
        <tr data-id="<?= $row2['IDNhanVien']; ?>" style="counter-increment: rowNumber;">
            <td style="content: counter(rowNumber);  min-width: 1em;  margin-right: 0.5em;"><?php echo $i; ?></td>
            <td class="idnv" value='<?php echo $row2['IDNhanVien']; ?>'> <?php echo $row2['IDNhanVien']; ?></td>
            <td><?php echo $row2['HoTenNhanVien']; ?></td>
            <td><?php echo $row2['TenChucVu']; ?></td>
            <td><?php echo $row2['TenBoPhan']; ?></td>
            <td><?php echo $row2['Email']; ?></td>
            <td>
                <button id='modify' class="btn btn-primary" style="background-color: #00529C;color: white;">CHỈNH SỬA</button>
            </td>


            <td>

                <button id='delete' class="btn btn-primary" style="background-color: orangered; color: white; border-color: orangered;">XÓA</button>
            </td>
            </a>
            <?php $i++;
        }
    } else {
        $query_search = "SELECT * FROM `nhanvien`,chucvu,bophan WHERE nhanvien.IDBoPhan = bophan.IDBoPhan and nhanvien.IDChucVu = chucvu.IDChucVu and nhanvien.IDBoPhan='$dept' and nhanvien.HoTenNhanVien like '%$dk%'";
        $result = $conn1->query($query_search);
        if ($result && $result->num_rows > 0) {
            while ($row2 = $result->fetch_assoc()) {
                echo $query_search;
            ?>
        <tr data-id="<?= $row2['IDNhanVien']; ?>" style="counter-increment: rowNumber;">
            <td style="content: counter(rowNumber);  min-width: 1em;  margin-right: 0.5em;"><?php echo $i; ?></td>
            <td class="idnv" value='<?php echo $row2['IDNhanVien']; ?>'> <?php echo $row2['IDNhanVien']; ?></td>
            <td><?php echo $row2['HoTenNhanVien']; ?></td>
            <td><?php echo $row2['TenChucVu']; ?></td>
            <td><?php echo $row2['TenBoPhan']; ?></td>
            <td><?php echo $row2['Email']; ?></td>
            <td>
                <button id='modify' class="btn btn-primary" style="background-color: #00529C;color: white;">CHỈNH SỬA</button>
            </td>


            <td>

                <button id='delete' class="btn btn-primary" style="background-color: orangered; color: white; border-color: orangered;">XÓA</button>
            </td>
            </a>
<?php $i++;
            }
        } else echo "201";
    }
