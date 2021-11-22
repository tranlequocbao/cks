<html>
<head>
  <meta charset="utf-8" />
  <title></title>
  <link href="Style/chitietvpp.css" rel="stylesheet" />
  <link rel="stylesheet" href="Style/bootstrap.min.css">
  <script src="js/jquery-2.1.4.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>

</head>

<body style="padding: 20px;">
  <table id="header">
    <tr>
      <th style="border: 1px solid;">
        <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 160px;height: 30px;" />
      </th>
      <th style="border: 1px solid;">
        CÔNG TY TNHH MTV SẢN XUẤT Ô TÔ THACO MAZDA
        <br>
        <span style="font-style: italic; font-size: 15px;">AUTOMOBILE MANUFACTURING ONE MEMBER CO.,LTD</span>
      </th>
      <th style="border: 1px solid;">TMAC.OP3-02.1/F03/Rev0</th>
    </tr>
  </table>
  <div class="title" style="font-weight: bold;font-size: 20px;text-align: center; padding-top: 15px">
    PHIẾU ĐỀ NGHỊ CẤP VẬT TƯ VĂN PHÒNG PHẨM
    <br />
    -------oOo-------
  </div>
  <?php
  require_once "dbhelp.php";
  $id = $_GET['inid'];
  $infomation = "SELECT * FROM yeucauvpp,nhanvien,bophan, vattu WHERE yeucauvpp.IDNhanVien=nhanvien.IDNhanVien AND yeucauvpp.IDBoPhan=bophan.IDBoPhan AND yeucauvpp.IDPhieu='$id' AND vattu.IDVatTu=yeucauvpp.IDVatTu";
  $query = mysqli_query($connect, $infomation);
  $row = mysqli_fetch_array($query);
  $htnv = $row["HoTenNhanVien"];
  $bp = $row["TenBoPhan"];
  ?>
  <div id="noidung">
    <div id="td">
      <p><strong>Mã phiếu yêu cầu:</strong> <?php echo $id ?></p>
      <p><strong>Người đề nghị: </strong><?php echo $htnv ?></p>
      <p><strong>Xưởng/Bộ phận/Phòng ban: </strong><?php echo $bp ?></p>
      <p>Đề nghị Ban lãnh đạo xét duyệt cho cấp một số các vật tư sau:</p>
    </div>
    <table class="TableData">
      <tr>
        <th style="border: 1px solid;">TT</th>
        <th style="border: 1px solid;">Tên vật tư</th>
        <th style="border: 1px solid;">Đơn vị tính</th>
        <th style="border: 1px solid;">Số lượng</th>
        <th style="border: 1px solid;">Hạng mục sử dụng</th>
        <th style="border: 1px solid;">Ghi chú</th>
      </tr>
      <?php
      $stt = 1;
      if ($result = mysqli_query($connect, $infomation)) {
        if (mysqli_num_rows($result) > 0) {
          while ($dong = mysqli_fetch_array($result)) {
      ?>
            <tr>
              <td style="border: 1px solid;text-align: center; padding: 0px 5px; width: 40px;"><?php echo $stt ?></td>
              <td style="border: 1px solid;text-align: left; padding: 0px 5px; width: 230px;"><?php echo $dong['TenVatTu']; ?></td>
              <td style="border: 1px solid;text-align: center; width: 100px;"><?php echo $dong['DonViTinh']; ?></td>
              <td style="border: 1px solid;text-align: center; width: 100px;"><?php echo $dong['SoLuong']; ?></td>
              <td style="border: 1px solid;text-align: center;"><?php echo $dong['HangMucSuDung']; ?></td>
              <td style="border: 1px solid;text-align: center;  width: 260px;"><?php echo $dong['GhiChu']; ?></td>
            </tr>
          <?php
            $stt++;
          }
          // Giải phóng bộ nhớ của biến
          mysqli_free_result($result);
        } else {
          ?>
          <tr>
            <td colspan="4">No Records.</td>
          </tr>
      <?php
        }
      } else {
        echo "ERROR: Không thể thực thi câu lệnh $sql. " . mysqli_error($connect);
      }
      ?>
    </table>
    <?php
    $ngaytao = "SELECT * FROM phieu WHERE IDPhieu='$id'";
    $queryngaytao = mysqli_query($connect, $ngaytao);
    $rowngaytao = mysqli_fetch_array($queryngaytao);
    $thoigiantao = strtotime($rowngaytao['NgayTao']);
    $ngaytao = date('d', $thoigiantao);
    $thangtao = date('m', $thoigiantao);
    $namtao = date('Y', $thoigiantao);
    ?>
