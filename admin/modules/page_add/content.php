<h1>Добавление новой страницы</h1>

<div class="tabs">
	<form class="ui form">
		
		<div class="ui top attached tabular menu">
			<a class="item active" data-tab="first">Ссылка</a>
			<a class="item" data-tab="second">META</a>
			<a class="item" data-tab="third">Контент</a>
		</div>
	
		<!-- ССЫЛКИ -->
		<div class="ui bottom attached tab segment active" data-tab="first">
			<div class="field">
				<label>Название страницы</label>
				<input type="text" id="name" onblur="translit()" placeholder="Новая страница">
			</div>
			<div class="field">
				<label>Alias</label>
				<input type="text" id="alias" placeholder="new_page">
			</div>
			
			<?
				$json = file_get_contents( '../../../content/config.json' );
				$data_path = json_decode($json);
			?>
			
			<div class="two fields">
				<div class="field">
					<label>Шаблон страницы</label>
					<select class="ui fluid search dropdown" id="path" onchange="select_path()">
					
						<?
							foreach($data_path as $item){
								?><option value="<?=$item->full_path?>"><?=$item->name?></option><?
							}
						?>
					</select>
				</div>

				<div class="field" id="query_field">
					<label>Категория</label>
					<select class="ui fluid search dropdown" id="query">
					
						<?
							foreach($site->get_list('category') as $item){
								?><option value="<?=$item['id']?>"><?=$item['name']?></option><?
							}
						?>
					</select>
				</div>							
			</div>
				
		</div>
		
		<!-- МЕТА -->
		<div class="ui bottom attached tab segment" data-tab="second">
			<div class="field">
				<label>Заголовок страницы (h1)</label>
				<input type="text" id="h1" placeholder="">
			</div>
			<div class="field">
				<label>Title</label>
				<input type="text" id="title" placeholder="">
			</div>
			<div class="field">
				<label>Description</label>
				<textarea id="description"></textarea>
			</div>
		</div>
		
		<!-- КОНТЕНТ -->
		<div class="ui bottom attached tab segment" data-tab="third">
			<h2>Текст до основного контента</h2>
			<textarea id="content_1" name="content_1"></textarea>
			<h2>Текст после основного контента (если есть)</h2>
			<textarea id="content_2" name="content_2"></textarea>
		</div>
	</form>
	
	<div class="field" style="float: right;">
		<button class="ui primary button" onclick="save()">Сохранить</button>
	</div>
	
</div> 
<script>
	CKEDITOR.replace( 'content_1' );
	CKEDITOR.replace( 'content_2' );
	
	function select_path(){
		var path = $('#path').val();
		
		console.log(path)
		
		$('#query_field').addClass('disabled');
		
		if(path == './content/category_template.php'){
			$('#query_field').removeClass('disabled');
		}
	}
	
	function save(){
		var name = $('#name').val(),
			alias = $('#alias').val(),
			h1 = $('#h1').val(),
			title = $('#title').val(),
			description = $('#description').val(),
			path = $('#path').val(),
			query = $('#query').val(),
			content_1 = CKEDITOR.instances.content_1.getData(),
			content_2 = CKEDITOR.instances.content_2.getData();
			
		if($('#query_field').attr('class') == 'field disabled'){
			query = '0';
		}	
			
		if(name && alias){
			$.ajax({
				url: "../../modules/php/route.php",
				data: {type: 'save_page', name: name, h1: h1, alias: alias, title: title, query: query, description: description, content_1: content_1, content_2: content_2, path: path},
				type: 'POST',
				cache: false,
				success: function(data) {
					console.log(data)
					if(data.trim() == 'true'){
						$('#modal_header').text('Создание страницы')
						$('#modal_text').text('Страница успешно добавлена')
						$('#modal_dialog').modal('show')
					}else{
						$('#modal_header').text('Создание страницы')
						$('#modal_text').text('Произошла ошибка при добавлении страницы')
						$('#modal_dialog').modal('show')
					}
				}.bind(this)
			}); 
		}
			
	}
	
	function translit(){
		var text=document.getElementById('name').value;
		text = text.toLowerCase();
		
		var transl=new Array();
		
		transl['А']='A';     transl['а']='a';
		transl['Б']='B';     transl['б']='b';
		transl['В']='V';     transl['в']='v';
		transl['Г']='G';     transl['г']='g';
		transl['Д']='D';     transl['д']='d';
		transl['Е']='E';     transl['е']='e';
		transl['Ё']='Yo';    transl['ё']='yo';
		transl['Ж']='Zh';    transl['ж']='zh';
		transl['З']='Z';     transl['з']='z';
		transl['И']='I';     transl['и']='i';
		transl['Й']='J';     transl['й']='j';
		transl['К']='K';     transl['к']='k';
		transl['Л']='L';     transl['л']='l';
		transl['М']='M';     transl['м']='m';
		transl['Н']='N';     transl['н']='n';
		transl['О']='O';     transl['о']='o';
		transl['П']='P';     transl['п']='p';
		transl['Р']='R';     transl['р']='r';
		transl['С']='S';     transl['с']='s';
		transl['Т']='T';     transl['т']='t';
		transl['У']='U';     transl['у']='u';
		transl['Ф']='F';     transl['ф']='f';
		transl['Х']='X';     transl['х']='x';
		transl['Ц']='C';     transl['ц']='c';
		transl['Ч']='Ch';    transl['ч']='ch';
		transl['Ш']='Sh';    transl['ш']='sh';
		transl['Щ']='Shh';    transl['щ']='shh';
		transl['Ъ']='"';     transl['ъ']='';
		transl['Ы']='Y';    transl['ы']='y';
		transl['Ь']='';    transl['ь']='';
		transl['Э']='E';    transl['э']='e';
		transl['Ю']='Yu';    transl['ю']='yu';
		transl['Я']='Ya';    transl['я']='ya';
		transl[' ']='_';

		var result='';
		for(i=0;i<text.length;i++) {
			if(transl[text[i]]!=undefined) { result+=transl[text[i]]; }
			else { result+=text[i]; }
		}
		document.getElementById('alias').value=result;
	}
	
	$( document ).ready(function() {
		//$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		$('.menu .item').tab()
		
		
		var path = $('#path').val();
		
		if(path != './content/item_template.php'){
			$('#query_field').addClass('disabled');
		}else{
			$('#query_field').removeClass('disabled');
		}
	});
	
</script>
