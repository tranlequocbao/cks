<?php
require_once "dbhelp.php";
session_start();
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
$IDnhanvien = $_SESSION["IDNhanVien"];
$dept = $_SESSION['IDBoPhan'];

if (isset($_SESSION["IDBoPhan"])) {
    $query_dept = 'SELECT DISTINCT TenBoPhan from bophan,nhanvien WHERE bophan.IDBoPhan=nhanvien.IDBoPhan and nhanvien.IDBoPhan="' . $_SESSION["IDBoPhan"] . '"';
    $result_dept = mysqli_query($connect, $query_dept);
    $row_dept = mysqli_fetch_array($result_dept);
}
if (isset($_GET["nhap"]) && !empty($_GET["nhap"])) {
    $message1 = 'abc';
    echo "<SCRIPT>
                    alert('$message1')
                    window.location.replace('Index.php');
                </SCRIPT>";
    // $name_search = $_GET["nhap"];

    // $sql2 = "SELECT * FROM nhanvien,chucvu,bophan WHERE nhanvien.IDBoPhan = bophan.IDBoPhan and nhanvien.IDChucVu = chucvu.IDChucVu and nhanvien.IDNhanVien = '$name_search' and nhanvien.IDBoPhan='$dept'";
} else {
    $sql2 = "SELECT * FROM `nhanvien`,chucvu,bophan WHERE nhanvien.IDBoPhan = bophan.IDBoPhan and nhanvien.IDChucVu = chucvu.IDChucVu and nhanvien.IDBoPhan='$dept'";
}
$result2 = mysqli_query($connect, $sql2);

