<h1>Добавление категории</h1>

<form class="dropzone" id="myAwesomeDropzoneEdit">
	<input type="hidden" name="name" id="namePhoto" value="test_0.jpg" />
</form>

<form class="ui form">
	<div class="field">
		<label>Название</label>
		<input type="text" id="new_name" >
	</div>
	<div class="field">
		<label>Выберите родителя категории</label>
		<select class="ui search dropdown" id="selected_parent_id">
			<option value="0">Главная</option>
			<?
				foreach($site->get_list('category') as $row){
					?>
						<option value="<?=$row['id']?>"><?=$row['name']?></option>
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
							<option value="<?=$row['name']?>"><?=$row['name']?></option>
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
							<option value="<?=$row['name']?>"><?=$row['name']?></option>
						<?
					}
				?>
				
			</select>
		</div>
	</div>
</form>

<button style="float: right;" class="ui primary button" onclick="save_new_category()">Сохранить</button>

<script>

	var myDropzoneEdit_photo, myDropzoneEdit;

	function save_new_category(){
		var name = $('#new_name').val(),
			parent_id = $('#selected_parent_id').val(),
			param_1 = $('#param_1').val(),
			param_2 = $('#param_2').val();
			
		console.log(name, parent_id);	
			
		if(name){
			$.ajax({
				url: "../../modules/php/route.php",
				data: {type: 'save_new_category', name: name, parent_id: parent_id, param_1: param_1, param_2: param_2},
				type: 'POST',
				cache: false,
				success: function(data) {
					console.log(data)
					
					if(parseInt(data) != 'NaN' || data.trim() != 'false'){
						$('#namePhoto').val(parseInt(data)+'.jpg');						
						myDropzoneEdit.processQueue();
					}
					
					if(parseInt(data) != 'NaN' || data.trim() != 'false'){
						$('#modal_header').text('Добавление категории')
						$('#modal_text').text('Новая категория создана')
						$('#modal_dialog').modal('show')
					}else{
						$('#modal_header').text('Добавление категории')
						$('#modal_text').text('Произошла ошибка при создании категории')
						$('#modal_dialog').modal('show')
					}
				}.bind(this)
			});
		}	
			
	}
	
	myDropzoneEdit = new Dropzone(document.getElementById('myAwesomeDropzoneEdit'), {
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
	});
</script>