<html>

<head>
  <meta charset="utf-8" />
  <title>Chữ ký điện tử Thaco Auto</title>
  <!-- <link href="Style/chitietvpp.css" rel="stylesheet" /> -->
</head>

<body onload="window.print();">
  <div style="width: 650px; height: auto; margin-left:auto;margin-right:auto">
    <table id="header">
      <tr>
        <th style="text-align: left; width:40%">
          <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 160px;height: 30px;" />
        </th>
        <th style=" width:10%">
        </th>
        <th style="text-align: center; width: 40%; margin-left: 30%">
          CÔNG TY TNHH MTV SẢN XUẤT
          <br>
          Ô TÔ THACO MAZDA
          <br>
        </th>
      </tr>
    </table>
    <br />
    <br>
    <br>
    <div class="title" style="font-weight: bold;font-size: 22px;text-align: center;">
      GIẤY RA CỔNG

    </div>
    <br>
    <?php
    require("dbhelp.php");
    $id = $_GET['inid'];
    $sql = "select * from nhanvien, bophan, chucvu, phieu, loaiphieu, giayracong where nhanvien.IDBoPhan LIKE CONCAT('%', bophan.IDBoPhan ,'%') and nhanvien.IDChucVu = chucvu.IDChucVu and giayracong.IDNhanVienRaCong=nhanvien.IDNhanVien and phieu.IDLoaiPhieu = loaiphieu.IDLoaiPhieu and phieu.IDPhieu = giayracong.IDPhieu and phieu.IDPhieu = '$id' ";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);
    $tennhanvien = $row['HoTenNhanVien'];
    $idnhanvien = $row['IDNhanVien'];
    $chucvu = $row['TenChucVu'];
    $bophan = $row['TenBoPhan'];

    $raluc =  strtotime($row['OutTime']);
    $giora = date('H', $raluc);
    $phutra = date('i', $raluc);
    $ngayra = date('d/m/Y', $raluc);
    $vaoluc = strtotime($row['InTime']);
    $giovao = date('H', $vaoluc);
    $phutvao = date('i', $vaoluc);
    $ngayvao = date('d/m/Y', $vaoluc);
    $taoluc = strtotime($row['NgayTao']);
    $giotao = date('H', $taoluc);
    $phuttao = date('i', $taoluc);
    $ngaytao = date('d', $taoluc);
    $thangtao = date('m', $taoluc);
    $namtao = date('Y', $taoluc);

    ?>
    <div id="noidung">
      <table ">
      <tr>
              <td style=" font-weight: bold;">
        <p style="margin: 3px;">Mã phiếu:</p>
        </td>
        <td><?php echo $_GET['inid']; ?> </td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Họ tên:</p>
          </td>
          <td><?php echo $row['HoTenNhanVien']; ?> </td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">MSNV: </p>
          </td>
          <td><?php echo $idnhanvien; ?></td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Phòng/Ban: </p>
          </td>
          <td><?php echo $bophan; ?></td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Chức vụ:</p>
          </td>
          <td> <?php echo $chucvu; ?></td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Biển số xe:</p>
          </td>
          <td> <?php echo $row['BSXE']; ?> </td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Lý do ra cổng:</p>
          </td>
          <td><?php echo $row['LyDo']; ?></td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Có mang theo:</p>
          </td>
          <td><?php echo $row['GhiChu']; ?></td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Ghi chú:</p>
          </td>
          <td><?php echo $row['ChuY']; ?></td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Ra lúc:</p>
          </td>
          <td><?php echo $giora ?> giờ <?php echo $phutra ?> phút, ngày <?php echo $ngayra ?></td>
        </tr>
        <tr>
          <td style="font-weight: bold;">
            <p style="margin: 3px;">Vào lại (nếu có):</p>
          </td>
          <?php if ($row['InTime'] == '0000-00-00 00:00:00.000000') { ?>
            <td>Chưa xác định</td>
          <?php } else { ?>
            <td><?php echo $giovao ?> giờ <?php echo $phutvao ?> phút, ngày <?php echo $ngayvao ?></td>
          <?php
          }
          ?>
        </tr>
      </table>
      <div style=" text-align:right;font-style: italic ">Núi Thành, Ngày <?php echo $ngaytao ?> tháng <?php echo $thangtao ?> năm <?php echo $namtao ?> </div>
      <br />

      <table style="border: none;margin: auto;">
        <tr>
          <td style="width: 20%;border: none;text-align: center;font-weight: bold;">Phê duyệt</td>
          <td style="width: 20%;border: none;text-align: center;font-weight: bold;">Xem xét</td>
        </tr>

        <tr>

          <?php

          $duyet2 = "SELECT * FROM pheduyet, caidatmau,nhanvien WHERE nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDNhanVien=caidatmau.IDNhanVien AND pheduyet.MucDuyet=2 AND pheduyet.IDPhieu='" . $_GET['inid'] . "'";
          $query2 = mysqli_query($connect, $duyet2);
          $row2 = mysqli_fetch_assoc($query2);
          $daduyet2 = $row2["DaDuyet"];
          $ngayduyet2 = $row2["NgayDuyet"];
          $ghichu2 = $row2["GhiChu"];
          $tenduyet2 = $row2["HoTenNhanVien"];
          if ($daduyet2 == '1') {
          ?>
            <img src="Images/Signed.jpg" height="100px"  alt="Signed" style="z-index: -1;position: absolute;margin-left: 80px">
            <td style="border: none;text-align: center;height:60px">ĐÃ KÝ</td>
          <?php
          } else {
          ?>
            <td style="border: none;text-align: center;height:60px"></td>
            <!-- <td style="width: 25%;border: none;text-align: center;height:60px">d<img src="Images/tickky.png" alt="HTML5 Icon" width="100" height="100"></td> -->
          <?php }
          ?>
          <?php
          $duyet1 = "SELECT * FROM pheduyet, caidatmau,nhanvien WHERE nhanvien.IDNhanVien=pheduyet.IDNhanVien AND pheduyet.IDNhanVien=caidatmau.IDNhanVien AND caidatmau.MucDuyet=1 AND pheduyet.IDPhieu='" . $_GET['inid'] . "' AND caidatmau.IDLoaiPhieu='P0003'";
          $query1 = mysqli_query($connect, $duyet1);
          $row1 = mysqli_fetch_assoc($query1);
          $daduyet1 = $row1['DaDuyet'];
          $ngayduyet1 = $row1['NgayDuyet'];
          $ghichu1 = $row1['GhiChu'];
          $tenduyet1 = $row1["HoTenNhanVien"];
          if ($daduyet1 == '1') {
          ?>
            <td style="border: none;text-align: center;height:60px">ĐÃ KÝ</td>
            <!-- <td style="width: 25%;border: none;text-align: center;height:60px">b<img src="Images/tickky.png" alt="HTML5 Icon" width="100" height="100"></td> -->
          <?php
          } else {
          ?>
            <td style="border: none;text-align: center;height:60px"></td>
            <!-- <td style="width: 25%;border: none;text-align: center;height:60px">d<img src="Images/tickky.png" alt="HTML5 Icon" width="100" height="100"></td> -->
          <?php }
          ?>
        </tr>
        <tr>
          <td style="border: none;text-align: center;font-weight: bold;"><?php echo $tenduyet2; ?></td>
          <td style="border: none;text-align: center;font-weight: bold;"><?php echo $tenduyet1; ?></td>
        </tr>
        <tr>
          <td style="border: none;text-align: center;"><?php echo $ghichu2; ?></td>
          <td style="border: none;text-align: center;"><?php echo $ghichu1; ?></td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>