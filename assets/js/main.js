function cal() {
    var self = this;

    this.readExcel = (status = 0) => {


        var file_data = $('#inputGroupFile01').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        //alert(form_data);
        $.ajax({
            url: 'funcPhieutangca/upfile.php',
            dataType: 'html',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function(php_script_response) {
                $('.detail').html(php_script_response);
                $('.result').removeClass('d-none');
                $('.container').css({
                    'background-color': 'aliceblue'
                });
                //console.log(php_script_response);
                self.Amount();
            },
            error: function(error) {
                alert(error.responseText);
            }
        });


        //self.save(1);

        //console.log(php_script_response);
        //self.Amount();



    }
    this.Amount = (status = 0) => {


        var
            total = [],
            time_18h30 = [],
            time_20h45 = [],
            time_22h15 = [],
            time_24h00 = [],
            time_7h00 = [],
            food = [],
            tamky = 0,
            tpqn = 0,
            qn = 0,
            cd = 0;

        $('.result tbody tr th:nth-child(1)').each(function() {

            total.push($(this).text());
        });
        $('.result tbody tr td:nth-child(6)').each(function() {

            if ($(this).text().trim() != "") time_18h30.push($(this).text());
        });
        $('.result tbody tr td:nth-child(7)').each(function() {

            if ($(this).text().trim() != "") time_20h45.push($(this).text());
        });
        $('.result tbody tr td:nth-child(8)').each(function() {

            if ($(this).text().trim() != "") time_22h15.push($(this).text());
        });
        $('.result tbody tr td:nth-child(9)').each(function() {

            if ($(this).text().trim() != "") time_24h00.push($(this).text());
        });
        $('.result tbody tr td:nth-child(10)').each(function() {

            if ($(this).text().trim() != "") time_7h00.push($(this).text());
        });
        $('.result tbody tr td:nth-child(11)').each(function() {

            if ($(this).text().toUpperCase().includes("TK") == true) {
                tamky++;
            } else if ($(this).text().toUpperCase().includes("QNG") == true) {
                qn++;
            } else if ($(this).text().toUpperCase().includes("TPQN") == true) {
                tpqn++;
            } else if ($(this).text().toUpperCase().includes("CD") == true) {
                cd++;
            }
        });
        $('.result tbody tr td:nth-child(12)').each(function() {

            if ($(this).text() != "") food.push($(this).text());
        });
        var food_ = new Set(food);
        var food_arr = [...food_];


        var total_ = total.length;
        var stt_ = 1;
        if (status == 1) {
            $('.result tbody tr th:nth-child(1)').each(function() {
                if (stt_ != total)
                    $(this).text(stt_);

                stt_++;
            });
        }
        var time_18h30_ = time_18h30.length;
        var time_20h45_ = time_20h45.length;
        var time_22h15_ = time_22h15.length;
        var time_24h00_ = time_24h00.length;
        var time_7h00_ = time_7h00.length;


        $('.detail').append("<tr><th colspan=" + 4 + ">TỔNG</th><td></td><td>" + time_18h30_ + "</td><td>" + time_20h45_ + "</td><td>" + time_22h15_ + "</td><td>" + time_24h00_ + "</td><td>" + time_7h00_ + "</td><td></td><td></td><td></td></tr>");
        $('.time_over').append("" +
            "<tr>" +
            "<td>Đến 18h30</td>" +
            "<td>" + time_18h30_ + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>Đến 20h45</td>" +
            "<td>" + time_20h45_ + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>Đến 22h15</td>" +
            "<td>" + time_22h15_ + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>Đến 24h00</td>" +
            "<td>" + time_24h00_ + "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>Đến 7h00</td>" +
            "<td>" + time_7h00_ + "</td>" +
            "</tr>");
        $('.position').append("" +
            "<tr>" +
            "<td>Tam Kỳ</td>" +
            "<td>" + tamky + "</td" +
            "</tr>" +
            "<tr>" +
            "<td>Quãng Ngãi</td>" +
            "<td>" + qn + "</td" +
            "</tr>" +
            "<tr>" +
            "<td>TP Quãng Ngãi</td>" +
            "<td>" + tpqn + "</td" +
            "</tr>" +
            "<tr>" +
            "<td>Trường Cao Đẳng</td>" +
            "<td>" + cd + "</td" +
            "</tr>"
        )

        for (var i = 0; i < food_arr.length; i++) {
            var type_food = 0;
            $('.result tbody tr td:nth-child(12)').each(function() {
                if ($(this).text() == food_arr[i]) {
                    type_food++;
                }

            });

            $('.food').append("" +
                "<tr>" +
                "<td>" + food_arr[i] + "</td>" +
                "<td>" + type_food + "</td" +
                "</tr>");
        }
        $('.total').removeClass('d-none');
        $('#confirm').removeClass('d-none');
        self.scroll();
    }
    this.check_empty = () => {

        $('#nameModal').blur(function() {
            if (!this.value) {

                if (!$(this).hasClass('is-invalid')) {
                    $(this).addClass('is-invalid');
                    $(this).parent('.form-group').append(' <small id="error" class="text-danger">Vui lòng không để trống.</small>')
                }



            } else {
                $(this).removeClass('is-invalid');
                $(this).parent('.form-group').find('#error').remove();
            }
            self.check_error_input();

        })
        $('#noidungModal').blur(function() {
            if (!this.value) {
                if (!$(this).hasClass('is-invalid')) {
                    $(this).addClass('is-invalid');
                    $(this).parent('.form-group').append(' <small id="error" class="text-danger">Vui lòng không để trống.</small>')
                }

            } else {
                $(this).removeClass('is-invalid');
                $(this).parent('.form-group').find('#error').remove();
            }
            self.check_error_input();


        })
        $('#msnvModal').blur(function() {
            var a = $(this).val().length;

            if (a != 7) {

                if (!$(this).hasClass('is-invalid')) {
                    console.log("zzz");
                    $(this).addClass('is-invalid');
                    $(this).parent('.form-group').append(' <small id="error" class="text-danger">Vui lòng nhập đúng Mã số Nhân viên.</small>')
                }

            } else {
                $(this).removeClass('is-invalid');
                $(this).parent('.form-group').find('#error').remove();
            }
            self.check_error_input();


        })
    }
    this.check_error_input = () => {

        if ($('#nameModal').val().length != 0 && $('#noidungModal').val().length != 0 && $('#msnvModal').val().length == 7) {

            $('#save').attr('disabled', false);

        } else {

            console.log($('#nameModal').val());
            $('#save').attr('disabled', true);
        }
    }
    this.save = (status = 0) => {
        var change = 0;
        var no = false;
        //đã có dữ liệu bảng

        //chưa có dữ liệu bảng

        if (status == 0) {


            $('.detail tr').find('#msnv').each(function() {


                if ($(this).text() == $('#msnvModal').val()) {
                    if (!confirm("Đã trùng mã số NV bạn đang nhập? Bạn có muốn cập nhật không?")) {

                        no = true;
                        return;
                    } else {
                        console.log($(this).closest('tr'));
                        $(this).closest('tr').remove();
                        change = 1;
                    }



                }
            })
        }
        if (no == true) { console.log("cancel"); return; }
        if (status == 0) {
            $('.detail tr:last').remove();

        }
        var value = "";
        var stt = $('.detail tr:last').closest('tr');
        if (stt.length != 0) {

            value = stt.find('th:eq(0)').text();
        }

        var stt_ = "1";
        if (value != "") {
            stt_ = parseInt(value) + 1
        }

        var giotc = "";
        var tc = $('#dropdown').text();
        if (tc == '18h30') {
            giotc = "<td id='18h30'>X</td><td  id='20h45'></td><td  id='22h15'></td><td id='24h00'></td><td id='7h00'></td>";
        } else if (tc == '20h45') {
            giotc = "<td id='18h30'></td><td id='20h45'>X</td><td id='22h15'></td id='24h00'><td></td><td id='7h00'></td>"
        } else if (tc == '22h15') {
            giotc = "<td id='18h30'></td><td id='20h45'></td ><td id=id='22h15'>X</td><td id='24h00'></td><td id='7h00'></td>"
        } else if (tc == '24h00') giotc = "<td id='18h30'> </td><td id='20h45'></td><td id='22h15'></td><td id='24h00'>X</td><td id='7h00'></td>"
        else if (tc == '7h00') giotc = "<td id='18h30'></td><td id='20h45'></td><td id='22h15'></td><td id='24h00'></td><td id='7h00'>X</td>"

        $('.detail').append("" +
            "<tr>" +
            "<th id='" + stt_ + "'>" + stt_ + "</th>" +
            "<td id='name'>" + $('#nameModal').val() + "</td>" +
            "<td id='msnv'>" + $('#msnvModal').val() + "</td>" +
            "<td id='chucvu'>" + $('#chucvuModal').val() + "</td>" +
            "<td id='noidung'>" + $('#noidungModal').val() + "</td>" +
            "" + giotc + "" +
            "<td id='diadiem'>" + $('#diadiemModal').val() + "</td>" +
            "<td id='monan'>" + $('#monanModal').val() + "</td>" +
            "<td id='ghichu'> " + $('#ghichuModal').val() + "</td>" +
            "</tr>");
        $('.time_over tr').remove();
        $('.position tr').remove();
        $('.food tr').remove();
        if (change == 1) {
            self.Amount(1);
        } else
            self.Amount();
        $('#manualModel').modal('hide')
        $('.detail').removeClass('d-none');
        $('.result').removeClass('d-none');

    }
    this.get_info_toSave = () => {
        var i = 0;
        var arry = [];
        var value = {};
        $('.detail tr').each(function() {
            var name = $(this).find('#name').text();
            var msnv = $(this).find('#msnv').text();
            var chucvu = $(this).find('#chucvu').text();
            var noidung = $(this).find('#chuvu').text();
            var h18h30 = $(this).find('#18h30').text();
            var h20h45 = $(this).find('#20h45').text();
            var h22h15 = $(this).find('#22h15').text();
            var h24h00 = $(this).find('#24h00').text();
            var h7h00 = $(this).find('#7h00').text();
            var diadiem = $(this).find('#diadiem').text();
            var monan = $(this).find('#monan').text();
            var ghichu = $(this).find('#ghichu').text();

            value = {
                name: name,
                msnv: msnv,
                chucvu: chucvu,
                noidung: noidung,
                h18h30: h18h30,
                h20h45: h20h45,
                h22h15: h22h15,
                h24h00: h24h00,
                h7h00: h7h00,
                diadiem: diadiem,
                monan: monan,
                ghichu: ghichu

            };
            arry.push(value);

            // if (msnv != null && msnv != "") {

            //     // if (self.saveToDatabase(name, msnv, chucvu, noidung, h18h30, h20h45, h22h15, h24h00, h7h00, diadiem, monan, ghichu) != 1) {

            //     //     result = 1;
            //     // }
            //     self.saveToDatabase(name, msnv, chucvu, noidung, h18h30, h20h45, h22h15, h24h00, h7h00, diadiem, monan, ghichu);

            // }


        });
        console.log(arry);
        self.saveToDatabase(arry);

    }
    this.saveToDatabase = (data) => {
        var result = 0;
        $.ajax({
            url: 'funcPhieutangca/saveTable.php',
            dataType: 'json',
            cache: false,
            data: {
                data: data
            },
            type: 'post',
            success: function(result) {
                console.log(result);
                if (result.code == 200) {
                    alert("Lưu thành công");
                    //location.reload();
                } else alert("Lưu thông thất bại");


            },
            error: function(error) {
                alert(error.responseText);
            },
            complete: function() {

            }


        });
    }
    this.scroll = () => {
        var $container = $('div'),
            $scrollTo = $('#row_8');

        $container.scrollTop(
            0, 0
        );
    }


}
var cal = new cal();