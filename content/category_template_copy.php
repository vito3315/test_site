<?php
	if(empty($data['sub_cat_pages'])){//если категорию
		$cat_id = $data['breadcrumbs']['parent']['cat_id']?$data['breadcrumbs']['parent']['cat_id']:$data['breadcrumbs']['main']['cat_id'];
		
		if(empty($cat = $site->cash('category_'.$cat_id))){
			$cat = $site->cash('category_'.$cat_id, $site->get_one('category', $cat_id));	
		}		
		
		$param1 = $cat['param1_name'];
		$param2 = $cat['param2_name'];
		
		if(empty($data['items'] = $site->cash('items_cat_id_'.$cat_id))){
			$data['items'] = $site->cash('items_cat_id_'.$cat_id, $site->get_list('items', $cat_id, 'category_id', '', 1));
		}
		
		//выделяем производителей
		if(empty($data['subname'] = $site->cash('items_subname_'.$cat_id))){
			$data['subname'] = array();
			
			foreach($data['items'] as $item){
				if(!empty($item['subname'])){
					$item['subname'] = str_replace(' ', '', $item['subname']);//убираем пробелы
					$data['subname'][$item['subname']] = $item['subname'];
				}	
			}
			
			krsort($data['subname']);
			
			$site->cash('items_subname_'.$cat_id, $data['subname']);
		}
		//
		
		//выделяем типы
		if(empty($data['sub_cat_list'] = $site->cash('sub_cat_list_'.$cat_id))){
			$data['sub_category_list'] = $site->cash('subcategory', $site->get_list('subcategory'));
			
			$data['sub_cat_list'] = array();
			
			foreach($data['items'] as $item){
				foreach($data['sub_category_list'] as $cat){
					if($cat['id'] == $item['subcategory_id']){
						$data['sub_cat_list'][$item['subcategory_id']] = array('name'=>$cat['name'], 'id'=>$cat['id']);
					}
				}
			}
			
			$site->cash('sub_cat_list_'.$cat_id, $data['sub_cat_list']);			
		}	
		//
		
		//нужные библиотеки
		$data['load_lib'] = array('mixitup');
		
	}
	//если товар
	$data['load_lib'] = array('items', 'mixitup_', 'lazyload');
	
?>

<?if(empty($data['sub_cat_pages'])){?> 
	<div class="white z-depth-1">
		<div style="width: 92%; margin-left: 4%; min-height: 56px;">
			<a class="btn-filtr z-depth-1" onclick="$('#filter').slideToggle()" style="margin-bottom: 10px; margin-top: 10px; float: right;">Фильтр</a>
			
			<form id="filter" style="">
				<span class="h5" style="padding: .82rem 0 .656rem; margin: 0;">Сортировать</span>
				<fieldset style="border: none;" data-filter-group>
					<span>по цене: </span>
					<a type="button" class="control" data-sort="price:desc"><i class="fa fa-sort-numeric-desc"></i></a> 
					<a type="button" class="control" data-sort="price:asc"><i class="fa fa-sort-numeric-asc"></i></a>
					
					<span>по алфавиту: </span>
					<a type="button" class="control" data-sort="name:desc"><i class="fa fa-sort-alpha-desc"></i></a>
					<a type="button" class="control" data-sort="name:asc"><i class="fa fa-sort-alpha-asc"></i></a>
				</fieldset>

				<?if(!empty($data['subname'])){?>
					<span class="h5">По производителю</span>	
					<fieldset style="border: none;" data-filter-group>
						<?foreach($data['subname'] as $item){?>
							<a type="button" class="control" data-toggle=".<?=$item?>"><?=$item?></a>
						<?}?>	
					</fieldset>
				<?}?>
				
				<?if(!empty($data['sub_cat_list'])){?>
					<span class="h5">По типу</span>
					<fieldset style="border: none;" data-filter-group>
						<?foreach($data['sub_cat_list'] as $item){?>
							<a type="button" class="control" data-toggle=".sub_id_<?=$item['id']?>"><?=$item['name']?></a>
						<?}?>	
					</fieldset>
				<?}?>
			</form>
		</div>		
	</div>	
<?}?>
	
	
<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['content_page']['h1']?></h1>	
	
