
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Chữ ký điện tử Thaco Auto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/Stylephieu.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />
    <script src="js/jquery-2.1.4.js"></script>

    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js" ></script>
</head>
<body>
<?php
                session_start();
                require_once "dbhelp.php";
                // không có session sẽ tự động quay về trang đăng nhập
                if (!isset($_SESSION["IDNhanVien"])) {
                    header('Location: Dangnhap.php');
                }
                $ID = $_SESSION["IDNhanVien"];
                $IDbophan = $_SESSION["IDBoPhan"];
                $sql5 = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
                $query5 = mysqli_query($connect, $sql5);
                $row5 = mysqli_fetch_array($query5);
                if ($row5['IDNhomQuyen'] == 03) {define("admin",true);} 
                if ($row5['IDNhomQuyen'] == 01) {define("quanly",true);}  
                if ($row5['IDNhomQuyen'] == 02 or $row5['IDNhomQuyen'] == 04) {define("nhanvien",true);} 
                ?>

<?php
    require "display/header.php";
?>
    <div id="content">
        <form id="yeucauvattu" style="width: 750px;" action="#" method="post">
            <div id="input" style="margin: 0px;">
        
            <div id="title">
                THÊM NHÂN VIÊN
            </div>
<table style="margin: 30px auto; width: 500px; ">

<tr>
	<td style="font-weight: bold;">Mã số nhân viên:</td>
	<td><input type="text" style=" width: -webkit-fill-available;" name="masonhanvien" ></td>
</tr>
<tr>
	<td style="font-weight: bold;">Họ và tên:</td>
	<td><input type="text" style=" width: -webkit-fill-available;" name="hovaten" ></td>
</tr>
<tr>
	<td style="font-weight: bold;">Bộ phận:</td>
	<td style="width: 33%;">
	    <select id="cboBoPhan" style=" width: -webkit-fill-available;height: 30px" name="bophan">
			<?php
				$bp =mysqli_query($connect,"SELECT * FROM bophan ORDER BY IDBoPhan ASC")
				or die ("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." .mysqli_error($connect));
				while($row = mysqli_fetch_assoc($bp)){
			?>
				<option value="<?php echo $row["IDBoPhan"]?>"><?php echo $row["TenBoPhan"]; ?></option>
			<?php
				}
			?>
			</select>   
						</td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Chức vụ:</td>
                    <td style="width: 33%;">
	    <select id="cboChucVu" style=" width: -webkit-fill-available;height: 30px" name="chucvu">
			<?php
				$bp =mysqli_query($connect,"SELECT * FROM chucvu ORDER BY IDChucVu ASC")
				or die ("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." .mysqli_error($connect));
				while($row = mysqli_fetch_assoc($bp)){
			?>
				<option value="<?php echo $row["IDChucVu"]?>"><?php echo $row["TenChucVu"]; ?></option>
			<?php
				}
			?>
			</select>   
						</td>
                </tr>
                <tr>
                <td style="font-weight: bold;">Email:</td>
                    <td><input type="email" style="width: -webkit-fill-available;" name="Email" ></td>
                    <!-- <td style="font-weight: bold;">Email:</td>
                    <td><input type="text" style=" width: -webkit-fill-available;" name="Email" ></td> -->
                </tr>
                <tr>
                    <td style="font-weight: bold;">Mật khẩu:</td>
                    <td><input type="password" style=" width: -webkit-fill-available;" name="matkhau" ></td>
                </tr>
                </table>
        <!-- </form>  -->
                <div id="duoi" style="    text-align: center;">
                <input type="submit" class="btn btn-primary" name="process" value="THÊM NHÂN VIÊN" >
                
                </div>
                <br>
                </div>
            </div>
        </form>
    </div>
    <?php
        require "display/footer.php";
    ?>

<?php 
    if(isset($_POST['process'])){ 
        $msnv=$_POST['masonhanvien'];
        $ht=$_POST['hovaten'];
        $bp=$_POST['bophan'];
        $cv=$_POST['chucvu'];
        $mail=$_POST['Email'];
        $mk=$_POST['matkhau'];

            
            $sqlthemnhanvien = "INSERT INTO `nhanvien`(`IDNhanVien`, `HoTenNhanVien`, `IDChucVu`, `IDBoPhan`, `IDNhomQuyen`, `Email`, `MatKhau`, `PassReset`) VALUES ('".$msnv."','".$ht."','".$cv."','".$bp."','02','".$mail."','".$mk."','0')";
            $querythemnhanvien = mysqli_query($connect, $sqlthemnhanvien);
            if(isset($querythemnhanvien)){
                $message1 = 'Thêm thông tin nhân viên thành công.';
                echo "<SCRIPT>
                alert('$message1');
                </SCRIPT>"; 
            }
            else{
                $message2 = 'Thêm thông tin nhân viên thất bại.';
                echo "<SCRIPT>
                alert('$message2');
                </SCRIPT>"; 
            }
    }
?>