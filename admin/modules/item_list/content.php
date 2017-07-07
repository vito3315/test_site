<?php
	$data['items'] = $site->get_list('items', $site->get_uri()[0], 'category_id', 'name');
	
	$cat = $site->get_one('category', $site->get_uri()[0]);

	$data['category_list'] = $site->get_list('category', (int)$site->get_uri()[0], 'parent_id', 'sort');
	
	//двухуровневое меню
	$i = 0;
	foreach($data['category_list'] as &$category_one){
		if($category_one['parent_id'] != 0){
			foreach($data['category_list'] as &$category_two){
				if($category_two['id'] == $category_one['parent_id']){
					$category_two['parent'][] = $category_one;
					unset($data['category_list'][$i]);
					continue;
				}
			}
		}
		$i++;
	}	
?>


<?if(!empty($data['category_list'])){?>
	<h1>Список категорий товаров</h1>
	<table class="ui celled table">
		<thead>
			<tr>
				<th>#</th>
				<th>Фото</th>
				<th>Название</th>
				<th>Видимсть</th>
			</tr>
		</thead>
		<tbody>
			<?foreach($data['category_list'] as $category){?>
				<tr id="row_<?=$category['id']?>">
					<td><?=$category['sort']?></td>
					<td><img style="max-width: 100px; max-height: 100px;" src="<?=$site->addr?>/img/category/<?=$category['id']?>_min.jpg"></td>
					<td><a href="<?=$site->addr?>/admin/modules/item_list/?/<?=$category['id']?>"><?=$category['name']?></a></td>
					<td><i class="<?=$category['is_show']==1?'fa fa-eye fa-2x':'fa fa-eye-slash fa-2x'?>"></i></td>
				</tr>
			<?}?>
		</tbody>
	</table>
<?}else{?>
	<h1>Список товаров</h1>
	<div>
		<table class="ui celled table" id="page_list">
			<thead>
				<tr>
					<th>#</th>
					<th>Фото</th>
					<th>Название</th>
					<th>Артикул</th>
					<th>Видимость</th>
				</tr>
			</thead>
			<tbody>
			<?foreach($data['items'] as $item){?>
				<tr class="items_category cat_id_<?=$item['category_id']?> ">
					<td><?=$item['id']?></td>
					<td><img style="max-width: 100px; max-height: 100px;" class="activator" src="<?=$site->addr?>/img/items/<?=$item['id']?>_main.jpg"></td>
					<td><a href="<?=$site->addr?>/admin/modules/item_edit/?/<?=$item['id']?>"><?=$item['name']?></a></td>
					<td><?=$item['art']?></td>
					<td>
						<div class="ui checkbox" onclick="update_show(<?=$item['id']?>)">
							<input <?=$item['is_show']?'checked':''?> type="checkbox" id="show_<?=$item['id']?>">
							<label>видимость</label>
						</div>
					
					</td>
				</tr>
			<?}?>
			</tbody>
		</table>	
	</div>
<?}?>


 
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
	
	function update_show(id){
		var val = $('#show_'+id).prop("checked");
		
		val = val?'0':'1';
		
		console.log(val)
		
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'update_show_item', id: id, val: val},
			type: 'POST',
			cache: false,
			success: function(data) {
				if(data.trim() == 'true'){
					$('#modal_header').text('Обновление товара')
					$('#modal_text').text('Изменения успешно сохранены')
					$('#modal_dialog').modal('show')
				}else{
					$('#modal_header').text('Обновление товара')
					$('#modal_text').text('Произошла ошибка при обновлении товара')
					$('#modal_dialog').modal('show')
				}
			}.bind(this)
		}); 
	}
	
	
</script>
