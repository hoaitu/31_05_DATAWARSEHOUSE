<?php

require('connect/db_connect.php');
require('Classes/PHPExcel.php');
require('Classes/PHPExcel/IOFactory.php');


if(isset($_POST['btnGui'])){
	$file = $_FILES['file']['tmp_name'];
	echo $file;

	$objReader = PHPExcel_IOFactory::createReaderForFile($file);
	$objReader->setLoadSheetsOnly('A1');


	$objExcel = $objReader->load($file);
	$sheetData = $objExcel->getActiveSheet()->toArray('null',true,true,true);
	print_r($sheetData);
	// 
	$highestRow = $objExcel->setActiveSheetIndex()->getHighestRow();
	// echo $highestRow; 
	// dong 1 : la tên côt
	for($row = 2; $row<=$highestRow; $row++){
	
		$full_name = $sheetData[$row]['A'];
		$day_bord = $sheetData[$row]['B'];
		$gender = $sheetData[$row]['C'];
		$gmail = $sheetData[$row]['D'];

		$sql = "INSERT INTO loadex(full_name,day_bord,gender,gmail) VALUES ('$full_name','$day_bord','$gender','$gmail')";
		$mysqli->query($sql);
		
	}
	if ($mysqli !== NULL){
		header('Location: result.php');

	}else {
		header('Location: result.php') ; exit();
	}

	

}



?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Import data to database</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<form method="POST" enctype="multipart/form-data">
		<input type="file" name="file">
		<button type="submit" name="btnGui">Import</button>
	</form>
</body>
</html>