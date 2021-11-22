<?php
$link = '| <a href="http://papermashup.com/easy-php-pagination/">Back To Tutorial</a>';
include('dbhelp.php');
session_start();
if (!isset($_SESSION["IDNhanVien"])) {
    header('Location: Dangnhap.php');
}
$ID = $_SESSION["IDNhanVien"];
$IDbophan = $_SESSION["IDBoPhan"];
$sql5 = "SELECT * FROM `nhanvien` WHERE IDNhanVien='$ID' ";
$query5 = mysqli_query($connect, $sql5);
$row5 = mysqli_fetch_array($query5);

$tableName = "phieu";
$targetpage = "Tatca.php";
$limit = 10;
$stages = 3;
$page = mysqli_real_escape_string($connect, $_GET['page']);
if ($page) {
    $start = ($page - 1) * $limit;
} else {
    $start = 0;
}
// Get page data
if ($row5['IDNhomQuyen'] == 02 ) {
    $query1 = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat FROM phieu,nhanvien,loaiphieu,pheduyet WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu and nhanvien.IDNhanVien='$ID' order by NgayTao desc LIMIT $start, $limit";
    $query = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat FROM phieu,nhanvien,loaiphieu,pheduyet WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu  and nhanvien.IDNhanVien='$ID' order by NgayTao desc";
}elseif ($row5['IDNhomQuyen'] == 04) {
    $query1 = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat FROM phieu,nhanvien,loaiphieu,pheduyet WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu  and (loaiphieu.IDLoaiPhieu='P0001' or loaiphieu.IDLoaiPhieu='P0003')  order by NgayTao desc LIMIT $start, $limit";
    $query = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat FROM phieu,nhanvien,loaiphieu,pheduyet WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu  and (loaiphieu.IDLoaiPhieu='P0001' or loaiphieu.IDLoaiPhieu='P0003') order by NgayTao desc";
} 
 elseif ($row5['IDNhomQuyen'] == 01) {
    $query1 = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat FROM phieu,nhanvien,loaiphieu,pheduyet WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu and phieu.IDPhieu=pheduyet.IDPhieu and ( nhanvien.IDBoPhan='$IDbophan' or (nhanvien.IDBoPhan !='$IDbophan' AND pheduyet.IDNhanVien='$ID' )) order by NgayTao desc  LIMIT $start, $limit";
    $query = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat FROM phieu,nhanvien,loaiphieu,pheduyet WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu and phieu.IDPhieu=pheduyet.IDPhieu and ( nhanvien.IDBoPhan='$IDbophan' or (nhanvien.IDBoPhan !='$IDbophan' AND pheduyet.IDNhanVien='$ID' )) order by NgayTao desc ";
} elseif ($row5['IDNhomQuyen'] == 03) {
    $query1 = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat FROM phieu,nhanvien,loaiphieu,pheduyet WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu  order by NgayTao desc LIMIT $start, $limit";
    $query = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat FROM phieu,nhanvien,loaiphieu,pheduyet WHERE phieu.IDNhanVien=nhanvien.IDNhanVien and phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu order by NgayTao desc";
}
$result = mysqli_query($connect, $query1);
$result1 = mysqli_query($connect, $query);
$total_pages = mysqli_num_rows($result1);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title>Phần mềm chữ ký số Thaco Mazda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Style/hopthu.css" rel="stylesheet" />
    <link href="Style/StypeIndex.css" rel="stylesheet" />
    <link href="Style/display.css" rel="stylesheet" />
    <link rel="stylesheet" href="Style/bootstrap.min.css">

    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.2.1.min.js"></script>
</head>

