<link href="<?=$site->addr?>/css/ui/materialize_new.min.css" type="text/css" rel="stylesheet"/>
<link href="<?=$site->addr?>/css/ui/template.css" type="text/css" rel="stylesheet"/>
<!--<link href="<?=$site->addr?>/css/ui/container.min.css" type="text/css" rel="stylesheet"/>
<link href="<?=$site->addr?>/css/ui/bootstrap.css" type="text/css" rel="stylesheet"/>
<link href="<?=$site->addr?>/css/ui/input.css" type="text/css" rel="stylesheet"/>
<link href="<?=$site->addr?>/css/ui/template.css" type="text/css" rel="stylesheet"/>

<link href="<?=$site->addr?>/css/cart/cart_device.css" type="text/css" rel="stylesheet"/>

<link href="<?=$site->addr?>/css/search/component.css" type="text/css" rel="stylesheet"/>
<link href="<?=$site->addr?>/css/search/default.css" type="text/css" rel="stylesheet"/>-->

<?
	foreach($data['load_lib'] as $item){
		if($item == 'magnific'){
			?><link href="<?=$site->addr?>/css/img_popup/magnific-popup.css" type="text/css" rel="stylesheet"/><?
		}
		if($item == 'slick'){
			?><link href="<?=$site->addr?>/css/slide_logo/slick.css" type="text/css" rel="stylesheet"/><?
			?><link href="<?=$site->addr?>/css/slide_logo/slick-theme.css" type="text/css" rel="stylesheet"/><?
		}
		if($item == 'embed'){
			?><link href="<?=$site->addr?>/css/embed/embed.css" type="text/css" rel="stylesheet"/><?
		}
		if($item == 'compare'){
			?><link href="<?=$site->addr?>/css/compare/style.css" type="text/css" rel="stylesheet"/><?
		}
	}
?>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="<?=$site->addr?>/css/font-awesome.css" type="text/css" rel="stylesheet" />