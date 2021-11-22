'use strict'


var vattus = [];

// View List Danh sách vật tư
function Danhsachvattu() {
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
        html += '             <div class="cell" data-title="Xoa" style="text-align: center;border-bottom: 1px lightgray solid;">';
        html += '                 <button class="xoa" onclick="xoaVattu(' + i + ')">Xóa</button>';
        html += '             </div>';
        html += '             </div>';
    }
    var vattusElement = document.getElementById('row')
    vattusElement.innerHTML = html;
}

document.addEventListener('DOMContentLoaded', function() {
    Danhsachvattu();
});

// Click thêm vật tư
function onclickvattu() {
    var tenvattu = themvattu('#txtVatTu');
    var donvitinh = themvattu('#txtDonViTinh');
    var soluong = themvattu('#txtSoLuong');
    var hangmucsudung = themvattu('#txtHangMucSuDung');
    var ghichu = themvattu('#txtGhiChu');
    var regex = /^[0-9]+$/;

    if (donvitinh == "") {
        alert("Vật tư không tồn tại. Vui lòng nhập ĐÚNG tên vật tư.");
    } else if (soluong == "" || hangmucsudung == "" || tenvattu == "") {
        alert("KHÔNG để trống các nội dung bắt buộc.");
    } else if (!soluong.match(regex)) {
        alert("Số lượng không phải là số. Vui lòng kiểm tra lại.");
    } else
    if (tenvattu != "") {
        var result1 = tenvattu;
        kiemtravattu(result1);
    } else {
        addvattu({
            tenvattu: tenvattu,
            donvitinh: donvitinh,
            soluong: soluong,
            hangmucsudung: hangmucsudung,
            ghichu: ghichu
        });
        console.log(vattus);
        Danhsachvattu();
    }
}

function kiemtravattu(result) {
    $.ajax({
        url: 'checkunit.php',
        type: 'post',
        dataType: 'json',
        data: {
            result: result
        },
        success: function(result) {
            var tenvattu = themvattu('#txtVatTu');
            var donvitinh = themvattu('#txtDonViTinh');
            var soluong = themvattu('#txtSoLuong');
            var hangmucsudung = themvattu('#txtHangMucSuDung');
            var ghichu = themvattu('#txtGhiChu');
            var regex = /^[0-9]+$/;
            if (donvitinh == "undefined") {
                alert("Vật tư không tồn tại. Vui lòng nhập ĐÚNG tên vật tư.");
            } else {
                addvattu({
                    tenvattu: tenvattu,
                    donvitinh: donvitinh,
                    soluong: soluong,
                    hangmucsudung: hangmucsudung,
                    ghichu: ghichu
                });
                console.log(vattus);
                Danhsachvattu();
            }
        },
        error: function(error) {
            console.log(error.responseText);
        }
    })
}

function isArray(vattu) {
    return vattu.tenvattu === document.getElementById('txtVatTu').value;
}

// thêm 1 vật tư
function addvattu(vattu) {
    if (vattus.find(isArray) == undefined) {
        vattus.push(vattu);
    } else {
        alert("Vật tư đã tồn tại. Vui lòng kiểm tra lại trong danh sách.");
    }
}


function themvattu(selector) {
    var inputElement = document.querySelector(selector);
    return inputElement.value;
}

function xoaVattu(index) {
    del(index);
    Danhsachvattu();
}

function del(index) {
    vattus.splice(index, 1);
}


function aja(vattus) {
    $.ajax({
        url: 'submitVPP.php',
        type: 'post',
        dataType: 'json',
        data: {
            vattus: vattus
        },
        success: function(vattus) {
            confirm("OK")
        },
        error: function(error) {
            console.log(error.responseText);
        }
    })
}

function aj1(usertaoduyet) {
    $.ajax({
        url: 'submitVPP.php',
        type: 'post',
        dataType: 'json',
        data: {
            usertaoduyet: usertaoduyet
        },
        success: function(usertaoduyet) {
            confirm("OK");
        },
        error: function(error) {
            console.log(error.responseText);
        }
    })
}

function aj2(userketoan) {
    $.ajax({
        url: 'submitVPP.php',
        type: 'post',
        dataType: 'json',
        data: {
            userketoan: userketoan
        },
        success: function(userketoan) {
            confirm("OKke toán");
        },
        error: function(error) {
            console.log(error.responseText);
        }
    })
}

function aj3(userduyet) {
    $.ajax({
        url: 'submitVPP.php',
        type: 'post',
        dataType: 'json',
        data: {
            userduyet: userduyet
        },
        success: function(userduyet) {
            confirm("OKduyet");
        },
        error: function(error) {
            console.log(error.responseText);
        }
    })
}

function onclickGui() {
    if (vattus.length == 0) {
        alert("Chưa có vật tư, vui lòng thêm vật tư.");
    } else {
        var arry_duyet1 = $('#cbotaoduyet').val().split("-");
        var nguoiduyet1 = arry_duyet1[1];
        var usertaoduyet = arry_duyet1[0];


        var arry_duyet2 = $('#cboketoan').val().split("-");
        var nguoiduyet2 = arry_duyet2[1];
        var userketoan = arry_duyet2[0];


        var arry_duyet3 = $('#cboduyet').val().split("-");
        var nguoiduyet3 = arry_duyet3[1];
        var userduyet = arry_duyet3[0];
        aj1(usertaoduyet);
        aj2(userketoan);
        aj3(userduyet);
        aja(vattus);
        alert("Đã tạo phiếu yêu cầu thành công, Vui lòng chờ cấp trên duyệt.");
    }

}