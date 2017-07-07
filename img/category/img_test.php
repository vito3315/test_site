 <?
	set_time_limit(0);
 
	function imageresize($outfile,$infile,$neww,$newh,$quality) {
		$im=imagecreatefromjpeg($infile);
		$k1=$neww/imagesx($im);
		$k2=$newh/imagesy($im);
		$k=$k1>$k2?$k2:$k1;

		$w=intval(imagesx($im)*$k);
		$h=intval(imagesy($im)*$k);

		$im1=imagecreatetruecolor($w,$h);
		imagecopyresampled($im1,$im,0,0,0,0,$w,$h,imagesx($im),imagesy($im));

		imagejpeg($im1,$outfile,$quality);
		imagedestroy($im);
		imagedestroy($im1);
	}

	
	function getExtension1($filename) {
		return explode(".", $filename);
	}
   
	
	$dir    = '';
	$files1 = scandir('.');
	$a=0;
	for($i=0; $files1[$i]; $i++){
		$file_ = getExtension1($files1[$i]);
		if($file_[1] == "jpg"){
			echo $files1[$i].' -> '.$file_[0].'_tmp.'.$file_[1]."<br />";
			imageresize($file_[0].'_min.'.$file_[1], $files1[$i], 330, 200, 75);
		}	
	}
	
	//imageresize("","webcam.jpg",640,240,75);

?>