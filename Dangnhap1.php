<html lang="vi">

<head>
	<script>
		var _prePath = './';
	</script>
	<title>Chữ ký điện tử Thaco Auto</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="login/images/icons/favicon.ico">
	<link href="Style/dangnhap.css" rel="stylesheet" />
	<script src="js/jquery-2.1.4.js"></script>
	<!--===============================================================================================-->

</head>

<body>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Yinka Enoch Adedokun">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title">

					<span class="login100-form-title-1">
						ĐĂNG NHẬP
					</span>
				</div>

				<form class="login100-form validate-form " method="POST">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Tài khoản:</span>
						<input class="input100" type="text" id="username" name="username" placeholder="Nhập MSNV">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" placeholder="Nhập mật khẩu" data-validate="Password is required">
						<span class="label-input100">Mật khẩu:</span>
						<input class="input100" type="password" name="password" placeholder="********" id="Passw">
						<span class="focus-input100"></span>
					</div>
					<div class="container-login100-form-btn">
						<input class="login100-form-btn" id="btn_login" onclick="function1()" type="button" value="Đăng nhập">

						</input>
					</div>
				</form>
				<?php
				session_start();
				require_once "dbhelp.php";
				if ((isset($_SESSION["IDNhanVien"]) && $_SESSION["IDNhanVien"]) and (isset($_SESSION["HoTenNhanVien"]) && $_SESSION["HoTenNhanVien"]) != NULL) {
					unset($_SESSION["IDNhanVien"]);
					unset($_SESSION["HoTenNhanVien"]);
					unset($_SESSION['link']);
				}
				?>
			</div>
		</div>
	</div>
	<div id="id02" style="z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
		<div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0; width: 400px; height: 225px;">
			<div class="w3-container">
				<button onclick="document.getElementById('id02').style.display='none'" class="btn btn-danger" style="background: red; float: right; border: none; width: 32px;height: 32px;">X</button>
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c">
					<h6 class="m-0 font-weight-bold" style="color: #fffcd5;padding: 10px;">ĐỔI MẬT KHẨU</h6>
				</div>
				<div class="table-responsive" style="font-family: Arial;font-size: 17px;TEXT-ALIGN: -WEBKIT-CENTER;">
					<table class="table align-items-center table-flush table-hover" style="background: white;color: black;margin: 5% auto;width: 95%;">
						<tr>
							<th style="text-align: left;">Nhập mật khẩu mới:</th>
							<td style="padding: 2%;border: 1px solid;"><input id="newpass" type="password" required></td>
						</tr>
						<tr>
							<td style="height: 15px;"></td>
						</tr>
						<tr>
							<th style="text-align: left;">Xác nhận mật khẩu:</th>
							<td style="padding: 2%;border: 1px solid;"><input id="confirmpass" type="password" required></td>
						</tr>
					</table>
					<input id="button" type="button" onclick="change()" value="Đổi mật khẩu" class="btn btn-primary" style="height: 40px;text-align: center;width: 150px;background-color: green;border: none;font-size: 17px;color: white;border-radius: 10px;">
				</div>
			</div>
		</div>
	</div>

	<div id="chonbophan" style="z-index:2;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:95%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
		<div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0; width: 400px; height: 225px;">
			<div class="w3-container">
				<button onclick="document.getElementById('chonbophan').style.display='none'" class="btn btn-danger" style="background: red; float: right; border: none; width: 32px;height: 32px;">X</button>
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background: #00529c">
					<h6 class="m-0 font-weight-bold" style="color: white;padding: 10px;">CHỌN BỘ PHẬN</h6>
				</div>
				<div class="table-responsive" style="font-family: Arial;font-size: 17px;TEXT-ALIGN: -WEBKIT-CENTER;    padding: 40px; ">
					<table class="table align-items-center table-flush table-hover" style="background: white;color: black;margin: 5% auto;width: 95%;">
						<tr style="background-color: red;">
						<select class="textbox" id="bophan" name="bophan" style="padding: 5px;">
						</select>
						</tr>
						
					</table>
					<input id="button" type="button" onclick="xacnhanbophan()" value="XÁC NHẬN" class="btn btn-primary" style="height: 40px;text-align: center;width: 150px;background-color: green;border: none;font-size: 17px;color: white;border-radius: 10px;">
				</div>
			</div>
		</div>
	</div>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		//check đổi pass
		function change() {
			var newpass = document.getElementById('newpass').value;
			var confirmpass = document.getElementById('confirmpass').value;

			console.log(newpass);


			if (newpass !== '') {
				if (newpass !== confirmpass) {
					alert('Vui lòng xác nhận mật khẩu giống nhau');
				} else {
					var idmember = $('#username').val();
					var result = {
						newpass,
						idmember
					};
					console.log(result);
					updatepass(result);
					// checkinfo(result);
				}
			} else {
				alert('Vui lòng nhập mật khẩu mới');
			}

		}

		function checkdept(result){
			$.ajax({
				url: 'Checkdept.php',
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					result: result
				},
				success: function(result) {
					var bophan=result.result[0].IDBoPhan;
					var cutdept=bophan.split(",");
					for(var i=0;i<cutdept.length;i++){
						var ari=cutdept[i];
						// console.log(ari);
						
					}
					if(cutdept.length>=2){
						document.getElementById('chonbophan').style.display = 'block';
						
						$('#bophan').empty();
                        for(var i=0;i<cutdept.length;i++)
                        {
							

							ari=cutdept[i];
							loadtenbophan(ari);
                        
                        }
					}
				},
				error: function(error) {
					console.log(error)
				}
			});
		}

		function loadtenbophan(resulttt){
			$.ajax({
				url: 'checkbophan.php',
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					resulttt: resulttt
				},
				success: function(resulttt) {
					console.log(resulttt.resulttt[0].TenBoPhan);
					console.log(resulttt.resulttt[0].IDBoPhan);
					$('#bophan').append(`<option value="${resulttt.resulttt[0].IDBoPhan}">
                                       ${resulttt.resulttt[0].TenBoPhan}
                                  </option>`); 
				},
				error: function(error) {
					console.log(error)
				}
			});
		}

		function xacnhanbophan(){
			var resultt = document.getElementById("bophan").value;
			$.ajax({
				url: 'Createsessionbophan.php',
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					resultt: resultt
				},
				success: function(resultt) {
					console.log(resultt.resultt);
				},
				error: function(error) {
					console.log(error)
				}
			});
		}
		//check thông tin nv để lấy session sau khi đổi pass thành công
		// function checkinfo(result)
		// {
		// 	$.ajax ({
		//     url: 'updatepass.php',
		//     type: 'post',
		//     dataType: 'json',
		//     cache: false,
		//     data: 
		//     {
		//         result: result
		//     },
		//     success: function (result)
		//     {


		//     },
		//     error: function (error) {
		//         console.log(error.responseText)
		//         }
		//     });
		// }
		//ajax đổi pass
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
					console.log(value.result);
					console.log("==>")
					var ms = value.result[0].IDNhanVien;
					var hoten = value.result[0].HoTenNhanVien;
					var idbophan = value.result[0].IDBoPhan;
					var matkhau = value.result[0].MatKhau;
					var chucvu = value.result[0].IDChucVu;
					var result = {
						ms,
						hoten,
						idbophan,
						matkhau,
						chucvu
					};
					createsesion(result);

				},
				error: function(error) {
					console.log(error.responseText)
				}
			});
		}
		//bắt sự kiện enter ở username
		document.getElementById("username")
			.addEventListener("keyup", function(event) {
				event.preventDefault();
				if (event.keyCode === 13) {
					function1();
				}
			});
		//bắt sự kiện enter ở pass
		document.getElementById("Passw")
			.addEventListener("keyup", function(event) {
				event.preventDefault();
				if (event.keyCode === 13) {
					function1();
				}
			});
		//check lần đầu đăng nhập

		function function1() {
			var msnv = $('#username').val();
			var oldpass = $('#Passw').val();
			var result = {
				msnv,
				oldpass
			};
			console.log(result);
			if (msnv !== '' && oldpass !== '')
				checkpassreset(result);
			else
				alert("Vui lòng nhập thông tin nhân viên");
		}

		function createsesion(result) {
			$.ajax({
				url: 'CreateSession.php',
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					result: result
				},
				success: function(result) {
					console.log(result.result);
					window.location = result.result;
				},
				error: function(error) {
					console.log(error)
				}
			});
		}

		function checkpassreset(result) {
			$.ajax({
				url: 'checkpass.php',
				type: 'post',
				dataType: 'json',
				cache: false,
				data: {
					result: result
				},
				success: function(result) {
					console.log(result);
					if (result.result !== "NONE") {
						var msnv = $('#username').val();
						var oldpass = $('#Passw').val();
						var idnhanvien = result.result[0].IDNhanVien;
						var currentpass = result.result[0].MatKhau;
						var passrest = result.result[0].PassReset;

						if (msnv !== '' && oldpass !== '') {
							if (msnv === idnhanvien) {
								if (oldpass === currentpass) {
									if (passrest === "0") {
										console.log("Change Pass");
										document.getElementById('id02').style.display = 'block';
									} else {
										console.log("==>")
										var ms = result.result[0].IDNhanVien;
										var hoten = result.result[0].HoTenNhanVien;
										var idbophan = result.result[0].IDBoPhan;
										var matkhau = result.result[0].MatKhau;
										var chucvu = result.result[0].IDChucVu;
										var result = {
											ms,
											hoten,
											idbophan,
											matkhau,
											chucvu
										};
										createsesion(result);
									}
								} else {
									alert("Mật khẩu không đúng!");
								}
							} else {
								alert("Mã nhân viên không đúng!");
							}
						}
					} else {
						alert("Vui lòng kiểm tra thông tin nhân viên");
					}
				},
				error: function(error) {
					console.log(error)
				}
			});
		}

		//đổi mk
	</script>

</body>

</html>