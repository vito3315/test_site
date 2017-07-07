<?php
	$data['items'] = $site->get_query_list('SELECT n.`id`, n.`name`, n.`art`, n.`kod`, n.`price`, i.`price` price_site, i.`name` name_site, i.`art` art_site, i.`id` site_id FROM `nomenklatura` n INNER JOIN `items` i ON i.`kod`=n.`kod` WHERE n.`price`>0');
	
	//$data['numenklatura'] = $site->get_list('nomenklatura');
	
	/*foreach($data['numenklatura'] as $num_item){
		if(!empty($site->get_one('items', $num_item['kod'], 'kod'))){
			mysql_query("UPDATE nomenklatura SET type=1 WHERE id='".$num_item['id']."'");
		}
	}
	echo 'true';*/
	
	//SELECT n.`name`, n.`art`, n.`kod`, n.`price`, i.name name_site, i.art art_site, i.kod FROM `nomenklatura` n RIGHT JOIN items i ON i.kod=n.kod
?>



<h1>Таблица синхронизации кодов из 1с и товаров с сайта</h1>
<div>
	<table class="ui celled table" id="page_list">
		<thead>
			<tr>
				<th>Название из 1с</th>
				<th>Код товара</th>
				<th>Цена из 1с</th>
				<th>Цена с сайта</th>
				<th>Название с сайта</th>
				<th>id на сайте</th>
			</tr>
		</thead>
		<tbody>
		<?
			foreach($data['items'] as $item){
				?>
				<tr>
					<td><?=$item['name'].'; арт.: '.$item['art']?></td>
					<td><?=$item['kod']?></td>
					<td><?=$item['price']?></td>
					<td><?=$item['price_site']?></td>
					<td><?=$item['name_site'].'; арт.: '.$item['art_site']?></td>
					<td><?=$item['site_id']?></td>
				</tr>
				<?
			}
		?>
		</tbody>
	</table>	
</div>



 
<script>
	$( document ).ready(function() {
		//$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		$('.menu .item').tab()
		$('.ui.checkbox').checkbox()
		
		$('#page_list').DataTable( {
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
			}
		} );
		
	});
</script>
