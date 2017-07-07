<?php

	function myscandir($dir, $sort=0){
		$list = scandir($dir, $sort);
		if(!$list) return false;
		if($sort == 0){
			unset($list[0],$list[1]);
		}else{
			unset($list[count($list)-1], $list[count($list)-1]);
		}	
		return $list;
	}

	$dir_ = './';
	$files_ = myscandir($dir_);

	foreach($files_ as $file){	
		$tmp_name = $file;
		$new_name = 'tmp/'.pathinfo($file)['filename'];//без расширения
		$resolution_width = '250';
		$resolution_height = '175';
		$max_size = '3';
		$message = images_size($tmp_name, $new_name, $resolution_width, $resolution_height, $max_size);
	}	
		
	$dir = './tmp/';
	$files = myscandir($dir);

	$i=0;
			
	foreach($files as $file){	
		$file_name = $file;
		$path = 'tmp/'.$file;
		if(pathinfo($path)['extension']){
			$source_src = $path; 
			$params = getimagesize($source_src);
			switch ( $params[2] ){
				case 1: $source = imagecreatefromgif($source_src); break;
				case 2: $source = imagecreatefromjpeg($source_src); break;
				case 3: $source = imagecreatefrompng($source_src); break;
			}
			$max_size = 230;
			if ( $params[0]>$max_size || $params[1]>$max_size ) {
				if ( $params[0]>$params[1] ){
					$size = $params[0]; # ширина
				}else{
					$size = $params[1]; # высота
				}	
				
				$resource_width = floor($params[0] * $max_size / $size);
				$resource_height = floor($params[1] * $max_size / $size);
			 
				$resource = imagecreatetruecolor($resource_width, $resource_height); // создание «подкладки»
				imagecopyresampled($resource, $source, 0, 0, 0, 0,$resource_width, $resource_height, $params[0], $params[1]);
			}else{
				$resource = $source;
			}	
			 
			$resource_src = 'items_min/'.$file_name;
			imagejpeg($resource, $resource_src);
		}
	}

	function images_size($tmp_name, $new_name, $resolution_width, $resolution_height, $max_size){
		$image_size = filesize($tmp_name);
		$image_size = floor($image_size / '1048576') ;
		if($image_size <= $max_size) {
			$params = getimagesize($tmp_name) ;
			if($params['0'] > $resolution_width || $params['1'] > $resolution_height) {
				switch ($params['2']) {
					case 1: $old_img = imagecreatefromgif($tmp_name); break;
					case 2: $old_img = imagecreatefromjpeg($tmp_name); break;
					case 3: $old_img = imagecreatefrompng($tmp_name); break;
					case 6: $old_img = imagecreatefromwbmp($tmp_name); break;
				}
				//вычисляем новые размеры
				if($params['0'] > $params['1']) {
					$size = $params['0'] ;
					$resolution = $resolution_width;
				}
				else {
					$size = $params['1'] ;
					$resolution = $resolution_height;
				}
				$new_width = floor($params['0'] * $resolution / $size) ;
				$new_height = floor($params['1'] * $resolution / $size) ;
				//создаём новое изображение
				$new_img = imagecreatetruecolor($new_width, $new_height) ;
				imagecopyresampled ($new_img, $old_img, 0, 0, 0, 0, $new_width, $new_height, $params['0'], $params['1']) ;

				switch ($params['2']) {
					case 1: $type = '.gif'; break;
					case 2: $type = '.jpg'; break;
					case 3: $type = '.png'; break;
					case 6: $type = '.bmp'; break;
				}
				//Сохраняем
				$new_name = "$new_name$type" ;
				switch ($type) {
					case '.gif': imagegif($new_img, $new_name); break;
					case '.jpg': imagejpeg($new_img, $new_name, 100); break;
					case '.bmp': imagejpeg($new_img, $new_name, 100); break;
					case '.png': imagepng($new_img, $new_name); break;
				}
				$message = ('<font class="message">Изображение добавлено</font><br>') ;
				imagedestroy($old_img);
			}else {
				switch ($params['2']) {
					case 1: $type = '.gif'; break;
					case 2: $type = '.jpg'; break;
					case 3: $type = '.png'; break;
					case 6: $type = '.bmp'; break;
				}
				//Сохраняем
				$new_name = "$new_name$type" ;
				copy($tmp_name, $new_name);
				$message = ('<font class="message">Изображение добавлено</font><br>') ;
			}
		}
		else $errors = ('<font class="error">Слишком большой размер</font><br>') ;
		
		return($message);
		return($errors);
	}

	var_dump('end');

?>