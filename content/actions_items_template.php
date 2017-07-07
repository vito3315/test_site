<?php
	if(empty($data['actions'] = $site->cash('items_action_page_'))){
		$data['actions'] = $site->cash('items_action_page_', $site->get_action_items());
	}
	
	//нужные библиотеки
	$data['load_lib'] = array('mixitup', 'lazyload_');
?>

<div class="white z-depth-1">
	<div style="width: 92%; margin-left: 4%; min-height: 56px;">
		<a class="btn-filtr z-depth-1" onclick="$('#filter').slideToggle()" style="margin-bottom: 10px; margin-top: 10px; float: right;">Фильтр</a>
		
		<form id="filter" style="display: none;">
			<span class="h5" style="padding: .82rem 0 .656rem; margin: 0;">Сортировать</span>
			<fieldset style="border: none;" data-filter-group>
				<span>по цене: </span>
				<a type="button" class="control" data-sort="price:desc"><i class="fa fa-sort-numeric-desc"></i></a> 
				<a type="button" class="control" data-sort="price:asc"><i class="fa fa-sort-numeric-asc"></i></a>
				
				<span>по алфавиту: </span>
				<a type="button" class="control" data-sort="name:desc"><i class="fa fa-sort-alpha-desc"></i></a>
				<a type="button" class="control" data-sort="name:asc"><i class="fa fa-sort-alpha-asc"></i></a>
			</fieldset>
			<?if(!empty($data['actions']['sub_cat_list'])){?>
				<span class="h5">По типу</span>
				<fieldset style="border: none;" data-filter-group>
					<?foreach($data['actions']['sub_cat_list'] as $item){?>
						<a type="button" class="control" data-toggle=".sub_id_<?=$item['id']?>"><?=$item['name']?></a>
					<?}?>	
				</fieldset>
			<?}?>
			<?if(!empty($data['actions']['this_cat_list'])){?>
				<span class="h5">По категориям</span>
				<fieldset style="border: none;" data-filter-group>
					<?foreach($data['actions']['this_cat_list'] as $item){?>
						<a type="button" class="control" data-toggle=".cat_id_<?=$item['id']?>"><?=$item['name']?></a>
					<?}?>	
				</fieldset>
			<?}?>
		</form>
	
	</div>		
</div>	

<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['this_page']['h1']?></h1>
	
<div class="row category" style="padding-left: 4%; padding-right: 4%; min-height: 500px;" id="items_category">
	<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12">
		<?foreach($data['actions']['items'] as $item){?>
			<div class="card items cards_item hoverable col-md-4 col-xs-12 col-sm-4 col-lg-3 mix <?=$item['subname']?> sub_id_<?=$item['subcategory_id']?> cat_id_<?=$item['category_id']?>" data-price="<?=$item['price']?>" data-name="<?=$item['name']?>">
				<a href="<?=$site->addr?>/item/<?=$item['id']?>">
					<div class="card-image waves-effect waves-block waves-light loaderIMG">
						<img class="activator" src="<?=$data['img_src']?>" data-src="<?=$site->addr?>/img/items/items_min/<?=$item['id']?>_main.jpg" alt="<?=$item['name']?>" onerror="this.src='<?=$site->addr?>/img/product-preview.png'">
					</div>
					<div class="card-content">
						<span class="grey-text text-darken-4 art">Арт.:<?=$item['art']?></span>
						<span class="divider"></span>
						<span class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
					</div>
				</a>	
				<span class="item_price"><?=number_format($item['price_origin'], 1, ',', '')?><i class="fa fa-rub"></i></span> <?if($item['price_old'] > 0){?><span class="item_price_old"><?=number_format($item['price_old'], 1, ',', '')?><i class="fa fa-rub"></i></span><?}?>
				<div class="buttons">
					<button class="item_buy btn waves-effect waves-light tooltipped cd-add-to-cart" data-position="bottom" data-delay="10" data-tooltip="Добавить к корзину" data-price="<?=$item['price_origin']?>" data-name="<?=$item['name']?>" data-photo="<?=$site->addr?>/img/items/items_min/<?=$item['id']?>_main.jpg" data-id="<?=$item['id']?>">Купить</button>
					<button class="item_compare compare tooltipped z-depth-1" data-position="bottom" data-delay="10" data-tooltip="Добавить к сравнению" onclick="add_compare(<?=$item['id']?>)"><i class="fa fa-th-list"></i></button>
				</div>
			</div>
		<?}?>
	</div>
</div>
