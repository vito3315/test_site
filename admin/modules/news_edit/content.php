<?
	$page = $site->get_one('news', $site->get_uri()[0]);
?>

<div class="tabs">
	<h1>Редактирование страницы: <?=$page['name']?></h1>
	<div class="ui form">
		
		<div class="ui top attached tabular menu">
			<a class="active item" data-tab="first">Основные параметры</a>
			<a class="item" data-tab="second">МЕТА</a>
			<a class="item" data-tab="third">Текст</a>
			<a class="item" data-tab="five">Фото</a>
		</div>
		
		<input type="hidden" id="this_id" value="<?=$page['id']?>">
		
		<!-- ССЫЛКИ -->
		<div class="ui bottom attached tab segment active" data-tab="first">
			<div class="field">
				<div class="ui checkbox">
					<input <?=$page['is_show']==1?'checked':''?> id="this_is_show" type="checkbox" tabindex="0">
					<label style="color: #333 !important;">Активность</label>
				</div>
			</div>
			<div class="field">
				<label>Название новости</label>
				<input type="text" id="name" onblur="translit()" value="<?=$page['name']?>">
			</div>
			<div class="field">
				<label>Дата окончания действия новости</label>
				<input type="date" id="date" value="<?=$page['date_end']?>">
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input type="checkbox" <?=$page['date_end']==1?'checked':''?> tabindex="0" id="this_date">
					<label>Новость активна всегда</label>
				</div>
			</div>
			<div class="field">
				<label>Alias</label>
				<input type="text" id="alias" value="<?=$page['alias']?>">
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
			<h2>Текст новости</h2>
			<textarea id="content_1" name="content_1"><?=$page['content']?></textarea>
		</div>
		
		<div class="ui bottom attached tab segment" data-tab="five">
			<h2>Изображение новости</h2>
			<form class="dropzone" id="myAwesomeDropzoneEdit_main">
				<input type="hidden" name="name" id="main_namePhoto" value="test_0.jpg" />
			</form>
		</div>
	</div>
	
	<div class="field" style="float: right;">
		<button class="ui primary button" onclick="save(<?=$page['id']?>)">Сохранить</button>
	</div>
	
</div> 
<script>
	CKEDITOR.replace( 'content_1' );

	var myDropzoneEdit_main, flagImagesToEdit = false;

	function save(){
		var name			= $('#name').val(),
			alias			= $('#alias').val(),
			date 			= $('#date').val(),
			this_date		= $("#this_date").prop("checked"),
			h1				= $('#h1').val(),
			title			= $('#title').val(),
			description		= $('#description').val(),	
			is_show			= $("#this_is_show").prop("checked"),
			text			= CKEDITOR.instances.content_1.getData();
			
		this_date = this_date?1:0;
		
		is_show = is_show?1:0;
		
		var test_date;
		
		if(this_date == 1){
			test_date = '1';
		}else{
			test_date = date;
		}		
			
		$.ajax({
			url: "../../modules/php/route.php",
			data: {
					type: 				'update_news', 
					name: 				name, 
					id:					$('#this_id').val(),
					alias: 				alias, 
					date: 				test_date, 
					h1: 				h1, 
					title:				title,
					description:		description,
					text: 				text,
					is_show: 			is_show,
					flagImagesToEdit: 	flagImagesToEdit,
					photo:				alias+'.jpg'
				},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				
				if(data.trim() == 'true'){
					$('#main_namePhoto').val(alias+'.jpg');
					
					if(flagImagesToEdit){
						myDropzoneEdit_main.processQueue();
					}
				}
				
				if(data.trim() == 'true'){
					$('#modal_header').text('Обновление новости')
					$('#modal_text').text('Новость успешно обновлена')
					$('#modal_dialog').modal('show')
				}else{
					$('#modal_header').text('Обновление новости')
					$('#modal_text').text('Произошла ошибка при обновлении новости')
					$('#modal_dialog').modal('show')
				}
			}.bind(this)
		});
		
			
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
	});
		
	myDropzoneEdit_main = new Dropzone(document.getElementById('myAwesomeDropzoneEdit_main'), {
		paramName: "file", 
		maxFilesize: 10, 
		url: "../../../img/news/load_images.php",
		method: "POST",
		//uploadMultiple: true,
		//parallelUploads: 20,
		maxFiles: 1,
		autoProcessQueue: false,
		accept: function(file, done) {
			done();
		},
		init: function() {
			this.on("complete", function(file) {
				this.removeFile(file);
			})
			this.on("addedfile", function(file) {
				flagImagesToEdit = true;	
			});
		}
	});
</script>