?>
<?php
$IDnhanvien = $_SESSION["IDNhanVien"];
$sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$IDnhanvien' ";
$query1 = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_array($query1);
if ($row1['IDNhomQuyen'] == 03) {
    define("admin", true);
}
if ($row1['IDNhomQuyen'] == 01) {
    define("quanly", true);
}
if ($row1['IDNhomQuyen'] == 02 or $row1['IDNhomQuyen'] == 04) {
    define("nhanvien", true);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title>Phần mềm chữ ký số Thaco Mazda</title>
    <link href="Style/quantri.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!-- <script src="js/jquery-3.2.1.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script> -->
    <!-- <script src="js/jquery-3.2.1.slim.min.js"></script> -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- <script src="js/jquery-3.2.1.min.js"></script> -->
    <!-- <script   src="https://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script> -->
    <!-- <script src="js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>-->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>  -->
    <link rel="stylesheet" href="Style/bootstrap.min.css">


</head>

<body style="background: url(Images/VPMazda.jpg) no-repeat;background-size: cover;">
    <?php
    require "display/header.php";
    ?>
    <?php
    require "display/footer.php";
    ?>
    <div id="content">
        <div id="right">
            <!-- <div class="hopthu1">     -->
            <!-- <div style="background-color: grey;"> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary" style="padding:10px">
                        <SPAN style="float:left">
                            <h6 class="card-title" style="font-weight:bold;padding-top: 10px;">QUẢN LÝ NHÂN VIÊN</h6>
                        </SPAN>

                    </div>
                    <div class="card-body">
                        <div>
                            <div class="cb_dept" style="text-align: center;">
                                <label for="cars">Bộ phận:</label>
                                <select name="cars" id="Dept" style="width: 320px;">
                                    <option value="<?= $_SESSION['IDBoPhan'] ?>"><?php echo $row_dept['TenBoPhan'] ?></option>
                            </div>
                            <span style="text-align:center;display: inline-block; margin-left: 60%;">
                                <form action="" method="get">
                                    <tr>
                                        <td><input type="text" name="nhap" id="textsearch" style="width: 200px;margin-left: 20px;" size="100">
                                            <input type="submit" id='__search' name="search" value="Tìm kiếm" class="btn btn-primary" style="margin-right: 20px;background-color: #00529C;color: white;">
                                        </td>
                                    </tr>
                                </form>
                            </span>
                            <a href='themnhanvien.php'>
                                <input type="submit" name="them" value="Thêm nhân viên" class="btn btn-primary" style="background-color: #00529C;color: white;">
                            </a>

                        </div>
                        <div>
                            <table class="table">
                                <thead class=" text-primary">
                                    <tr>
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
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- phân trang -->

            <!-- </div> -->
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog dp-none" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa thông tin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="content" style="padding-top: 10px !important;">
                        <form>
                            <div class="form-group">
                                <label for="recipient-id" class="col-form-label" read-only>Mã số nhân viên:</label>
                                <textarea class="form-control" id="recipient-id"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message-name" class="col-form-label">Họ và tên:</label>
                                <textarea class="form-control" id="message-name"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message-dept" class="col-form-label">Bộ phận:</label>
                                <div class="dropdown1">
                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" type="button" id="dept"  aria-haspopup="true" aria-expanded="false">
                                    <!-- dropdown-toggle
                                    data-toggle="dropdown" -->
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="drop_dept">
                                        <?php
                                        $bp = mysqli_query($connect, "SELECT * FROM bophan ORDER BY IDBoPhan ASC")
                                            or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                                        while ($row = mysqli_fetch_assoc($bp)) {
                                        ?>
                                            <a class="dropdown-item" href="#" value="<?php echo $row["IDBoPhan"] ?>"><?php echo $row["TenBoPhan"]; ?></a>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message-order" class="col-form-label">Chức vụ:</label>
                                <div class="dropdown2">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="order" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="drop_order">
                                        <?php
                                        $bp = mysqli_query($connect, "SELECT * FROM chucvu ORDER BY IDChucVu ASC")
                                            or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                                        while ($row = mysqli_fetch_assoc($bp)) {
                                        ?>
                                            <a class="dropdown-item" href="#" value="<?php echo $row["IDChucVu"] ?>"><?php echo $row["TenChucVu"]; ?></a>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message-email" class="col-form-label">Email:</label>
                                <textarea class="form-control" id="message-email"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="message-pass" class="col-form-label">Reset Mật Khẩu:</label>
                                <input class="form-control" id="message-pass" type='password'></input>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-weight:bold">Đóng</button>
                                <button type="button" id='save' class="btn btn-primary" style="background-color: #00529C;color: white;">Cập nhật</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var idnv = '',
            name = '',
            dept = '',
            order = '',
            email = '',
            pass = '',
            iddept = '<?= $_SESSION['IDBoPhan'] ?>';
    </script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '#modify', function() {
                $('#exampleModal').modal('show');

                let _parent = $(this).closest("tr");
                idnv = _parent.data('id');
                load_modal();

            });
            $('#drop_dept a').on('click', function() {
                $('#dept').text($(this).text());
            });
            $('#drop_order a').on('click', function() {
                $('#order').text($(this).text());
            });
            $('#save').on('click', function() {
                if (confirm("Bạn có muốn thay đổi thông tin dữ liệu nhân viên")) {
                    name = $('#message-name').val();
                    email = $('#message-email').val();
                    dept = $('#dept').text()
                    order = $('#order').text();
                    pass = $('#message-pass').val();
                    $.ajax({
                        url: 'save_modalquantri.php',
                        type: 'post',
                        data: {
                            'name': name,
                            'email': email,
                            'dept': dept,
                            'order': order,
                            'pass': pass,
                            'idnv': idnv,
                        },

                        dataType: 'json',
                        success: function(result) {
                            //console.log(result);
                            if (result.code == 200) {
                                alert('Đã thêm dữ liệu thành công');
                                reloadPage();
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        }
                    })
                }



            })
            $('body').on('click', '#delete', function() {
                let _parent = $(this).closest("tr");
                idnv = _parent.data('id');
                alert(idnv);
                if (confirm("Bạn có chắc muốn xóa thông tin nhân sự")) {
                    $.ajax({
                        url: 'Xoanhansu.php',
                        type: 'post',
                        data: {
                            'idnv': idnv
                        },
                        dataType: 'json',
                        success: function(result) {
                            alert("Xóa nhân sự thành công");
                            reloadPage();
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        }

                    })
                }
            })

            $('#__search').on('click', function() {

                var dieukien = $('#textsearch').val();

                $.ajax({
                    url: 'timkiemnv.php',
                    type: 'post',
                    data: {
                        'dieukien': dieukien,
                        'iddept': iddept
                    },
                    cache: false,
                    success: function(data) {

                        if (data == "201") {
                            alert("Dữ liệu tìm kiếm không có. Vui lòng nhập thông tin chính xác.")
                        } else {

                            loadsearch(data);
                        }
                    },
                    error: function(error) {
                        console.log(error.responseText);
                    }
                })
            })

        })

        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                return false;
            } else {
                return true;
            }
        }

        function loadsearch(data) {
            $('#table_han tr').remove();
            $('#table_han').html(data);
        }

        function reloadPage() {
            location.reload(true);
        }

        function load_modal() {
            console.log(idnv);
            $.ajax({
                url: 'loadformcapnhat.php',
                type: 'post',
                dataType: 'json',
                data: {
                    'idnv': idnv
                },
                success: function(result) {
                    if (result.code == 200) {

                        var data = result.data;
                        console.log(data[0].HoTenNhanVien);
                        $('#recipient-id').text(idnv);
                        $('#message-name').text(data[0].HoTenNhanVien);
                        $('#message-email').text(data[0].Email);
                        $('#dept').text(result.dept);
                        $('#order').text(result.order);

                    }
                },
                error: function(error) {
                    console.log(error.responseText);
                }


            })
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