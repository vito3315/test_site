<?
	$slide = $site->get_one('slider', $site->get_uri()[0]);
?>

<h1>Редактирование слайда: <?=$slide['title']?></h1>

<div style="width: 25%; float: left;">
	<img src="<?=$site->addr?>/<?=$slide['photo_addr']?>" style="width: 100%; padding-right: 15px;"/>
</div>
<div style="width: 75%; float: left;">
	<form class="dropzone" id="myAwesomeDropzoneEdit_main">
		<input type="hidden" name="name" id="main_namePhoto" value="<?=$slide['photo_addr']?>" />
	</form>
</div>

<div class="ui form">
	<div class="field">
		<label>Заголовок</label>
		<input type="text" id="new_fileTitle" value="<?=$slide['title']?>" onblur="translit()">
	</div>
	<div class="field">
		<div class="ui checkbox">
			<input <?=$slide['is_show']==1?'checked':''?> type="checkbox" tabindex="0" id="fileShow">
			<label>Показывать на сайте</label>
		</div>
	</div>
</div>

<button class="ui primary button" onclick="update_slide(<?=$slide['id']?>)" style="margin-top: 10px;">Обновить</button>

<script>
	var myDropzoneEdit, myDropzoneEdit_main;

	function update_slide(id){
		var file_name = $('#main_namePhoto').val(),
			name = $('#new_fileTitle').val(),
			is_show = document.getElementById('fileShow').checked;
			
		file_name = file_name.split('/');	
		file_name = file_name.length==1?file_name[0]:file_name[file_name.length-1];	
		
		is_show = is_show?1:0;	
		//if(link_content!=0 && !link_page || link_page){
		//if(link_content!=0){	
			$.ajax({
				url: "../../modules/php/route.php",
				data: {type: 'update_slide', id: id, name: name, is_show: is_show, file_name: file_name},
				type: 'POST',
				cache: false,
				success: function(data) {
					console.log(data)
					if(data.trim() == 'true'){
						$('#modal_header').text('Обновление слайда')
						$('#modal_text').text('Слайд успешно обновлен')
						$('#modal_dialog').modal('show')
					}else{
						$('#modal_header').text('Обновление слайда')
						$('#modal_text').text('Произошла ошибка при обновлении слайда')
						$('#modal_dialog').modal('show')
					}
				}.bind(this)
			});
		//}	
		
			
	}
	
	function translit(){
		var text=document.getElementById('new_fileTitle').value;
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
		document.getElementById('main_namePhoto').value=result+'.jpg';
	}	
	
	myDropzoneEdit_main = new Dropzone(document.getElementById('myAwesomeDropzoneEdit_main'), {
		paramName: "file", 
		maxFilesize: 10, 
		url: "../../../img/slider/load_images.php",
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
	
	
	$( document ).ready(function() {
		//$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		$('.ui.radio.checkbox').checkbox()
		// Initialise the table
		//$("#table_menu").tableDnD();
		// Make a nice striped effect on the table
		//$("#table_menu tr:even").addClass("alt");
	
	});
</script>