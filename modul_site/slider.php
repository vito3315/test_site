<div class="row" style="margin-top: 10px;">
	<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding: 0;">
		<div class="slider">
			<ul class="slides" style="height: 600px;">
				<?
					if(empty($slides = $site->cash('slider_index'))){
						$slides = $site->cash('slider_index', $site->get_list('slider', '', '', 'sort', 1));
					}
				
					foreach($slides as $item){
						?>
							<li>
								<img src="<?=$item['photo_addr']?>" alt="<?=$item['title']?>">
								<div class="caption center-align">
									<span class="h3" style="background-color: #01579b;opacity: 0.8;color: #fff;"><?=$item['title']?></span>
								</div>
							</li>
						<?
					}
				?>
			</ul>
		</div>
	</div>	
</div>