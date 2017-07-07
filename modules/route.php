<?php

	include('class.php'); 
	$site = new site();
	
	if(method_exists($site, $_POST['type'])){
		echo $site->$_POST['type']($_POST);
	}else{
		echo 'false';
	}

?>