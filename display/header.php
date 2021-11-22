<?php
include('dbhelp.php');
//session_start();
$ID = $_SESSION["IDNhanVien"];
$sql5 = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query5 = mysqli_query($connect, $sql5);
$row5 = mysqli_fetch_array($query5);
if ($row5['IDNhomQuyen'] == 03) {
    define("admin", true);
}
if ($row5['IDNhomQuyen'] == 01) {
    define("quanly", true);
}
if ($row5['IDNhomQuyen'] == 02 ) {
    define("nhanvien", true);
}
if ( $row5['IDNhomQuyen'] == 04) {
    define("kiemsoat", true);
} 
?>
<div id="header">
    <div id="logo">
        <a href="Index.php">
            <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 200px; height: 40px;" />
        </a>
    </div>
    <div class="topnav" id="myTopnav">
        <ul id="menu">
            <li>
                <a  style="font-size:28px; color:black;background-color: #fffcd5;" class="icon" onclick="clickMenu()">&#9776;<span class="arrow arrow-down"></span></a>
                <ul class="dropdown_menu">
                    <li>
                        <a href="Index.php">Trang chủ</a>
                    </li>
                    <?php if (defined("admin") or defined("quanly") or defined("nhanvien")) { ?>
                    <li>
                        <ul class="submenu">
                            <li>
                                <a href="phieuracong.php">Giấy ra cổng</a>
                            </li>
                            <li>
                                <a href="Donxinnghiphep.php">Giấy xin phép</a>
                            </li>
                            <li>
                                <a href="Denghicapvattu.php">Đề nghị cấp vật tư</a>
                            </li>
                            <li>
                                <a href="Phieuyeucaucongviec.php">Phiếu yêu cầu công việc</a>
                            </li>
                        </ul>
                        <a href="javascript:void(0)">Tạo phiếu<span class="arrow arrow-right"></span></a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="Tatca.php?page=1">Quản lý hồ sơ</a>
                    </li>
                    <?php if (defined("admin") or defined("quanly")) { ?>
                    <li>
                        <ul class="submenu">
                            <li>
                                <a href="quantri.php">Quản lý nhân viên</a>
                            </li>
                            <?php if (defined("admin")) { ?>
                            <li>
                                <a href="phanquyen.php">Phân quyền</a>
                            </li>
                            <?php } ?>
                        </ul>
                        <a href="javascript:void(0)">Quản lý nhân viên<span class="arrow arrow-right"></span></a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <!-- <li><a href="javascript:void(0);" style="font-size:60px; color:black;background-color: #fffcd5;" class="icon" onclick="clickMenu()">&#9776;</a></li> -->
        </ul>
    </div>

    <nav style="background-color: #fffcd5;" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <?php if (defined("admin") or defined("quanly") or defined("nhanvien")) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Tạo phiếu
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="phieuracong.php">Giấy ra cổng</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="Donxinnghiphep.php">Giấy xin phép</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="Denghicapvattu.php">Đề nghị cấp vật tư</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="Phieuyeucaucongviec.php">Phiếu yêu cầu công việc</a>

                    </div>
                </li>
                <?php } ?>
                <li class="nav-item active">
                    <a class="nav-link" href="Tatca.php?page=1">Quản lý hồ sơ</a>
                </li>

                <?php if (defined("admin") or defined("quanly")) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Quản lý nhân viên
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="quantri.php">Quản lý nhân viên</a>

                            <?php if (defined("admin")) { ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="phanquyen.php">Phân quyền</a>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>

            </ul>
        </div>
    </nav>


    <div id="account" style="font-size: 12px;">
        <?php
        if (isset($_SESSION['HoTenNhanVien']) && $_SESSION['IDNhanVien'] != NULL) {
        ?>
            <li class="nav-item dropdown" style="list-style: none;">
                <a class="nav-link dropdown-toggle" style="text-align: right;" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION["HoTenNhanVien"];?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="margin: .125rem 30% 0" onload="Loadaccount()">
                    <a class="dropdown-item" onclick="userInfo()" href="#">Thông tin người dùng</a>
                    <div class="dropdown-divider"></div> 
                    <a class="dropdown-item" onclick="changePass()" href="#">Đổi mật khẩu</a>
                    <div class="dropdown-divider" id="ke" style="display:none"></div>
                    <a class="dropdown-item" id="doibophan" style="display:none" onclick="doibophan_Click()" href="#">Đổi bộ phận</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="Dangnhap.php">Đăng xuất</a>
                </div>
            </li>

        <?php
        } else {
        ?>
            <a style="text-decoration:none" href="Dangnhap.php">Đăng nhập</a>
        <?php
        }
        ?>
        </ul>
    </div>
</div>
<div id="id01" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
    <div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0;width: 500px;height: 300px;">
        <div class="w3-container">
            <button onclick="document.getElementById('id01').style.display='none'" class="btn btn-danger" style="background: red; float: right; border: none; width: 35px; height: 35px;">X</button>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c">
                <h6 class="m-0 font-weight-bold" style="color: #fffcd5;padding: 10px;">THÔNG TIN NGƯỜI DÙNG</h6>
            </div>
            <div class="table-responsive" style="min-height: 400px;font-family: Arial;font-size: 17px;TEXT-ALIGN: -WEBKIT-CENTER;">
                <?php
                $idnhanvien = $_SESSION['IDNhanVien'];
                $idbophan=$_SESSION['IDBoPhan'];
                $idchucvu=$_SESSION['IDChucVu'];

                require_once "dbhelp.php";
                $sql = "SELECT * FROM nhanvien, chucvu where nhanvien.IDChucVu = chucvu.IDChucVu and nhanvien.IDNhanVien = '$idnhanvien'";
                $query2 = mysqli_query($connect, $sql);
                $row2 = mysqli_fetch_array($query2);
                ?>
                <table id="tableshow" class="table align-items-center table-flush table-hover" style="background: white;color: black">
                    <tr>
                        <th style="text-align: left;">Mã nhân viên:</th>
                        <td style="padding: 10px;"> <?php echo $idnhanvien; ?></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Tên nhân viên:</th>
                        <td style="padding: 10px;"><?php echo $row2['HoTenNhanVien']; ?></td>
                    </tr>
                    <tr><?php
                    $sql3 = "SELECT * FROM bophan where IDBoPhan = '$idbophan'";
                    $query3 = mysqli_query($connect, $sql3);
                    $row3 = mysqli_fetch_array($query3);
                    ?>
                        <th style="text-align: left;">Bộ phận:</th>
                        <td style="padding: 10px;"><?php echo $row3['TenBoPhan']; ?></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Chức vụ:</th>
                        <td style="padding: 10px;"><?php echo $row2['TenChucVu']; ?></td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
</div>
<div id="id02" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
    <div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0; width: 500px; height: 300px;">
        <div class="w3-container">
            <button onclick="document.getElementById('id02').style.display='none'" class="btn btn-danger" style="background: red; float: right; border: none; width: 35px; height: 35px;">X</button>
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c">
                <h6 class="m-0 font-weight-bold" style="color: white;padding: 10px;">ĐỔI MẬT KHẨU</h6>
            </div>
            <div class="table-responsive" style="min-height: 400px;font-family: Arial;font-size: 17px;TEXT-ALIGN: -WEBKIT-CENTER;">

                <table class="table align-items-center table-flush table-hover" style="background: white;color: black">
                    <tr>
                        <th style="text-align: left;">Nhập mật khẩu hiện tại:</th>
                        <td style="padding: 10px;"><input id="oldpass" type="password" required></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Nhập mật khẩu mới:</th>
                        <td style="padding: 10px;"><input id="newpass" type="password" required></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;">Xác nhận mật khẩu:</th>
                        <td style="padding: 10px;"><input id="confirmpass" type="password" required></td>
                    </tr>

                </table>
                <p style="text-align: center;"><input id="button" onclick="change()" type="submit" class="btn btn-primary" value="Đổi mật khẩu"></input></p>
            </div>
        </div>
    </div>
</div>

<div id="chonbophan" style="z-index:2;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
		<div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0; width: 400px; height: 225px;">
			<div class="w3-container">
				<button onclick="document.getElementById('chonbophan').style.display='none'" class="btn btn-danger" style="background: red; float: right; border: none; width: 35px;height: 35px;">X</button>
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c">
					<h6 class="m-0 font-weight-bold" style="color: white;padding: 10px;">CHỌN BỘ PHẬN</h6>
				</div>
				<div class="table-responsive" style="font-family: Arial;font-size: 17px;TEXT-ALIGN: -WEBKIT-CENTER;    padding: 15px; ">
					
							<select class="textbox" id="bophan" name="bophan" style="width: min-content;padding: 5px;font-size: 17px;margin-bottom: 20px;color: black;">
							</select>
						
					<input id="button" type="button" onclick="xacnhanbophan()" value="XÁC NHẬN" class="btn btn-primary" style="height: 40px;text-align: center;width: 150px;background-color: green;border: none;font-size: 17px;color: white;border-radius: 10px;">
				</div>
			</div>
		</div>
	</div>

<script>
    function clickMenu() {
        var x = document.getElementById("myTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }

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

    window.onload = function()
        {
                var msnv = <?php echo json_encode($_SESSION['IDNhanVien']); ?>;
                    var pass = <?php echo json_encode($_SESSION['MatKhau']); ?>;
                    var result = {
                        msnv,
                        pass
                    };
                checkdept(result)
        };
    function checkdept(result) {
			$.ajax({
				url: 'Checkdept.php',
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					result: result
				},
				success: function(result) {
					var bophan = result.result[0].IDBoPhan;
					var cutdept = bophan.split(",");
					
					if (cutdept.length >= 2) {
						document.getElementById('doibophan').style.display = 'block';
                        document.getElementById('ke').style.display = 'block';

						$('#bophan').empty();
						for (var i = 0; i < cutdept.length; i++) {
							ari = cutdept[i];
							loadtenbophan(ari);
						}
					}
					else
					{
						document.getElementById('doibophan').style.display = 'none';
                        document.getElementById('ke').style.display = 'none';
					}
				},
				error: function(error) {
					alert("Tài khoản KHÔNG chính xác. Vui lòng kiểm tra thông tin đăng nhập.");
				}
			});
		}
        function doibophan_Click(){
            document.getElementById('chonbophan').style.display = 'block';
            var msnv = <?php echo json_encode($_SESSION['IDNhanVien']); ?>;
			var pass = <?php echo json_encode($_SESSION['MatKhau']); ?>;
			var result = {
				msnv,
				pass
			};
        checkdept(result)
        }

        function loadtenbophan(resulttt) {
			$.ajax({
				url: 'checkbophan.php',
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					resulttt: resulttt
				},
				success: function(resulttt) {
					console.log(resulttt);
					console.log(resulttt.resulttt[0].IDBoPhan);
					$('#bophan').append(`<option value="${resulttt.resulttt[0].IDBoPhan}">
                                       ${resulttt.resulttt[0].TenBoPhan}
                                  </option>`);
				},
				error: function(error) {
					console.log(error.responseText);
				}
			});
		}

		function xacnhanbophan() {
				var user = <?php echo json_encode($_SESSION['IDNhanVien']); ?>;
				var pass = <?php echo json_encode($_SESSION['MatKhau']); ?>;
				var idbophan = document.getElementById("bophan").value;
				var resultt={
					user,
					pass,
					idbophan
				};
				
			$.ajax({
				url: 'doibophan.php',
				type: 'post',
				dataType: 'json',
				data: {
					resultt: resultt
				},
				success: function(resultt) {
                    console.log(resultt);
					if(resultt="OK"){
                        alert("Đổi bộ phận thành công.");
                        location.reload();
                    }
                    else{
                        alert("Đổi bộ phận thất bại. Vui lòng kiểm tra lại.");
                    }
				},
				error: function(error) {
					alert("Đổi bộ phận thất bại. Vui lòng thử lại sau.");
				}
			});
		}
</script>