<br>
    <p style="text-align:right;font-style: italic;">Núi Thành, ngày <?php echo $ngaytao ?> tháng <?php echo $thangtao ?> năm <?php echo $namtao ?> </p>
    <table style="border: none;">
      <tr>
        <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Duyệt</td>
        <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Kế toán</td>
        <td class="txtXemXet" style="width: 100%;border: none;text-align: center;font-weight: bold;">Xem xét</td>
        <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Người lập</td>
      </tr>

      <tr>
        <?php
        $duyet3 = "SELECT * FROM pheduyet, nhanvien WHERE pheduyet.IDNhanVien=nhanvien.IDNhanVien AND pheduyet.MucDuyet=3 AND pheduyet.IDPhieu='" . $_GET['inid'] . "'";
        $query3 = mysqli_query($connect, $duyet3);
        $row3 = mysqli_fetch_assoc($query3);
        $daduyet3 = $row3["DaDuyet"];
        $ngayduyet3 = $row3["NgayDuyet"];
        $ghichu3 = $row3["GhiChu"];
        if ($daduyet3 == '1') {
        ?>
        <img src="Images/Signed.jpg" height="100px"  alt="Signed" style="z-index: -1;position: absolute;margin-left: 25px">
          <td style="width: 25%;border: none;text-align: center;height:60px">ĐÃ KÝ</td>
        <?php
        } else {
        ?>
          <td style="width: 25%;border: none;text-align: center;height:60px"></td>
        <?php }
        ?>
        <?php
        $duyet2 = "SELECT * FROM pheduyet, nhanvien WHERE pheduyet.IDNhanVien=nhanvien.IDNhanVien AND pheduyet.MucDuyet=2 AND pheduyet.IDPhieu='" . $_GET['inid'] . "'";
        $query2 = mysqli_query($connect, $duyet2);
        $row2 = mysqli_fetch_assoc($query2);
        $daduyet2 = $row2["DaDuyet"];
        $ngayduyet2 = $row2["NgayDuyet"];
        $ghichu2 = $row2["GhiChu"];
        if ($daduyet2 == '1') {
        ?>
          <td style="width: 25%;border: none;text-align: center;height:60px">ĐÃ KÝ</td>
        <?php
        } else {
        ?>
          <td style="width: 25%;border: none;text-align: center;height:60px"></td>
        <?php }
        ?>

        <?php
        $duyet1 = "SELECT * FROM pheduyet, nhanvien WHERE pheduyet.IDNhanVien=nhanvien.IDNhanVien AND pheduyet.MucDuyet=1 AND pheduyet.IDPhieu='" . $_GET['inid'] . "'";
        $query1 = mysqli_query($connect, $duyet1);
        $row1 = mysqli_fetch_assoc($query1);
        $daduyet1 = $row1['DaDuyet'];
        $ngayduyet1 = $row1['NgayDuyet'];
        $ghichu1 = $row1['GhiChu'];
        if ($daduyet1 == '1') {
        ?>
          <td class="txtXemXet" style="width: 100%;border: none;text-align: center;height:60px">ĐÃ KÝ</td>
        <?php
        } else {
        ?>
          <td class="txtXemXet" style="width: 100%;border: none;text-align: center;height:60px"></td>
        <?php }
        ?>


        <td style="width: 25%;border: none;text-align: center;height:60px">ĐÃ KÝ</td>
      </tr>
      <tr>
        <td style="width: 25%;border: none;text-align: center;"><?php echo $row3['HoTenNhanVien'] ?></td>
        <td style="width: 25%;border: none;text-align: center;"><?php echo $row2['HoTenNhanVien'] ?></td>
        <td class="txtXemXet" style="width: 100%;border: none;text-align: center;"><?php echo $row1['HoTenNhanVien']; $msnvtd=$row1["IDNhanVien"]; ?></td>
        <td style="width: 25%;border: none;text-align: center;"><?php echo $row['HoTenNhanVien'];$msnvt=$row["IDNhanVien"]; ?></td>
      </tr>
      <tr>
        <td style="width: 25%;border: none;text-align: center;"><?php echo $ghichu3; ?></td>
        <td style="width: 25%;border: none;text-align: center;"><?php echo $ghichu2; ?></td>
        <td class="txtXemXet" style="width: 100%;border: none;text-align: center;"><?php echo $ghichu1; ?></td>
        <td style="width: 25%;border: none;text-align: center;"></td>
      </tr>
    </table>
  </div>
  <DIV style="text-align: center;">
    <input type="button"  id="inphieu" onclick="printform()" class="btn btn-primary" style="width: 100px;" value="In phiếu"></input>
  </DIV>
</body>

</html>

<script>
         var idtao="<?php  $infomation = "SELECT * FROM yeucauvpp,nhanvien WHERE yeucauvpp.IDNhanVien=nhanvien.IDNhanVien AND yeucauvpp.IDPhieu='$id'";
  $query = mysqli_query($connect, $infomation);
  $row = mysqli_fetch_array($query); echo $row["IDNhanVien"];?>";
        var idtaoduyet="<?php $duyet1 = "SELECT * FROM pheduyet, nhanvien WHERE pheduyet.IDNhanVien=nhanvien.IDNhanVien AND pheduyet.MucDuyet=1 AND pheduyet.IDPhieu='" . $_GET['inid'] . "'";
        $query1 = mysqli_query($connect, $duyet1);
        $row1 = mysqli_fetch_assoc($query1); echo $row1["IDNhanVien"];?>";
        if(idtao==idtaoduyet){
            $('.txtXemXet').css('display', 'none');
        }
        else{
            $('.txtXemXet').css('display', 'block');
        }

  function printform() {
    document.getElementById("inphieu").style.display = 'none';
    var css = '@page { size: landscape;  margin: 0; padding:20px}',
      head = document.head || document.getElementsByTagName('head')[0],
      style = document.createElement('style');
    style.type = 'text/css';
    style.media = 'print';
    if (style.styleSheet) {
      style.styleSheet.cssText = css;
    } else {
      style.appendChild(document.createTextNode(css));
    }
    head.appendChild(style);
    window.print();
    window.location = 'VPP.php?p=VPP&id=<?php echo $_GET['inid'] ?>';
    
    
  }
</script>