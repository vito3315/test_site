<?
	$data['category_list'] = $site->get_list('category', '', '', 'sort');
	
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

<h1>Категории</h1>

<table class="ui celled table sortable" id="table_000">
	<thead>
		<tr>
			<th>#</th>
			<th>Фото</th>
			<th>Название</th>
			<th>Видимсть</th>
		</tr>
	</thead>
	<tbody>
		<?
			foreach($data['category_list'] as $category){
				?>
					<tr id="row_<?=$category['id']?>">
						<td><?=$category['sort']?></td>
						<td><img style="max-width: 100px; max-height: 100px;" src="<?=$site->addr?>/img/category/<?=$category['id']?>_min.jpg"></td>
						<td><a href="<?=$site->addr?>/admin/modules/category_edit/?/<?=$category['id']?>"><?=$category['name']?></a></td>
						<td><i class="<?=$category['is_show']==1?'fa fa-eye fa-2x':'fa fa-eye-slash fa-2x'?>"></i></td>
					</tr>
				<?
			}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="4"><button class="ui primary button" onclick="save_sort('000')" style="float: right;">Сохранить сортировку</button></th>
		</tr>	
	</tfoot>
</table>

<script>
	function save_sort(id){
		var arr = [],
			i = 1;
		
		var classes = $('#table_'+id+' > tbody > tr').map(function(indx, element){
			arr[i] = {id_menu: $(element).attr("id").split('_')[1], pos: i++};
		});
		
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'save_sort_category', arr: arr},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				if(data.trim() == 'true'){
					$('#modal_header').text('Сортировка категории')
					$('#modal_text').text('Новая сортировка сохранена')
					$('#modal_dialog').modal('show')
				}else{
					$('#modal_header').text('Сортировка категории')
					$('#modal_text').text('Произошла ошибка при обновлении сортировки')
					$('#modal_dialog').modal('show')
				}
			}.bind(this)
		});
	}
	
	$( document ).ready(function() {
		$('.ui.dropdown').dropdown();
		$(".sortable").tableDnD();
	});
</script>