<body>
    <?php
    require "display/header.php";
    ?>

    <div id="content">
        <div id="left">
            <div id="danhmuchoso">DANH MỤC HỒ SƠ</div>
            <div id="menu2">
                <ul>
                    <li><a href="Tatca.php?page=1"> TẤT CẢ</a></li>
                    <li><a href="Dangduyet.php?page=1"> ĐANG DUYỆT</a></li>
                    <li><a href="Daduyet.php?page=1"> ĐÃ DUYỆT</a></li>
                    <li><a href="Tuchoi.php?page=1"> ĐÃ TỪ CHỐI</a></li>
                    <?php if (defined("admin") or defined("quanly")) { ?>
                        <li><a href="Canduyet.php?page=1"> CẦN DUYỆT</a></li>
                        <?php } ?>
                </ul>
            </div>
        </div>
        <div id="right">
            <div class="hopthu1">
                

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h6 class="card-title" style="font-weight: bold;">TẤT CẢ HỒ SƠ</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <tr style="color: #00529C;">
                                            <th>
                                                MÃ PHIẾU
                                            </th>
                                            <th>
                                                NGƯỜI TẠO
                                            </th>
                                            <th>
                                                LOẠI PHIẾU
                                            </th>
                                            <th>
                                                THỜI GIAN TẠO
                                            </th>
                                            <th>
                                                TRẠNG THÁI
                                            </th>
                                    </thead>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        $idphieu = $row['IDPhieu'];
                                        // kiểm tra trạng thái

                                        $sql6 = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat, pheduyet.DaDuyet 
        FROM phieu,nhanvien,loaiphieu,pheduyet,caidatmau 
        WHERE phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu 
        and phieu.IDPhieu=pheduyet.IDPhieu
        and phieu.IDPhieu='$idphieu' 
        and phieu.IDLoaiPhieu=caidatmau.IDLoaiPhieu 
        and phieu.IDNhanVien=nhanvien.IDNhanVien
        and pheduyet.IDNhanVien='$ID' 
        and pheduyet.DaDuyet='0'
        and phieu.TuChoi='0'
        and phieu.IDPhieu not in (SELECT DISTINCT phieu.IDPhieu
      FROM phieu,nhanvien,loaiphieu,pheduyet,caidatmau 
      WHERE phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu 
    and phieu.IDPhieu=pheduyet.IDPhieu 
    and phieu.IDLoaiPhieu=caidatmau.IDLoaiPhieu 
    and phieu.IDNhanVien=nhanvien.IDNhanVien
    and caidatmau.IDNhanVien='$ID'
    and pheduyet.MucDuyet=caidatmau.MucDuyet-1
      and pheduyet.DaDuyet='0'
      and phieu.TuChoi='0'
      and phieu.IDPhieu not in (SELECT pheduyet.IDPhieu FROM `pheduyet` where IDNhanVien='$ID' and MucDuyet='1' ))";
                                        $query6 = mysqli_query($connect, $sql6);
                                        $trangthai = "";
                                        $mau = "";
                                        if (mysqli_num_rows($query6) != 0) {
                                            $trangthai = 'CẦN DUYỆT';
                                            $mau = 'green';
                                        } else {
                                            $sql7 = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat,caidatmau.IDNhanVien, pheduyet.DaDuyet 
                from phieu,nhanvien,loaiphieu,pheduyet,caidatmau 
                WHERE phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu 
                and phieu.IDPhieu=pheduyet.IDPhieu
                and phieu.IDPhieu='$idphieu' 
                and phieu.IDLoaiPhieu=caidatmau.IDLoaiPhieu 
                and phieu.IDNhanVien=nhanvien.IDNhanVien
                and pheduyet.IDNhanVien= caidatmau.IDNhanVien
                and caidatmau.MucDuyet=loaiphieu.SoMucDuyet 
                and pheduyet.DaDuyet='1'";
                                            $query7 = mysqli_query($connect, $sql7);
                                            $trangthai = "";
                                            if (mysqli_num_rows($query7) != 0) {
                                                $trangthai = 'ĐÃ DUYỆT';
                                                $mau = 'blue';
                                            } else {
                                                $sql8 = "SELECT DISTINCT phieu.IDPhieu,nhanvien.HoTenNhanVien,loaiphieu.TenLoaiPhieu,phieu.NgayTao,loaiphieu.VietTat,caidatmau.IDNhanVien, pheduyet.DaDuyet 
                    from phieu,nhanvien,loaiphieu,pheduyet,caidatmau 
                    WHERE phieu.IDLoaiPhieu=loaiphieu.IDLoaiPhieu 
                    and phieu.IDPhieu=pheduyet.IDPhieu
                    and phieu.IDPhieu='$idphieu' 
                    and phieu.IDLoaiPhieu=caidatmau.IDLoaiPhieu 
                    and phieu.IDNhanVien=nhanvien.IDNhanVien
                    and caidatmau.MucDuyet=loaiphieu.SoMucDuyet 
                    and pheduyet.DaDuyet='0'
                    and phieu.TuChoi=1";
                                                $query8 = mysqli_query($connect, $sql8);
                                                $trangthai = "";
                                                if (mysqli_num_rows($query8) != 0) {
                                                    $trangthai = 'TỪ CHỐI';
                                                    $mau = 'red';
                                                } else {
                                                    $trangthai = 'ĐANG DUYỆT';
                                                    $mau = 'yellow';
                                                }
                                            }
                                        }


                                    ?>
                                        <tbody id="table_han">
                                            <tr>
                                                <td><a style="text-decoration:none"><?php echo $row['IDPhieu']; ?></a></td>
                                                <td><?php echo $row['HoTenNhanVien'];  ?></td>
                                                <td><?php echo $row['TenLoaiPhieu']; ?></td>
                                                <td><?php echo $row['NgayTao']; ?></td>
                                                <td style="color:<?php echo $mau ?> ">
                                                    <?php echo $trangthai; ?>
                                                </td>
                                                <td>
                                                <td><a href="<?php echo $row['VietTat']; ?>.php?p=<?php echo $row['VietTat']; ?>&id=<?php echo $row['IDPhieu']; ?>" target="_blank">
                                                        <button target='_blank' href='showphieu.php' class="btn btn-dangerr">XEM CHI TIẾT</button></td>
                                                </a>
                                            <?php } ?>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- phân trang -->
                <?php
                // Initial page num setup
                if ($page == 0) {
                    $page = 1;
                }
                $prev = $page - 1;
                $next = $page + 1;
                $lastpage = ceil($total_pages / $limit);
                $LastPagem1 = $lastpage - 1;

                $paginate = '';
                if ($lastpage > 1) {
                    $paginate .= "<div class='paginate' style='text-align: center;'>";
                    // Previous
                    if ($page > 1) {
                        $paginate .= "<a href='Tatca.php?page=$prev'>Trang trước</a>";
                    } else {
                        $paginate .= "<span class='disabled'>Trang trước</span>";
                    }
                    // Pages	
                    if ($lastpage < 7 + ($stages * 2))    // Not enough pages to breaking it up
                    {
                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                            if ($counter == $page) {
                                $paginate .= "<span class='current'>$counter</span>";
                            } else {
                                $paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
                            }
                        }
                    } elseif ($lastpage > 5 + ($stages * 2))    // Enough pages to hide a few?
                    {
                        // Beginning only hide later pages
                        if ($page < 1 + ($stages * 2)) {
                            for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                                if ($counter == $page) {
                                    $paginate .= "<span class='current'>$counter</span>";
                                } else {
                                    $paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
                                }
                            }
                            $paginate .= "...";
                            $paginate .= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
                            $paginate .= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
                        }
                        // Middle hide some front and some back
                        elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
                            $paginate .= "<a href='$targetpage?page=1'>1</a>";
                            $paginate .= "<a href='$targetpage?page=2'>2</a>";
                            $paginate .= "...";
                            for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                                if ($counter == $page) {
                                    $paginate .= "<span class='current'>$counter</span>";
                                } else {
                                    $paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
                                }
                            }
                            $paginate .= "...";
                            $paginate .= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
                            $paginate .= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";
                        }
                        // End only hide early pages
                        else {
                            $paginate .= "<a href='$targetpage?page=1'>1</a>";
                            $paginate .= "<a href='$targetpage?page=2'>2</a>";
                            $paginate .= "...";
                            for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                                if ($counter == $page) {
                                    $paginate .= "<span class='current'>$counter</span>";
                                } else {
                                    $paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
                                }
                            }
                        }
                    }
                    // Next
                    if ($page < $counter - 1) {
                        $paginate .= "<a href='$targetpage?page=$next'>Trang sau</a>";
                    } else {
                        $paginate .= "<span class='disabled'>Trang sau</span>";
                    }
                    $paginate .= "</div>";
                }
                // pagination
                echo $paginate;
                ?>
            </div>
        </div>
    </div>
    <?php
    require "display/footer.php";
    ?>
    