<?$data['load_lib'] = array('magnific', 'stat_');?>
<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['this_item']['item']['name']?></h1>	
<div class="row item_template" style="padding-left:4%;padding-right:4%;margin-top: 15px;">
	<div class="row card-panel">
		
		<div itemscope itemtype="https://schema.org/Product">
			<meta itemprop="name" content="<?=$data['this_item']['item']['name']?>" />
			<link itemprop="url" href="<?=$site->addr?>/item/<?=$data['this_item']['item']['id']?>" />
			<link itemprop="image" href="<?=$site->addr?>/img/items/<?=$data['this_item']['item']['id']?>_main.jpg" />
			<meta itemprop="brand" content="<?=$data['this_item']['item']['subname']?>" />
			<meta itemprop="model" content="<?=$data['this_item']['item']['art']?>" />
			<meta itemprop="category" content="<?=$site->get_one('category', $data['this_item']['item']['category_id'])['name']?>" />
			<div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
				<meta itemprop="priceCurrency" content="RUB" />
				<meta itemprop="price" content="<?=$data['this_item']['item']['sale_price']?$data['this_item']['item']['sale_price']:$data['this_item']['item']['price']?>" />
				<link itemprop="availability" href="https://schema.org/InStock" />
			</div>
			<meta itemprop="description" content="<?=$data['this_item']['item']['description']?>" />
		</div>
		
		<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
			<div class="col-md-7 col-xs-12 col-sm-12 col-lg-7">
				<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 p0">
					<div class="popup-gallery valign-wrapper col-md-12 col-xs-12 col-sm-12 col-lg-12 p0 i0">
						<div class="valign">
							<a href="<?=$site->addr?>/img/items/<?=$data['this_item']['item']['id']?>_main.jpg" class="loaderIMG">
								<img src="<?=$data['img_src']?>" data-src="<?=$site->addr?>/img/items/<?=$data['this_item']['item']['id']?>_main.jpg" alt="<?=$data['this_item']['item']['name']?>">
							</a>
						</div>
					</div>
					<?if(count($data['this_item']['item']['photos'])>1){?>
						<div class="popup-gallery valign-wrapper col-md-12 col-xs-12 col-sm-12 col-lg-12 p0 i_">
							<?foreach($data['this_item']['photos'] as $item){?>
								<div class="valign col-md-4 col-xs-12 col-sm-6 col-lg-4">
									<a href="<?=$site->addr?>/img/items/<?=$item['name']?>" class="loaderIMG">
										<img src="<?=$data['img_src']?>" data-src="<?=$site->addr?>/img/items/<?=$item['name']?>" style="max-width:180px; max-height: 100px;">
									</a>
								</div>
							<?}?>
						</div>
					<?}?>
				</div>	
			</div>
			<div class="col-md-5 col-xs-12 col-sm-12 col-lg-5" style="margin-top: 20px; padding: 0px; margin-bottom: 10px;">
				<span style="text-align: right; width: 100%; float: left;position: absolute;">артикул: <?=$data['this_item']['item']['art']?></span>
				<?if($data['this_item']['item']['sale_price']){?><span style="font-size: 1.6em; text-decoration: line-through; font-family: 'a_Stamper Bold', arial;"><?=$data['this_item']['item']['price_origin']?><i class="fa fa-rub"></i></span><?}?>
				<span style="font-size: 2.3em; float: right; width: 100%; font-family: 'a_Stamper Bold', arial;"><?=$data['this_item']['item']['price_sale']?><i class="fa fa-rub"></i></span>
				<?if($data['this_item']['item']['type_price'] == 2 && $data['this_item']['item']['count_']){?><div><span>Цена указана за 1ед.</span></div><?}?>
				<?if($data['this_item']['item']['count_'] && $data['this_item']['item']['type_price'] != 2){?><span style="float: right; width: 100%;">Цена за 1шт: <span style="font-size: 1.6em; float: right; width: 100%; font-family: 'a_Stamper Bold', arial;"><span><?=number_format($data['this_item']['item']['price_one'], 1, ',', '')?></span><i class="fa fa-rub"></i></span></span><?}?>
				<hr />
				<a style="width: 100%;" class="btn waves-effect waves-light tooltipped cd-add-to-cart" data-position="bottom" data-delay="10" data-tooltip="Добавить к корзину" data-price="<?=$data['this_item']['item']['price_one']?$data['this_item']['item']['price_one']:$data['this_item']['item']['price_sale']?>" data-name="<?=$data['this_item']['item']['name']?>" data-photo="<?=$site->addr?>/img/items/<?=$data['this_item']['item']['id']?>_main.jpg" data-id="<?=$data['this_item']['item']['id']?>">Купить</a>
				<button class="btn_count <?=$data['this_item']['item']['count_color']?>" style="width: 100%;margin-top: 10px;"><?=$data['this_item']['item']['count_title']?></button>
				<?if($data['this_item']['item']['href']){?><a rel="nofollow" target="_blank" class="btn_count green_" style="width: 100%;margin-top: 10px;" href="<?=$data['this_item']['item']['href']?>">Посмотреть на сайте производителя</a><?}?>
			</div>

			<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
			<script src="//yastatic.net/share2/share.js"></script>
			<div class="ya-share2" data-services="vkontakte,facebook,gplus,twitter,viber,whatsapp,skype,telegram" data-counter=""></div>
			
			<?if(!empty($data['this_item']['item']['param_1'])){?>
				<div class="col-md-10 col-xs-12 col-sm-12 col-lg-10 col-md-offset-1 col-lg-offset-1" style="padding: 0px; padding-bottom: 20px;">
					<h5 class="center-align" style="color: #111!important;">Характеристики</h5>
					<table class="striped" style="font-size: 1.3em;">
						<tbody>
							<?foreach($data['this_item']['item']['param_1'] as $item){?>
								<?if(!empty($item['value'])){?>
									<tr>
										<td><?=$item['name']?></td>
										<td><?=$item['value']?></td>
									</tr>
								<?}?>	
							<?}?>
						</tbody>
					</table>		
				</div>
			<?}?>
	
			<?if(!empty($data['this_item']['item']['description'])){?>
				<div class="col-md-10 col-xs-12 col-sm-12 col-lg-10 col-md-offset-1 col-lg-offset-1" style="font-size: 1.3em; padding: 0px!important;">
					<h5 class="center-align" style="color: #111!important;">Описание</h5>
					<?=$data['this_item']['item']['description']?>
				</div>
			<?}?>
			
			<?if(!empty($data['this_item']['item']['param_2'])){?>
				<div class="col-md-10 col-xs-12 col-sm-12 col-lg-10 col-md-offset-1 col-lg-offset-1" style="padding: 0px; padding-bottom: 20px;">
					<h5 class="center-align" style="color: #111!important;">Комплектация</h5>
					<table class="striped" style="font-size: 1.3em;">
						<tbody>
							<?foreach($data['this_item']['item']['param_2'] as $item){?>
								<tr>
									<td style="width: 70%; padding-left: 1em;"><?=$item['name']?></td>
									<td><?=$item['value']?></td>
								</tr>
							<?}?>
						</tbody>
					</table>		
				</div>
			<?}?>
		</div>	
	</div>
	
	<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="text-align: center; margin-top: 20px;">
		<span class="h2" style="font-size: 3em;">Вас также может заинтересовать</span>
		<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" style="text-align: left;">
			<?foreach($data['this_item']['interesting'] as &$item){?>
				<?
					$price_old = 0;
					if($item['type_price'] == 2){//цена за 1ед
						if($item['sale_price'] > 0){
							$price_origin 	= $item['sale_price'];
							$price_old 		= $item['price'];
						}else{
							$price_origin 	= $item['price'];
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
					
					$item['count_'] = $count;
					$item['price_origin'] = $price_origin;
					$item['price_old'] = $price_old;
				
				?>
			
			
				<div class="card items cards_item hoverable col-md-4 col-xs-12 col-sm-4 col-lg-3">
					<a href="<?=$site->addr?>/item/<?=$item['id']?>">
						<?if($item['sale_price']!=0){?><img style="width: 120px;position: absolute;z-index: 99999;left: -11px;top: -8px;" src="<?=$site->addr?>/img/other_mages/akcia.png"><?}?>
						<div class="card-image waves-effect waves-block waves-light valign-wrapper loaderIMG">
							<img src="<?=$data['img_src']?>" class="activator" data-src="<?=$site->addr?>/img/items/items_min/<?=$item['id']?>_main.jpg" alt="<?=$item['name']?>" onerror="this.src='<?=$site->addr?>/img/product-preview.png'">
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
						<button class="item_compare compare tooltipped z-depth-1" data-position="bottom" data-delay="10" data-tooltip="Добавить к сравнению"><i class="fa fa-th-list"></i></button>
					</div>
				</div>
			<?}?>
		</div>	
	</div>	
</div>

