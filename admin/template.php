<?php
	session_start();
	
	if(!$site->check_adm()){
		include($site->addr.'/admin/login.php');
		die();
	}
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<link href="<?=$site->addr?>/admin/css/semantic.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<link href="<?=$site->addr?>/admin/css/dropzone.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<link href="<?=$site->addr?>/css/font-awesome.css" type="text/css" rel="stylesheet" />
		<link href="<?=$site->addr?>/css/datatable/jquery.dataTables.min.css" type="text/css" rel="stylesheet" />		
		<link href="<?=$site->addr?>/css/datatable/dataTables.semanticui.min.css" type="text/css" rel="stylesheet" />	
		
		<script src="<?=$site->addr?>/admin/js/jquery-3.1.1.min.js"></script>
		<script src="<?=$site->addr?>/admin/js/semantic.min.js"></script>
		<script src="<?=$site->addr?>/admin/ckeditor/ckeditor.js"></script>
		<script src="<?=$site->addr?>/admin/js/jquery.tablednd.js"></script>
		<script src="<?=$site->addr?>/admin/js/dropzone.js"></script>
		<script src="<?=$site->addr?>/js/datatable/jquery.dataTables.min.js"></script>
		
		<script src="http://chartonline.rossvik63.ru/api/chart.js"></script>
		
		<style>
			h1{ color: #fff; }
			.ui.menu .pointing.dropdown.item .menu{ margin-top: 0px; }
			
			.ui.menu > .item{ justify-content: center; font-size: 1.3em; font-weight: 700; }
			
			#page_list_length{ display: none; }
			#page_list_info{ color: #fff; }
			.dataTables_wrapper .dataTables_paginate .paginate_button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active{color:#fff!important;}
			.dataTables_wrapper .dataTables_paginate .paginate_button{color:#fff!important;}
			#page_list_filter{ margin-bottom: 10px; }
			#page_list_filter > label{ color:#fff; }
			#page_list_filter > label > input{ color:#333; }
			.ui.tabular.menu .item{ color:#fff; }
			.ui.tabular.menu .item:hover{ color:#f3f3f3; }
			.ui.menu .active.item:hover, .ui.vertical.menu .active.item:hover{color:#333;}
			.field > label{ color: #fff!important; }
			.checkbox > label{ color: #fff!important; }
			table .checkbox > label{ color: #333!important; }
			.tabs .field > label{ color: #333!important; }
			
			.header_menu{
				margin-bottom: 0px !important;
				position: fixed !important;
				width: 100% !important;
				z-index: 9999999 !important;
				top: 0px !important;
				border-top-left-radius: 0px !important;
				border-top-right-radius: 0px !important;
				border-top: none !important;
			}
			.body_menu{
				min-height: 100% !important;
				padding-left: 15px !important;
				padding-right: 15px !important;
				padding-top: 62px !important;
			}
			
			.ui.bottom.attached.tab.segment label{ color: #333!important; }
			
		</style>
	</head>
	<body>
		<div class="ui menu grid header_menu">
			<div class="item three wide column">
				<a href="<?=$site->addr?>/admin/modules/page_list/"><img src="<?=$site->addr?>/img/other_mages/main_logo3_new.png" style="width: 100%;"></a>
			</div>
			
			<div class="item one wide column">
				<div class="ui icon" data-tooltip="Сбросить кеш" data-position="bottom left" style="cursor: pointer;" onclick="clear_cash()">
					<i class="fa fa-refresh fa-2x" aria-hidden="true"></i>
				</div>
			</div>
			<div class="item one wide column">
				<div class="ui icon" data-tooltip="Обновить карту сайта (sitemap.xml)" data-position="bottom left" style="cursor: pointer;" onclick="cerate_sitemap()">
					<i class="fa fa-sitemap fa-2x" aria-hidden="true"></i>
				</div>
			</div>
			<div class="item one wide column">
				<div class="ui icon" data-tooltip="Обновить ценники из выгрузки 1с" data-position="bottom left" style="cursor: pointer;" onclick="update_price()">
					<i class="fa fa-rub fa-2x" aria-hidden="true"></i>
				</div>
			</div>
			<div class="item one wide column">
				<a class="ui icon" data-tooltip="Настройки сайта" data-position="bottom left" style="cursor: pointer; color:#333;" href="/admin/modules/setting/">
					<i class="fa fa-cog fa-2x" aria-hidden="true"></i>
				</a>
			</div>
			<div class="item one wide column">
				<a class="ui icon" data-tooltip="Заказы" data-position="bottom left" style="cursor: pointer; color:#333;" href="/admin/modules/order/">
					<i class="fa fa-first-order fa-2x" aria-hidden="true"></i>
				</a>
			</div>
			<div class="ui pointing dropdown link item one wide column">
				<a class="ui icon" data-tooltip="Новости" data-position="bottom left" style="cursor: pointer; color:#333;" href="#!">
					<i class="fa fa-newspaper-o fa-2x" aria-hidden="true"></i>
				</a>
				<i class="dropdown icon"></i>
				<div class="menu">
					<a class="item" href="/admin/modules/news_list/">Список</a>
					<a class="item" href="/admin/modules/news_add/">Добавить</a>
				</div>
			</div>
			<div class="ui pointing dropdown link item one wide column">
				<div class="ui icon" data-tooltip="Страницы" data-position="bottom left" style="cursor: pointer;">
					<i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i>
				</div>
				<i class="dropdown icon"></i>
				<div class="menu">
					<a class="item" href="/admin/modules/page_list/">Список</a>
					<a class="item" href="/admin/modules/page_add/">Добавить</a>
				</div>
			</div>
			<div class="item one wide column">
				<a class="ui icon" data-tooltip="Статистика" data-position="bottom left" style="cursor: pointer; color:#333;" href="/admin/modules/stat/">
					<i class="fa fa-star fa-2x" aria-hidden="true"></i>
				</a>
			</div>
			<div class="ui pointing dropdown link item one wide column">
				<a class="ui icon" data-tooltip="Товары" data-position="bottom left" style="cursor: pointer; color:#333;" href="#!">
					<i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
				</a>
				<i class="dropdown icon"></i>
				<div class="menu">
					<a class="item" href="/admin/modules/item_list/">Список</a>
					<a class="item" href="/admin/modules/item_add/">Добавить</a>
				</div>
			</div>
			<div class="ui pointing dropdown link item two wide column">
				<span class="text">Категории</span>
				<i class="dropdown icon"></i>
				<div class="menu">
					<a class="item" href="/admin/modules/category_list/">Список</a>
					<a class="item" href="/admin/modules/category_add/">Добавить</a>
				</div>
			</div>
			<div class="ui pointing dropdown link item two wide column">
				<span class="text">Слайдер</span>
				<i class="dropdown icon"></i>
				<div class="menu">
					<a class="item" href="/admin/modules/slider_list/">Список</a>
					<a class="item" href="/admin/modules/slider_add/">Добавить</a>
				</div>
			</div>
		</div>
		
		<div class="ui grid body_menu" style="background-image: url(<?=$site->addr?>/css/img/background_img/1-fon-dlya-sayta.png);">
			<div class="sixteen wide column" >
				<!-- Контент -->
				<?include($data['content'])?>
				<!-- /Контент -->
			</div>
		</div>
		
		<!-- Modal dialog -->
		<div class="ui basic modal" id="modal_dialog" style="font-size: 2em; text-align: center;">
			<div class="ui icon header" id="modal_header"></div>
			<div class="content">
				<p id="modal_text"></p>
			</div>
			<div class="actions">
				<div class="ui green ok inverted button">
					<i class="checkmark icon"></i>
					Хорошо
				</div>
			</div>
		</div>
		<!-- -->		
		
		<script>
			function clear_cash(){
				$.ajax({
					url: "/admin/modules/php/route.php",
					data: {type: 'clear_cash'},
					type: 'POST',
					cache: false,
					success: function(data) {
						console.log(data)
						if(data.trim() == 'true'){
							$('#modal_header').text('Очистка кеша')
							$('#modal_text').text('Кеш очишен')
							$('#modal_dialog').modal('show')
						}
					}.bind(this)
				});
			}
			
			function update_price(){
				$('#modal_header').text('Обновление ценников')
				$('#modal_text').text('Процесс запущен, надо немного подождать')
				$('#modal_dialog').modal('show')
							
				$.ajax({
					url: "/admin/modules/php/update_price.php",
					//data: {type: 'update_price'},
					//type: 'POST',
					cache: false,
					success: function(data) {
						console.log(data)
						//if(data.trim() == 'true'){
							$('#modal_dialog').modal('close')
							$('#modal_header').text('Обновление ценников')
							$('#modal_text').text('Ценники обновлены')
							$('#modal_dialog').modal('show')
						//}
					}.bind(this)
				});
			}
			
			function cerate_sitemap(){
				$.ajax({
					url: "/admin/modules/php/route.php",
					data: {type: 'cerate_sitemap'},
					type: 'POST',
					cache: false,
					success: function(data) {
						console.log(data)
						if(data.trim() == 'true'){
							$('#modal_header').text('Обновление карты сайта (sitemap.xml)')
							$('#modal_text').text('Карта сайта обновлена')
							$('#modal_dialog').modal('show')
						}
					}.bind(this)
				});
			}
			
			$('.ui.sticky').sticky({
				context: '#menu',
				pushing: true
			  })
			
		</script>
	</body>
</html>