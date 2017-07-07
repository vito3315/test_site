<?
	$orders = $site->get_order_admin();
	
	foreach($orders as &$order){
		if($order['type_user'] == 2){
			$order['user_full'] = $site->get_one('fast_user', (int)$order['user_id']);
		}
		
		if($order['type_user'] == 0){
			$order['user_full'] = $site->get_one('users', (int)$order['user_id']);
		}
		
		$order['user_items'] = $site->get_query_list("SELECT * FROM order_items WHERE user_id='".$order['user_id']."' AND date='".$order['date']."'");
	
		if(empty($order['user_items'])){
			continue;
		}
	
		foreach($order['user_items'] as $item){
			$order['full_user_items'][] = array('item' => $site->get_one('items', $item['item_id']), 'count' => $item['count'], 'price' => $item['price']);
		}
	
	}
	//var_dump($orders);
?>

<div>
	<h1>Заказы</h1>
	
	<table class="ui celled table" id="page_list">
		<thead>
			<tr>
				<th>Имя</th>
				<th>Дата</th>
				<th>Статус</th>
				<th>Товары</th>
				<th>E-mail</th>
				<th>Телефон</th>
			</tr>
		</thead>
		<tbody>
			<?
			$i2=0;	
			foreach($orders as $order1){ 
				$i=1;
				
				switch($order1['type']){
					case '0': {
						$type = 'Незавершен';
						break;}
					case '1': {
						$type = 'Завершен';
						break;}
					case '2': {
						$type = 'Отменен';
						break;}		
				}
				
				$full_price=0;	?>	
				<tr>
					<td><?=$order1['user_full']['fam'].' '.$order1['user_full']['name']?></td>
					<td><?=$order1['date']?></td>
					<td>
						<div><?=$type?></div>
					</td>
					<td>
					
						<div class="ui modal" id="order_<?=$i2?>">
							<i class="close icon"></i>
							<div class="header">Заказ покупателя <?=$order1['user_full']['fam'].' '.$order1['user_full']['name']?> от <?=$order1['date']?></div>
							<div class="content">
								<div class="description">
									<table class="ui celled table">
										<thead>
											<tr>
												<th>#</th>
												<th>Название</th>
												<th>Код</th>
												<th>Арт</th>
												<th>К-во</th>
												<th>Цена</th>
											</tr>	
										</thead>
										<tbody>
											<?foreach($order1['full_user_items'] as $this_item){
											
												$full_price += (float)$this_item['price']*(int)$this_item['count'];
												
											?>
												<tr>
													<td><?=$i++?></td>
													<td><a href="<?=$site->addr?>/item/<?=$this_item['item']['id']?>"><?=$this_item['item']['name']?></a></td>
													<td><?=$this_item['item']['kod']?></td>
													<td><?=$this_item['item']['art']?></td>
													<td><?=$this_item['count']?></td>
													<td><?=$this_item['price']?><i class="fa fa-rub"></i></td>
												</tr>	
											<?}?>
										</tbody>
										<tfoot>
											<tr>
												<th></th>
												<th>К оплате:</th>
												<th></th>
												<th></th>
												<th></th>
												<th><?=$full_price?><i class="fa fa-rub"></i></th>
											</tr>
										</tfoot>
									</table>	
								</div>
							</div>
							<div class="actions">
								<div class="ui black deny button">Закрыть</div>
								<?if($order1['type']=='0'){?><div class="ui red right icon button" onclick="del_order('order_<?=$i2?>', '<?=$order1['type_user']?>', '<?=$order1['user_id']?>', '<?=$order1['date']?>')">Отменить</div><?}?>
								<?if($order1['type']=='0'){?><div class="ui primary right labeled icon button" onclick="hide_order('order_<?=$i2?>', '<?=$order1['type_user']?>', '<?=$order1['user_id']?>', '<?=$order1['date']?>')">Завершить заказ<i class="checkmark icon"></i></div><?}?>
							</div>
						</div>
					
						<button onclick="$('#order_<?=$i2++?>').modal('show')">Список товаров</button>
						
					</td>
					<td><?=$order1['user_full']['mail']?></td>
					<td><?=$order1['user_full']['phone']?></td>
				</tr>
			<?}?>
		</tbody>
	</table>	
		
</div> 
<script>
	function hide_order(id, type_user, user_id, date){
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'update_order', type_user: type_user, user_id: user_id, date: date},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				
				$(id).modal('close')
				
				if(data.trim() == 'true'){
					$('#modal_header').text('Обновление заказа')
					$('#modal_text').text('Заказ успешно завершен')
					$('#modal_dialog').modal('show')
					
				}else{
					$('#modal_header').text('Обновление заказа')
					$('#modal_text').text('Произошла ошибка при завершении заказа')
					$('#modal_dialog').modal('show')
				}
			}.bind(this)
		}); 
	}
	
	function del_order(id, type_user, user_id, date){
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'del_order_1', type_user: type_user, user_id: user_id, date: date},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				
				$(id).modal('close')
				
				if(data.trim() == 'true'){
					$('#modal_header').text('Обновление заказа')
					$('#modal_text').text('Заказ успешно отменен')
					$('#modal_dialog').modal('show')
					
				}else{
					$('#modal_header').text('Обновление заказа')
					$('#modal_text').text('Произошла ошибка при отмене заказа')
					$('#modal_dialog').modal('show')
				}
			}.bind(this)
		}); 
	}
	
	$( document ).ready(function() {
		$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		$('#page_list').DataTable( {
			"order": [[ 1, "desc" ]],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
			}
		} );
		
	});
</script>