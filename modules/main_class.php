<?php
	class main_class{
		private $host 		= 'localhost';
		private $user 		= 'marusimg_marcet';
		private $pwd 		= '4815162342';
		private $bd 		= 'marusimg_marcet';
		public  $addr		= '';
		public  $cash;
		public  $time_cash	= 86400; //сутки
		 
		function __construct() {
			mysql_connect($this->host, $this->user, $this->pwd) or
				die('Could not connect: ' . mysql_error());
			mysql_select_db($this->bd);
			
			$this->cash = memcache_connect('127.0.0.1', 11211);
			$this->addr = 'https://'.$_SERVER['SERVER_NAME'];
		}
		
		function r_404(){
			header('HTTP/1.1 404 Not Found', true, 404);
			return $this->get_one('pages', '404', 'alias');
		}
		
		function r_304($date=0){
			if($date!=0){
				$data['date_'] = explode(' ', $date);
				$data['date_date'] = explode('-', $data['date_'][0]);
				$data['date_time'] = explode(':', $data['date_'][1]);
				
				$data['date__'] = mktime($data['date_time'][0], $data['date_time'][1], $data['date_time'][2], $data['date_date'][1], $data['date_date'][2], $data['date_date'][0]);
				
				$LastModified_unix = $data['date__'];
				$LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
				$IfModifiedSince = false;
				
				if (isset($_ENV['HTTP_IF_MODIFIED_SINCE']))    
					$IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5)); 
				
				if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))    
					$IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5)); 
				
				if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix){    
					header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');    
					exit; 
				}
				
				header('Last-Modified: '. $LastModified);
				//header('Expires: '. $LastModified);
			}	
		}
		
		function get_(){
			$data['arr_url'] = $this->get_uri(); //текущий адрес
			$data['pages'] = $this->get_list('pages', '', '', '', 1); //все страницы
			
			foreach($data['arr_url'] as $item){
				foreach($data['pages'] as $page){//синхронизируем
					if($item == $page['alias']){
						$data['this_page'] = $page;
						if(count($data['arr_url']) == 1 || $page['alias'] == 'search'){
							return $page;
						}
						continue;
					}
					
					if($data['this_page']['alias'] == 'item' || $data['this_page']['alias'] == 'novosti'){
						return $data['this_page'];
					}
				}
				
				if(empty($data['this_page'])){//если кривой url
					return $this->r_404();
				}
			}
			
			if(empty($data['arr_url'])){//если главная
				return $this->get_one('pages', '', 'alias');
			}
			
			if(empty($data['this_page'])){//если кривой url
				return $this->r_404();
			}
			
			return $data['this_page'];
		}
		
		function get_item($id=0, $count_type_device){
			$data['all_items'] = $this->get_list('items', '', '', '', 1);
			foreach($data['all_items'] as &$item){
				if($item['id'] == $id){
					
					$item['param_1'] = $this->get_list('params', $item['id'], 'item_id');
					$item['param_2'] = $this->get_list('params_2', $item['id'], 'item_id');
					
					if($item['type_price'] == 2){//цена за 1ед
						$count = $this->find_count_in_item($item['param_1']);
						
						if($item['sale_price'] > 0){
							$price_origin 	= $item['price'];
							$price_sale = $item['sale_price'];
						}else{
							$price_sale = $item['price'];
						}
					}else{
						$count = $this->find_count_in_item($item['param_1']);
						$price_origin 	= $item['price'];
						$price_sale 	= $item['sale_price'];
					
						if($price_sale > 0 && $count){
							$price_origin 	= $price_origin;
							$price_sale 	= $price_sale*$count;
							$price_one 		= $item['sale_price'];
						}
					
						if($price_sale == 0 && $count){
							$price_sale 	= $price_origin;
							$price_one 		= $price_origin/$count;
						}
						
						if($price_sale == 0 && !$count){
							$price_sale 	= $price_origin;
						}
					}
					
					$item['price_origin'] 	= $price_origin;
					$item['price_sale'] 	= $price_sale;
					$item['price_one'] 		= $price_one;
					$item['count_'] 		= $count;
					
					switch($item['count']){
						case 0:{
							$count_title = 'Временно остсутствует';
							$count_color = 'red_';
							break;}
						case 1:{
							$count_title = 'Доступно под заказ';
							$count_color = 'orange_';
							break;}
						case 2:{
							$count_title = 'Наличие уточните у менеджера';
							$count_color = 'orange_';
							break;}
						case 3:{
							$count_title = 'Имеется в наличии';
							$count_color = 'green_';
							break;}	
						case 4:{
							$count_title = 'Наличие и ценник уточните у менеджера';
							$count_color = 'orange_';
							break;}		
					}
					
					$item['count_title'] = $count_title;
					$item['count_color'] = $count_color;
					
					//подкоректировать
					$data['interesting'] = $this->get_query_list("SELECT * FROM items WHERE category_id='".$item['category_id']."' ORDER BY RAND() LIMIT ".$count_type_device);
					$data['photos'] = $this->get_list('items_photo', $item['id'], 'item_id');
					
					return array('item' => $item, 'interesting' => $data['interesting'], 'photos' => $data['photos']);
				}
			}
			return $this->r_404();
		}
		
		function get_breadcrumb($item_=0){
			$data['pages_list'] = $this->get_query_list('SELECT p.id, p.alias, p.name, p.query FROM pages p');
			$data['breadcrumbs'] = array();
			$data['url'] = $this->get_uri();
			
			if($data['url'][0] == 'item'){
				$data['list'] = $this->get_query_list('SELECT p.alias, p.name, c.id, c.parent_id FROM pages p, category c WHERE p.query=c.id');
				
				foreach($data['list'] as $item){
					if($item_['category_id'] == $item['id']){
						
						foreach($data['list'] as $item2){
							if($item2['id'] == $item['parent_id']){
								$data['breadcrumbs'][] = array('alias' => $this->addr.'/'.$item2['alias'].'/', 'name' => $item2['name']);
								$data['breadcrumbs'][] = array('alias' => $this->addr.'/'.$item2['alias'].'/'.$item['alias'].'/', 'name' => $item['name']);
								break;
							}
						}
						$data['breadcrumbs'][] = array('name' => $item_['name']);
						break;
					}
				}
			}
					
			if($data['url'][0] != 'item' && $data['url'][0] != 'novosti'){
				$url_ = $this->addr.'/';
				foreach($data['url'] as $url){
					foreach($data['pages_list'] as $item){
						if($url == $item['alias']){
							$url_ .= $item['alias'].'/';
							if($data['url'][count($data['url'])-1] == $url){
								$data['breadcrumbs'][] = array('name' => $item['name']);
							}else{
								$data['breadcrumbs'][] = array('alias' => $url_, 'name' => $item['name']);
							}
						}
					}
				}
			}
			
			if($data['url'][0] == 'novosti'){
				$data['news_list'] = $this->get_query_list('SELECT name, alias FROM news');
				$data['breadcrumbs'][] = array('alias' => $this->addr.'/'.$data['url'][0].'/', 'name' => $this->get_one('pages', $data['url'][0], 'alias', 1)['name']);
				
				foreach($data['news_list'] as $news){
					if($news['alias'] == $data['url'][1]){
						$data['breadcrumbs'][] = array('name' => $news['name']);
						break;
					}
				}
			}
			
			return $data['breadcrumbs'];
		}
		
		function find_count_in_item($item_param){
			if(empty($item_param)){
				return null;
			}
			
			foreach($item_param as $param){
				if(trim($param['name']) == 'Количество в упаковке'){
					return (int)$param['value'];
				}
			}
		}
		
		function get_action_items(){
			$data['items'] = $this->get_query_list('SELECT * FROM items WHERE sale_price > 0 AND is_show=1');
				
			foreach($data['items'] as &$item){
				$price_old = 0;
				if($item['type_price'] == 2){//цена за 1ед
					if($item['sale_price'] > 0){
						$price_origin 	= $item['sale_price'];
						$price_old 		= $item['price'];
					}else{
						$price_origin 	= $item['price'];
					}
				}else{	
					$count = $this->find_count_in_item($this->get_list('params', $item['id'], 'item_id'));
							
					if($item['sale_price'] > 0){
						if($count){
							$price_origin = $item['sale_price'];
						}else{
							$price_origin = $item['sale_price'];
						}	
						$price_old = $item['price'];
					}else{
						if($count){
							$price_origin = $item['price']/$count;
						}else{
							$price_origin = $item['price'];
						}	
					}	
				}
				
				$item['count_'] = $count;
				$item['price_origin'] = $price_origin;
				$item['price_old'] = $price_old;
			}
			
			//выделяем типы
			$data['sub_category_list'] = $this->get_list('subcategory');
			
			//выделяем категории
			$data['this_category_list'] = $this->get_list('category');
			
			$data['sub_cat_list'] = array();
			$data['this_cat_list'] = array();
			
			foreach($data['items'] as $item){
				
				foreach($data['this_category_list'] as $cat){
					if($cat['id'] == $item['category_id']){
						$data['this_cat_list'][$item['category_id']] = array('name'=>$cat['name'], 'id'=>$cat['id']);
					}
				}
				
				foreach($data['sub_category_list'] as $cat){
					if($cat['id'] == $item['subcategory_id']){
						$data['sub_cat_list'][$item['subcategory_id']] = array('name'=>$cat['name'], 'id'=>$cat['id']);
					}
				}
			}
			return array('items' => $data['items'], 'sub_cat_list' => $data['sub_cat_list'], 'this_cat_list' => $data['this_cat_list']);
		}
		
		function check_link($cur_url){
			if($cur_url == '#'){
				return '#';
			}
			
			$full_url = $this->addr.$this->get_full_uri();
			
			if($full_url == $cur_url){
				return '#';
			}else{
				return $cur_url;
			}
		}
		
		function get_uri($thisURL=''){
			if($thisURL == '') {
				$thisURL = addslashes($_SERVER['REQUEST_URI']);
			}
			$thisURL = explode('/', $thisURL);
			
			foreach($thisURL as $url){
				if(!empty($url)){
					$pos = strpos($url, '?');
					if ($pos === false) {//is not found
						$newUrl[] = $url;
					} else {//is found
						
					}
				}
			}
			
			return $newUrl;
		}
		
		function get_full_uri(){
			return $_SERVER['REQUEST_URI'];
		}
		
		public function cash($key, $val=0){
			if(empty(memcache_get($this->cash, $key)) && $val!=0){
				memcache_set($this->cash, $key, $val, 0, 86400);
				return memcache_get($this->cash, $key);
			}
			return memcache_get($this->cash, $key);
		}
		
		public function get_list($table, $id='', $type_id='', $sort='', $is_show=0){
			$type_id = $type_id!=''?"$type_id":'id';
			$query = $id!=''?" WHERE $type_id='$id'":'';
			$sort = $sort!=''?" ORDER BY $sort ASC ":'';
			
			if($is_show==1){
				$is_show = $id!=''?' AND is_show=1 ':' WHERE is_show=1 ';
			}else{
				$is_show = '';
			}
			
			return $this->get_query_list("SELECT * FROM ".$table.$query.$is_show.$sort);
		}
		
		public function get_one($table, $id='', $type_id='', $is_show=0){
			$type_id = $type_id!=''?"$type_id":"id";
			$query = $id!=''?" WHERE $type_id='$id'":"";
			
			if($is_show==1){
				$is_show = $id!=''?' AND is_show=1 ':' WHERE is_show=1 ';
			}else{
				$is_show = '';
			}
			
			return $this->get_query_one("SELECT * FROM ".$table.$query.$is_show);
		}
		
		public function get_query_list($query){
			$query = mysql_query($query);
			$result = array();
			while($row = mysql_fetch_assoc($query)){
				$result[] = $row;
			}
			return $result;
		}
	
		public function get_query_one($query){
			$query = mysql_query($query);			
			return mysql_fetch_assoc($query);
		}
		
	}

?>	