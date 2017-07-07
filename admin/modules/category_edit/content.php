<?
	$cat = $site->get_one('category', $site->get_uri()[0]);

	$data['category_list'] = $site->get_list('category', '', '', 'sort');
	$data['category_list_new'] = array();
	
	//двухуровневое меню
	$i = 0;
	foreach($data['category_list'] as $category_one){
		if($category_one['parent_id'] == $cat['id']){
			$data['category_list_new'][] = $category_one;
		}
	}	
	
	
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

<h1>Редактирование категории: <?=$cat['name']?></h1>

<div class="ui grid">
	<div class="four wide column">
		<img src="<?=$site->addr?>/img/category/<?=$cat['id']?>_min.jpg" style="max-width: 100%;">
	</div>
	<div class="twelve wide column">
		<form class="dropzone" id="myAwesomeDropzoneEdit_photo">
			<input type="hidden" name="name" id="namePhoto_edit" value="<?=$cat['id']?>.jpg" />
		</form> 
		<button class="ui primary button" onclick="save_photo_cat()">Сохранить фото</button>
	</div>
</div>

<form class="ui form">
	<div class="field">
		<label>Название</label>
		<input type="text" id="edit_name_<?=$cat['id']?>" value="<?=$cat['name']?>">
	</div>
	<div class="field">
		<div class="ui checkbox">
			<input type="checkbox" id="edit_show_<?=$cat['id']?>" <?=$cat['is_show']==1?'checked':''?> tabindex="0" class="hidden">
			<label>Показывать категорию</label>
		</div>
	</div>
	<div class="field">
		<label>Выберите родителя</label>
		<select class="ui search dropdown" id="selected_parent_id_<?=$cat['id']?>">
			<option value="0">Главная</option>
			<?
				foreach($data['category_list'] as $row2){
					?>
						<option <?=$cat['parent_id']==$row2['id']?'selected':''?> value="<?=$row2['id']?>"><?=$row2['name']?></option>
					<?
				}
			?>
			
		</select>
	</div>
	<div class="two fields">
		<div class="field">
			<label>Параметр 1</label>
			<select class="ui search dropdown" id="param_1">
				<?
					foreach($site->get_unic_param() as $row){
						?>
							<option <?=$cat['param1_name']==$row['name']?'selected':''?> value="<?=$row['name']?>"><?=$row['name']?></option>
						<?
					}
				?>
				
			</select>
		</div>
		<div class="field">
			<label>Параметр 2</label>
			<select class="ui search dropdown" id="param_2">
				<?
					foreach($site->get_unic_param() as $row){
						?>
							<option <?=$cat['param2_name']==$row['name']?'selected':''?> value="<?=$row['name']?>"><?=$row['name']?></option>
						<?
					}
				?>
				
			</select>
		</div>
	</div>
</form>

<button style="float: right;" class="ui primary button" onclick="update_category_item(<?=$cat['id']?>)">Сохранить</button>

<?if(!empty($data['category_list_new'])){?>
	<h1>Подкатегории</h1>
	<table class="ui celled table sortable" id="table_<?=$cat['id']?>">
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
				foreach($data['category_list_new'] as $category){
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
				<th colspan="4"><button class="ui primary button" onclick="save_sort('<?=$cat['id']?>')" style="float: right;">Сохранить сортировку</button></th>
			</tr>	
		</tfoot>
	</table>
<?}?>

<script>
	var myDropzoneEdit_photo, myDropzoneEdit;

	function update_category_item(id){
		var parent_id = $('#selected_parent_id_'+id).val(),
			name = $('#edit_name_'+id).val(),
			is_show = document.getElementById('edit_show_'+id).checked,
			param_1 = $('#param_1').val(),
			param_2 = $('#param_2').val();
			
		is_show = is_show?1:0;	
		
		//console.log(id, parent_id, name, is_show);	
			
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'update_category', cat_id: id, parent_id: parent_id, name: name, is_show: is_show, param_1: param_1, param_2: param_2},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				if(data.trim() == 'true'){
					$('#modal_header').text('Обновление категории')
					$('#modal_text').text('Категория новлена')
					$('#modal_dialog').modal('show')
				}else{
					$('#modal_header').text('Обновление категории')
					$('#modal_text').text('Произошла ошибка при обновлении категории')
					$('#modal_dialog').modal('show')
				}
			}.bind(this)
		});
	}
	
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
	
	function save_photo_cat(){
		myDropzoneEdit_photo.processQueue();
	}
	
	myDropzoneEdit_photo = new Dropzone(document.getElementById('myAwesomeDropzoneEdit_photo'), {
		paramName: "file", 
		maxFilesize: 10, 
		url: "../../../img/category/load_images.php",
		method: "POST",
		maxFiles: 1,
		autoProcessQueue: false,
		accept: function(file, done) {
			done();
		},
		init: function() {
			this.on("complete", function(file) {
				this.removeFile(file);
				
			})
		}
	});
	
	$( document ).ready(function() {
		$('.ui.dropdown').dropdown();
		$(".sortable").tableDnD();
		$('.ui.checkbox').checkbox()
	});
</script>