<?$data['load_lib'] = array('items_cart');?>

<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['content_page']['h1']?></h1>	
	
<div class="row category" style="padding-left: 4%; padding-right: 4%; min-height: 500px;" id="main_content">
	<div class="row card-panel col-md-12 col-xs-12 col-sm-12 col-lg-12" id="main_content_div">
	
		<ul id="tabs-swipe-demo red darken-2" class="tabs">
			<li class="tab col s4"><a class="active" href="#test-swipe-1">Корзина</a></li>
			<li class="tab col s4"><a href="#test-swipe-2">Доставка</a></li>
			<li class="tab col s4"><a href="#test-swipe-3">Оплата</a></li>
		</ul>
		<div id="test-swipe-1" class="col s12">
		
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" id="myCart">
			</div>	
			
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
				<div class="h5" style="display: none;text-align: center;margin-top: 25px;" id="empty_cart">Корзина пуста.</div>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">	
				<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12 not_action" style="padding: 15px 0px; display: flex; flex-wrap: wrap;">
					<div class="col-md-2 col-xs-12 col-sm-2 col-lg-2">
					</div>
					<div class="col-md-4 col-xs-12 col-sm-4 col-lg-4" style="margin: auto;">
					</div>
					<div class="col-md-3 col-xs-12 col-sm-3 col-lg-3" style="margin: auto;">
					</div>
					<div class="col-md-3 col-xs-12 col-sm-3 col-lg-3" id="price_to_pay" style="margin: auto;">
						<span>К оплате: </span>
						<span style="font-size: 2.1em; font-family: 'a_Stamper Bold', arial;" id="full_price"></span><i style="font-size: 2.1em;" class="fa fa-rub"></i>
					</div>
				</div>	
			</div>
		</div>
		<div id="test-swipe-2" class="col s12">
			<br />
			<div>Забрать заказ можно на адресу: самарская область, г. Тольятти, Приморский 45.</div>
			<div>Возможна доставка по городу, доставка осуществляется раз в неделю.</div>
			<div>Возможна доставка и в другие города через транспортную компанию.</div>
			<div>
				Для уточнения времени и стоимости доставки свяжитесь по одному из следующих номеров: 
				<div style="margin-left: 15px;">Валерий - 8 903 3320510; (8482) 766-001</div>
				<div style="margin-left: 15px;">Алексей - 8 903 3330211</div>
				или закажите обратный звонок с сайта.
			</div>
			<br />
			<iframe src="https://www.google.com/maps/d/embed?mid=15ZxH4p7JmBa0W0xi4tk2mvYeGms" frameborder="0" id="map" style="width: 100%; height: 515px;"></iframe>
		</div>
		<div id="test-swipe-3" class="col s12">
			<p>Оплата осуществляется на месте наличным и безналичным расчетом. Безналичный расчет - выставление счета на оплату через банк или перевод с карты на карту.</p>
		</div>
	
		
		<a class="btn_count green_ waves-effect waves-light" style="float: right;" href="#modal_order" id="for_order_now">Заказать</a>
		
		<div id="modal_order" class="modal">
			<div class="modal-content">
				<span class="h5">Подтверждение заказа</span>
				<p>Подтверждая заказ, вы соглашаетесь с возможностями получения заказа и его оплаты.</p>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action waves-effect waves-green btn-flat" onclick="order()">Подтвердить заказ</a>
				<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Отмена</a>
			</div>
		</div>
		
		<div id="modal_order_true" class="modal">
			<div class="modal-content">
				<span class="h5">Спасибо за заказ</span>
				<p>В ближайшее время с вами свяжется наш менеджер для уточнения заказа.</p>
			</div>
			<div class="modal-footer">
				<a href="#!" class="modal-action waves-effect waves-green btn-flat" onclick="order_true()">Хорошо</a>
			</div>
		</div>
		
		<div id="modal_fast_reg_log" class="modal">
			<div class="modal-content">
				<span class="h5">Чтобы сделать заказ необходимо авторизоваться.</span>
				
				<div class="row col-md-6 col-xs-12 col-sm-6 col-lg-6" id="reg_fast" style="padding-top: 15px;">
					<span>Сделать быстрый заказ, без регистрации</span>
					<div class="input-field">
						<input id="first_name_fast" type="url" class="">
						<label for="first_name_fast">Имя</label>
					</div>
					<div class="input-field">
						<input id="last_name_fast" type="url" class="">
						<label for="last_name_fast">Фамилия</label>
					</div>
					<div class="input-field">
						<input id="phone_fast" type="tel" class="validate">
						<label for="phone_fast" data-error="Номер телефона введен некорректно" data-success="">Номер телефона</label>
					</div>
					<div class="input-field">
						<input id="email_fast" type="email" class="validate">
						<label for="email_fast" data-error="E-mail введен некорректно">E-mail</label>
					</div>
					<div class="input-field" style="padding-bottom: 25px;">
						<input type="checkbox" id="politic" class="validate" />
						<label for="politic" id="politic_for">Я даю соглашение на обработку моих персональных данных, согласно настоящей <a target="blank_" href="<?=$site->addr?>/politika_konfidencialnosti/">политики конфиденциальности</a></label>
					</div>
					
					<div class='g-recaptcha' data-sitekey='6LdgSBkTAAAAAJCnlv-r4v7pL9kJqxyjQrvS1aJE'></div>
					
					<button class="waves-effect waves-light btn" style="margin-top: 15px;" onclick="reg_fast()">Сделать заказ</button>
				</div>
				<div class="row col-md-6 col-xs-12 col-sm-6 col-lg-6" style="padding-top: 15px;">
					<span>Войти под своим логином, паролем</span>
					<div class="input-field">
						<input id="email_login_fast" type="email" class="validate">
						<label for="email_login_fast">E-mail</label>
					</div>
					<div class="input-field">
						<input id="pass_login_fast" type="password" class="validate">
						<label for="pass_login_fast">Пароль</label>
					</div>
					<div><a href="<?=$site->addr?>/registration/">Регистрация</a></div>
					<button class="waves-effect waves-light btn" style="margin-top: 15px;" onclick="log_fast()">Войти</button>
				</div>
			</div>
			
		</div>
		
	</div>
