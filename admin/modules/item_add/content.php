<h1>Добавление товара</h1>

<div class="tabs">
	<div style="display: none;">
		<select class="ui search dropdown" id="hidden_select_add1">
			<option value="none">Пустая</option>
			<?
				foreach($site->get_unic_param() as $param){
					?><option value="<?=$param['name']?>"><?=$param['name']?></option><?
				}
			?>
		</select>
	</div>	
	
	<div class="ui top attached tabular menu">
		<a class="active item" data-tab="first">Основные параметры</a>
		<a class="item" data-tab="second">Характеристики</a>
		<a class="item" data-tab="third">Описание</a>
		<a class="item" data-tab="four">Комплектация</a>
		<a class="item" data-tab="five">Фото</a>
	</div>
	<div class="ui bottom attached active tab segment ui form" data-tab="first">
		<div class="field">
			<label>Категория</label>
			<select class="ui search dropdown" id="category">
				<?
					foreach($site->get_list('category') as $cat){
						?><option value="<?=$cat['id']?>"><?=$cat['name']?></option><?
					}
				?>
			</select>
		</div>
		<div class="field">
			<label>Подкатеория</label>
			<select class="ui search dropdown" id="subcategory">
				<option value="0">Нету</option>
				<?
					foreach($site->get_list('subcategory') as $cat){
						?><option value="<?=$cat['id']?>"><?=$cat['name']?></option><?
					}
				?>
			</select>
			<input type="text" id="subcategory_two" style="margin-top: 10px;" placeholder="Если отсутствует подкатегория">
		</div>	
		<div class="field">
			<label>Ссылка на страницу производителя</label>
			<input type="text" id="href">
		</div>	
		<div class="field">
			<label>Название</label>
			<input type="text" id="name" placeholder="Подъемник легковой T100">
		</div>
		<div class="field">
			<label>Артикул</label>
			<input type="text" id="art" placeholder="T100">
		</div>
		<div class="field">
			<label>Производитель</label>
			<input type="text" id="maker" placeholder="Skynet">
		</div>
		<div class="field">
			<label>Код товара из 1с</label>
			<input type="text" id="kod" placeholder="А0001055">
		</div>
		<div class="ui checkbox">
			<input type="checkbox" id="type_price">
			<label>Цена указана за 1ед</label>
		</div>
		<div class="field">
			<label>Цена</label>
			<input type="text" id="price" placeholder="10325">
		</div>
		<div class="field">
			<label>Цена со скидкой</label>
			<input type="text" id="price_sale" placeholder="9999">
		</div>
		
		<div class="field">
			<label>Наличие</label>
			<select class="ui dropdown" id="count">
				<option value="0">Временно остсутствует</option>
				<option value="1">Доступно под заказ</option>
				<option value="2">Наличие уточните у менеджера</option>
				<option value="3">Имеется в наличии</option>
				<option value="4">Наличие и ценник уточните у менеджера</option>
			</select>
		</div>
		
	</div>
	
	<div class="ui bottom attached tab segment" data-tab="second">
		<button onclick="addLine('add1')" class="ui primary button">Добавить строку</button>
		<input type="hidden" id="add1_count" value="0">
		
		<form class="ui form" id="add1">
			<div class="field" id="after_clone_add1">
				
			</div>	
		</form>
		
	</div>
	<div class="ui bottom attached tab segment" data-tab="third">
		<textarea id="content" name="content"></textarea>
	</div>
	<div class="ui bottom attached tab segment" data-tab="four">
		<button onclick="addLine('add3')" class="ui primary button">Добавить строку</button>
		<input type="hidden" id="add3_count" value="0">
		
		<form class="ui form" id="add3">
			<div class="field" id="after_clone_add3">
				
			</div>	
		</form>
	</div>
	
	<div class="ui bottom attached tab segment" data-tab="five">
		<span>Остальные фотографии</span>
		<form class="dropzone" id="myAwesomeDropzoneEdit">
			<input type="hidden" name="name" id="namePhoto" value="test_0.jpg" />
			<input type="hidden" name="name_min" id="namePhoto_min" value="test_0.jpg" />
			<input type="hidden" name="typePOST" id="typePOST" value="1" />
		</form>
		
		<span>Основная фотография</span>
		<form class="dropzone" id="myAwesomeDropzoneEdit_main">
			<input type="hidden" name="name" id="main_namePhoto" value="test_0.jpg" />
			<input type="hidden" name="name_min" id="main_namePhoto_min" value="test_0.jpg" />
		</form>
	</div>
		
	<div class="field" style="float: right;">
		<button class="ui primary button" onclick="save()">Сохранить</button>
	</div>
	
