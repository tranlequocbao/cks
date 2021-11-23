<?php
// ini_set('display_errors', 0);
// error_reporting(E_ERROR | E_WARNING | E_PARSE); 
require_once '../vendor/PhpExcel/PhpExcel/Classes/PHPExcel.php';
if(!($_FILES['file']['name'])){
    echo "<script>alert('Vui lòng chọn file Excel');</script>";
    return;
}
else{
    $file_='../vendor/Excel/'.$_FILES['file']['name'];
    //upfile lên server
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        move_uploaded_file($_FILES['file']['tmp_name'], '../vendor/Excel/' . $_FILES['file']['name']);
    }
    
    
    
    
    
    //Tiến hành xác thực file
    $objFile = PHPExcel_IOFactory::identify($file_);
    $objData = PHPExcel_IOFactory::createReader($objFile);
    $r = PHPExcel_CachedObjectStorageFactory::initialize(PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp);
    if (!$r) {
        die('Unable to set cell cacheing');
    }
    //Chỉ đọc dữ liệu
    $objData->setReadDataOnly(true);
    
    // Load dữ liệu sang dạng đối tượng
    $objPHPExcel = $objData->load($file_);
    
    //Lấy ra số trang sử dụng phương thức getSheetCount();
    // Lấy Ra tên trang sử dụng getSheetNames();
    
    //Chọn trang cần truy xuất
    $sheet = $objPHPExcel->setActiveSheetIndex(0);
    
    //Lấy ra số dòng cuối cùng
    $Totalrow = $sheet->getHighestRow();
    //Lấy ra tên cột cuối cùng
    $LastColumn = $sheet->getHighestColumn();
    
    //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3,D là 4
    $TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);
    
    //Tạo mảng chứa dữ liệu
    $data = [];$stt=1;$html='';
    
    //Tiến hành lặp qua từng ô dữ liệu
    //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
    for ($i = 9; $i <= $Totalrow; $i++) {
        
        //----Lặp cột
        
      if($sheet->getCellByColumnAndRow(0, $i)->getCalculatedValue()!=""){
        ?>
                <tr>
                    <th id="<?=$stt?>" scope="row"><?=$sheet->getCellByColumnAndRow(0, $i)->getCalculatedValue();?></th>
                    <td id="name"><?=$sheet->getCellByColumnAndRow(1, $i)->getCalculatedValue();?></td>
                    <td id="msnv"><?=$sheet->getCellByColumnAndRow(2, $i)->getCalculatedValue();?></td>
                    <td id="chucvu"><?=$sheet->getCellByColumnAndRow(3, $i)->getCalculatedValue();?></td>
                    <td id="noidung"><?=$sheet->getCellByColumnAndRow(4, $i)->getCalculatedValue();?></td>
                    <td id="18h30"><?=$sheet->getCellByColumnAndRow(5, $i)->getCalculatedValue();?></td>
                    <td id="20h45"><?=$sheet->getCellByColumnAndRow(6, $i)->getCalculatedValue();?></td>
                    <td id="22h15"><?=$sheet->getCellByColumnAndRow(7, $i)->getCalculatedValue();?></td>
                    <td id="24h00"><?=$sheet->getCellByColumnAndRow(8, $i)->getCalculatedValue();?></td>
                    <td id="7h00"><?=$sheet->getCellByColumnAndRow(9, $i)->getCalculatedValue();?></td>
                    <td id="diadiem"><?=$sheet->getCellByColumnAndRow(10, $i)->getCalculatedValue();?></td>
                    <td id="monan"><?=$sheet->getCellByColumnAndRow(11, $i)->getCalculatedValue();?></td>
                    <td id="ghichu"><?=$sheet->getCellByColumnAndRow(12, $i)->getCalculatedValue();?></td>

                </tr>
                
        <?php }
    
        // for ($j = 0; $j < $TotalCol; $j++) {
        //     // Tiến hành lấy giá trị của từng ô đổ vào mảng
        //     $result1= $sheet->getCellByColumnAndRow($j, $i)->getCalculatedValue();
         
        
        // }
       $stt++;
    }
    
}


