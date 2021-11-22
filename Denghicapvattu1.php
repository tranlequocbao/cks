<?php session_start();
require_once "dbhelp.php";
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}

$ID = $_SESSION["IDNhanVien"];
$sql = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query1 = mysqli_query($connect, $sql);
$row1 = mysqli_fetch_array($query1);
  
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Chữ ký điện tử Thaco Auto</title>
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/Stylephieu.css" rel="stylesheet" />
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/vpp.js"></script>
    <script src="js/main.js"></script>
    <link href="Style/display.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <!-- <script src="js/jquery-3.2.1.slim.min.js"></script> -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- <script src="js/main.js"></script> -->
</head>
<script>
     function ajax(result) {
        $.ajax({
            url: 'checkunit.php',
            type: 'post',
            dataType: 'json',
            data: {
                result: result
            },
            success: function(result) {
                console.log(result.result);
                if(result.result=='NG'){
                    document.getElementById('txtDonViTinh').value ="";
                }
                else{
                    document.getElementById('txtDonViTinh').value = result.result[0].DonViTinh;
                }
                
            },
            error: function(error) {
                console.log(error.responseText);
            }
        })
    }

    function myFunction() {
        var result = document.getElementById('txtVatTu').value;
        ajax(result);
    }
</script>

<body>
    <?php
    require "display/header.php";
    ?>


    <div id="content">
        <div id="yeucauvattu">
            <div id="title">
                ĐỀ NGHỊ CẤP VẬT TƯ
            </div>

            <form id="input" autocomplete="off" action="#" method="post">

                <div id="trai">
                    <p>
                        <label id="text">Tên người yêu cầu:</label>
                        <input id="txtHoTen" class="textbox" type="text" value="<?php echo $_SESSION["HoTenNhanVien"] ?>" required="" disabled="">
                    </p>
                    <p style="display: none;">
                        <label id="text">Bộ phận yêu cầu:</label>
                        <input id="txtBoPhan" class="textbox" type="text" value="<?php
                        $sqlbp = "SELECT * FROM `bophan` WHERE IDBoPhan='".$_SESSION["IDBoPhan"]."'";
                        $querybp = mysqli_query($connect, $sqlbp);
                        $rowbp = mysqli_fetch_array($querybp);
                        echo $rowbp["TenBoPhan"] ?>" required="" disabled="">
                    </p>
                    <p>
                    <div class="autocomplete" style="width: 100%;">
                        <label id="text">Vật tư: <span style="color:red">*</span></label>
                        <input id="txtVatTu" name="VatTu" onkeyup="myFunction()" onkeydown="myFunction()" onkeypress="myFunction()" onchange="myFunction()" onselect="myFunction()" onmousedown="myFunction()" onmouseout="myFunction()" onmouseover="myFunction()" onmousemove="myFunction()" onmouseup="myFunction()">
                    </div>
                    </p>
                    <p>
                        <label id="text">Đơn vị tính:</label>
                        <input id="txtDonViTinh" name="DonViTinh" type="text" placeholder="Vui lòng chọn vật tư" required="" disabled="">
                    </p>
                    <p>
                        <label id="text">Số lượng: <span style="color:red">*</span></label>
                        <input id="txtSoLuong" style="resize: none;" placeholder="Nhập số lượng">
                    </p>

                    <input type="button" class="themvattu" onclick="onclickvattu()" id="submit" value="Thêm vật tư" />
                </div>

                <div id="phai">
                    <p>
                        <label id="text">Hạng mục sử dụng: <span style="color:red">*</span></label>
                        <textarea id="txtHangMucSuDung" name="inputValue" style="resize:none" placeholder="Nhập hạng mục sử dụng..."></textarea>
                    </p>
                    <p>
                        <label id="text">Ghi chú:</label>
                        <textarea id="txtGhiChu" style="resize:none" placeholder="Nhập ghi chú..."></textarea>
                    </p>
                    <p>
                        <label id="text" class="txtXemXet">Xem xét:</label>
                        <select id="cbotaoduyet" name="choice" placeholder="">
                            <?php
                            $bophan = $_SESSION["IDBoPhan"];
                            // $db=mysqli_connect('10.40.13.29','root','','chukyso');
                            $bp = mysqli_query($connect, "SELECT * FROM `nhanvien` WHERE (IDChucVu LIKE '%CV002%' AND IDBoPhan like '%".$bophan."%') OR (IDChucVu LIKE '%CV003%' AND IDBoPhan like '%".$bophan."%')")
                                or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                            while ($row = mysqli_fetch_assoc($bp)) {
                            ?>
                                <option value="<?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?>"><?php echo $row['HoTenNhanVien']; ?> - <?php echo $row["IDNhanVien"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <label id="text">Kế toán:</label>

                        <select id="cboketoan" name="choice" placeholder="">
                            <?php
                            // $db=mysqli_connect('10.40.13.29','root','','chukyso');
                            $bp = mysqli_query($connect, "SELECT * FROM `nhanvien` WHERE IDChucVu LIKE '%CV0023%' AND IDBoPhan='D0010'")
                                or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                            while ($roww = mysqli_fetch_assoc($bp)) {
                            ?>
                                <option value="<?php echo $roww['HoTenNhanVien']; ?> - <?php echo $roww["IDNhanVien"]; ?>"><?php echo $roww['HoTenNhanVien']; ?> - <?php echo $roww["IDNhanVien"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>

                        <label id="text">Phê duyệt:</label>
                        <select id="cboduyet" name="choice" placeholder="Duyệt">
                            <?php
                            // $db=mysqli_connect('10.40.13.29','root','','chukyso');
                            $d = mysqli_query($connect, "SELECT * FROM `nhanvien` WHERE IDChucVu='CV005' OR IDChucVu='CV007' order by IDChucVu asc")
                                or die("Kết nối tới máy chủ thất bại, vui lòng quay lại sau." . mysqli_error($connect));
                            while ($rowd = mysqli_fetch_assoc($d)) {
                            ?>
                                <option value="<?php echo $rowd['HoTenNhanVien']; ?> - <?php echo $rowd["IDNhanVien"]; ?>"><?php echo $rowd['HoTenNhanVien']; ?> - <?php echo $rowd["IDNhanVien"]; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </p>
                </div>
                <div id="duoi" style="text-align: center;text-align: -webkit-center;">
                    <div class="table" id="bangvattu">
                        <div class="row header blue" style="text-align: center;">
                            <div class="cell"> TT </div>
                            <div class="cell"> Tên vật tư </div>
                            <div class="cell"> Đơn vị tính </div>
                            <div class="cell"> Số lượng </div>
                            <div class="cell"> Hạng mục sử dụng </div>
                            <div class="cell"> Ghi chú </div>
                            <div class="cell"> Xóa </div>
                        </div>


                        <div id="row" style="display: contents;">

                        </div>
                    </div>
                    <p style="text-align: center;height: 50px;"><button type="button" id="button_modal" class="btn btn-primary">TẠO PHIẾU</button></p>
                    <!-- onclick="onclickGui()" -->
                </div>

                <br>

            </form>
        </div>



        <div id="id03" style="z-index:3;display:none;padding-top:100px;position:absolute;left:0;top:0;width:100%;height:150%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4)">
            <div style="margin:auto;background-color:#fff; position:relative; padding:0; outline: 0; width: 80%; height: auto; padding-bottom: 2%;">
                <div class="w3-container">
                    <div class="table-responsive" style="min-height: 400px;font-family: Arial;font-size: 17px;TEXT-ALIGN: -WEBKIT-CENTER;">
                        <DIV style="padding-top: 2%;">
                            <table style="width: -webkit-fill-available;margin: 1%;">
                                <tr>
                                    <th style="border: 1px solid;">
                                        <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 200px; height: 40px;" />
                                    </th>
                                    <th style="border: 1px solid;">
                                        CÔNG TY TNHH MTV SẢN XUẤT Ô TÔ THACO MAZDA
                                        <br>
                                        <span style="font-style: italic; font-size: 15px;">AUTOMOBILE MANUFACTURING ONE MEMBER CO.,LTD</span>
                                    </th>
                                    <th style="border: 1px solid;">TMAC.OP3-02.1/F03/Rev0</th>
                                </tr>
                            </table>
                        </DIV>
                        <div style="font-weight: bold;font-size: 20px;text-align: center;">
                            PHIẾU ĐỀ NGHỊ VẬT TƯ VĂN PHÒNG PHẨM
                            <br />
                            ---oOo---
                        </div>
                        <br>
                        <div style="text-align: left;">
                            <p style="padding-left: 3%;"><span style="font-weight: bold;">Tôi tên là: </span> <span id="tennv"> </span></p>
                            <p style="padding-left: 3%;"><span style="font-weight: bold;">Phòng ban/ Xưởng: </span> <span id="tenphongban"> </span></p>
                            <p style="padding-left: 3%;">Đề nghị Ban lãnh đạo xét duyệt cho cấp một số các vật tư sau:</p>

                            <div id="phan3" style="text-align: center;margin: 1%;">
                                <div class="table">
                                    <div class="row header blue" style="text-align: center;">
                                        <div class="cell">TT</div>
                                        <div class="cell">Tên vật tư</div>
                                        <div class="cell">Đơn vị tính</div>
                                        <div class="cell">Số lượng</div>
                                        <div class="cell">Hạng mục sử dụng</div>
                                        <div class="cell">Ghi chú</div>
                                    </div>

                                    <div id="rowconfirm" style="display: contents;">
                                        (Chưa có vật tư)
                                    </div>
                                </div>
                            </div>

                            <div id="phan4" style="text-align: right;padding-right: 3%; font-style: italic;">
                                <br />
                                <p>Núi Thành, ngày <span id="date"></span> tháng <span id="month"></span> năm <span id="year"></span></p>
                            </div>

                            <table style="text-align: center;width: 100%;">
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Phê Duyệt</td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Kế Toán</td>
                                    <td class="txtXemXet" style="width: 100%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Xem Xét</td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;padding-bottom: 8%;">Người lập</td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="pheduyet"></span></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="ketoan"></span></td>
                                    <td class="txtXemXet" style="width: 100%;border: none;text-align: center;font-weight: bold;"><span id="xemxet"></span></td>
                                    <td style="width: 25%;border: none;text-align: center;font-weight: bold;"><span id="nguoitao"></span></td>
                                </tr>
                            </table>
                            <br>
                            <div style="text-align: center; width: 100%;" id="duoi1">
                                <input style="text-align: center; width: 160px;background-color: red;border-color: red;margin-right: 30px;" type="button" id="button" onclick="document.getElementById('id03').style.display='none'" value='QUAY LẠI' class="btn btn-primary"></input>
                                <input style="text-align: center; width: 160px;background-color: green;border-color: green;margin-left: 30px;" type="button" id="button_save" value='XÁC NHẬN' class="btn btn-primary"></input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>

    <?php
    require "display/footer.php";
    ?>

    <script>
        //chọn vật tư
        function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        /*create a DIV element for each matching element:*/
                        b = document.createElement("DIV");
                        /*make the matching letters bold:*/
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                        /*insert a input field that will hold the current array item's value:*/
                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                        /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            inp.value = this.getElementsByTagName("input")[0].value;
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                        });
                        a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                        /*and simulate a click on the "active" item:*/
                        if (x) x[currentFocus].click();
                    }
                }
            });
            // click vào item
            document.getElementById("input").addEventListener("click", function(e){
                if(document.getElementById('txtVatTu').value!=""){
                    var item = e.target; 
                    myFunction();
                }
            }); 
            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }

        function ajax2(result) {
            var ret = [];
            $.ajax({
                url: 'LoadVT.php',
                type: 'post',
                dataType: 'json',
                data: {
                    result: result
                },
                success: function(result) {
                    result.result.forEach(myfuntion);
                },
                error: function(error) {}
            })

            function myfuntion(item) {
                ret.push(item.TenVatTu);
            }
            return ret;
        }
        var listvt = ajax2("idchange");
        autocomplete(document.getElementById("txtVatTu"), listvt);

        function GetData() {
            $('#tbData>tbody>tr').each(function() {
                var $tbs = $(this).find('td');
                var $nd = $tbs.eq(1).find('option:selected').val();
                var $nd2 = $tbs.eq(0).find('label').type();
                console.log($nd2);
                alert($nd2);
            })
        }
    </script>

    <script>
        var ngduyet = '';
        
        var arry_nguoiduyet1 = $('#cbotaoduyet').val().split(" - ");
        var nguoiduyet1 = arry_nguoiduyet1[0];
        var usertaoduyet = arry_nguoiduyet1[1];
        var kiemtra = "<?php echo $_SESSION["IDNhanVien"]?>";
        if(kiemtra==usertaoduyet){
            $('.txtXemXet').css('display', 'none');
            $('#cbotaoduyet').css('display', 'none');
        }
        else{
            $('.txtXemXet').css('display', 'block');
            $('#cbotaoduyet').css('display', 'block');
        }
        
        $(document).ready(function() {
            
            $("#button_modal").click(function() {
                var arry_nguoiduyet1 = $('#cbotaoduyet').val().split(" - ");
        var nguoiduyet1 = arry_nguoiduyet1[0];
        var usertaoduyet = arry_nguoiduyet1[1];


        var arry_nguoiduyet2 = $('#cboketoan').val().split(" - ");
        var nguoiduyet2 = arry_nguoiduyet2[0];
        userketoan = arry_nguoiduyet2[1];


        var arry_nguoiduyet3 = $('#cboduyet').val().split(" - ");
        var nguoiduyet3 = arry_nguoiduyet3[0];
        userduyet = arry_nguoiduyet3[1];


                hoten = $('#txtHoTen').val();
                $('#tennv').text(hoten);

                bp = $('#txtBoPhan').val();
                $('#tenphongban').text(bp);

                var todate = new Date();
                var date = todate.getDate();
                $('#date').text(date);
                var month = todate.getMonth() + 1;
                $('#month').text(month);
                var year = todate.getFullYear();
                $('#year').text(year);

                nguoitao = $('#txtHoTen').val();
                $('#nguoitao').text(nguoitao);





                $('#xemxet').text(nguoiduyet1);


                $('#ketoan').text(nguoiduyet2);


                $('#pheduyet').text(nguoiduyet3);



                var html = '';
                for (var i = 0; i < vattus.length; i++) {
                    var vattu = vattus[i];
                    html += '<div id="row" style="        display: table-row;    ">';
                    html += '             <div class="cell" data-title="Sothutu" style="border-bottom: 1px lightgray solid;">';
                    html += '                ' + (i + 1) + '';
                    html += '             </div>';
                    html += '             <div class="cell" data-title="TenVatTu" style="border-bottom: 1px lightgray solid;text-align: left;">';
                    html += '                ' + vattu.tenvattu + '';
                    html += '             </div>';
                    html += '             <div class="cell" data-title="DonViTinh" style="border-bottom: 1px lightgray solid;">';
                    html += '                 ' + vattu.donvitinh + '';
                    html += '             </div>';
                    html += '             <div class="cell" data-title="SoLuong" style="border-bottom: 1px lightgray solid;">';
                    html += '                 ' + vattu.soluong + '';
                    html += '             </div>';
                    html += '             <div class="cell" data-title="HangMucSuDung" style="border-bottom: 1px lightgray solid;">';
                    html += '                 ' + vattu.hangmucsudung + '';
                    html += '             </div>';
                    html += '             <div class="cell" data-title="Ghichu" style="border-bottom: 1px lightgray solid;">';
                    html += '                 ' + vattu.ghichu + '';
                    html += '             </div>';
                    html += '             </div>';
                }
                var vattusElement = document.getElementById('rowconfirm')
                vattusElement.innerHTML = html;

                if (vattus.length == 0) {
                    alert("Chưa có vật tư, vui lòng thêm vật tư.");
                } else {
                    $('#id03').css('display', 'block');
                }

            });

            $('#button_save').on('click', function() {

                var arry_nguoiduyet1 = $('#cbotaoduyet').val().split(" - ");
        var nguoiduyet1 = arry_nguoiduyet1[0];
        var usertaoduyet = arry_nguoiduyet1[1];


        var arry_nguoiduyet2 = $('#cboketoan').val().split(" - ");
        var nguoiduyet2 = arry_nguoiduyet2[0];
        userketoan = arry_nguoiduyet2[1];


        var arry_nguoiduyet3 = $('#cboduyet').val().split(" - ");
        var nguoiduyet3 = arry_nguoiduyet3[0];
        userduyet = arry_nguoiduyet3[1];

                var idnhanvien = <?php echo json_encode($_SESSION['IDNhanVien']); ?>;
                
                // aj1(usertaoduyet);
                // aj2(userketoan);
                // aj3(userduyet);
                aja(vattus);


            })
        });

        function thanhcong() {
            alert("Phiếu yêu cầu đã được gởi!");
            $('#id03').css('display', 'none');
            location.reload();
        }

        function thatbai() {
            alert("Phiếu yêu cầu gởi KHÔNG thành công. Vui lòng kiểm tra lại đường truyền hoặc tạo lại phiếu.");
            $('#id03').css('display', 'none');
            location.reload();
        }

        function aja(vattus) {
            var arry_nguoiduyet1 = $('#cbotaoduyet').val().split(" - ");
            var nguoiduyet1 = arry_nguoiduyet1[0];
            var usertaoduyet = arry_nguoiduyet1[1];


            var arry_nguoiduyet2 = $('#cboketoan').val().split(" - ");
            var nguoiduyet2 = arry_nguoiduyet2[0];
            userketoan = arry_nguoiduyet2[1];


            var arry_nguoiduyet3 = $('#cboduyet').val().split(" - ");
            var nguoiduyet3 = arry_nguoiduyet3[0];
            userduyet = arry_nguoiduyet3[1];


            $.ajax({
                url: 'submitVPP.php',
                type: 'post',
                dataType: 'json',
                data: {
                    vattus: vattus
                },
                success: function(vattus) {
                    return $.ajax({
                        url: 'submitVPP.php',
                        type: 'post',
                        dataType: 'json',
                        data: {
                            usertaoduyet: usertaoduyet
                        },
                        success: function(usertaoduyet) {
                            if(usertaoduyet.result=='OK'){
                            return $.ajax({
                                url: 'submitVPP.php',
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    userketoan: userketoan
                                },
                                success: function(userketoan) {
                                        if(userketoan.result=='OK'){
                                    $.ajax({
                                        url: 'submitVPP.php',
                                        type: 'post',
                                        dataType: 'json',
                                        data: {
                                            userduyet: userduyet
                                        },
                                        success: function(userduyet) {
                                            if(userduyet.result=='OK'){
                                                thanhcong();
                                            }
                                            else{
                                                alert ("Gửi yêu cầu thất bại. Vui lòng tạo lại phiếu yêu cầu");
                                            }
                                            
                                        },
                                        error: function(error) {
                                            console.log(error.responseText);
                                        }
                                    })}
                                    else{
                                        alert ("Gửi yêu cầu thất bại. Vui lòng tạo lại phiếu yêu cầu");
                                    }
                                },
                                error: function(error) {
                                    console.log(error.responseText);
                                }
                            })}
                            else{
                                alert ("Gửi yêu cầu thất bại. Vui lòng tạo lại phiếu yêu cầu");
                            }
                        },
                        error: function(error) {
                            console.log(error.responseText);
                        }
                    })
                },
                error: function(error) {
                    console.log(error.responseText);
                }
            })
        }

        // function aj1(usertaoduyet) {
        //     $.ajax({
        //         url: 'submitVPP.php',
        //         type: 'post',
        //         dataType: 'json',
        //         data: {
        //             usertaoduyet: usertaoduyet
        //         },
        //         success: function(usertaoduyet) {
        //             alert("OKtaoduyet");
        //         },
        //         error: function(error) {
        //             console.log(error.responseText);
        //         }
        //     })
        // }

        // function aj2(userketoan) {
        //     $.ajax({
        //         url: 'submitVPP.php',
        //         type: 'post',
        //         dataType: 'json',
        //         data: {
        //             userketoan: userketoan
        //         },
        //         success: function(userketoan) {

        //             alert("OKke toán");
        //         },
        //         error: function(error) {
        //             console.log(error.responseText);
        //         }
        //     })
        // }

        // function aj3(userduyet) {
        //     $.ajax({
        //         url: 'submitVPP.php',
        //         type: 'post',
        //         dataType: 'json',
        //         data: {
        //             userduyet: userduyet
        //         },
        //         success: function(userduyet) {
        //             alert("OKduyet");
        //         },
        //         error: function(error) {
        //             console.log(error.responseText);
        //         }
        //     })
        // }
    </script>