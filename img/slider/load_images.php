<?php

	$ds = DIRECTORY_SEPARATOR;  //1
	$storeFolder = './';   //2
	//$storeFolder = '../../image_test/';	
	if (!empty($_FILES)) {
		$tempFile = $_FILES['file']['tmp_name'];          //3             
		$targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds. 'tmp_images' . $ds;  //4
		$targetFile =  $targetPath. $_FILES['file']['name'];  //5
		move_uploaded_file($tempFile,$targetFile); //6
		
		//imageresize($storeFolder.$_POST['name_min'], $targetFile, 40, 75);
		imageresize($storeFolder.$_POST['name'], $targetFile, 90, 75);
	}
 

	function imageresize($outfile,$infile,$percents,$quality) {
		$im=imagecreatefromjpeg($infile);
		$w=imagesx($im)*$percents/100;
		$h=imagesy($im)*$percents/100;
		$im1=imagecreatetruecolor($w,$h);
		imagecopyresampled($im1,$im,0,0,0,0,$w,$h,imagesx($im),imagesy($im));

		imagejpeg($im1,$outfile,$quality);
		imagedestroy($im);
		imagedestroy($im1);
	}
 

?>