</div>

<script>
	function remove(this_id, number, name){
		if (confirm('Удалить из корзины '+name+'?')) {
			$('#this_'+number).remove();
			reprice();
			
			
			myCart = localStorage['myCart']?JSON.parse(localStorage['myCart']):[];
			var newCart = [];
			
			myCart.map(function(item){
				if(item.id != this_id){
					newCart = newCart.concat(item);
				}
			})
			
			if(localStorage['login']){
				$.ajax({
					url: "/admin/modules/php/route.php",
					data: {
							type: 'kill_item_from_cart',
							login: localStorage['login'],
							item_id: this_id
						},
					type: 'POST',
					cache: false,
					success: function(data) {
						console.log(data)
					}.bind(this)
				});
			}
			
			localStorage['myCart'] = JSON.stringify(newCart)
		}
	}

	function reg_fast(){
		var name 	= $('#first_name_fast').val(),
			fam 	= $('#last_name_fast').val(),
			phone 	= $('#phone_fast').val(),
			email 	= $('#email_fast').val(),
			politic = $('#politic')[0].checked,
			pass 	= $('#pass_fast').val();
			
		if(!politic){ 
			$('#politic_for').css('color', 'red'); 
			$('#politic').addClass('invalid');
		}else{ 
			$('#politic_for').css('color', '#9e9e9e'); 
			$('#politic').removeClass('invalid');
		}	
			
		if(!name){ $('#first_name_fast').addClass('invalid'); }else{ $('#first_name_fast').removeClass('invalid'); }
		
		if(!fam){ $('#last_name_fast').addClass('invalid'); }else{ $('#last_name_fast').removeClass('invalid'); }
		
		//if(!email){ $('#email_fast').addClass('invalid'); }
		if(email){
			var pattern_email = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
			if(!pattern_email.test(email)){
				$('#email_fast').addClass('invalid');
			}else{ 
				$('#email_fast').removeClass('invalid'); 
			}
		}
		
		if(!phone){ $('#phone_fast').addClass('invalid'); }else{ $('#phone_fast').removeClass('invalid'); }
		
		var pattern_phone = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i;
		if(!pattern_phone.test(phone)){
			$('#phone_fast').addClass('invalid');
		}else{ 
			$('#phone_fast').removeClass('invalid'); 
		}
		
		var err_count = $('#reg_fast > div > .invalid');
		
		console.log(err_count)
		
		if(err_count.length == 0){
			$.ajax({
				url: "/admin/modules/php/route.php",
				data: {
						type: 'reg_fast',
						name: name,
						fam: fam,
						phone: phone,
						email: email,
						data: document.getElementById('g-recaptcha-response').value
					},
				type: 'POST',
				cache: false,
				success: function(data) {
					console.log(data)
					
					if(data.trim() != 'recapture'){
						//localStorage['login'] = email;
						$('#modal_fast_reg_log').modal('close');
						//console.log(email)
						order(2, email?email:phone, data);
					}
					
				}.bind(this)
			});
		}
	}
	
	function log_fast(){
		$.ajax({
			url: "/admin/modules/php/route.php",
			dataType: 'json',
			data: {
					type: 'login_full',
					mail: $('#email_login_fast').val(),
					pass: $('#pass_login_fast').val()
				},
			type: 'POST',
			cache: false,
			success: function(data) {
				//console.log(data)
				
				if(data['mail']){
					localStorage['login'] = data['mail'];
					$('#modal_fast_reg_log').modal('close');
					order(1);
				}else{
					alert('Логин или пароль указаны неверно!');
				}
				
			}.bind(this)
		});
	}
	
	function order(type=0, email, id){
		if(localStorage['login'] || email){
			console.log(email, type, id, id.trim());
			$.ajax({
				url: "/admin/modules/php/route.php",
				data: {
						type: type==0?'to_my_order':'to_my_order_fast',
						login: email?email:localStorage['login'],
						user_type: type,
						user_id: id.trim(),
						cart: localStorage['myCart']?JSON.parse(localStorage['myCart']):[]
					},
				type: 'POST',
				cache: false,
				success: function(data) {
					console.log(data)
					data = data.trim();
					
					if(data == 'true'){//заказ сделан
					
						$.ajax({
							url: "/modules/send_post_order.php",
							cache: false,
							success: function(data1) {
							}.bind(this)
						});
					
						localStorage['myCart'] = '';
						$('#modal_order').modal('close');
						$('#modal_order_true').modal('open');
						setTimeout(function(){
							//location.reload();	
						}, 3500)
					}
					
					if(data == 'cart_empty'){//корзину пуста
						
					}
					
					if(data == 'false'){//проблема с авторизацией
						
					}
					
				}.bind(this)
			});
		}else{
			$('#modal_fast_reg_log').modal('open');
			console.log('asd');
		}
	}
	
	function order_true(){
		setTimeout(function(){
			location.reload();	
		}, 1500)
	}
	
	function reprice(){
		var full_price = 0;
		
		var items = $('#myCart');
		
		myCart = localStorage['myCart']?JSON.parse(localStorage['myCart']):[];
		var newCart = [];
		
		items.children('div:not(.not_action)').each(function(){
			var count = parseInt($(this).find('input').val());
			if(parseInt(count) <=0 || !parseInt(count)){count = 1;}
			
			console.log(count+'-');
			
			full_price += parseInt(count)*parseFloat($(this).find('.price').text());
			
			var this_id = $(this).attr('data-id');
				//count = parseInt($(this).find('select').val());
			
			//if(parseInt(count) <=0 || !parseInt(count)){count = 1;}
			
			myCart.map(function(item){
				if(item['id'] == this_id){
					newCart = newCart.concat({id: this_id, count: count});
				}
			})
			
			if(localStorage['login']){
				$.ajax({
					url: "/admin/modules/php/route.php",
					data: {
							type: 'kill_from_cart',
							login: localStorage['login'],
							item_id: this_id,
							count: count
						},
					type: 'POST',
					cache: false,
					success: function(data) {
						console.log(data)
					}.bind(this)
				});
			}
		})	
		
		localStorage['myCart'] = JSON.stringify(newCart)
		
		console.log(localStorage['myCart']);
		
		$('#full_price').text(full_price)
	}
</script>
