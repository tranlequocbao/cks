<html>
<style type="text/css" media="print">
      @media print
      {
         @page {
           margin-top: 0;
           margin-bottom: 0;
         }
         body  {
           padding-top: 72px;
           padding-bottom: 72px ;
         }
      } 
</style>
<?php 
   require("dbhelp.php");
   $id=$_GET['inid'];
   $sql = "select * from nhanvien, bophan, chucvu, phieu, loaiphieu, giayxinphep where nhanvien.IDBoPhan = bophan.IDBoPhan and nhanvien.IDChucVu = chucvu.IDChucVu and phieu.IDNhanVien = nhanvien.IDNhanVien and phieu.IDLoaiPhieu = loaiphieu.IDLoaiPhieu and phieu.IDPhieu = giayxinphep.IDPhieu and phieu.IDPhieu = '$id' ";
        $result = mysqli_query($connect,$sql);
        $row = mysqli_fetch_array($result);
        $tennhanvien = $row['HoTenNhanVien'];
        $idnhanvien = $row['IDNhanVien'];
        $chucvu = $row['TenChucVu'];
        $bophan = $row['TenBoPhan'];
        $nghitu =  strtotime($row['InTime']);
        $gionghi = date('H',$nghitu);
        $phutnghi = date('i', $nghitu);
        $giophutnghi = date('H:i',$nghitu);
        $ngaynghi = date('d/m/Y', $nghitu);
        $nghiden = strtotime($row['OutTime']);
        $dengio = date('H', $nghiden);
        $denphut = date('i', $nghiden); 
        $dengiophut = date('H:i', $nghiden);
        $denngay = date('d/m/Y', $nghiden);
        $lydo  = $row['LyDo']; 
        $nhansubangiao = $row['NhanVienThayThe']; 
        $ngaytao = strtotime($row['NgayTao']);
        $ngay = date('d', $ngaytao);
        $thang = date('m', $ngaytao);
        $nam = date('Y', $ngaytao);
        $ngaythangnam = date('d/m/Y', $ngaytao);
        $ghichu = $row['Note'];
        $sql4 = "SELECT * FROM nhanvien, phieu where nhanvien.IDNhanVien = phieu.IDNhanVien and phieu.IDPhieu = '$id'" ;
        $result4 = mysqli_query($connect,$sql4);
        $row4 = mysqli_fetch_array($result4);
        $sql5 = "SELECT * FROM giayxinphep , nhanvien WHERE nhanvien.IDNhanVien = giayxinphep.NhanVienNghi and giayxinphep.IDPhieu = '$id'";
        $result5 = mysqli_query($connect, $sql5);
        $row5 = mysqli_fetch_array($result5);
 
  ?>
<head>
  <meta charset="utf-8" />
  <title> </title>
  <link rel="stylesheet" href="Style/bootstrap.min.css">
</head>

<body >
  <div style="width: 900px; height: auto; margin-left:auto;margin-right:auto;font-size:18px;">
    <table id="header">
      <tr>
        <th style="text-align: left; width:40%;">
          <img src="Images/LOGO.jpg" alt="Thaco Auto" style=" width: 160px;height: 40px;margin-top: -34px;" />
        </th>
        
        <th style="text-align: center; width: 45%; margin-left: 30%;font-size:18px;">
            CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM 
            <br>
            Độc lập - Tự do - Hạnh phúc
            <br>
            ------***------
        </th>
      </tr>
    </table>
    <br />
    
    <div class="title" style="font-weight: bold;font-size: 22px;text-align: center;">
      ĐƠN XIN NGHỈ PHÉP
      <br >
      <span style="font-size: 20px;"><span style="font-style: italic;">Kính gửi:</span> BAN GIÁM ĐỐC</span>

    </div>
    <br>
    
    <div id="noidung">
    <table style="margin: 3px;font-size:18px;">
          <tr>
            <td><p ><span style="font-weight: bold;">Tôi tên là: </span><?php echo $row5['HoTenNhanVien'];?></p></td>
            <td><p style="margin-left: 55px;"><span style="font-weight: bold;">MSNV: </span><?php echo $idnhanvien;?></p></td>
        </tr>
        <tr>
            <td><p ><span style="font-weight: bold;">Phòng/Ban:</span> <?php echo $bophan;?></p></td>
            <td><p style="margin-left: 55px;"><span style="font-weight: bold;">Chức vụ:</span> <?php echo $chucvu;?></p></td>
        </tr>
    </table>
    <p style="margin: 3px;">Nay tôi viết đơn này kính trình Ban giám đốc cho tôi được <span style="font-weight: bold;">nghỉ phép:</span></p>
    <p style="margin: 3px;">Từ <?php echo $gionghi?> giờ <?php echo $phutnghi?> phút, ngày <?php echo $ngaynghi?> đến <?php echo $dengio?> giờ <?php echo $phutnghi?> phút, ngày <?php echo $denngay?></p>
    <p style="margin: 3px;"><span style="font-weight: bold;">Lý do:</span> <?php echo $lydo?></p>
    <p style="margin: 3px;">Tôi đã bàn giao công việc trong thời gian nghỉ phép lại cho <span style="font-weight: bold;">ông (bà): <?php echo $nhansubangiao?></span></p>
    <p style="margin: 3px;"><span style="font-weight: bold;">Ông (Bà): <?php echo $nhansubangiao?> </span>sẽ thay thế tôi hoàn thành tốt nhiệm vụ được giao theo quy định.</p>
    <p style="margin: 3px;">Kính trình Ban giám đốc xem xét phê duyệt.</p>
    <p style="margin: 3px;">Trân trọng!</p>
    <div style=" text-align:right; font-style:italic">Núi Thành, Ngày <?php echo $ngay ?> tháng <?php echo $thang ?> năm <?php echo $nam ?>  </div>
        <br>
      <table style="border: none;margin: auto;width:900px;font-size:18px;">
        <tr>
          <td style="width: 20%;border: none;text-align: center;font-weight: bold;">Phê duyệt</td>
          <td style="width: 20%;border: none;text-align: center;font-weight: bold;">Xem xét</td>
          <td style="width: 20%;border: none;text-align: center;font-weight: bold;">Người lập</td>
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
          <img src="Images/Signed.jpg" height="100px"  alt="Signed" style="z-index: -1;position: absolute;margin-left: 25px">
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
          <td style="width: 25%;border: none;text-align: center;height:60px">ĐÃ KÝ</td>
        </tr>
        <tr>
      <td style="border: none;text-align: center;"><?php echo $row2['HoTenNhanVien'];?></td>
      <td style="border: none;text-align: center;"><?php echo $row1['HoTenNhanVien'];?></td>
      <td style="border: none;text-align: center;"><?php echo $row4['HoTenNhanVien'];?></td>
    </tr>
    <tr>
      <td style="border: none;text-align: center;"><?php echo $ghichu2; ?></td>
      <td style="border: none;text-align: center;"><?php echo $ghichu1; ?></td>
      <td style="border: none;text-align: center;"><?php echo $ghichu; ?></td>
    </tr>
      </table>
      </div>
</div>
<DIV style="text-align: center;">
    <input type="button" id="inphieu" onclick="printform()" class="btn btn-primary" style="width: 100px;" value="In phiếu"></input>
  </DIV>
</body>
<script>
  function printform()
  {
    document.getElementById("inphieu").style.display = 'none';
    window.print();
    window.location = 'DNP.php?p=DNP&id=<?php echo $_GET['inid']?>';
  }
</script>
</html>