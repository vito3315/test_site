<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['this_page']['h1']?></h1>

<div class="row general_template">
	<div class="grid col-md-12 col-xs-12 col-sm-12 col-lg-12 flex-box">
		<?foreach($data['menu_catalog'] as $main_cat){?>
			<ul class=" col-md-4 col-xs-12 col-sm-6 col-lg-4 grid-item">
				<li><a href="<?=$site->addr.'/'.$main_cat['alias']?>/" style="font-size: 2em; color: #fff;"><?=$main_cat['name']?></a></li>
				<ul style="padding-left: 20px;">
					<?foreach($site->get_pages_from_category($main_cat['query']) as $sub_cat){?>
						<li style="list-style-type: decimal; font-size: 1.3em; color: #fff;"><a href="<?=$site->addr.'/'.$main_cat['alias']?>/<?=$sub_cat['alias']?>/"><?=$sub_cat['name']?></a></li>
					<?}?>
				</ul>
			</ul>	
		<?}?>	
	</div>
</div>