</div> 
<script>	
	CKEDITOR.replace( 'content' );

	var myDropzoneEdit, myDropzoneEdit_main;

	function testTo_(item, hr, jd){
		var newItem = "";
		for(var i=0; item[i]; i++)
			if(item[i] == hr)
				newItem += jd;
			else
				newItem += item[i];
		return newItem;	
	}	
	
	function addLine(id){
		var newCount = parseInt($('#'+id+'_count').val());
		newCount++;
		$('#'+id+'_count').val( newCount );
		
		if(id == 'add3'){
			$('#after_clone_'+id).append(
				'<div class="ui divider"></div>'+
				'<div class="two fields">'+
					'<div class="field">'+
						'<input type="text" id="'+id+'_name_'+newCount+'" placeholder="значение">'+
					'</div>'+
					'<div class="field">'+
						'<input type="text" id="'+id+'_val_'+newCount+'" placeholder="значение">'+
					'</div>'+
				'</div>');
		}
		
		if(id == 'add1'){
			var select = $('#hidden_select_'+id).clone();
	
			$('#after_clone_'+id).append(
				'<div class="ui divider"></div>'+
				'<div class="two fields" style="height: 86px;">'+
					'<div class="field">'+
						'<select class="ui search dropdown" id="'+id+'_sel_'+newCount+'">'+
							select[0].innerHTML+
						'</select>'+
					'</div>'+
					'<div class="field" style="margin-top: 50px; position: absolute;">'+
						'<input type="text" id="'+id+'_newName_'+newCount+'" placeholder="Введите новый параметр">'+
					'</div>'+	
					'<div class="field">'+
						'<input type="text" id="'+id+'_val_'+newCount+'" placeholder="значение">'+
					'</div>'+
				'</div>');
		}
		
		$('.ui.dropdown').dropdown()
		
	}
	
	function save(){
		var category	 	= $('#category').val(),
			subcategory 	= $('#subcategory').val(),
			name			= $('#name').val(),
			art				= $('#art').val(),
			href			= $('#href').val(),
			kod				= $('#kod').val(),
			type_price		= $('#type_price').prop("checked"),
			price 			= $('#price').val(),
			price_sale		= $('#price_sale').val(),
			maker			= $('#maker').val(),
			count			= $('#count').val(),
			subcat_two		= $('#subcategory_two').val(),	
			add1			= [],
			add3			= [],
			description		= CKEDITOR.instances.content.getData()
			
		type_price = type_price?'2':'1';	
			
		for(var i=1; document.getElementById('add1_sel_'+i); i++){
			if($('#add1_sel_'+i).val() != 'none' || $('#add1_newName_'+i).val()){
				add1 = add1.concat({name: testTo_($('#add1_newName_'+i).val()?$('#add1_newName_'+i).val():$('#add1_sel_'+i).val(), '"', " "), value: testTo_($('#add1_val_'+i).val(), '"', " ")})
			}
		}	
			
		for(var i=1; document.getElementById('add3_name_'+i); i++){
			if($('#add3_name_'+i).val()){
				add3 = add3.concat({name: testTo_($('#add3_name_'+i).val(), '"', " "), value: testTo_($('#add3_val_'+i).val(), '"', " ")})
			}
		}	
			
		var sub_cat_che = 0;
		
		if(subcat_two.length > 0){
			sub_cat_che = 1;
		}		
			
		if(name && art){
			$.ajax({
				url: "../../modules/php/route.php",
				data: {
						type: 			'save_item', 
						name: 			name, 
						category: 		category, 
						subcategory: 	subcategory, 
						art: 			art, 
						subcat_two:		subcat_two,
						sub_cat_che:	sub_cat_che,
						count: 			count, 
						href:			href,
						maker:			maker,
						description: 	description, 
						kod:			kod,
						type_price:		type_price,
						price: 			parseFloat(price), 
						price_sale: 	price_sale, 
						add1: 			add1,
						add3: 			add3
					},
				type: 'POST',
				cache: false, 
				success: function(data) {
					console.log(data)
					
					if(parseInt(data) != 'NaN'){
						$('#namePhoto').val(parseInt(data)+'_0.jpg');
						
						$('#main_namePhoto').val(parseInt(data)+'_main.jpg');
						$('#main_namePhoto_min').val('min_'+parseInt(data)+'_main.jpg');
						
						myDropzoneEdit.processQueue();
						myDropzoneEdit_main.processQueue();
					}
					
					if(parseInt(data) != 'NaN'){
						$('#modal_header').text('Добавление товара')
						$('#modal_text').text('Новый товар успешно добавлен')
						$('#modal_dialog').modal('show')
					}else{
						$('#modal_header').text('Добавление товара')
						$('#modal_text').text('Произошла ошибка при добавлении товара')
						$('#modal_dialog').modal('show')
					}
				}.bind(this)
			});
		}
			
	}
	
	$( document ).ready(function() {
		//$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		$('.menu .item').tab()
	});
	
	$('#preview-template > img').click(function(eventObject){
		console.log(eventObject)
	});
	
	myDropzoneEdit = new Dropzone(document.getElementById('myAwesomeDropzoneEdit'), {
		paramName: "file", 
		maxFilesize: 10, 
		url: "../../../img/items/load_images.php",
		method: "POST",
		//uploadMultiple: true,
		parallelUploads: 20,
		maxFiles: 20,
		autoProcessQueue: false,
		accept: function(file, done) {
			
			done();
		},
		init: function() {
			this.on("complete", function(file) {
				this.removeFile(file);
				
			})
			this.on("sending", function(file) {
				var name = $('#namePhoto').val(),
					name_1 = name.split('_'),
					name_2 = name_1[1].split('.');
				
				name_2 = parseInt(name_2)+1;
				
				if(name_2 != 'NaN' || name_2 != NaN){
					$.ajax({
						url: "/admin/modules/php/route.php",
						dataType: 'json',
						data: {type: 'save_img', name: name_1[0]+'_'+name_2+'.jpg', name_min: 'min_'+name_1[0]+'_'+name_2+'.jpg', id: name_1[0]},
						type: 'POST',
						cache: false
					});
				}
				
				
				$('#namePhoto').val(name_1[0]+'_'+name_2+'.jpg');
				$('#namePhoto_min').val('min_'+name_1[0]+'_'+name_2+'.jpg');
			})
		}
	});
	
	myDropzoneEdit_main = new Dropzone(document.getElementById('myAwesomeDropzoneEdit_main'), {
		paramName: "file", 
		maxFilesize: 10, 
		url: "../../../img/items/load_images.php",
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
