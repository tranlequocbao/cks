
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
          
                $query_dept = 'SELECT DISTINCT TenBoPhan,bophan.IDBoPhan from bophan,nhanvien WHERE bophan.IDBoPhan=nhanvien.IDBoPhan and nhanvien.IDBoPhan like "%' . $_SESSION["IDBoPhan"] . '%"';
                $result_dept = mysqli_query($connect, $query_dept);
                $row_dept = mysqli_fetch_array($result_dept);
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
	<td style="font-weight: bold;">Mã số nhân viên:<span style="color:red">*</span></td>
	<td><input type="text" style=" width: -webkit-fill-available;" name="masonhanvien" ></td>
</tr>
<tr>
	<td style="font-weight: bold;">Họ và tên:<span style="color:red">*</span></td>
	<td><input type="text" style=" width: -webkit-fill-available;" name="hovaten" ></td>
</tr>
<tr>
	<td style="font-weight: bold;">Bộ phận:<span style="color:red">*</span></td>
	<td style="width: 33%;">
	    <select id="cboBoPhan" style=" width: -webkit-fill-available;height: 30px" name="bophan">
				
        <?php
                                    if ($row5['IDNhomQuyen'] == 01) {
                                    ?>
                                        <option selected value="<?php echo $row_dept['IDBoPhan'] ?>"><?php echo $row_dept['TenBoPhan'] ?></option>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($row5['IDNhomQuyen'] == 03) {
                                    ?>
                                        <option selected value="<?php echo $row_dept['IDBoPhan']; ?>"><?php echo $row_dept['TenBoPhan'] ?></option>
                                        <?php
                                        $sql6 = "SELECT * FROM bophan WHERE IDBoPhan != '$IDbophan'";
                                        $result6 = mysqli_query($connect, $sql6);
                                        while ($row = mysqli_fetch_array($result6)) {
                                        ?>
                                            <option value="<?php echo $row["IDBoPhan"]; ?>"><?php echo $row["TenBoPhan"]; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
			</select>   
						</td>
                </tr>

                <tr>
                    <td style="font-weight: bold;">Chức vụ:<span style="color:red">*</span></td>
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
                    <td style="font-weight: bold;">Mật khẩu:<span style="color:red">*</span></td>
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

        $sql = "select count(*) as ct from nhanvien where IDNhanVien = '$msnv'";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($result);
        $n = $row['ct']; 
        if($msnv == "")
        {
            echo "<SCRIPT>
                alert('Vui lòng nhập mã nhân viên');
                </SCRIPT>";
        }
        else 
        {
            if($n == "1")
            {
                echo "<SCRIPT>
                alert('Nhân viên đã tồn tại');
                </SCRIPT>";
            }
            else
            {
                if ($ht == "")
                {
                    echo "<SCRIPT>
                alert('Vui lòng nhập họ và tên nhân viên');
                </SCRIPT>";
                }
                else 
                {
                    if($mk == "")
                    {
                        echo "<SCRIPT>
                    alert('Vui lòng nhập mật khẩu');
                    </SCRIPT>";
                    }
                    else{
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
                }
            }
        }
    }
?>

