<thead class=" text-primary">         
                                        <th>
                                            TT
                                        </th>
                                        <th>
                                            MSNV
                                        </th>

                                        <th>
                                            TÊN NHÂN VIÊN
                                        </th>
                                        <th>
                                            CHỨC DANH
                                        </th>
                                        <th>
                                            BỘ PHẬN/ XƯỞNG
                                        </th>
                                        <th>
                                            EMAIL
                                        </th>
                                        <th>
                                        </th>
                                        <th>
                                        </th>
</thead>
<?php
session_start();
require_once "dbhelp.php";
// không có session sẽ tự động quay về trang đăng nhập
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}

$idDept=$_POST['idDept'];
$sql2 = "SELECT * FROM `nhanvien`,chucvu,bophan WHERE nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and nhanvien.IDChucVu = chucvu.IDChucVu and bophan.IDBoPhan like '%$idDept%'";

$result2 = mysqli_query($connect, $sql2);
$i = 1;

while ($row2 = mysqli_fetch_array($result2)) {
?>
    <tbody id="table_han" style="counter-reset: rowNumber;">
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
    </tbody>
<?php $i++;
}
?>