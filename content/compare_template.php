<?php
	$data['items'] = array();
	$data['items_id_list'] = explode(',', explode('=', explode('/', $site->get_full_uri())[1])[1]);//id товаров для сравнения
	$data['category'] = array();
	
	foreach($data['items_id_list'] as $item){
		$find_item = $site->get_one('items', $item, 'id');//получаем список товаров
		
		if($find_item){
			$data['items'][$item] = $find_item;
			$data['items'][$item]['param'] = $site->get_list('params', $item, 'item_id');//получаем список параметров
			
			$data['category'][(int)$data['items'][$item]['category_id']] = (int)$data['items'][$item]['category_id'];//сортировка категории
		}
	}
	
	$data['params'] = array();
	
	//сортировка параметров по категориям
	foreach($data['category'] as $cat){
		foreach($data['items'] as $item){
			if($cat == $item['category_id']){
				$this_cat = array();
				foreach($item['param'] as $param){
					$this_cat[trim($param['name'])] = trim($param['name']);
				}
				
				$data['params'][(int)$item['category_id']] = $data['params'][(int)$item['category_id']]?array_merge($data['params'][(int)$item['category_id']], $this_cat):$this_cat;
				
				
				
			}
		}
	}
	
	//нужные библиотеки
	$data['load_lib'] = array('compare_');
?>
<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['content_page']['h1']?></h1>	
	
<div class="row category" style="padding-left: 4%; padding-right: 4%; min-height: 500px;" id="main_content">

	<?foreach($data['params'] as $key => $param){?>
		<div class="row col-md-3 col-xs-5 col-sm-3 col-lg-3" id="main_content_div">
			<ul class="collection with-header" style="width: 300px;">
				<li class="collection-header" style="height: 90px;"><h4>Параметры</h4></li>
				<li class="collection-item">Артикул</li>
				<?foreach($param as $key_param => $this_param){?>
					<li class="collection-item"><?=$key_param?></li>
				<?}?>
				<li class="collection-item">Цена</li>
			</ul>
		</div>
		<div class="row col-md-9 col-xs-7 col-sm-9 col-lg-9 items" id="main_content_div" style="flex-direction: row; justify-content: center; align-items: flex-start; display: -webkit-inline-box; overflow: overlay;">
			<?foreach($data['items'] as $item){?>
				<?if($item['category_id'] == $key){?>
					<ul class="collection with-header" style="width: 300px;">
						<div onclick="del_item_compare(<?=$item['id']?>)"><i class="fa fa-close"></i></div>
						<li class="collection-header"><?=$item['name']?></li>
						<li class="collection-item"><?=$item['art']?></li>
						
						<?foreach($param as $key_param => $this_param){
							$chek = false;
							foreach($item['param'] as $item_param){
								if(trim($item_param['name']) == trim($key_param)){
									$chek = true;
									?><li class="collection-item"><?=$item_param['value']?></li><?
								}
							}
							if(!$chek){
								?><li class="collection-item">-</li><?
							}
							
						}?>
						
						<?
							if($item['type_price'] == 2){//цена за 1ед
								if($item['sale_price'] > 0){
									$price_origin = $item['sale_price'];
								}else{
									$price_origin = $item['price'];
								}
							}else{
								$count = $site->find_count_in_item($site->get_list('params', $item['id'], 'item_id'));
										
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
						?>
						<li class="collection-item"><?=$price_origin?></li>
					</ul>
				<?}?>	
			<?}?>
		</div>
	<?}?>
</div>

<script>
	function del_item_compare(id){
		var keys = sessionStorage.keys?sessionStorage.keys:'';
		
		var this_keys = keys.split(','),
			tmp_keys = '';
		
		this_keys.map(function(key_item_id){
			if(key_item_id != id){
				tmp_keys += tmp_keys.length>0?','+key_item_id:key_item_id;
			}
		})
		
		tmp_keys = tmp_keys.length>0?tmp_keys:'0';
		
		sessionStorage.keys = tmp_keys;
		
		//if(sessionStorage.keys && sessionStorage.keys.length>0){
			location.href = "/sravnenie_tovarov&items="+sessionStorage.keys+"/";
		//}else{
			
		//}

	}
</script>
