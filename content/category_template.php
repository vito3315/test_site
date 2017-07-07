<?php

	if(empty($data['sub_category'] = $site->cash('sub_category_'.$data['this_page']['query']))){
		$data['sub_category'] = $site->cash('sub_category_'.$data['this_page']['query'], $site->get_pages_from_category($data['this_page']['query']));
	}

	$data['sub_cat'] = $site->get_list('subcategory');
	$data['items_for_filtr'] = $site->get_query_list("SELECT i.subname, i.subcategory_id sc_id FROM items i WHERE i.category_id='".$data['this_page']['query']."' AND i.is_show=1");
	
	foreach($data['items_for_filtr'] as &$item){
		foreach($data['sub_cat'] as $cat){
			if($item['sc_id'] == $cat['id']){
				$item['name'] = $cat['name'];
			}
		}
	}
	
	//выделяем производителей
	if(empty($data['subname'] = $site->cash('items_subname_'.$data['this_page']['query']))){
		$data['subname'] = array();
		
		foreach($data['items_for_filtr'] as &$item){
			if(!empty($item['subname'])){
				$item['subname'] = str_replace(' ', '', $item['subname']);//убираем пробелы
				$data['subname'][$item['subname']] = $item['subname'];
			}	
		}
		
		krsort($data['subname']);
		
		$site->cash('items_subname_'.$cat_id, $data['subname']);
	}
	
	//выделяем типы
	if(empty($data['sub_cat_list'] = $site->cash('sub_cat_list_'.$data['this_page']['query']))){
		$data['sub_cat_list'] = array();
		foreach($data['items_for_filtr'] as &$item){
			if(!empty($item['name'])){
				$data['sub_cat_list'][$item['sc_id']] = array('name'=>$item['name'], 'id'=>$item['sc_id']);
			}	
		}
		
		$site->cash('sub_cat_list_'.$cat_id, $data['sub_cat_list']);			
	}	
	
	if(empty($data['sub_category'])){
		$data['load_lib'] = array('items');
	}
?>

<?if(empty($data['sub_category'])){?> 
	<div class="white z-depth-1">
		<div style="width:92%;margin-left:4%;min-height:56px;">
			<a class="btn-filtr z-depth-1" onclick="$('#filter').slideToggle()" style="margin-bottom:10px;margin-top:10px;float:right;">Фильтр</a>
			
			<form id="filter" style="padding-top:10px;">
				<span class="h5">Сортировать</span>
				<fieldset style="border:none;" data-filter-group>
					<span>по цене: </span>
					<a class="control" data-sort="price:desc"><i class="fa fa-sort-numeric-desc"></i></a> 
					<a class="control" data-sort="price:asc"><i class="fa fa-sort-numeric-asc"></i></a>
					
					<span>по алфавиту: </span>
					<a class="control" data-sort="name:desc"><i class="fa fa-sort-alpha-desc"></i></a>
					<a class="control" data-sort="name:asc"><i class="fa fa-sort-alpha-asc"></i></a>
				</fieldset>

				<?if(!empty($data['subname'])){?>
					<span class="h5">По производителю</span>	
					<fieldset style="border:none;" data-filter-group>
						<?foreach($data['subname'] as $item){?>
							<a class="control" data-toggle=".<?=$item?>"><?=$item?></a>
						<?}?>	
					</fieldset>
				<?}?>
				
				<?if(!empty($data['sub_cat_list'])){?>
					<span class="h5">По типу</span>
					<fieldset style="border:none;" data-filter-group>
						<?foreach($data['sub_cat_list'] as $item){?>
							<a class="control" data-toggle=".sub_id_<?=$item['id']?>"><?=$item['name']?></a>
						<?}?>	
					</fieldset>
				<?}?>
			</form>
		</div>		
	</div>	
<?}?>
	
<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['this_page']['h1']?></h1>	
	
