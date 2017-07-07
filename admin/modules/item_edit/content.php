<?
	$data['item'] = $site->get_this_item();
?>

<h1>Редактирование товара: <?=$data['item']['name']?></h1>

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
	
	<input type="hidden" id="item_id" value="<?=$data['item']['id']?>" />
	
	<div class="ui top attached tabular menu">
		<a class="active item" data-tab="first">Основные параметры</a>
		<a class="item" data-tab="second">Характеристики</a>
		<a class="item" data-tab="third">Описание</a>
		<a class="item" data-tab="four">Комплектация</a>
		<a class="item" data-tab="five">Фото</a>
	</div>
	
	<!-- Основные параметры -->
	<div class="ui bottom attached active tab segment ui form" data-tab="first">
		<div class="field">
			<label>Категория</label>
			<select class="ui search dropdown" id="category">
				<?
					foreach($site->get_list('category') as $cat){
						?><option <?=$data['item']['category_id']==$cat['id']?'selected':''?> value="<?=$cat['id']?>"><?=$cat['name']?></option><?
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
						?><option <?=$data['item']['subcategory_id']==$cat['id']?'selected':''?> value="<?=$cat['id']?>"><?=$cat['name']?></option><?
					}
				?>
			</select>
			<input type="text" id="subcategory_two" style="margin-top: 10px;" placeholder="Если отсутствует подкатегория">
		</div>		
		<div class="field">
			<label>Ссылка на страницу производителя</label>
			<input type="text" id="href" value="<?=$data['item']['href']?>">
		</div>
		<div class="field">
			<label>Название</label>
			<input type="text" id="name" value="<?=$data['item']['name']?>">
		</div>
		<div class="field">
			<label>Артикул</label>
			<input type="text" id="art" value="<?=$data['item']['art']?>">
		</div>
		<div class="field">
			<label>Производитель</label>
			<input type="text" id="maker" value="<?=$data['item']['subname']?>">
		</div>
		<div class="field">
			<label>Код товара из 1с</label>
			<input type="text" id="kod" value="<?=$data['item']['kod']?>" placeholder="А0001055">
		</div>
		<div class="ui checkbox">
			<input type="checkbox" <?=$data['item']['type_price']==2?'checked':''?> id="type_price">
			<label>Цена указана за 1ед</label>
		</div>
		<div class="field">
			<label>Цена</label>
			<input type="text" id="price" value="<?=$data['item']['price']?>">
		</div>
		<div class="field">
			<label>Цена со скидкой</label>
			<input type="text" id="price_sale" value="<?=$data['item']['sale_price']?>">
		</div>
		
		<div class="field">
			<label>Наличие</label>
			<select class="ui dropdown" id="count">
				<option <?=$data['item']['count']==0?'selected':''?> value="0">Временно остсутствует</option>
				<option <?=$data['item']['count']==1?'selected':''?> value="1">Доступно под заказ</option>
				<option <?=$data['item']['count']==2?'selected':''?> value="2">Наличие уточните у менеджера</option>
				<option <?=$data['item']['count']==3?'selected':''?> value="3">Имеется в наличии</option>
				<option <?=$data['item']['count']==4?'selected':''?> value="4">Наличие и ценник уточните у менеджера</option>
			</select>
		</div>
		
	</div>
	
	<!-- Характеристики -->
	<div class="ui bottom attached tab segment" data-tab="second">
		<button onclick="addLine('add1')" class="ui primary button">Добавить строку</button>
		
		<form class="ui form" id="add1">
			<div class="field" id="after_clone_add1">
				<?
					$i=0;
				
					foreach($data['item']['param_1'] as $param){
						$abc = false;
						$i++;
						?>
							<div class="ui divider"></div>
							<div class="two fields" style="height: 86px;">
								<div class="field">
									<select class="ui search dropdown" id="add1_sel_<?=$i?>">
										<?
											foreach($site->get_unic_param() as $param2){
												$abc = $param2['name']==$param['name']?true:false;
												
												?><option <?=$param2['name']==$param['name']?'selected':''?> value="<?=$param2['name']?>"><?=$param2['name']?></option><?
											}
										?>
									</select>
								</div>
								<div class="field" style="margin-top: 50px; position: absolute;">
									<input type="text" id="add1_newName_<?=$i?>" placeholder="Введите новый параметр">
								</div>
								<div class="field">
									<input type="text" id="add1_val_<?=$i?>" value="<?=$param['value']?>">
								</div>
							</div>
						<?
						
					}
				?>
			</div>	
		</form>
		
		<input type="hidden" id="add1_count" value="<?=$i?>">
		
	</div>
	
	<!-- Описание -->
	<div class="ui bottom attached tab segment" data-tab="third">
		<textarea id="content" name="content"><?=$data['item']['description']?></textarea>
	</div>
	
	<!-- комплектация -->
	<div class="ui bottom attached tab segment" data-tab="four">
		<button onclick="addLine('add3')" class="ui primary button">Добавить строку</button>
		
		<form class="ui form" id="add3">
			<div class="field" id="after_clone_add3">
				<?
					$i=0;
				
					foreach($data['item']['param_2'] as $param){
						?>
							<div class="ui divider"></div>
							<div class="two fields">
								<div class="field">
									<input type="text" id="add3_name_<?=$i?>" value="<?=$param['name']?>">
								</div>
								<div class="field">
									<input type="text" id="add3_val_<?=$i?>" value="<?=$param['value']?>">
								</div>
							</div>
						<?
						$i++;
					}
				?>
			</div>	
		</form>
		
		<input type="hidden" id="add3_count" value="<?=$i?>">
		
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
		var id				= $('#item_id').val(),
			category	 	= $('#category').val(),
			subcategory 	= $('#subcategory').val(),
			name			= $('#name').val(),
			art				= $('#art').val(),
			href			= $('#href').val(),
			price 			= $('#price').val(),
			price_sale		= $('#price_sale').val(),
			maker			= $('#maker').val(),
			art				= $('#art').val(),
			kod				= $('#kod').val(),
			type_price		= $('#type_price').prop("checked"),
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
						type: 			'update_item', 
						id:				id,
						name: 			name, 
						category: 		category, 
						subcategory: 	subcategory, 
						art: 			art, 
						href:			href,
						count:			count,
						maker:			maker,
						subcat_two:		subcat_two,
						sub_cat_che:	sub_cat_che,
						description: 	description, 
						price: 			price, 
						price_sale: 	price_sale, 
						add1: 			add1,
						add3: 			add3,
						type_price:		type_price
					},
				type: 'POST',
				cache: false,
				success: function(data) {
					console.log(data)
					console.log(data.trim())
					
					if(data.trim() != false || data.trim() != 'false'){
						$('#namePhoto').val(parseInt(data)+'_0.jpg');
						
						$('#main_namePhoto').val(parseInt(data)+'_main.jpg');
						$('#main_namePhoto_min').val('min_'+parseInt(data)+'_main.jpg');
						
						myDropzoneEdit.processQueue();
						myDropzoneEdit_main.processQueue();
					}
					
					if(data.trim() != false || data.trim() != 'false'){
						$('#modal_header').text('Обновление товара')
						$('#modal_text').text('Изменения успешно сохранены')
						$('#modal_dialog').modal('show')
					}else{
						$('#modal_header').text('Обновление товара')
						$('#modal_text').text('Произошла ошибка при обновлении товара')
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
	
	myDropzoneEdit = new Dropzone(document.getElementById('myAwesomeDropzoneEdit'), {
		paramName: "file", 
		maxFilesize: 10, 
		url: "../../../img/items/load_images.php",
		method: "POST",
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
						data: {type: 'update_img', name: name_1[0]+'_'+name_2+'.jpg', name_min: 'min_'+name_1[0]+'_'+name_2+'.jpg', id: name_1[0]},
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
