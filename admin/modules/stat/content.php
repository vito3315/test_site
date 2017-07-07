<?
	/*$orders = $site->get_order_admin();
	
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
	
	}*/
	//var_dump($orders);
?>

<div>
	<h1>Статистика</h1>
	
	<div class="ui buttons">
		<button class="ui button primary" onclick="today()">Сегодня</button>
		<button class="ui button primary" onclick="last_7()">За 7 дней</button>
		<button class="ui button primary" onclick="last_30()">За 30 дней</button>
	</div>
	
	<div id="for_graph"></div>
	
	<table class="ui celled table">
		<thead>
			<tr>
				<th>Название</th>
				<th>Количество просмотров</th>
			</tr>
		</thead>
		<tbody id="popular_items">
			
		</tbody>
		<tfoot>
			<tr>
				<td>Всего просмотров: </td>
				<td><span id="allCount"></span></td>
			</tr>
		</tfoot>
	</table>
</div> 

<script>
	var date = new Date()
	
	function today(){
		document.getElementById('popular_items').innerHTML = '';
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'get_popular_item_today'},
			type: 'POST',
			dataType: 'JSON',
			cache: false,
			success: function(data) {
				console.log(data)
				
				var items_data = [],
					abc = data,
					i = 0,
					table = "",
					allCount = 0,
					url = location.hostname,
					today = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
					
				abc.map(function(item){
					var name = item['name'],
						count = item['count'];
						
					allCount += parseInt(count);	
						
					//if(count > 2){
						items_data[i++] = [name, parseInt(count)];
						table += "<tr><td><a href='http://"+url+"/item/"+item['id']+"' target='_blank'>"+name+"</a></td><td>"+count+"</td></tr>";
					//}
				})
				
				$('#popular_items').append(table);
				
				$('#allCount').text(allCount);
				
				var ccc = [{name: '111', data: items_data}]
				
				console.log(ccc)
				update_chart_data_full(ccc)
				$('.highcharts-subtitle > tspan').text('Самые просматриваемые товары на '+today)
			}.bind(this)
		}); 
	}

	function last_7(){
		document.getElementById('popular_items').innerHTML = '';
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'get_popular_item_last_7'},
			type: 'POST',
			dataType: 'JSON',
			cache: false,
			success: function(data) {
				console.log(data)
				
				var items_data = [],
					abc = data,
					i = 0,
					table = "",
					allCount = 0,
					url = location.hostname,
					today = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
					
				abc.map(function(item){
					var name = item['name'],
						count = item['count'];
						
					allCount += parseInt(count);
						
					//if(count > 7){
						items_data[i++] = [name, parseInt(count)];
						table += "<tr><td><a href='http://"+url+"/item/"+item['id']+"' target='_blank'>"+name+"</a></td><td>"+count+"</td></tr>";
					//}
				})
				
				$('#popular_items').append(table);
				
				$('#allCount').text(allCount);
				
				var ccc = [{name: '111', data: items_data}]
				
				console.log(ccc)
				update_chart_data_full(ccc)
				$('.highcharts-subtitle > tspan').text('Самые просматриваемые товары за последние 7 дней')
			}.bind(this)
		}); 
	}
	
	function last_30(){
		document.getElementById('popular_items').innerHTML = '';
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'get_popular_item_last_30'},
			type: 'POST',
			dataType: 'JSON',
			cache: false,
			success: function(data) {
				console.log(data)
				
				var items_data = [],
					abc = data,
					i = 0,
					table = "",
					allCount = 0,
					url = location.hostname,
					today = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
					
				abc.map(function(item){
					var name = item['name'],
						count = item['count'];
						
					allCount += parseInt(count);
					
					//if(count > 9){
						items_data[i++] = [name, parseInt(count)];
						table += "<tr><td><a href='http://"+url+"/item/"+item['id']+"' target='_blank'>"+name+"</a></td><td>"+count+"</td></tr>";
					//}
				})
				
				$('#popular_items').append(table);
				
				$('#allCount').text(allCount);
				
				var ccc = [{name: '111', data: items_data}]
				
				console.log(ccc)
				update_chart_data_full(ccc)
				$('.highcharts-subtitle > tspan').text('Самые просматриваемые товары за последние 30 дней')
			}.bind(this)
		}); 
	}

	console.log('start_load_today')
	$.ajax({
		url: "../../modules/php/route.php",
		data: {type: 'get_popular_item_today'},
		type: 'POST',
		dataType: 'JSON',
		cache: false,
		success: function(data) {
			console.log(data)
			
			var items_data = [],
				abc = data,
				i = 0,
				table = "",
				allCount = 0,
				url = location.hostname,
				today = date.getFullYear()+"-"+(date.getMonth()+1)+"-"+date.getDate();
				
			abc.map(function(item){
				var name = item['name'],
					count = item['count'];
					
				allCount += parseInt(count);
				
				$('#allCount').text(allCount);
				
				//if(count > 2){
					items_data[i++] = [name, parseInt(count)];
					table += "<tr><td><a href='http://"+url+"/item/"+item['id']+"' target='_blank'>"+name+"</a></td><td>"+count+"</td></tr>";
				//}
			})
			
			$('#popular_items').append(table);
			
			var ccc = [{name: '111', data: items_data}]
			
			console.log(ccc)
			
			getChart("for_graph", "Статистика просмотров", "Самые просматриваемые товары на "+today, "количество", ccc, 15, "vito")
		}.bind(this)
	}); 
	
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
	
	$( document ).ready(function() {
		$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		/*$('#page_list').DataTable( {
			"order": [[ 1, "desc" ]],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
			}
		} );*/
		
	});
</script>