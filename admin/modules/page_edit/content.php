<?
	$page = $site->get_one('pages', $site->get_uri()[0]);
?>

<div>
	<h1>Редактирование страницы: <?=$page['name']?></h1>
	<form class="ui form">
		
		<div class="ui top attached tabular menu">
			<a class="item active" data-tab="first">Ссылка</a>
			<a class="item" data-tab="second">META</a>
			<a class="item" data-tab="third">Контент</a>
		</div>
		
		<!-- ССЫЛКИ -->
		<div class="ui bottom attached tab segment active form" data-tab="first">
			<div class="field">
				<div class="ui checkbox">
					<input <?=$page['is_show']==1?'checked':''?> id="this_is_show" type="checkbox" tabindex="0">
					<label style="color: #333 !important;">Активность</label>
				</div>
			</div>
			<div class="field">
				<label>Название страницы</label>
				<input type="text" id="name" onblur="translit()" value="<?=$page['name']?>">
			</div>
			<div class="field <?=$page['is_edit_alias']==1?'':'disabled'?>" id="alias_class">
				<label>Alias</label>
				<input class="" type="text" id="alias" value="<?=$page['alias']?>">
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
								?><option <?=$page['path']==$item->full_path?'selected':''?> value="<?=$item->full_path?>"><?=$item->name?></option><?
							}
						?>
					</select>
				</div>

				<div class="field" id="query_field">
					<label>Категория</label>
					<select class="ui fluid search dropdown" id="query">
						<option value="0">Пусто</option>
						<?
							foreach($site->get_list('category') as $item){
								?><option <?=$page['query']==$item['id']?'selected':''?> value="<?=$item['id']?>"><?=$item['name']?></option><?
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
				<input type="text" id="h1" value="<?=$page['h1']?>">
			</div>
			<div class="field">
				<label>Title</label>
				<input type="text" id="title" value="<?=$page['title']?>">
			</div>
			<div class="field">
				<label>Description</label>
				<textarea id="description"><?=$page['description']?></textarea>
			</div>
		</div>
		
		<!-- КОНТЕНТ -->
		<div class="ui bottom attached tab segment" data-tab="third">
			<h2>Текст до основного контента</h2>
			<textarea id="content_1" name="content_1"><?=$page['content_after']?></textarea>
			<h2>Текст после основного контента (если есть)</h2>
			<textarea id="content_2" name="content_2"><?=$page['content_before']?></textarea>
		</div>
	</form>
	
	<div class="field" style="float: right;">
		<button class="ui primary button" onclick="save(<?=$page['id']?>)">Сохранить</button>
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
		
		//console.log(path);
	}
	
	function save(id){
		var name = $('#name').val(),
			h1 = $('#h1').val(),
			alias = $('#alias').val(),
			title = $('#title').val(),
			description = $('#description').val(),
			path = $('#path').val(),
			query = $('#query').val(),
			is_show = $("#this_is_show").prop("checked"),
			content_1 = CKEDITOR.instances.content_1.getData(),
			content_2 = CKEDITOR.instances.content_2.getData();
			
		if($('#query_field').attr('class') == 'field disabled'){
			query = '0';
		}	
		
		is_show = is_show?1:0;	
			
		//if(name && alias){
			$.ajax({
				url: "../../modules/php/route.php",
				data: {type: 'update_page', is_show: is_show, id: id, h1: h1, name: name, alias: alias, title: title, description: description, content_1: content_1, content_2: content_2, path: path, query: query},
				type: 'POST',
				cache: false,
				success: function(data) {
					console.log(data)
					if(data.trim() == 'true'){
						$('#modal_header').text('Обновление страницы')
						$('#modal_text').text('Страница успешно обновлена')
						$('#modal_dialog').modal('show')
					}else{
						$('#modal_header').text('Обновление страницы')
						$('#modal_text').text('Произошла ошибка при обновлении страницы')
						$('#modal_dialog').modal('show')
					}
				}.bind(this)
			}); 
		//}
			
	}
	
	function translit(){
		var text = document.getElementById('name').value,
			end	= document.getElementById('alias_class').className;
			
		console.log(end);	
			
		if(end != 'field disabled'){
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
			transl['Ъ']='';     transl['ъ']='';
			transl['Ы']='Y';    transl['ы']='y';
			transl['Ь']='';    transl['ь']='';
			transl['Э']='';    transl['э']='e';
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
		
	}
	
	$( document ).ready(function() {
		$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		//$('.menu .item').tab()
		var path = $('#path').val();
		$('#query_field').addClass('disabled');
		
		if(path == './content/category_template.php'){
			$('#query_field').removeClass('disabled');
			console.log('sa');
		}
	});
</script>