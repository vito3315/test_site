<?php

	include('../php/class.php');
	$site = new site();
	
	$data['content'] = 'content.php';

	include('../../template.php');

	//$j = file_get_contents( '../../../content/config.json' ); // в примере все файлы в корне
	//$data = json_decode($j);   
	
	/*foreach($data as $item){
		echo $item->name."<br />";
	}*/
	
	//var_dump($data->index->name);
?>