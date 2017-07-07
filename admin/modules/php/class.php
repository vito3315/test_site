<?php
	session_start();
	
	include('../../../modules/main_class.php');
	
	class site extends main_class{
		private $login1		= 'vito';
		private $pass1 		= 'f7b16af5588f9654862e4aefcec8b0de';
		
		function check_adm(){
			
			if($_SESSION['user'] != $this->login1 && $_SESSION['GiK'] != $this->pass1){
				return false;
			}else{
				return true;
			}
		}
		
		function get_popular_item_today($post){
			$data = $this->get_query_list('SELECT it.`item_id` id, count(*) count, i.`name` FROM `items_trafic` it, `items` i WHERE date="'.date("Y-m-d").'" AND it.`item_id`=i.id GROUP BY `item_id` ORDER BY `item_id` ASC');
			return json_encode($data);
		}
		
		function get_popular_item_last_7($post){
			$data = $this->get_query_list('SELECT it.`item_id` id, count(*) count, i.`name` FROM `items_trafic` it, `items` i WHERE date BETWEEN "'.date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-7, date("Y"))).'" AND "'.date("Y-m-d").'" AND it.`item_id`=i.id GROUP BY `item_id` ORDER BY `item_id` ASC');
			return json_encode($data);
		}
		
		function get_popular_item_last_30($post){
			$data = $this->get_query_list('SELECT it.`item_id` id, count(*) count, i.`name` FROM `items_trafic` it, `items` i WHERE date BETWEEN "'.date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")-30, date("Y"))).'" AND "'.date("Y-m-d").'" AND it.`item_id`=i.id GROUP BY `item_id` ORDER BY `item_id` ASC');
			return json_encode($data);
		}
		
		function save_stat($post){
			mysql_query("INSERT INTO items_trafic VALUES('', '".date("Y-m-d")."', '".addslashes($post['id'])."', 'test', '')");
		}
		
		function find_param_by_name($param_name, $item_id){
			if(empty($params = $this->cash('params_1_'.$item_id))){
				$params = $this->cash('params_1_'.$item_id, $this->get_list('params', $item_id, 'item_id'));
			}
			
			foreach($params as $param){
				if (strpos($param['name'], $param_name) === false) {//false
					
				} else {//true
					return $param['name'].': '.$param['value'];
				}
			}
		}
		
		function get_items_list($post){
			$data['items'] = $this->get_items_by_category_(array('url' => $post['url']));
			$data['cat'] = $this->get_query_one("SELECT * FROM category WHERE id='".$data['items'][0]['category_id']."'");
			
			foreach($data['items'] as &$item){
				
				$item['p1'] = $this->find_param_by_name($data['cat']['param1_name'], $item['id']);
				$item['p2'] = $this->find_param_by_name($data['cat']['param2_name'], $item['id']);
				
				$price_old = 0;
				if($item['type_price'] == 2){//цена за 1ед
					if($item['sale_price'] > 0){
						$price_origin = $item['sale_price'];
						$price_old 	  = $item['price'];
					}else{
						$price_origin = $item['price'];
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
				
				$item['price_origin_'] = number_format($price_origin, 1, ',', '');
				$item['price_old_'] = number_format($price_old, 1, ',', '');
				
				$item['price_origin'] = $price_origin;
				$item['price_old'] = $price_old;
				$item['subname_'] = str_replace(' ', '', $item['subname']);
			}
			
			return json_encode($data['items']);
		}
		
		function get_items_by_category_($post){
			$pages = $this->get_list('pages', '', '', '', 1);
			$uri = $this->get_uri($post['url']);
			
			foreach($pages as $page){
				if($page['alias'] == $uri[(int)count($uri)-1]){
					return $this->get_query_list("SELECT * FROM items WHERE category_id='".$page['query']."' AND is_show=1");
				}
			}
		}
		
		/* тестовые */
		function catalog_1(){
			return json_encode($this->get_query_list('SELECT * FROM `nomenklatura` WHERE `price`>0'));
		}
		
		function catalog_2(){
			return json_encode($this->get_query_list('SELECT * FROM `items` WHERE `kod`=""'));
		}
		
		function update_price(){
			$data['numenklatura'] = $this->get_list('nomenklatura');
			foreach($data['numenklatura'] as $num_item){
				mysql_query("UPDATE items SET price='".$num_item['price']."', type_price=2 WHERE kod='".$num_item['kod']."'");
			}
			return 'true';
		}
		
		function update_item_kod($post){
			//mysql_query("UPDATE items SET kod='".addslashes($post['kod'])."' WHERE id='".addslashes($post['id'])."'");
			//mysql_query("DELETE FROM nomenklatura WHERE kod='".addslashes($post['kod'])."'");
			//INSERT INTO `nom_date` (`id`, `date`, `true_`, `false_`, `zero_`) VALUES (NULL, CURRENT_TIMESTAMP, '', '', '');
		}
		
		/**/
		
		function getCurlData($url){
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT, 10);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
			$curlData = curl_exec($curl);
			curl_close($curl);
			return $curlData;
		}
		
		function reg($post){
			$msg='';
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$recaptcha=$_POST['data'];
				if(!empty($recaptcha)){
					/* include("getCurlData.php"); */
					$google_url="https://www.google.com/recaptcha/api/siteverify";
					$secret='6LdgSBkTAAAAAPSywCsZ1RiH6Ch-2XNokKa9fAyf';
					$ip=$_SERVER['REMOTE_ADDR'];
					$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
					$res=$this->getCurlData($url);
					$res= json_decode($res, true);
					//reCaptcha введена
					if($res['success']){
						// Продолжаем проверку данных формы
						$msg=true;
					}else{
						$msg=false;
					}
			 
				}else{
					$msg=false;
				}
			} 

			if($msg){
				if(empty($this->get_one('users', $post['email'], 'mail'))){
					$result = mysql_query("
						INSERT INTO 
							users 
						VALUES(
							'',
							'".addslashes($post['name'])."', 
							'".addslashes($post['fam'])."', 
							'".addslashes($post['email'])."', 
							'".MD5($post['pass'])."', 
							'', 
							'0', 
							'0', 
							'0', 
							'".addslashes($post['phone'])."'
						)");
						
					if($result){
						return 'true';
					}	
					
				}else{
					return 'E-mail уже используется';
				}
			}else{
				return 'recapture';
			}
		}
		
		function reg_fast($post){
			$msg='';
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$recaptcha=$_POST['data'];
				if(!empty($recaptcha)){
					/* include("getCurlData.php"); */
					$google_url="https://www.google.com/recaptcha/api/siteverify";
					$secret='6LdgSBkTAAAAAPSywCsZ1RiH6Ch-2XNokKa9fAyf';
					$ip=$_SERVER['REMOTE_ADDR'];
					$url=$google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
					$res=$this->getCurlData($url);
					$res= json_decode($res, true);
					//reCaptcha введена
					if($res['success']){
						// Продолжаем проверку данных формы
						$msg=true;
					}else{
						$msg=false;
					}
			 
				}else{
					$msg=false;
				}
			} 

			if($msg){
				$result = mysql_query("
					INSERT INTO 
						fast_user 
					VALUES(
						'',
						'".addslashes($post['name'])."', 
						'".addslashes($post['fam'])."', 
						'".addslashes($post['email'])."', 
						'".addslashes($post['phone'])."'
					)");
					
				if($result){
					return mysql_insert_id();
				}	
			}else{
				return 'recapture';
			}
		}
		
		function res_pas($post){
			$data['user'] = $this->get_one('users', $post['mail'], 'mail');
			if(!empty($data['user'])){
				$arr = array('a','b','c','d','e','f',
							 'g','h','i','j','k','l',
							 'm','n','o','p','r','s',
							 't','u','v','x','y','z',
							 'A','B','C','D','E','F',
							 'G','H','I','J','K','L',
							 'M','N','O','P','R','S',
							 'T','U','V','X','Y','Z',
							 '1','2','3','4','5','6',
							 '7','8','9','0','!','?',
							 '^','+','-');
				$pass = '';
				
				for($i = 0; $i < 10; $i++){
					// Вычисляем случайный индекс массива
					$index = rand(0, count($arr) - 1);
					$pass .= $arr[$index];
				}
				
				$res = mysql_query("UPDATE users SET pass='".MD5($pass)."' WHERE mail='".$post['mail']."'");
				
				if($res){
					return $pass;
				}else{
					return 'er_mail';
				}
				
			}else{
				return 'er_mail';
			}
		}
		
		function login($post){
			$data['user'] = $this->get_query_one("SELECT * FROM users WHERE mail='".$post['data']."' OR phone='".$post['data']."'");
			$data['user']['cart'] = $this->get_list('cart_new', $data['user']['id'], 'user_id');
			return json_encode($data['user']);
		}
		
		function login_full($post){
			$data['user'] = $this->get_query_one("SELECT * FROM users WHERE mail='".addslashes($post['mail'])."' OR phone='".addslashes($post['mail'])."' AND pass='".md5(addslashes($post['pass']))."'");
			$data['user']['cart'] = $this->get_list('cart_new', $data['user']['id'], 'user_id');
			return json_encode($data['user']);
		}
		
		function log_adm($post){
			if($post['login'] == $this->login1){
				if(md5($post['pass']) == $this->pass1){
					$_SESSION['user'] = $post['login'];
					$_SESSION['GiK'] = md5($post['pass']);
					return 'true';
				}else{
					return 'false';
				}
			}else{
				return 'false';
			}
		}
		
		function get_setting_param($name){
			$query = "SELECT * FROM setting WHERE name='$name'";
			return $this->get_query_one($query);
		}
	
		function set($name_param, $name, $val){
			$res = $this->get_setting_param($name_param);
			
			if($res){
				mysql_query("UPDATE setting SET value='".addslashes($val)."' WHERE name='$name_param'");
			}else{
				mysql_query("INSERT INTO setting VALUES('', '$name', '".addslashes($val)."')");
			}
		}
	
		function save_setting($post, $cache_brower, $cache_proxy, $mail_login, $mail_pass, $mail_host, $main_mail){
			$this->set('cache_brower', 'cache_brower', $post['cache_brower']);
			$this->set('cache_proxy', 'cache_proxy', $post['cache_proxy']);
			$this->set('mail_login', 'mail_login', $post['mail_login']);
			$this->set('mail_pass', 'mail_pass', $post['mail_pass']);
			$this->set('mail_host', 'mail_host', $post['mail_host']);
			$this->set('main_mail', 'main_mail', $post['main_mail']);
			
			return 'true';
		}
		
		function get_setting(){
			$query = "SELECT * FROM setting";
			$data = array();
			foreach($this->get_query_list($query) as $row){
				$data[$row['name']] = $row['value'];
			}
			
			return $data;
		}
		
		function add_to_cart($post){
			$user_id = $this->get_one('users', $post['login'], 'mail')['id'];
			
			if($user_id){
				$result = mysql_query("
						INSERT INTO 
							cart_new 
						VALUES(
							'',
							'".addslashes($user_id)."', 
							'".addslashes($post['item_id'])."', 
							'0', 
							'1', 
							'0', 
							''
						)");
						
				if($result){
					return 'true';
				}		
			}
			return 'false';
		}
		
		function kill_item_from_cart($post){
			$user_id = $this->get_one('users', $post['login'], 'mail')['id'];
			if($user_id){
				$result = mysql_query("DELETE FROM cart_new WHERE user_id='$user_id' AND item_id='".$post['item_id']."'");
						
				if($result){
					return 'true';
				}		
			}

			return 'false';	
		}
		
		function kill_from_cart($post){
			$user_id = $this->get_one('users', $post['login'], 'mail')['id'];
			if($user_id){
				$result = mysql_query("UPDATE cart_new SET count='".$post['count']."' WHERE user_id='$user_id' AND item_id='".$post['item_id']."'");
						
				if($result){
					return 'true';
				}		
			}

			return 'false';	
		}
		
		function get_items_from_my_cart($post){
			if(empty($post['items'])){
				return 'false';
			}
			
			$arr = array();
			
			foreach($post['items'] as $item){
				$item1 = $this->get_one('items', $item['id'], '', '', 1);
				
				
				if($item1['type_price'] == 2){//цена за 1ед
					if($item1['sale_price'] > 0){
						$price_origin = $item1['sale_price'];
					}else{
						$price_origin = $item1['price'];
					}
				}else{
					$count = $this->find_count_in_item($this->get_list('params', $item1['id'], 'item_id'));
						
					if($item1['sale_price'] > 0){
						if($count){
							$price_origin = $item1['sale_price'];
						}else{
							$price_origin = $item1['sale_price'];
						}	
					}else{
						if($count){
							$price_origin = $item1['price']/$count;
						}else{
							$price_origin = $item1['price'];
						}	
					}
				}	
				
				$item1['price'] = $price_origin;
				
				$arr[] = $item1;
			}
			
			return json_encode($arr);
		}
			
		function find_price_item($id){
			$item = $this->get_one('items', $id);
			
			$count = $this->find_count_in_item($this->get_list('params', $item['id'], 'item_id'));
					
			if($item['sale_price'] > 0){
				$price_origin = $item['sale_price'];
			}else{
				if($count){
					$price_origin = $item['price']/$count;
				}else{
					$price_origin = $item['price'];
				}	
			}
			
			return $price_origin;
		}	
			
		function to_my_order_fast($post){
			//$data['user'] = $post['user_type'] == 2?$post['login']:$this->get_query_one("SELECT * FROM users WHERE mail='".$post['login']."' OR phone='".$post['login']."'");
			//$data['user']['id'] = $post['user_id']?$post['user_id']:$data['user']['id'];
			//$data['user']['id'] = $post['user_id'];
			//if(!empty($data['user'])){
				$data['mycart'] = $post['cart'];
				
				if(!empty($data['mycart'])){
					//mysql_query("DELETE FROM cart_new WHERE user_id='".$data['user']['id']."'");
					
					foreach($data['mycart'] as $items){
						
						$count = 1;
						if((int)$items['count'] <= 0 || !$items['count']){$count = 1;}else{$count = $items['count'];}
						
						mysql_query("INSERT INTO order_items VALUES('', '".$post['user_id']."', '".$post['user_type']."', '".$items['id']."', '".$count."', '".$this->find_price_item($items['id'])."', '0', '".date('Y-m-d H:i:s')."')");
					}
					return 'true';
				}
				return 'cart_empty';
			//}
				
			return 'false';
		}
		
		function to_my_order($post){
			$data['user'] = $this->get_query_one("SELECT * FROM users WHERE mail='".$post['login']."' OR phone='".$post['login']."'");  //$this->get_one('users', $post['login'], 'mail');
			if(!empty($data['user'])){
				$data['mycart'] = $this->get_list('cart_new', $data['user']['id'], 'user_id');
				
				if(!empty($data['mycart'])){
					mysql_query("DELETE FROM cart_new WHERE user_id='".$data['user']['id']."'");
					
					foreach($data['mycart'] as $items){
						
						$count = 1;
						if((int)$items['count'] <= 0 || !$items['count']){$count = 1;}else{$count = $items['count'];}
						
						mysql_query("INSERT INTO order_items VALUES('', '".$data['user']['id']."', '0', '".$items['item_id']."', '".$count."', '".$this->find_price_item($items['id'])."', '0', '".date('Y-m-d H:i:s')."')");
					}
					return 'true';
				}
				return 'cart_empty';
			}
				
			return 'false';
		}
		
		function clear_cash(){
			memcache_flush($this->cash);
			return 'true';
		}
		
		function cerate_sitemap(){
			$data['pages_other'] = $this->get_list('pages', '0', 'query', '', 1);
			$data['items'] = $this->get_list('items', '', '', '', 1);
			
			$i = 0;
			$data['pages_cat'] = $this->get_query_list('SELECT p.alias, p.query, c.* FROM `pages` p INNER JOIN category c ON c.id=p.query WHERE c.is_show=1 AND p.is_show=1');
			
			foreach($data['pages_cat'] as &$caty){
				if($caty['parent_id'] != 0){
					foreach($data['pages_cat'] as &$category_two){
						if($category_two['id'] == $caty['parent_id']){
							$category_two['parent'][] = $caty;
							unset($data['pages_cat'][$i]);
							continue;
						}
					}
				}
				$i++;
			}
			
			$f = fopen('../../../sitemap.xml', 'w+');
			
			fwrite($f, '<?xml version="1.0" encoding="UTF-8"?>'."\n");
			fwrite($f, '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n");
	
			foreach($data['pages_other'] as $row){
				fwrite($f, $this->sitemap_url_gen(
					$this->addr.'/'.$row['alias'], //url
					'', //lastmod
					'monthly', //переодичность сканирования
					'1' //приоритет
				));
			}
	
			foreach($data['pages_cat'] as $row){
				fwrite($f, $this->sitemap_url_gen(
					$this->addr.'/'.$row['alias'].'/', //url
					'', //lastmod
					'monthly', //переодичность сканирования
					'1' //приоритет
				));
				
				foreach($row['parent'] as $row2){
					fwrite($f, $this->sitemap_url_gen(
						$this->addr.'/'.$row['alias'].'/'.$row2['alias'].'/', //url
						'', //lastmod
						'monthly', //переодичность сканирования
						'1' //приоритет
					));
				}				
			}
	
			foreach($data['items'] as $row){
				fwrite($f, $this->sitemap_url_gen(
					$this->addr.'/item/'.$row['id'], //
					$row['urldate_update'], //lastmod
					'monthly', //переодичность сканирования
					'1' //приоритет
				));
			}
	
			fwrite($f, '</urlset>'."\n");
	
			return 'true';
		}
		
		function sitemap_url_gen($url, $lastmod = '', $changefreq = '', $priority = ''){
			$search = array('&', '\'', '"', '>', '<');
			$replace = array('&amp;', '&apos;', '&quot;', '&gt;', '&lt;');
			$url = str_replace($search, $replace, $url);
			$lastmod = (empty($lastmod)) ? '' : "<lastmod>".$lastmod."</lastmod>";
			
			$res = '
				<url>
					<loc>'.$url.'</loc>
					'.$lastmod.'
					<changefreq>'.$changefreq.'</changefreq>
					<priority>'.$priority.'</priority>
				</url>';
			return $res;
		}
		
		function save_sort_category($post){
			foreach($post['arr'] as $row){
				$result = mysql_query("UPDATE category SET sort=$row[pos] WHERE id=$row[id_menu]");
			}
			return 'true';
		}
		
		function get_unic_param(){
			return $this->get_query_list('SELECT DISTINCT `name` FROM `params`');
		}
		
		function get_order_admin(){
			return $this->get_query_list("SELECT `user_id`, `type_user`, `type`, `date` FROM `order_items` GROUP BY `date`");
		}
		
		function get_slides_list(){
			return $this->get_query_list("SELECT * FROM slider ORDER BY sort");
		}
		
		function save_new_slide($post){
			$result = mysql_query("
				INSERT INTO slider
				VALUES(
					'', 
					'./img/slider/".addslashes($post['photo'])."',
					'".addslashes($post['name'])."', 
					'0',
					'1'
				);");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
		
		function save_new_sort_slider($post){
			foreach($post['arr'] as $row){
				$result = mysql_query("UPDATE slider SET sort='".$row['pos']."' WHERE id='".$row['id_menu']."'");
			}
			return 'true';
		}
		
		function update_slide($post){
			$result = mysql_query("
				UPDATE 
					slider 
				SET 
					title='".$post['name']."', 
					photo_addr='./img/slider/".$post['file_name']."', 
					is_show='".$post['is_show']."' 
				WHERE 
					id='".$post['id']."'");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}	
		}
		
		function save_img($post){
			mysql_query("INSERT INTO items_photo VALUES('', '".addslashes($post['name'])."', '".addslashes($post['id'])."')");
			
			if($post['name_min']){
				mysql_query("INSERT INTO items_photo VALUES('', '".addslashes($post['name_min'])."', '".addslashes($post['id'])."')");
			}
		}
		
		function update_img($post){
			mysql_query("DELETE FROM items_photo WHERE item_id='".addslashes($post['id'])."'");
			
			mysql_query("INSERT INTO items_photo VALUES('', '".addslashes($post['name'])."', '".addslashes($post['id'])."')");
			
			if($post['name_min']){
				mysql_query("INSERT INTO items_photo VALUES('', '".addslashes($post['name_min'])."', '".addslashes($post['id'])."')");
			}
		}
		
		function update_item($post){
			$id = $post['id'];
			
			if($post['sub_cat_che'] == 1){
				mysql_query("INSERT INTO subcategory VALUES('', '".addslashes($post['subcat_two'])."')");
				$sub_cat_id = mysql_insert_id();
			}
			
			$sub_cat_id = $sub_cat_id?$sub_cat_id:$post['subcategory'];
			
			$result = mysql_query("
				UPDATE
					items
				SET
					name='".addslashes($post['name'])."',
					art='".addslashes($post['art'])."',
					count='".addslashes($post['count'])."',
					kod='".addslashes($post['kod'])."',
					type_price='".addslashes($post['type_price'])."',
					price='".addslashes($post['price'])."',
					sale_price='".addslashes($post['price_sale'])."',
					category_id='".addslashes($post['category'])."',
					subcategory_id='".addslashes($sub_cat_id)."',
					subname='".addslashes($post['maker'])."',
					href='".addslashes($post['href'])."',
					description='".addslashes($post['description'])."',
					date_update='".date('Y-m-d H:i:s')."'
				WHERE
					id=".$id."
			");
			
			if($result){
				
				$result_1 = mysql_query("DELETE FROM params WHERE item_id='".addslashes($id)."'");
				
				foreach($post['add1'] as $add1){
					mysql_query("
						INSERT INTO 
							params
						VALUES(
							'',
							'".addslashes($add1['name'])."',
							'".addslashes($add1['value'])."',
							'".addslashes($id)."'
						);	
					");
				}
				
				$result_2 = mysql_query("DELETE FROM params_2 WHERE item_id='".addslashes($id)."'");
				
				foreach($post['add3'] as $add3){
					$result3 = mysql_query("
						INSERT INTO 
							params_2
						VALUES(
							'',
							'".addslashes($add3['name'])."',
							'".addslashes($add3['value'])."',
							'".addslashes($id)."'
						);	
					");
				}
			}
			
			if($result){
				return $id;
			}else{
				return 'false_'.$id;
			}
			
		}
		
		function save_item($post){
			
			if($post['sub_cat_che'] == 1){
				mysql_query("INSERT INTO subcategory VALUES('', '".addslashes($post['subcat_two'])."')");
				$sub_cat_id = mysql_insert_id();
			}
			
			$sub_cat_id = $sub_cat_id?$sub_cat_id:$post['subcategory'];
			
			$result = mysql_query("
				INSERT INTO 
					items
				VALUES(
					'', 
					'".addslashes($post['name'])."',
					'".addslashes($post['art'])."', 
					'".addslashes($post['kod'])."', 
					'".addslashes($post['count'])."', 
					'".addslashes($post['price'])."', 
					'".addslashes($post['price_sale'])."', 
					'".addslashes($post['type_price'])."', 
					'".addslashes($post['category'])."', 
					'".addslashes($sub_cat_id)."', 
					'".addslashes($post['maker'])."', 
					'".addslashes($post['href'])."',
					'".addslashes($post['description'])."', 
					'".date('Y-m-d H:i:s')."',
					'',
					'1'
				);");
			
			$id = mysql_insert_id();
			
			foreach($post['add1'] as $add1){
				$result2 = mysql_query("
					INSERT INTO 
						params
					VALUES(
						'',
						'".addslashes($add1['name'])."',
						'".addslashes($add1['value'])."',
						'".addslashes($id)."'
					);	
				");
			}
			
			foreach($post['add3'] as $add3){
				$result3 = mysql_query("
					INSERT INTO 
						params_2
					VALUES(
						'',
						'".addslashes($add3['name'])."',
						'".addslashes($add3['value'])."',
						'".addslashes($id)."'
					);	
				");
			}
			
			if($result){
				return $id;
			}else{
				return 'false';
			}
		}
		
		function update_show_item($post){
			$result = mysql_query("
				UPDATE 
					items 
				SET 
					is_show=".$post['val']."
				WHERE 
					id='".$post['id']."'");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
		
		function get_this_item(){
			$data['item'] = $this->get_one('items', $this->get_uri()[0]);
			
			if(!empty($data['item'])){
				$data['item']['param_1'] = $this->get_list('params', $this->get_uri()[0], 'item_id');
				$data['item']['param_2'] = $this->get_list('params_2', $this->get_uri()[0], 'item_id');
				
				return $data['item'];
			}else{
				header('HTTP/1.1 404 Not Found', true, 404);
				return false;
			}
		}
		
		function update_new_tmp_items($item){
			/*$result = mysql_query("
				INSERT INTO 
					items
				VALUES(
					'".$item['id']."',
					'".$item['name']."',
					'".$item['fuckingCell']."',
					'".$item['price']."',
					'".$item['sale']."',
					'2',
					'2',
					'".$item['date']."',
					'".$item['last_update']."',
					'".$item['is_show']."'
				)		
			");*/
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
		
		function update_category($post){
			$result = mysql_query("
				UPDATE 
					category 
				SET 
					name='".$post['name']."', 
					parent_id='".$post['parent_id']."', 
					is_show='".$post['is_show']."',
					param1_name='".$post['param_1']."',
					param2_name='".$post['param_2']."' 	
				WHERE 
					id='".$post['cat_id']."'");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
		
		function save_new_category($post){
			$result = mysql_query("
				INSERT INTO category
				VALUES(
					'', 
					'".addslashes($post['name'])."', 
					'0', 
					'".addslashes($post['parent_id'])."',
					'0',
					'".addslashes($post['param_1'])."',
					'".addslashes($post['param_2'])."',
					'1'
				);");
			
			$id = mysql_insert_id();
			
			if($result){
				return $id;
			}else{
				return 'false';
			}
		}
				
		function save_page($post){
			
			$result = mysql_query("
				INSERT INTO pages
				VALUES(
					'', 
					'".addslashes($post['name'])."', 
					'".addslashes($post['alias'])."', 
					'".addslashes($post['h1'])."', 
					'".addslashes($post['title'])."', 
					'".addslashes($post['description'])."', 
					'".addslashes($post['content_1'])."', 
					'".addslashes($post['content_2'])."', 
					'".addslashes($post['path'])."', 
					'".addslashes($post['query'])."', 
					'1', 
					'1'
				);");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
		
		function update_page($post){
			$result = mysql_query("
				UPDATE 
					pages
				SET 
					name			= '".addslashes($post['name'])."', 
					alias			= '".addslashes($post['alias'])."',
					h1				= '".addslashes($post['h1'])."',
					path			= '".addslashes($post['path'])."', 					
					title			= '".addslashes($post['title'])."', 
					description		= '".addslashes($post['description'])."', 
					query			= '".addslashes($post['query'])."', 
					is_show			= '".addslashes($post['is_show'])."', 
					content_after 	= '".addslashes($post['content_1'])."',
					content_before 	= '".addslashes($post['content_2'])."'
				WHERE
					id='".addslashes($post['id'])."'
				");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
		
		function get_page($post){
			return json_encode($this->get_one('pages', $post['id']));
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
		
		function update_order($post){
			$result = mysql_query("
				UPDATE 
					order_items
				SET 
					type='1'
				WHERE
						user_id='".addslashes($post['user_id'])."'
					AND
						type_user='".addslashes($post['type_user'])."'
					AND
						date='".addslashes($post['date'])."'
					AND
						type='0'
				");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
	
		function del_order_1($post){
			$result = mysql_query("
				UPDATE 
					order_items
				SET 
					type='2'
				WHERE
						user_id='".addslashes($post['user_id'])."'
					AND
						type_user='".addslashes($post['type_user'])."'
					AND
						date='".addslashes($post['date'])."'
					AND
						type='0'
				");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
	
		function save_news($post){
			$result = mysql_query("INSERT INTO news VALUES(
				'',
				'".addslashes($post['name'])."',
				'".addslashes($post['alias'])."',
				'".addslashes($post['date'])."',
				'".addslashes($post['h1'])."',
				'".addslashes($post['title'])."',
				'".addslashes($post['description'])."',
				'".addslashes($post['text'])."',
				'1',
				'".addslashes($post['photo'])."'
			)");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
	
		function update_news($post){
			
			if($post['flagImagesToEdit'] == 'true' || $post['flagImagesToEdit'] == true){
				$photo = ", photo='".addslashes($post['photo'])."'";
			}else{
				$photo = '';
			}
			
			$result = mysql_query("
				UPDATE 
					news 
				SET
					name='".addslashes($post['name'])."',
					alias='".addslashes($post['alias'])."',
					date_end='".addslashes($post['date'])."',
					h1='".addslashes($post['h1'])."',
					title='".addslashes($post['title'])."',
					description='".addslashes($post['description'])."',
					content='".addslashes($post['text'])."',
					is_show='".addslashes($post['is_show'])."' 
					".$photo."
				WHERE
					id='".addslashes($post['id'])."'
			");
			
			if($result){
				return 'true';
			}else{
				return 'false';
			}
		}
	
		function del_order($post){
			$data['user'] = $this->get_query_one("SELECT id FROM users WHERE mail='".addslashes($post['user'])."' OR phone='".addslashes($post['user'])."'");
			$data['res'] = mysql_query("UPDATE order_items SET type=2 WHERE date='".addslashes($post['date'])."' AND user_id='".$data['user']['id']."'");
			if($data['res']){
				return 'true';
			}else{
				return 'false';
			}
		}
	
		function my_account($post){
			$data['user'] = $this->get_query_one("SELECT id, name, fam, mail, phone FROM users WHERE mail='".addslashes($post['data'])."' OR phone='".addslashes($post['data'])."'");
			$data['user']['orders'] = $this->get_query_list("SELECT `item_id`, `count`, `price`, `type`, `date` FROM `order_items` WHERE `user_id`='".$data['user']['id']."' AND `type_user`='0'");
			
			foreach($data['user']['orders'] as $item){
				$data['user']['order'][] = array('date' => $item['date'], 'id' => $item['item_id'], 'price' => $item['price'], 'count' => $item['count'], 'item' => $this->get_one('items', $item['item_id'])['name']);
			}
			
			$data['user']['orders'] = $this->get_query_list("SELECT `type`, `date` FROM `order_items` WHERE `user_id`='".$data['user']['id']."' AND `type_user`='0' GROUP BY `date`");
			
			return json_encode($data['user']);
		}
	}

?>	