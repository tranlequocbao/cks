<html>

<head>
  <meta charset="utf-8" />
  <title>Chữ ký điện tử Thaco Auto</title>
  <!-- <link href="Style/chitietvpp.css" rel="stylesheet" /> -->
  <link rel="stylesheet" href="Style/bootstrap.min.css">
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- <link href="Style/chitietvpp.css" rel="stylesheet" /> -->
</head>
<?php
include ("dbhelp.php");

$sql = "SELECT * FROM phieu,nhanvien,bophan,loaiphieu,yeucaucongviec WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu and phieu.IDPhieu = yeucaucongviec.IDPhieu AND bophan.IDBoPhan=nhanvien.IDBoPhan and phieu.IDPhieu = '$_GET[inid]' ";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);
$hoanthanh = strtotime($row['NgayHoanThanh']);
$ngayhoanthanh = date('d', $hoanthanh);
$thanghoanthanh = date('m', $hoanthanh);
$namhoanthanh = date('Y', $hoanthanh);
$ngaytao = strtotime($row['NgayTao']);
$ngay = date('d', $ngaytao);
$thang = date('m', $ngaytao);
$nam = date('Y', $ngaytao);
?>


<body style="MARGIN-TOP: 50PX;">
  <div class="title" style="font-weight: bold;font-size: 20px;text-align: center; padding-top: 15px;width: 900px;height: 1042px;margin: auto;">
    <table id="header" style="width: -webkit-fill-available; margin:auto">
      <tr>
        <th>
          <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 160px;height: 40px;margin-top: -30px;" />
        </th>
        <th style= "font-size: 20px;">
          CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM
          <br>
          Độc lập - Tự do - Hạnh phúc
          <br>
          ______***______
        </th>
      </tr>
    </table>
    <br>
    <div class="title" style="font-weight: bold;font-size: 20px;text-align: center;">
      PHIẾU YÊU CẦU CÔNG VIỆC
    </div>
    <div id="noidung">
      <br>
      <table style="margin-left: 60; font-size: 20px;">
        <tr>
          <td>
            <p style="padding: 0px;"><span style="font-weight:bold">Đơn vị yêu cầu:</span>
              <?php echo $row['TenBoPhan']; ?>
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p style="padding: 0px;"><span style="font-weight:bold">Đơn vị thực hiện:</span>
              <?php
              $sql1 = "SELECT * FROM bophan WHERE IDBoPhan='" . $row['IDBoPhanNhanYeuCau'] . "' ";
              $result1 = mysqli_query($connect, $sql1);
              $row1 = mysqli_fetch_array($result1);

              echo $row1['TenBoPhan'] ?></p>
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p style="padding: 0px;"><span style="font-weight:bold">Nội dung công việc:</span>
              <?php echo $row['NoiDungCongViec']; ?>
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p style="padding: 0px;"><span style="font-weight:bold">Mục đích:</span>
              <?php echo $row['MucDich']; ?>
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p style="padding: 0px;"><span style="font-weight:bold">Ghi chú:</span>
              <?php echo $row['GhiChu1']; ?>
            </p>
          </td>
        </tr>
        <tr>
          <td>
            <p style="padding:  0px;"><span style="font-weight:bold">Thời gian hoàn thành:</span>
              Ngày <?php echo $ngayhoanthanh ?> tháng <?php echo $thanghoanthanh ?> năm <?php echo $namhoanthanh ?>.
            </p>
          </td>
        </tr>
      </table>
      <br />
      <div style=" text-align: right; margin-right: 48px;font-size: 20px;">
        <span style="font-style: italic; font: size 12px; font-weight:normal"> Núi Thành, ngày <?php echo $ngay ?> tháng <?php echo $thang ?> năm <?php echo $nam ?></span>
      </div>
      <br>
      <table style="border: none;margin: auto;width: -webkit-fill-available;font-size: 20px;">
        <tr>
          <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Phê duyệt</td>
          <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Bộ phận nhận</td>
          <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Xem xét</td>
          <td style="width: 25%;border: none;text-align: center;font-weight: bold;">Nhân viên tạo</td>
        </tr>
        <tr>
          <?php
          $duyet3 = "SELECT * FROM pheduyet, caidatmau, nhanvien WHERE pheduyet.IDNhanVien=nhanvien.IDNhanVien AND pheduyet.MucDuyet=3 AND pheduyet.IDPhieu='" . $_GET['inid'] . "' AND caidatmau.IDLoaiPhieu='P0004'";
          $query3 = mysqli_query($connect, $duyet3);
          $row3 = mysqli_fetch_assoc($query3);
          $daduyet3 = $row3["DaDuyet"];
          $ngayduyet3 = $row3["NgayDuyet"];
          $ghichu3 = $row3["GhiChu"];
          if ($daduyet3 == '1') {
          ?>
          <img src="Images/Signed.jpg" height="100px"  alt="Signed" style="z-index: -1;position: absolute;margin-left: -425px">
            <td style="width: 25%;border: none;text-align: center;height:60px">ĐÃ KÝ</td>
          <?php
          } else {
          ?>
            <td style="width: 25%;border: none;text-align: center;height:60px"></td>
          <?php }
          ?>
          <?php
          $duyet2 = "SELECT * FROM pheduyet, caidatmau, nhanvien WHERE pheduyet.IDNhanVien=nhanvien.IDNhanVien AND pheduyet.MucDuyet=2 AND pheduyet.IDPhieu='" . $_GET['inid'] . "' AND caidatmau.IDLoaiPhieu='P0004'";
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
          $duyet1 = "SELECT * FROM pheduyet, caidatmau, nhanvien WHERE pheduyet.MucDuyet=1 AND pheduyet.IDPhieu='" . $_GET['inid'] . "' and nhanvien.IDNhanVien=pheduyet.IDNhanVien";
          $query1 = mysqli_query($connect, $duyet1);
          $row1 = mysqli_fetch_assoc($query1);
          $daduyet1 = $row1['DaDuyet'];
          $ngayduyet1 = $row1['NgayDuyet'];
          $ghichu1 = $row1['GhiChu'];
          if ($daduyet1 == '1') {
          ?>
          
            <td style="width: 25%;border: none;text-align: center;height:60px">ĐÃ KÝ</td>
          <?php
          } else {
          ?>
            <td style="width: 25%;border: none;text-align: center;height:60px"></td>
          <?php }
          ?>
          <td style="width: 25%;border: none;text-align: center;height:60px">ĐÃ KÝ</td>
        </tr>

        <tr>
          <td style="width: 25%;border: none;text-align: center;"><?php echo $row3["HoTenNhanVien"]; ?></td>
          <td style="width: 25%;border: none;text-align: center;"><?php echo $row2["HoTenNhanVien"]; ?></td>
          <td style="width: 25%;border: none;text-align: center;"><?php echo $row1["HoTenNhanVien"]; ?></td>
          <td style="width: 25%;border: none;text-align: center;"><?php echo $row["HoTenNhanVien"]; ?></td>
        </tr>
        <tr>
          <td style="width: 25%;border: none;text-align: center;"><?php echo $row3["GhiChu"]; ?></td>
          <td style="width: 25%;border: none;text-align: center;"><?php echo $row2["GhiChu"]; ?></td>
          <td style="width: 25%;border: none;text-align: center;"><?php echo $row1["GhiChu"]; ?></td>
          <td style="width: 25%;border: none;text-align: center;"><?php echo $row["GhiChu1"]; ?></td>
        </tr>
      </table>
    </div>
    <br>
    <DIV style="text-align: center;">
      <input type="button" id="inphieu" onclick="printform()" class="btn btn-primary" style="width: 100px;" value="In phiếu"></input>
    </DIV>
  </div>

</body>
</div>

</html>
<script>
  function printform() {
    document.getElementById("inphieu").style.display = 'none';
    var css = '@page { margin: 0;}',
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
    window.location = 'PCV.php?p=PCV&id=<?php echo $_GET['inid'] ?>';
  }
</script>