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
            C???NG H??A X?? H???I CH??? NGH??A VI???T NAM 
            <br>
            ?????c l???p - T??? do - H???nh ph??c
            <br>
            ------***------
        </th>
      </tr>
    </table>
    <br />
    
    <div class="title" style="font-weight: bold;font-size: 22px;text-align: center;">
      ????N XIN NGH??? PH??P
      <br >
      <span style="font-size: 20px;"><span style="font-style: italic;">K??nh g???i:</span> BAN GI??M ?????C</span>

    </div>
    <br>
    
    <div id="noidung">
    <table style="margin: 3px;font-size:18px;">
          <tr>
            <td><p ><span style="font-weight: bold;">T??i t??n l??: </span><?php echo $row5['HoTenNhanVien'];?></p></td>
            <td><p style="margin-left: 55px;"><span style="font-weight: bold;">MSNV: </span><?php echo $idnhanvien;?></p></td>
        </tr>
        <tr>
            <td><p ><span style="font-weight: bold;">Ph??ng/Ban:</span> <?php echo $bophan;?></p></td>
            <td><p style="margin-left: 55px;"><span style="font-weight: bold;">Ch???c v???:</span> <?php echo $chucvu;?></p></td>
        </tr>
    </table>
    <p style="margin: 3px;">Nay t??i vi???t ????n n??y k??nh tr??nh Ban gi??m ?????c cho t??i ???????c <span style="font-weight: bold;">ngh??? ph??p:</span></p>
    <p style="margin: 3px;">T??? <?php echo $gionghi?> gi??? <?php echo $phutnghi?> ph??t, ng??y <?php echo $ngaynghi?> ?????n <?php echo $dengio?> gi??? <?php echo $phutnghi?> ph??t, ng??y <?php echo $denngay?></p>
    <p style="margin: 3px;"><span style="font-weight: bold;">L?? do:</span> <?php echo $lydo?></p>
    <p style="margin: 3px;">T??i ???? b??n giao c??ng vi???c trong th???i gian ngh??? ph??p l???i cho <span style="font-weight: bold;">??ng (b??): <?php echo $nhansubangiao?></span></p>
    <p style="margin: 3px;"><span style="font-weight: bold;">??ng (B??): <?php echo $nhansubangiao?> </span>s??? thay th??? t??i ho??n th??nh t???t nhi???m v??? ???????c giao theo quy ?????nh.</p>
    <p style="margin: 3px;">K??nh tr??nh Ban gi??m ?????c xem x??t ph?? duy???t.</p>
    <p style="margin: 3px;">Tr??n tr???ng!</p>
    <div style=" text-align:right; font-style:italic">N??i Th??nh, Ng??y <?php echo $ngay ?> th??ng <?php echo $thang ?> n??m <?php echo $nam ?>  </div>
        <br>
      <table style="border: none;margin: auto;width:900px;font-size:18px;">
        <tr>
          <td style="width: 20%;border: none;text-align: center;font-weight: bold;">Ph?? duy???t</td>
          <td style="width: 20%;border: none;text-align: center;font-weight: bold;">Xem x??t</td>
          <td style="width: 20%;border: none;text-align: center;font-weight: bold;">Ng?????i l???p</td>
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
            <td style="border: none;text-align: center;height:60px">???? K??</td>
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
            <td style="border: none;text-align: center;height:60px">???? K??</td>
            <!-- <td style="width: 25%;border: none;text-align: center;height:60px">b<img src="Images/tickky.png" alt="HTML5 Icon" width="100" height="100"></td> -->
          <?php
          } else {
          ?>
            <td style="border: none;text-align: center;height:60px"></td>
            <!-- <td style="width: 25%;border: none;text-align: center;height:60px">d<img src="Images/tickky.png" alt="HTML5 Icon" width="100" height="100"></td> -->
          <?php }
          ?>
          <td style="width: 25%;border: none;text-align: center;height:60px">???? K??</td>
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
    <input type="button" id="inphieu" onclick="printform()" class="btn btn-primary" style="width: 100px;" value="In phi???u"></input>
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