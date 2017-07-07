<?
	$data['news'] = $site->get_query_list("SELECT * FROM news WHERE is_show=1");	
?>

<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['this_page']['h1']?></h1>	
	
<div class="row category" style="padding-left: 4%; padding-right: 4%; min-height: 500px;" id="main_content">

	<?if(!empty($data['this_page']['content_after'])){?>
		<div class="row" style="padding: 0 15px; margin-top: 15px;">
			<div style="">
				<span class="white-text text-darken-2" style="font-size: 1.3em;"><?=$data['this_page']['content_after']?></span>
			</div>	
		</div>
	<?}?>
	
	<?if(!empty($data['item'])){?>
		<div class="row" style="padding-left: 4%;padding-right: 4%; margin-top: 15px;">
			<div class="card-panel" style="padding: 1px; margin-bottom: 0;">
				<div style="padding-left: 20px; padding-right: 20px;">
					<span class="black-text text-darken-2" style="font-size: 1.3em;"><?=$data['item']['content']?></span>
				</div>	
			</div>
		</div>
	<?}else{?>
		<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12" id="items_category">
			<?foreach($data['news'] as $item){?>
				<div class="card card_category col-md-4 col-xs-12 col-sm-6 col-lg-4">
					<a href="<?=$site->get_full_uri().$item['alias']?>/" style="color: #000">
						<div class="card-image waves-effect waves-block waves-light valign-wrapper">
							<img class="activator" style="max-width: 100%; max-height: 100%;" src="<?=$site->addr?>/img/news/<?=$item['photo']?>">
						</div>
						<div class="card-content center-align">
							<span style="font-weight: 500;" class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
						</div>
					</a>	
				</div>
			<?}?>
		</div>
	<?}?>
	
	<?if(!empty($data['this_page']['content_before'])){?>
		<div class="row" style="padding: 0 15px; margin-top: 15px;">
			<div style="">
				<span class="white-text text-darken-2" style="font-size: 1.3em;"><?=$data['this_page']['content_before']?></span>
			</div>	
		</div>
	<?}?>
	
</div>
