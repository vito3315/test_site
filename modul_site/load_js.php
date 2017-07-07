<script src="<?=$site->addr?>/js/jquery-3.2.1.min.js"></script>
<script src="<?=$site->addr?>/js/ui/materialize.min.js"></script>

<script src="<?=$site->addr?>/js/type_device/device.min.js"></script>

<?if($data['uri'][0] == 'korzina' || $data['uri'][0] == 'registration'){?>
	<script src='https://www.google.com/recaptcha/api.js'></script>
<?}?>

<script src="<?=$site->addr?>/js/search/classie.js"></script>
<script src="<?=$site->addr?>/js/search/modernizr.custom.js"></script>
<script src="<?=$site->addr?>/js/search/uisearch.js"></script>

<script src="<?=$site->addr?>/js/cart/cart_device.js"></script>

<script src="<?=$site->addr?>/js/init.js"></script>
<?
	foreach($data['load_lib'] as $item){
		if($item == 'magnific'){
			?><script src="<?=$site->addr?>/js/img_popup/jquery.magnific-popup.min.js"></script><?
			?><script src="<?=$site->addr?>/js/img_popup/init.js"></script><?
		}
		if($item == 'mixitup'){
			?><script src="<?=$site->addr?>/js/sort/mixitup.min.js"></script><?
			?><script src="<?=$site->addr?>/js/sort/mixitup-multifilter.js"></script><?
			/*?><script src="<?=$site->addr?>/js/sort/mixitup-pagination.js"></script><?*/
			?><script src="<?=$site->addr?>/js/sort/init.js"></script><?
		}
		if($item == 'slick'){
			?><script src="<?=$site->addr?>/js/slide_logo/slick.min.js"></script><?
			?><script src="<?=$site->addr?>/js/slide_logo/init.js"></script><?
		}
		if($item == 'embed'){
			?><script src="<?=$site->addr?>/js/embed/embed.min.js"></script><?
			?><script src="<?=$site->addr?>/js/embed/init.js"></script><?
		}
		if($item == 'items_cart'){
			?><script src="<?=$site->addr?>/js/cart/items_cart.js"></script><?
		}
		if($item == 'compare'){
			?><script src="<?=$site->addr?>/js/compare/main.js"></script><?
		}
		if($item == 'lazyload'){
			?><script src="<?=$site->addr?>/js/lazyload/jquery.lazyload.js"></script><?
			?><script src="<?=$site->addr?>/js/lazyload/init.js"></script><?
		}
		if($item == 'lichyi_cabinet'){
			?><script src="<?=$site->addr?>/js/lichyi_cabinet/init.js"></script><?
		}
		if($item == 'items'){
			?><script src="<?=$site->addr?>/js/sort/mixitup.min.js"></script><?
			?><script src="<?=$site->addr?>/js/sort/mixitup-multifilter.js"></script><?
			
			?><script src="<?=$site->addr?>/js/items/riot+compiler.min.js"></script><?
			?><script src="<?=$site->addr?>/js/items/load_items.js"></script><?
		}
		if($item == 'stat'){
			
		}
		if($item == 'sitemap'){
			?><script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script><?
			?><script src="<?=$site->addr?>/js/masonry-layout/init.js"></script><?
		}
	}
?>