<div class="row category" style="padding-left: 4%; padding-right: 4%; min-height: 500px;" id="main_content">
	
	<?if(!empty($data['content_page']['content_after'])){?>
		<div class="row" style="padding: 0 15px; margin-top: 15px;">
			<div style="">
				<span class="white-text text-darken-2" style="font-size: 1.3em;"><?=$data['content_page']['content_after']?></span>
			</div>	
		</div>
	<?}?>
	
	<?if(empty($data['sub_cat_pages'])){?>
		<div style="padding: 15px;">
			<span class="sb-icon-search_items" onclick="res_fast_search()"><i class="fa fa-close" style="font-size:1.5em;"></i></span>
			<input class="sb-search-input-items" placeholder="Быстрый поиск товаров в текущей категории" type="text" name="search" id="search_items">
		</div>
	<?}?>	
	
	<items></items>
	
	<script type="riot/tag">
		<items>		
			<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" id="items_category_" style="display: none;">
		
				<div each={ opts.data } class="this_items thisId_{id} card items hoverable col-md-4 col-xs-12 col-sm-4 col-lg-3 mix {subname_} sub_id_{subcategory_id}" data-price="{price_origin}" data-name="{name}" data-art="{art}" data-id="{id}">
					<a href="{url}/item/{id}" style="color: #000">
						<img if={sale_price != 0} style="width: 120px;position: absolute;z-index: 99999;left: -11px;top: -8px;" src="{url}/img/other_mages/akcia.png">
						<div class="card-image waves-effect waves-block waves-light valign-wrapper">
							<img class="activator" src="{url}/img/items/{id}_main.jpg" style="max-width: 100%; max-height: 100%;">
						</div>
						<div class="card-content">
							<div style="min-height: 54px;">
								<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;">Арт.:{art}</span>
								<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;">{p1}</span>
								<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;">{p2}</span>
							</div>
							<span class="divider" style="width: 100%; float: left; margin-bottom: 7px;"></span>
							<span class="card-title activator grey-text text-darken-4" style="line-height: 0px;font-size: 1.2em;">{name}</span>
						</div>
					</a>	
					
					<span class="item_price">{price_origin}<i class="fa fa-rub"></i></span> <span if={price_old>0} class="item_price_old">{price_old}<i class="fa fa-rub"></i></span>
					<div style="position: absolute; bottom: 0px; width: 100%; left: 0px; padding: 10px;">
						<button class="item_buy btn waves-effect waves-light tooltipped cd-add-to-cart" data-position="bottom" data-delay="10" data-tooltip="Добавить к корзину" data-price="{price_origin}" data-name="{name}" data-photo="{url}/img/items/{id}_main.jpg" data-id="{id}">Купить</button>
						<button class="item_compare compare tooltipped z-depth-1" data-position="bottom" data-delay="10" data-tooltip="Добавить к сравнению" onclick="add_compare({id})"><i class="fa fa-th-list"></i></button>
					</div>
				</div>	
			
			</div>	
			this.url = opts.url;
		</items>
		
	</script>

	<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" id="items_category">
		<?
			if(empty($data['sub_cat_pages'])){//показываем товары
				foreach($data['items'] as $item){
					$price_old = 0;
					if($item['type_price'] == 2){//цена за 1ед
						if($item['sale_price'] > 0){
							$price_origin = $item['sale_price'];
							$price_old 	  = $item['price'];
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
							$price_old = $item['price'];
						}else{
							if($count){
								$price_origin = $item['price']/$count;
							}else{
								$price_origin = $item['price'];
							}	
						}
					}	
					
					?>
						<div class="this_items thisId_<?=$item['id']?> card items hoverable col-md-4 col-xs-12 col-sm-4 col-lg-3 mix <?=str_replace(' ', '', $item['subname'])?> sub_id_<?=$item['subcategory_id']?>" data-price="<?=$item['price']?>" data-name="<?=$item['name']?>" data-art="<?=$item['art']?>" data-id="<?=$item['id']?>">
							<a href="<?=$site->addr?>/item/<?=$item['id']?>" style="color: #000">
								<?if($item['sale_price'] != 0){?><img style="width: 120px;position: absolute;z-index: 99999;left: -11px;top: -8px;" src="<?=$site->addr?>/img/other_mages/akcia.png"><?}?>
								<div class="card-image waves-effect waves-block waves-light valign-wrapper">
									<img class="lazy activator" data-original="<?=$site->addr?>/img/items/<?=$item['id']?>_main.jpg" style="max-width: 100%; max-height: 100%;">
								</div>
								<div class="card-content">
									<div style="min-height: 54px;">
										<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;">Арт.:<?=$item['art']?></span>
										<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;"><?=$site->find_param_by_name($param1, $item['id'])?></span>
										<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;"><?=$site->find_param_by_name($param2, $item['id'])?></span>
									</div>
									<span class="divider" style="width: 100%; float: left; margin-bottom: 7px;"></span>
									<span class="card-title activator grey-text text-darken-4" style="line-height: 0px;font-size: 1.2em;"><?=$item['name']?></span>
								</div>
							</a>	
							
							<span class="item_price"><?=number_format($price_origin, 1, ',', '')?><i class="fa fa-rub"></i></span> <?if($price_old > 0){?><span class="item_price_old"><?=number_format($price_old, 1, ',', '')?><i class="fa fa-rub"></i></span><?}?>
							<div style="position: absolute; bottom: 0px; width: 100%; left: 0px; padding: 10px;">
								<button class="item_buy btn waves-effect waves-light tooltipped cd-add-to-cart" data-position="bottom" data-delay="10" data-tooltip="Добавить к корзину" data-price="<?=$price_origin?>" data-name="<?=$item['name']?>" data-photo="<?=$site->addr?>/img/items/<?=$item['id']?>_main.jpg" data-id="<?=$item['id']?>">Купить</button>
								<button class="item_compare compare tooltipped z-depth-1" data-position="bottom" data-delay="10" data-tooltip="Добавить к сравнению" onclick="add_compare(<?=$item['id']?>)"><i class="fa fa-th-list"></i></button>
							</div>
						</div>
						
						
					<?
				}
				
				?>
					<div class="row" style="padding: 0 15px; margin-top: 15px; display: none;" id="items_not_found">
						<div style="">
							<span class="white-text text-darken-2" style="font-size: 1.3em;">По запросу ничего не найдено</span>
						</div>	
					</div>
				<?
				
			}else{//показываем категории
				foreach($data['sub_cat_pages'] as $item){
					?>
						<div class="card card_category col-md-4 col-xs-12 col-sm-6 col-lg-4">
							<a href="<?=$site->get_full_uri().$item['alias']?>/" style="color: #000">
								<div class="card-image waves-effect waves-block waves-light valign-wrapper">
									<img class="activator" style="max-width: 100%; max-height: 100%;" src="<?=$site->addr?>/img/category/<?=$item['cat_id']?>_min.jpg">
								</div>
								<div class="card-content center-align">
									<span style="font-weight: 500;" class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
								</div>
							</a>	
						</div>
					<?
				}
			}	
		?>
	</div>
	
	<div class="mixitup-page-list"></div>
	<div class="mixitup-page-stats"></div>
	
	<?if(!empty($data['content_page']['content_before'])){?>
		<div class="row" style="padding: 0 15px; margin-top: 15px;">
			<div style="">
				<span class="white-text text-darken-2" style="font-size: 1.3em;"><?=$data['content_page']['content_before']?></span>
			</div>	
		</div>
	<?}?>
	
</div>

<script>
	function res_fast_search(){
		$('.toHide').removeClass('toHide');
		$('#search_items').val("");
	}	
</script>
