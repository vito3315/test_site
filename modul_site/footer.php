<footer class="page-footer light-blue darken-4">
	<div class="container">
		<div class="row">
			<div class="col-md-5 col-xs-12 col-sm-12 col-lg-5">
				<span class="white-text h5">ООО "Всё для шиномонтажа+"</span>
				<p class="grey-text text-lighten-4">Компания занимается продажей проффесионального оборудования и материалов для автосервисов и шиномонтажек.</p>
			</div>
			<div class="col-md-3 col-xs-6 col-sm-4 col-lg-3">
				<span class="white-text h5">Каталог</span>
				<ul>
					<?foreach($data['menu_catalog'] as $item){?>
						<li><a class="white-text" href="<?=$site->check_link($site->addr.'/'.$item['alias'].'/')?>"><?=$item['name']?></a></li>
					<?}?>
				</ul>
			</div>
			<div class="col-md-2 col-xs-6 col-sm-4 col-lg-2">
				<span class="white-text h5">Покупателям</span>
				<ul>
					<li><a class="white-text" href="<?=$site->check_link($site->addr.'/kontakty/')?>">Контакты</a></li>
					<li><a class="white-text" href="<?=$site->check_link($site->addr.'/politika_konfidencialnosti/')?>">Политика конфиденциальности</a></li>
					<li><a class="white-text" href="<?=$site->check_link($site->addr.'/kak_oformit_zakaz/')?>">Как оформить заказ</a></li>
					<li><a class="white-text" href="<?=$site->check_link($site->addr.'/master-klassy/')?>">Мастер-классы</a></li>
				</ul>
			</div>
			<div class="col-md-2 col-xs-6 col-sm-4 col-lg-2">
				<span class="white-text h5">Интересное</span>
				<ul>
					<li><a class="white-text" href="http://rossvik163.ru/">Шиномонтаж</a></li>
					<li><a class="white-text" href="<?=$site->check_link($site->addr.'/sitemap/')?>">Карта сайта</a></li>
					<li><a class="white-text" href="<?=$site->check_link($site->addr.'/akcii/')?>">Акции</a></li>
					<li><a class="white-text" href="<?=$site->check_link($site->addr.'/novinki/')?>">Новые поступления</a></li>
					<li><a class="white-text" href="<?=$site->addr?>/modules/php_excel/Examples/01simple-download-xlsx.php">Прайс-лист</a></li>
					<li><a class="white-text" href="<?=$site->addr?>/content/katalogs/Clipper.pdf" target="_blank">Каталог Clipper</a></li>
					<li><a class="white-text" href="<?=$site->addr?>/content/katalogs/Extra_Seal.pdf" target="_blank">Каталог Extra Seal</a></li>
					<li><a class="white-text" href="<?=$site->addr?>/content/katalogs/Rema_Tip_Top.pdf" target="_blank">Каталог Rema Tip Top</a></li>
					<li><a class="white-text" href="<?=$site->addr?>/content/katalogs/Rossvik.pdf" target="_blank">Каталог Rossvik</a></li>
					<li><a class="white-text" href="<?=$site->addr?>/content/katalogs/Tech.pdf" target="_blank">Каталог Tech</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">Всё для шиномонтажа+ © 2016 - <?=getdate()['year']?>, All rights reserved.</div>
	</div>
</footer>