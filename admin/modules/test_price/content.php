<?
	//$data['nomenklatura'] = $site->get_query_list('SELECT * FROM nomenklatura WHERE price>0');
	
	$data['items'] = $site->get_list('items', 1, 'is_show');
	$data['items_'] = array();
	
	foreach($data['items'] as $item){
		$data['items_'] = array('origin_art' => $item['art'], 'item' => $site->get_query_one("SELECT * FROM nomenklatura WHERE price>0 AND art LIKE '%".$item['art']."%'"));
	}
	
	var_dump($data['items_']);
	die();
	
?>

<h1>Настройки сайта</h1>

<div class="ui form">
	<table class="ui celled table">
		<thead>
			<tr>
				<th>Код товара</th>
				<th>Название</th>
				<th>Артикул</th>
				<th>Оригинальный артикул</th>
				<th>Цена</th>
			</tr>
		</thead>
		<tbody>
			<?foreach($data['items_'] as $item){?>
				<tr>
					<td><?=trim($item['item']['kod'])?></td>
					<td><?=trim($item['item']['name'])?></td>
					<td><?=trim($item['item']['art'])?></td>
					<td><?=trim($item['origin_art'])?></td>
					<td><?=trim($item['item']['price'])?></td>
				</tr>
			<?}?>
		</tbody>
	</table>	
</div>
<div style="margin-top: 10px;">
	<button class="ui primary button" onclick="send()">Сохранить</button>
</div>


<script>
	$( document ).ready(function() {
		$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		
	});
</script>