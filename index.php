<?php
	ob_start();
	error_reporting(-1);
	
	// заголовки кеша
	header('Content-type: img/png/js/css/font/gif/script');
	header('Pragma: cache');
	header('Cache-Control: private, max-age=86400, must-revalidate');
	header('Content-Type: text/html; charset=utf-8');
	
	// подключаем классы
	include_once('modules/class.php');
	include_once('modules/mobile_detect/Mobile_Detect.php');
	$site = new site();
	$detect = new Mobile_Detect;
		
	$data['full_uri'] = $site->get_full_uri();	
	$data['uri'] = $site->get_uri();
	
	//var_dump($data['uri']);
	//die();
	
	//редирект со старых адресов на новые
	include_once('modules/redir.php');	
		
	//редирект со слэшами в конце адреса
	if($data['uri'][0] == 'item'){
		$pos = strpos($data['full_uri'], '?/');
		if ($pos === false) {
		} else {
			$data['full_uri'] = str_replace('?/', '', $data['full_uri']);
			$addr = $site->addr.$data['full_uri'];
			header("location: $addr", true, 301);
			exit();
		}
		
		if($data['full_uri'][strlen($data['full_uri'])-1] == '/'){
			$addr = $site->addr.'/'.$data['uri'][0].'/'.$data['uri'][1];
			header("location: $addr", true, 301);
			exit();
		}
	}else{
		if($data['full_uri'][strlen($data['full_uri'])-1] != '/'){
			$addr = $data['full_uri'].'/';
			header("location: $addr", true, 301);
			exit();
		}
	}
	
	// находим текущую страницу
	$data['this_page'] = $site->get_();
	
	//определяем платформу
	$data['type_pc'] = 'pc';
	$data['type_pc_с'] = 6;

	// определяем планшет
	if( $detect->isTablet() && $detect->isMobile()){
		$data['type_pc'] = 'tablet';
		$data['type_pc_с'] = 4;
	}
	
	// определяем телефон
	if( $detect->isMobile() && !$detect->isTablet() ){
		$data['type_pc'] = 'mobile';
		$data['type_pc_с'] = 3;
	}
	
	//список основных категорий
	if(empty($data['menu_catalog'] = $site->cash('menu_catalog'))){
		$data['menu_catalog'] = $site->cash('menu_catalog', $site->get_pages_from_category(0));
	}
	
	//формируем хлебные крошки
	if($data['type_pc'] != 'mobile'){
		if(empty($data['breadcrumbs']  = $site->cash($data['full_uri'].'_breadcrumbs_'))){
			$data['breadcrumbs']  = $site->cash($data['full_uri'].'_breadcrumbs_', $site->get_breadcrumb());
		}
	}	
	
	if($data['uri'][0] == 'novosti'){
		if(!empty($data['uri'][1])){//конкретная новость
			if(empty($data['item'] = $site->cash('news__'.$data['uri'][1]))){
				$data['item'] = $site->cash('news__'.$data['uri'][1], $site->get_one('news', $data['uri'][1], 'alias'));
			}
			
			if(empty($data['item'])){
				$data['this_page'] = $site->r_404();
			}else{
				$data['this_page']['h1'] = $data['item']['h1'];
				$data['this_page']['title'] = $data['item']['title'];
				$data['this_page']['description'] = $data['item']['description'];
			}
		}
	}
	
	if($data['uri'][0] == 'item'){
		$data['id'] = $data['uri'][1];
		if(empty($data['this_item'] = $site->cash('this_item_'.$data['id'].'_'.$data['type_pc']))){
			$data['this_item'] = $site->cash('this_item_'.$data['id'].'_'.$data['type_pc'], $site->get_item($data['id'], $data['type_pc_с']+1));
		}
		
		if($data['this_item']['item']['date_update'] == '0000-00-00 00:00:00'){
			$site->r_304($data['this_item']['item']['date_insert']);
		}else{
			$site->r_304($data['this_item']['item']['date_update']);
		}
		
		$data['this_page']['title'] = $data['this_item']['item']['name'];
		
		$data['tmp'] = '';
		
		if(empty($data['this_item']['item']['param_1'])){
			$data['this_page']['description'] = 'Купить '.$data['this_item']['item']['name'];
		}else{
			$data['tmp'] .= 'арт.: '.$data['this_item']['item']['art'].' ';
			foreach($data['this_item']['item']['param_1'] as $param){
				$data['tmp'] .= $param['name'].': '.$param['value'].' ';
			}
			$data['this_page']['description'] = $data['tmp'];
		}
		
		if($data['this_item']['alias'] == '404'){
			$data['this_page'] = $site->r_404();
		}
		
		if($data['type_pc'] != 'mobile'){
			$data['breadcrumbs'] = $site->get_breadcrumb($data['this_item']['item']);
		}
	}	
	
	$data['img_src'] = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
	
	// 404 ошибка
	ob_end_flush();
	if($data['this_page']['alias'] == '404'){
		ob_end_clean();
		include('template.php');
		die();
	}
	
	include('template.php');	
?>