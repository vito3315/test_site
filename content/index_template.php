<?
	include('./modul_site/logos.php');
	include('./modul_site/slider.php');
	
	if($data['type_pc'] != 'mobile'){
		if(empty($data['sub_cat_pages'] = $site->cash($data['this_page']['alias'].'_sub_cat_pages'))){
			$data['sub_cat_pages'] = $site->cash($data['this_page']['alias'].'_sub_cat_pages', $site->get_pages_from_category($data['this_page']['query']));
		}
	}
	
	if(empty($data['index_sale'] = $site->cash('last_update_index_'.$data['type_pc']))){
		$data['index_sale'] = $site->cash('last_update_index_'.$data['type_pc'], $site->get_last_update_sale($data['type_pc_с']));
	}
	
	if(empty($data['index_news'] = $site->cash('last_insert_index_'.$data['type_pc']))){
		$data['index_news'] = $site->cash('last_insert_index_'.$data['type_pc'], $site->get_last_insert($data['type_pc_с']));
	}
	
	/*if(empty($data['index_novosti'] = $site->cash('last_insert_novosti_'.$data['type_pc']))){
		$tmp = $site->get_query_list('SELECT * FROM news WHERE is_show=1 LIMIT '.$data['type_pc_с']);
		$date = strtotime(date('Y-m-d'));
	
		foreach($tmp as $item){
			if($item['date_end'] == 1 || strtotime($item['date_end']) > $date){
				$data['index_novosti'][] = $item;
			}
		}
	
		$data['index_novosti'] = $site->cash('last_insert_novosti_'.$data['type_pc'], $data['index_novosti']);
	}*/
	
	$data['load_lib'] = array('slick');
?>

