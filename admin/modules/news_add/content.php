<h1>Добавление новости</h1>

<div class="tabs">
	<div class="ui form">
	
		<div class="ui top attached tabular menu">
			<a class="active item" data-tab="first">Основные параметры</a>
			<a class="item" data-tab="second">МЕТА</a>
			<a class="item" data-tab="third">Текст</a>
			<a class="item" data-tab="five">Фото</a>
		</div>
		
		<div class="ui bottom attached tab segment active" data-tab="first">
			<div class="field">
				<label>Название новости</label>
				<input type="text" id="name" onblur="translit()" placeholder="Новая страница">
			</div>
			<div class="field">
				<label>Дата окончания действия новости</label>
				<input type="date" id="date">
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input type="checkbox" tabindex="0" id="this_date">
					<label>Новость активна всегда</label>
				</div>
			</div>
			<div class="field">
				<label>Alias</label>
				<input type="text" id="alias" placeholder="new_page">
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
			<h2>Текст новости</h2>
			<textarea id="content_1" name="content_1"></textarea>
		</div>
		
		<div class="ui bottom attached tab segment" data-tab="five">
			<h2>Изображение новости</h2>
			<form class="dropzone" id="myAwesomeDropzoneEdit_main">
				<input type="hidden" name="name" id="main_namePhoto" value="test_0.jpg" />
			</form>
		</div>
			
		<div class="field" style="float: right;">
			<button class="ui primary button" onclick="save()">Сохранить</button>
		</div>
		
	</div>
</div> 
<script>	
	CKEDITOR.replace( 'content_1' );

	var myDropzoneEdit_main;

	function save(){
		var name			= $('#name').val(),
			alias			= $('#alias').val(),
			date 			= $('#date').val(),
			this_date		= $("#this_date").prop("checked"),
			h1				= $('#h1').val(),
			title			= $('#title').val(),
			description		= $('#description').val(),	
			text			= CKEDITOR.instances.content_1.getData();
			
		this_date = this_date?1:0;
		
		var test_date;
		
		if(this_date == 1){
			test_date = '1';
		}else{
			test_date = date;
		}		
			
		$.ajax({
			url: "../../modules/php/route.php",
			data: {
					type: 			'save_news', 
					name: 			name, 
					alias: 			alias, 
					date: 			test_date, 
					h1: 			h1, 
					title:			title,
					description:	description,
					text: 			text,
					photo:			alias+'.jpg'
				},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				
				if(data.trim() == 'true'){
					$('#main_namePhoto').val(alias+'.jpg');
					
					myDropzoneEdit_main.processQueue();
				}
				
				if(data.trim() == 'true'){
					$('#modal_header').text('Добавление новости')
					$('#modal_text').text('Новая новость успешно добавлена')
					$('#modal_dialog').modal('show')
				}else{
					$('#modal_header').text('Добавление новости')
					$('#modal_text').text('Произошла ошибка при добавлении новости')
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
		}
	});
	
</script>
