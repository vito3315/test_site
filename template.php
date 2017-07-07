<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
		<meta name="description" content="<?=$data['this_page']['description']?>">
		<title><?=$data['this_page']['title']?> - Всё для шиномонтажа в Тольятти</title>
		
		<?if($data['this_page']['alias'] == ''){?>
			<meta property="og:title" content="<?=$data['this_page']['title']?>"/>
			<meta property="og:description" content="<?=$data['this_page']['description']?>"/>
			<meta property="og:image" content="<?=$site->addr?>/img/about/DSC_0052.JPG">
			<meta property="og:image:width" content="300" />
			<meta property="og:type" content="website"/>
			<meta property="og:url" content="<?=$site->addr?>" />	
		<?}?>
		
		<?if($data['this_page']['alias'] == 'item'){?>
			<meta property="og:title" content="<?=$data['this_page']['title']?>"/>
			<meta property="og:description" content="<?=$data['this_page']['description']?>"/>
			<meta property="og:image" content="<?=$site->addr?>/img/items/<?=$data['this_item']['item']['id']?>_main.jpg">
			<meta property="og:image:width" content="300" />
			<meta property="og:type" content="website"/>
			<meta property="og:url" content="<?=$site->addr?>/item/<?=$data['this_item']['item']['id']?>" />	
		<?}?>
		
		<?if($data['this_page']['query'] != 0 && $data['this_page']['alias'] != 'item'){?>
			<meta property="og:title" content="<?=$data['this_page']['title']?>"/>
			<meta property="og:description" content="<?=$data['this_page']['description']?>"/>
			<meta property="og:image" content="<?=$site->addr?>/img/category/<?=$data['this_page']['query']?>_min.jpg">
			<meta property="og:image:width" content="300" />
			<meta property="og:type" content="website"/>
			<meta property="og:url" content="<?=$site->addr?>/<?=$site->get_full_uri()?>" />	
		<?}?>
		
		<style>
			@font-face{font-family:'a_Stamper Bold';font-style:normal;font-weight:700;src:local('a_Stamper Bold'),local('a_Stamper-Bold'),url(https://allfont.ru/cache/fonts/a_stamper-bold_0a295a47da9e8502ac3d5091b3f22cc7.woff) format('woff'),url(https://allfont.ru/cache/fonts/a_stamper-bold_0a295a47da9e8502ac3d5091b3f22cc7.ttf) format('truetype')}#rc-copyright.rc-reset{display:none}.cards_item>a{color:#000}.cards_item .art{width:100%;float:left;font-size:.85em}.cards_item .divider{width:100%;float:left;margin-bottom:7px}.cards_item .card-title{line-height:0!important;font-size:1.2em!important}.badge{position:absolute;top:3px;margin-left:14px!important}.red_{box-shadow:0 0 0 1px #db2828 inset!important;color:#db2828!important}.orange_{box-shadow:0 0 0 1px #f26202 inset!important;color:#f26202!important}.green_{box-shadow:0 0 0 1px #16ab39 inset!important;color:#16ab39!important}.primary_{box-shadow:0 0 0 1px #2185d0 inset!important;color:#2185d0!important}.btn_count{margin-bottom:.75em;background:0 0!important;font-weight:400;border-radius:.28571429rem;text-transform:none;text-shadow:none!important;box-shadow:0 0 0 1px rgba(34,36,38,.15) inset;font-size:1rem;cursor:pointer;display:inline-block;min-height:1em;outline:0;border:0;vertical-align:baseline;background:#e0e1e2;font-family:Lato,'Helvetica Neue',Arial,Helvetica,sans-serif;margin:0 .25em 0 0;padding:.78571429em 1.5em;text-transform:none;text-shadow:none;font-weight:700;line-height:1em;font-style:normal;text-align:center;text-decoration:none;border-radius:.28571429rem;box-shadow:0 0 0 1px transparent inset,0 0 0 0 rgba(34,36,38,.15) inset;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-transition:opacity .1s ease,background-color .1s ease,color .1s ease,box-shadow .1s ease,background .1s ease;transition:opacity .1s ease,background-color .1s ease,color .1s ease,box-shadow .1s ease,background .1s ease;will-change:'';-webkit-tap-highlight-color:transparent}.card.items .card-content{padding:20px 0!important;padding-bottom:80px!important}.card .card-content{padding:20px 0!important}.card .card-content .card-title{line-height:25px!important}.card_category .card-image{height:200px;padding-top:10px}.card.items .card-image{height:175px;padding-top:10px}.card .card-image img{margin:10px auto!important;left:0!important;top:0!important;bottom:0!important;right:0!important;max-height:100%;max-width:100%}nav a{color:#000!important;font-weight:500}.icon-block{padding:0 15px}.icon-block .material-icons{font-size:inherit}h2.center-align{color:#fff!important}.valign-wrapper{display:flex!important;-webkit-align-items:center!important;-ms-flex-align:center!important;align-items:center!important}.compare{margin-top:10px;float:left;background-color:#fff;color:#f2711c;cursor:pointer;text-decoration:none;border:1px solid #f2711c;border-radius:2px;height:36px;font-size:1.5em;margin-left:4px;line-height:36px;padding:0 1rem;padding-top:1px}.compare:active,.compare:focus{background-color:#fff}.item_price{font-family:'a_Stamper Bold',arial;font-size:22px;position:absolute;bottom:50px}.item_price_old{font-family:'a_Stamper Bold',arial;text-decoration:line-through;font-size:18px;position:absolute;bottom:52px;right:15px}.item_buy{width:60%;padding:0!important;position:absolute!important;bottom:15px;left:15px}.item_compare{position:absolute;bottom:15px;right:15px}.h2{color:#fff!important;font-size:1.5em;margin:1.78rem 0 1.424rem;text-align:center;font-weight:400;line-height:110%}.h5{font-size:1.64rem;margin:.82rem 0 .656rem;line-height:110%}.h3{font-size:2rem;margin:1.46rem 0 1.168rem;padding:7px 0;line-height:110%;font-weight:400;display:block;-webkit-margin-before:1em;-webkit-margin-after:1em;-webkit-margin-start:0;-webkit-margin-end:0}.breadcrumb:last-child{color:#000!important;font-weight:500}.side-nav a{height:auto!important}.sb-search-input-items{border:0;outline:0;background:#fff;width:100%;height:64px;margin:0;z-index:10;padding:20px 65px 20px 20px;font-family:inherit;font-size:20px;color:#2c3e50}.sb-search-input-items::-webkit-input-placeholder{color:#000}.sb-search-input-items:-moz-placeholder{color:#000}.sb-search-input-items::-moz-placeholder{color:#000}.sb-search-input-items:-ms-input-placeholder{color:#000}.nav_menu>li>a{font-size:1.3em}.ac{max-width:200px;max-height:50px;margin:0 auto}.slick-next.slick-arrow{display:none!important}.controls{padding:1rem;font-size:.1px;padding-left:0}.control{position:relative;display:inline-block;cursor:pointer;font-size:15px;color:#333;text-align:center;min-width:30px;transition:background 150ms;padding:0 10px}.mixitup-control-active{color:#fff;background:#e60000;opacity:.9;border-radius:2px}.controls>span{font-size:15px}.btn-filtr{color:#fff;background:#e60000;opacity:.9;border-radius:2px;letter-spacing:.5px;transition:.2s ease-out;cursor:pointer;border:0;border-radius:2px;display:inline-block;height:36px;line-height:36px;padding:0 2rem;text-transform:uppercase;vertical-align:middle}.btn-filtr:hover{background:#f80000}.toHide{display:none!important}.items .collection-item{text-align:center}.items .collection-header{height:90px;text-align:center;justify-content:center;display:flex;flex-direction:column;overflow:hidden}.collection .fa-close{position:absolute;right:5px;top:4px;cursor:pointer}.tabs .tab a.active,.tabs .tab a:hover{color:#e60000!important;opacity:.9;font-weight:bold}.tabs .indicator{background-color:#e60000!important}.price_{background-color:#e60000;color:#fff!important}.price:hover{background-color:red;color:#fff!important}#nav_contact_1>a{font-size:1.3rem;height:64px}#nav_contact_1>a>span{height:20px;display:block;text-align:right}	
		</style>
	</head>
	<body style="background-image: url(<?=$site->addr?>/css/img/background_img/tweed.png);" onload="loadimg()">

		<?include("modul_site/nav_bar.php")?>
			
		
		<?
			if (file_exists($data['this_page']['path'])) {
				include($data['this_page']['path']);
			}else{
				include('./content/general_template.php');
			}
		?>
		
		<?include("modul_site/load_css.php")?>
		<?include("modul_site/load_js.php")?>
		
		<?include("modul_site/cart.php")?>
		<?include("modul_site/footer.php")?>
	</body>	
</html>