<div class="row category" style="padding-left: 4%; padding-right: 4%; min-height: 500px;" id="main_content">
	
	<?if(!empty($data['this_page']['content_after'])){?>
		<div class="row" style="padding: 0 15px; margin-top: 15px;">
			<div class="white-text text-darken-2" style="font-size: 1.3em;"><?=$data['this_page']['content_after']?></div>
		</div>
	<?}?>
	
	<?if(empty($data['sub_category'])){?>
		<div style="padding: 15px; height: 64px; margin-top: -76px; margin-bottom: 90px;">
			<span class="sb-icon-search_items" onclick="res_fast_search()"><i class="fa fa-close" style="font-size:1.5em;"></i></span>
			<input class="sb-search-input-items" placeholder="Быстрый поиск товаров в текущей категории" type="text" name="search" id="search_items">
		</div>
	<?}?>	
	
	<?if(empty($data['sub_category'])){?>
		<items></items>
		<script type="riot/tag">
			<items>		
				<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" id="items_category_">
			
					<div each={ opts.data } class="this_items cards_item thisId_{id} card items hoverable col-md-4 col-xs-12 col-sm-4 col-lg-3 mix {subname_} sub_id_{subcategory_id}" data-price="{price_origin}" data-name="{name}" data-art="{art}" data-id="{id}">
						<a href="{url}/item/{id}" style="color: #000">
							<img if={sale_price != 0} style="width: 120px;position: absolute;z-index: 99999;left: -11px;top: -8px;" src="{url}/img/other_mages/akcia.png">
							<div class="card-image waves-effect waves-block waves-light valign-wrapper">
								<img class="activator" src="{url}/img/items/items_min/{id}_main.jpg" onerror = "this.src='{url}/img/product-preview.png'">
							</div>
							<div class="card-content">
								<div style="min-height: 54px;">
									<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;">Арт.:{art}</span>
									<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;">{p1}</span>
									<span class="grey-text text-darken-4" style="width: 100%; float: left; font-size: 0.85em;">{p2}</span>
								</div>
								<span class="divider"></span>
								<span class="card-title activator grey-text text-darken-4">{name}</span>
							</div>
						</a>	
						
						<span class="item_price">{price_origin_}<i class="fa fa-rub"></i></span> <span if={price_old>0} class="item_price_old">{price_old_}<i class="fa fa-rub"></i></span>
						<div class="buttons">
							<button class="item_buy btn waves-effect waves-light tooltipped cd-add-to-cart" data-position="bottom" data-delay="10" data-tooltip="Добавить к корзину" data-price="{price_origin}" data-name="{name}" data-photo="{url}/img/items/items_min/{id}_main.jpg" data-id="{id}">Купить</button>
							<button class="item_compare compare tooltipped z-depth-1" data-position="bottom" data-delay="10" data-tooltip="Добавить к сравнению" onclick="add_compare({id})"><i class="fa fa-th-list"></i></button>
						</div>
					</div>	
				
				</div>	
				this.url = opts.url;
			</items>
			
		</script>
	<?}?>
		
	<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" id="items_category">
		<?if(empty($data['sub_category'])){?>
			<div class="row" style="padding: 0 15px; margin-top: 15px; display: none;" id="items_not_found">
				<div style="">
					<span class="white-text text-darken-2" style="font-size: 1.3em;">По запросу ничего не найдено</span>
				</div>	
			</div>
		<?}else{?>
			<?foreach($data['sub_category'] as $item){?>
				<div class="card card_category col-md-4 col-xs-12 col-sm-6 col-lg-4">
					<a href="<?=$site->get_full_uri().$item['alias']?>/" style="color: #000">
						<div class="card-image waves-effect waves-block waves-light valign-wrapper loaderIMG">
							<img class="activator" src="<?=$data['img_src']?>" data-src="<?=$site->addr?>/img/category/<?=$item['cat_id']?>_min.jpg" alt="<?=$item['name']?>">
						</div>
						<div class="card-content center-align">
							<span style="font-weight: 500;" class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
						</div>
					</a>	
				</div>
			<?}?>
		<?}?>	
	</div>
	
	<div class="mixitup-page-list"></div>
	<div class="mixitup-page-stats"></div>
	
	<?if(!empty($data['this_page']['content_before'])){?>
		<div class="row" style="padding: 0 15px; margin-top: 15px;">
			<div class="white-text text-darken-2" style="font-size: 1.3em;"><?=$data['this_page']['content_before']?></div>
		</div>
	<?}?>	
</div>

<script>
	function res_fast_search(){
		$('.toHide').removeClass('toHide');
		$('#search_items').val("");
	}	
</script>
