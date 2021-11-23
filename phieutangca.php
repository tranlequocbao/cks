<?php

session_start();
require_once "dbhelp.php";
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <!-- <link href="Style/Stylephieu.css" rel="stylesheet" /> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="Style/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

    <title>Document</title>
</head>

<body style="background-repeat: repeat !important;">
    <?php
    require "display/header.php";
    ?>
    <div class="container ">
        <div class="row form">
            <div class="col d-flex justify-content-center ">
                <form class="form-inline">
                    <div class="form-group mb-2 ml-2 tittle">

                        <div class="tittle">Chọn File Excel cần tải</div>
                    </div>
                    <div class="input-group mb-2 ml-2 select_file">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01">
                            <label class="custom-file-label" id="upfile" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>

                </form>
                <button id='upload' class="btn btn-primary mb-2 ml-2">Tải Lên</button>
                <button type="button" class="btn btn-primary mb-2 ml-2" style="width: initial !important;" data-toggle="modal" data-target="#manualModel" data-whatever="@IT">CẬP NHẬT TĂNG CA</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <p class="huongdan">Tải tệp mẫu <a id='download' href="#">tại đây</a></p>
        </div>
        <div class="row justify-content-center">
            <div class="table-responsive result d-none">
                <table class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">STT</th>
                            <th scope="col" rowspan="2">Họ và Tên</th>
                            <th scope="col" rowspan="2">MSNV</th>
                            <th scope="col" rowspan="2">Chức vụ</th>
                            <th scope="col" rowspan="2">Nội dung tăng ca</th>
                            <th scope="col" colspan="5">Giờ tăng ca đến</th>
                            <th scope="col" rowspan="2">Điểm đưa đón</th>
                            <th scope="col" rowspan="2">Suất ăn</th>
                            <th scope="col" rowspan="2">Ghi chú</th>
                        </tr>
                        <tr>

                            <th scope="col">Đến 18g30</th>
                            <th scope="col">Đến 20g45</th>
                            <th scope="col">Đến 22g25</th>
                            <th scope="col">Đến 24g00</th>
                            <th scope="col">Đến 07g00</th>

                        </tr>
                    </thead>
                    <tbody class="body detail">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row total d-none">
            <div class="col-4">
                <div class="table-responsive result">
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">TỔNG SL TĂNG CA:</th>

                            </tr>

                        </thead>
                        <tbody class="body time_over">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-4">
                <div class="table-responsive result">
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">TỔNG SL ĐƯA ĐÓN:</th>

                            </tr>
                        </thead>
                        <tbody class="body position">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-4">
                <div class="table-responsive result">
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">TỔNG SL MÓN ĂN:</th>

                            </tr>
                        </thead>
                        <tbody class="body food">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <button id="confirm" class="btn btn-primary d-none">Xác nhận</button>
        </div>

        <div class="modal fade" id="manualModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ĐĂNG KÝ TĂNG CA</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="nameModal" class="col-form-label">Họ và tên:</label>
                                <input type="text" class="form-control" id="nameModal">

                            </div>
                            <div class="form-group">
                                <label for="msnvModal" class="col-form-label">Mã số:</label>
                                <input type="text" class="form-control" id="msnvModal">
                            </div>
                            <div class="form-group">
                                <label for="chucvuModal" class="col-form-label">Chức vụ:</label>
                                <input type="text" class="form-control" id="chucvuModal">
                            </div>
                            <div class="form-group">
                                <label for="noidungModal" class="col-form-label">Nội dung tăng ca:</label>
                                <textarea class="form-control" id="noidungModal"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="giotcModal" class="col-form-label">Giờ tăng ca:</label>
                                <button id="dropdown" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Giờ tăng ca
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">18h30</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">20h45</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">22h15</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">24h00</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">7h00</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="diadiemModal" class="col-form-label">Điểm đưa đón:</label>
                                <input type="text" class="form-control" id="diadiemModal">
                            </div>
                            <div class="form-group">
                                <label for="monanModal" class="col-form-label">Món ăn:</label>
                                <input type="text" class="form-control" id="monanModal">
                            </div>
                            <div class="form-group">
                                <label for="ghichuModal" class="col-form-label">Ghi chú:</label>
                                <textarea class="form-control" id="ghichuModal"></textarea>
                            </div>
                        </form>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" disabled id="save">Lưu</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
    $date = getdate();
    ?>
    <div id="footer" class="row justify-content-center" style="margin-left: 0px;">
        <p style="position: absolute;"> Copyright &copy <?php echo $date['year'] ?> Bộ phận Quản trị CNTT Khối Sản Xuất Lắp Ráp xe Du lịch và Xe máy</p>
    </div>
    <script type="text/javascript" src="assets/js/main.js"></script>
    <script type="text/javascript" src="vendor/jquery/jquery.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.popper.min.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            var result_update_data = 0;

            $('#upload').click(function() {
                $('.container').css({
                    'position': 'absolute',
                    'top': '75px',
                    'left': '50%',
                    'transform': 'translateX(-50%)'
                });
                var filename, path;
                $('.filename').text("Chua co file");
                $('input[type="file"]').change(function(e) {
                    filename = e.target.files[0].name;
                    $('#upfile').text(filename);
                })
                $('tbody tr').remove();
                cal.readExcel();

            })
            $('#download').click(function(e) {
                e.preventDefault();
                window.location.href = "assets/form/excel.xlsx"
            })
            $('#manualModel').on('show.bs.modal', function(event) {

                cal.check_empty();
                $('.container').css({
                    'position': 'absolute',
                    'top': '75px',
                    'left': '50%',
                    'transform': 'initial',
                    
                });
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                //modal.find('.modal-title').text('CẬP NHẬT TĂNG CA ' + recipient)

                //modal.find('.modal-body input').val(recipient)
            })
            $('#manualModel').on('hide.bs.modal', function(event) {

                var body = $('.detail');
                if (body.children().length == 0) {
                    $('.container').css({
                        'position': 'absolute',
                        'top': '50%',
                        'left': '50%',
                        'transform': 'translate(-50%, -50%)',
                    });
                } else {
                    $('.container').css({
                        'position': 'absolute',
                        'top': '75px',
                        'left': '50%',
                        'transform': 'translateX(-50%)'
                    });
                    $('.container').css({
                    'background-color': 'aliceblue'
                });
                }
            })

            $('.dropdown-menu a').on('click', function() {
                $('#dropdown').text($(this).text());
            })
            $('#save').click(function() {

                var body = $('.detail');
                if ($('#dropdown').text().trim() == 'Giờ tăng ca') {
                    alert('Vui lòng chọn giờ tăng ca');
                    return;
                }
                if (body.children().length != 0) {

                    cal.save();

                } else {

                    cal.save(1);
                }

            })
            $('#confirm').click(function() {
                cal.get_info_toSave();
            })
            $('#close').click(function() {
                var body = $('.detail');
                if (body.children().length == 0) {
                    $('.container').css({
                        'position': 'absolute',
                        'top': '50%',
                        'left': '50%',
                        'transform': 'translate(-50%, -50%)',
                    });
                }
            })

        })
    </script>
</body>

</html>