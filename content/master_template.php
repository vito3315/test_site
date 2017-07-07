<?
	$data['load_lib'] = array('embed');
	
	$data['video_l'] = array(
		array('name' => '(часть 1)', 'url' => 'gs27kO4XMC0'),
		array('name' => 'часть 1 (часть 2)', 'url' => '65N_zqtsI50'),
		array('name' => 'часть 1 (часть 3)', 'url' => 'JfKdwylisO0'),
		array('name' => 'часть 1 (часть 4)', 'url' => 'm1iPlyxjOFI'),
		array('name' => 'часть 1 (часть 5)', 'url' => 'N8sdvUS37P4'),
		array('name' => 'часть 2 (часть 6)', 'url' => 'TYkx6Mo7hJA'),
		array('name' => 'часть 2 (часть 7)', 'url' => 'DBQVSBlDx8I'),
		array('name' => 'часть 2 (часть 8)', 'url' => 'n7PRxyW2osk'),
		array('name' => 'часть 2 (часть 9)', 'url' => 'm-vdDdje6SI'),
		array('name' => 'часть 3 (часть 24)', 'url' => '4CXHCChyTkM'),
		array('name' => 'часть 3 (часть 25)', 'url' => 'bJCFlMS0Bac'),
		array('name' => 'часть 3 (часть 26)', 'url' => 'sUF4l2l463I'),
		array('name' => 'часть 4 (часть 27)', 'url' => 'kwl2TYhlb7A'),
		array('name' => 'часть 4 (часть 28)', 'url' => 'yxrIAM1-BoU')
	);	
	
	$data['video_g'] = array(	
		array('name' => 'часть 1 (часть 10)', 'url' => 'h6eQSAnTp8Q'),
		array('name' => 'часть 1 (часть 11)', 'url' => 'Z2NrgbBmbMA'),
		array('name' => 'часть 1 (часть 12)', 'url' => 'ZEVlnsVTR9o'),
		array('name' => 'часть 1 (часть 13)', 'url' => 'R7GASP_wTHw'),
		array('name' => 'часть 2 (часть 14)', 'url' => '9NmQ7yRMCTE'),
		array('name' => 'часть 2 (часть 15)', 'url' => '8AcsDy0H6WI'),
		array('name' => 'часть 2 (часть 16)', 'url' => 'L3V4NZeSySc'),
		array('name' => 'часть 2 (часть 17)', 'url' => 'EgVYHmxJHAY'),
		array('name' => 'часть 2 (часть 18)', 'url' => 'PJsBi3H_5bg'),
		array('name' => 'часть 3 (часть 19)', 'url' => 'yjQlU8Bwh94'),
		array('name' => 'часть 3 (часть 20)', 'url' => '7YUddJb2AZY'),
		array('name' => 'часть 4 (часть 21)', 'url' => 'LNbTk08g5M0'),
		array('name' => 'часть 4 (часть 22)', 'url' => '_7tFO9zkRAo'),
		array('name' => 'часть 4 (часть 23)', 'url' => 'RG-FDpEGXKA')
	);
	
?>

<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['content_page']['h1']?></h1>

<div class="row" style="padding-left: 4%;padding-right: 4%; text-align: center;">
	<span class="h2">Ремонт легковых шин и камер Россвик</span>
	
	<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12">
		<?foreach($data['video_l'] as $item){?>
			<div class="card col-md-6 col-xs-12 col-sm-6 col-lg-4">
				<div class="card-image" style="padding-top: 15px;">
					<div class="ui embed" data-source="youtube" data-id="<?=$item['url']?>" data-placeholder="<?=$site->addr?>/img/logos/rossvik.png"></div>
				</div>
				<div class="card-content center-align">
					<span style="font-weight: 500;" class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
				</div>
			</div>
		<?}?>
	</div>
</div>	

<div class="row" style="padding-left: 4%;padding-right: 4%; text-align: center;">	
	<span class="h2">Ремонт грузовых шин и камер Россвик</span>
	
	<div class="row flex-box col-md-12 col-xs-12 col-sm-12 col-lg-12">	
		<?foreach($data['video_g'] as $item){?>
			<div class="card col-md-6 col-xs-12 col-sm-6 col-lg-4">
				<div class="card-image" style="padding-top: 15px;">
					<div class="ui embed" data-source="youtube" data-id="<?=$item['url']?>" data-placeholder="<?=$site->addr?>/img/logos/rossvik.png"></div>
				</div>
				<div class="card-content center-align">
					<span style="font-weight: 500;" class="card-title activator grey-text text-darken-4"><?=$item['name']?></span>
				</div>
			</div>
		<?}?>
	</div>
</div>

<div style="display: none;" class="ttt"><?=$site->get_()?></div>