<div class="row" style="padding-left: 4%; padding-right: 4%;" id="main_content">
	<?if($data['type_pc'] != 'mobile'){?>
		<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 hide-on-small-only" style="text-align: center;">
			<span class="h2" style="font-size: 3em;">Категории</span>
			<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" style="text-align: left;">
				<?foreach($data['sub_cat_pages'] as $item){?>
					<div class="card card_category hoverable col-md-4 col-xs-12 col-sm-6 col-lg-4">
						<a href="/<?=$item['alias']?>/">
							<div class="card-image waves-effect waves-block waves-light valign-wrapper loaderIMG">
								<img class="activator" src="<?=$data['img_src']?>" data-src="<?=$site->addr?>/img/category/<?=$item['cat_id']?>_min.jpg" alt="<?=$item['name']?>">
							</div>
							<div class="card-content center-align">
								<span class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
							</div>
						</a>	
					</div>
				<?}?>
			</div>
		</div>	
	<?}?>
	
	<?if(!empty($data['index_sale'])){?>
		<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="text-align: center;">	
			<span class="h2" style="font-size: 3em;">Распродажа</span>
			<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" style="text-align: left;">
				<?foreach($data['index_sale'] as $item){?>
					<div class="card items cards_item hoverable col-md-4 col-xs-12 col-sm-4 col-lg-3">
						<a href="<?=$site->addr?>/item/<?=$item['id']?>">
							<div class="card-image waves-effect waves-block waves-light valign-wrapper loaderIMG">
								<img class="activator" src="<?=$data['img_src']?>" data-src="<?=$site->addr?>/img/items/items_min/<?=$item['id']?>_main.jpg" alt="<?=$item['name']?>" onerror="this.src='<?=$site->addr?>/img/product-preview.png'">
							</div>
							<div class="card-content">
								<span class="grey-text text-darken-4 art">Арт.:<?=$item['art']?></span>
								<span class="divider"></span>
								<span class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
							</div>
						</a>	
						<span class="item_price"><?=number_format($item['price_origin'], 1, ',', '')?><i class="fa fa-rub"></i></span>	<span class="item_price_old"><?=number_format($item['price'], 1, ',', '')?><i class="fa fa-rub"></i></span>
						<div class="buttons">
							<button class="item_buy btn waves-effect waves-light tooltipped cd-add-to-cart" data-position="bottom" data-delay="10" data-tooltip="Добавить к корзину" data-price="<?=$item['price_origin']?>" data-name="<?=$item['name']?>" data-photo="<?=$site->addr?>/img/items/items_min/<?=$item['id']?>_main.jpg" data-id="<?=$item['id']?>">Купить</button>
							<button class="item_compare compare tooltipped z-depth-1" data-position="bottom" data-delay="10" data-tooltip="Добавить к сравнению" onclick="add_compare(<?=$item['id']?>)"><i class="fa fa-th-list"></i></button>
						</div>
					</div>
				<?}?>
				<div class="card items hoverable for_next col-md-4 col-xs-12 col-sm-4 col-lg-3">
					<a href="<?=$site->addr?>/akcii/">
						<div class="card-image waves-effect waves-block waves-light valign-wrapper">
							<i class="fa fa-arrow-right" aria-hidden="true"></i>
						</div>
					</a>	
					<div><a href="<?=$site->addr?>/akcii/" class="btn_count primary_ waves-effect waves-light">Смотреть далее</a></div>
				</div>
			</div>
		</div>
	<?}?>	
	
	<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="text-align: center;">
		<?if(!empty($data['index_news'])){?>
			<span class="h2" style="font-size: 3em;">Новые поступления</span>
			<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" style="text-align: left;">
				<?foreach($data['index_news'] as $item){?>
					<div class="card items cards_item hoverable col-md-4 col-xs-12 col-sm-4 col-lg-3">
						<a href="<?=$site->addr?>/item/<?=$item['id']?>">
							<div class="card-image waves-effect waves-block waves-light valign-wrapper loaderIMG">
								<img class="activator" src="<?=$data['img_src']?>" data-src="<?=$site->addr?>/img/items/items_min/<?=$item['id']?>_main.jpg" alt="<?=$item['name']?>" onerror="this.src='<?=$site->addr?>/img/product-preview.png'">
							</div>
							<div class="card-content">
								<span class="grey-text text-darken-4 art">Арт.:<?=$item['art']?></span>
								<span class="divider"></span>
								<span class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
							</div>
						</a>	
						<span class="item_price"><?=number_format($item['price_sale'], 1, ',', '')?><i class="fa fa-rub"></i></span> <?if($item['price_old'] > 0){?><span class="item_price_old"><?=number_format($item['price_old'], 1, ',', '')?><i class="fa fa-rub"></i></span><?}?>
						<div class="buttons">
							<button class="item_buy btn waves-effect waves-light tooltipped cd-add-to-cart" data-position="bottom" data-delay="10" data-tooltip="Добавить к корзину" data-price="<?=$item['price_sale']?>" data-name="<?=$item['name']?>" data-photo="<?=$site->addr?>/img/items/items_min/<?=$item['id']?>_main.jpg" data-id="<?=$item['id']?>">Купить</button>
							<button class="item_compare compare tooltipped z-depth-1" data-position="bottom" data-delay="10" data-tooltip="Добавить к сравнению" onclick="add_compare(<?=$item['id']?>)"><i class="fa fa-th-list"></i></button>
						</div>
					</div>
				<?}?>
				<div class="card items hoverable for_next col-md-4 col-xs-12 col-sm-4 col-lg-3">
					<a href="<?=$site->addr?>/novinki/">
						<div class="card-image waves-effect waves-block waves-light valign-wrapper">
							<i class="fa fa-arrow-right" aria-hidden="true"></i>
						</div>
					</a>	
					<div><a href="<?=$site->addr?>/novinki/" class="btn_count primary_ waves-effect waves-light">Смотреть далее</a></div>
				</div>
			</div>
		<?}?>	
			
		<h1 class="center-align" style="color: #fff;font-size: 3rem;"><?=$data['this_page']['h1']?></h1>	
		
		<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 card-panel" style="margin: 0px; text-align: left;" >
			<div class="col-md-8 col-xs-12 col-sm-12 col-lg-8" style="padding: 0;">
				<iframe src="https://www.google.com/maps/d/embed?mid=15ZxH4p7JmBa0W0xi4tk2mvYeGms" frameborder="0" id="map" style="width: 100%; height: 575px;"></iframe>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
				<div itemscope itemtype="http://schema.org/PostalAddress" class="vcard" style="color: #000;">
 
					<p><span class="category">Магазин</span> <span class="fn org" itemprop="name">"ООО Все для шиномонтажа+"</span></p>
					<div class="adr"><span class="locality" itemprop="addressLocality">Тольятти</span>, <span class="street-address" itemprop="streetAddress">Приморский бульвар 45</span></div>
					<div>
						<div>Телефоны:</div>
						<div style="padding-left: 20px;">
							<div>
								<br />
								Светлана - директор, бухгалтер
								<div style="padding-left: 20px;"><span itemprop="telephone">8 906 3398283</span></div>
								<div style="padding-left: 20px;"><span itemprop="telephone">(8482) 766-288</span></div>
							</div>
							<div>
								<br />
								Валерий - консультант, зам. директора
								<div style="padding-left: 20px;"><span class="tel" itemprop="telephone">8 903 3320510</span></div>
								<div style="padding-left: 20px;"><span class="tel" itemprop="telephone">(8482) 766-001</span></div>
							</div>
							<div>
								<br />
								Алексей - консультант, техник, ремонт оборудования, шиномонтаж
								<div style="padding-left: 20px;"><span itemprop="telephone">8 903 3330211</span></div>
							</div>
							<div>
								<br />
								Евгений - сбор заказов, доставка
								<div style="padding-left: 20px;"><span itemprop="telephone">8 906 3374631</span></div>
							</div>
						</div>
					</div>	
					<p>E-mail: <span class="email" itemprop="email">gva007@gmail.com</span></p>
					<div>
						<div>Skype: <a href="skype:tgva007?chat">tgva007</a></div>
						<br />
						<p>
							Мы работаем <span class="workhours">с понедельника по пятницу с 09:00 до 17:00, перерыв с 13:00 до 14:00</span>
							<span class="url">
								<span class="value-title" title="<?=$site->addr?>"> </span>
							</span>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?if($data['this_page']['content_before']){?>
	<div class="row" style="padding-left: 1%;padding-right: 1%;">
		<div class="card-panel" style="padding: 20px;">
			<span class="black-text text-darken-2"><?=$data['this_page']['content_before']?></span>
		</div>
	</div>	
<?}?>
