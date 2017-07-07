<?php
	include('main_class.php');

	class site extends main_class{		
		function save_item($item, $cat_id, $sub_cat_id){
			
			$query = "
				INSERT INTO 
					items
				VALUES(
					'".$item['id']."',
					'".$item['name']."',
					'".$item['fuckingCell']."',
					'".$item['count']."',
					'".$item['price']."',
					'".$item['sale']."',
					'".$cat_id."',
					'".$sub_cat_id."',
					'".$item['created']."',
					'".$item['other2']."',
					'".$item['date']."',
					'".$item['last_update']."',
					'".$item['is_show']."'	
				)";//$item['created']
				
			$res1 = mysql_query($query);
			
			if($res1){
			
				$param1 = json_decode($item['other1']);
				$param3 = json_decode($item['other3']);
				
				for($i=0; $param1[$i]; $i++){
					mysql_query("INSERT INTO params_2 VALUES('', '".$param1[$i]->name."', '".$param1[$i]->option."', '".$item['id']."')");
				}
				
				for($i=0; $param3[$i]; $i++){
					mysql_query("INSERT INTO params VALUES('', '".$param3[$i]->name."', '".$param3[$i]->option."', '".$item['id']."')");
				}
				
				echo "true<br />";
				
			}else{
				echo "false -> ".$item['name']."<br />";
			}	
		}
		
		function get_last_insert($limit){
			$data['last_insert'] = $this->get_query_list("SELECT * FROM items WHERE is_show=1 ORDER BY `items`.`date_insert` DESC LIMIT $limit");
		
			foreach($data['last_insert'] as &$item){
				$price_sale = 0;
				if($item['type_price'] == 2){//цена за 1ед
					if($item['sale_price'] > 0){
						$price_sale = $item['sale_price'];
						$price_old 	= $item['price'];
					}else{
						$price_sale = $item['price'];
					}
				}else{
					$count = $this->find_count_in_item($this->get_list('params', $item['id'], 'item_id'));
					$price_origin 	= $item['price'];
					$price_sale 	= $item['sale_price'];
				
					if($price_sale > 0 && $count){
						$price_origin 	= $price_origin;
						$price_sale 	= $price_sale;
					}
				
					if($price_sale == 0 && $count){
						$price_sale 	= $price_origin/$count;
					}
					
					if($price_sale == 0 && !$count){
						$price_sale 	= $price_origin;
					}
					
					if($price_sale > 0 && !$count){
						//$price_origin 	= $price_origin;
						$price_sale 	= $price_sale;
						$price_old 		= $price_origin;
					}
				}
				$item['price_sale'] = $price_sale;
				$item['price_old'] = $price_old;
			}	
			return $data['last_insert'];
		}
		
		function get_last_update_sale($limit){
			$data['last_update_items'] = $this->get_query_list("SELECT * FROM items WHERE sale_price!=0 AND is_show=1 ORDER BY `items`.`date_update` DESC LIMIT $limit");
		
			foreach($data['last_update_items'] as &$item){
				if($item['type_price'] == 2){//цена за 1ед
					if($item['sale_price'] > 0){
						$price_origin = $item['sale_price'];
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
					}else{
						if($count){
							$price_origin = $item['price']/$count;
						}else{
							$price_origin = $item['price'];
						}	
					}
				}
				$item['price_origin'] = $price_origin;
			}
			return $data['last_update_items'];
		}
						
		function get_pages_from_category($id=0){
			return $this->get_query_list("SELECT p.*, c.sort, c.id cat_id FROM `category` c RIGHT JOIN `pages` p ON p.query=c.id AND c.parent_id='$id' WHERE p.is_show=1 AND c.is_show=1 ORDER BY c.sort ASC");
		}
		
		function get_slides_list(){
			return $this->get_query_list("SELECT * FROM slider WHERE is_show=1 ORDER BY sort");
		}
		
		function show_all_menu($is_show=0){
			$is_show = $is_show==0?'':'WHERE menu.is_show=1';
			$query = "SELECT menu.id, menu.name, pages.alias, menu.is_show FROM menu LEFT JOIN pages ON pages.id=menu.page_id $is_show ORDER BY menu.id";
			return $this->get_query_list($query);
		}
			
		function get_setting(){
			$query = "SELECT * FROM setting";
			$data = array();
			foreach($this->get_query_list($query) as $row){
				$data[$row['name']] = $row['value'];
			}
			
			return $data;
		}	
	}

?>	