<h1>Слайдер на главной странице</h1>

<table class="ui celled table" id="table_menu">
	<thead>
		<tr>
			<th>#</th>
			<th>Фото</th>
			<th>Подпись</th>
			<th>Видимсть</th>
		</tr>
	</thead>
	<tbody>
		<?
			foreach($site->get_list('slider', '', '', 'sort') as $item){
				?>
					<tr id="item_<?=$item['id']?>">
						<td><?=$item['sort']?></td>
						<td><img src="../../../<?=$item['photo_addr']?>" style="height: 100px;" /></td>
						<td><a href="<?=$site->addr?>/admin/modules/slider_edit/?/<?=$item['id']?>"><?=$item['title']?></a></td>
						<td><i class="<?=$item['is_show']==1?'fa fa-eye fa-2x':'fa fa-eye-slash fa-2x'?>"></i></td>
					</tr>
				<?
			}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="4"><button class="ui primary button" onclick="save_new_sort()" style="float: right;">Сохранить сортировку</button></th>
		</tr>	
	</tfoot>
</table>

<script>
	function save_new_sort(){
		var arr = [],
			i = 1;
		
		var classes = $('#table_menu > tbody > tr').map(function(indx, element){
			arr[i] = {id_menu: $(element).attr("id").split('_')[1], pos: i++};
		});
		
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'save_new_sort_slider', arr: arr},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				if(data.trim() == 'true'){
					$('#modal_header').text('Сортировка слайдов')
					$('#modal_text').text('Сортировка успешно обновлена')
					$('#modal_dialog').modal('show')
				}else{
					$('#modal_header').text('Сортировка слайдов')
					$('#modal_text').text('Произошла ошибка при обновлении сортировки слайдов')
					$('#modal_dialog').modal('show')
				}
			}.bind(this)
		}); 
		
	}
	
	$( document ).ready(function() {
		//$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		
		// Initialise the table
		$("#table_menu").tableDnD();
		// Make a nice striped effect on the table
		//$("#table_menu tr:even").addClass("alt");
	
	});
</script>