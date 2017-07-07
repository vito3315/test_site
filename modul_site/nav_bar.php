<div class="navbar-fixed">
	<nav class="white" role="navigation">
		<div class="nav-wrapper container">
			<a id="logo-container" class="brand-logo left" href="<?=$site->check_link($site->addr.'/')?>" style="height: 90%; margin-top: 2.5px;">
				<img src="<?=$site->addr?>/img/other_mages/main_logo3_new_1.png" style="height: 100%;" alt="Всё для шиномонтажа+"/>	
			</a>
			
			<!-- фиксированный верхний -->
			<ul class="right hide-on-small-only">
				<li class="hide-on-med-and-down tooltipped" data-position="bottom" data-delay="10" data-tooltip="Форма сравнения" onclick="to_compare()"><a><i class="material-icons small">insert_chart</i><span class="badge">0</span></a></li>
				<li class="hide-on-med-and-down"><a href="<?=$site->check_link($site->addr.'/kontakty/')?>">Контакты</a></li>
				<li class="hide-on-med-and-down" id="nav_contact"> <a>г. Тольятти Самарская обл.</a></li>
				<li id="nav_contact_1">
					<a>
						<span style="margin-top: -20px;">+7(903)3320510</span>
						<span>+7(903)3330211</span>
						<span>gva007@gmail.com</span>
					</a>
				</li>
				<li>
					<div id="sb-search" class="sb-search">
						<form>
							<input class="sb-search-input" placeholder="Поиск по сайту..." type="text" value="" name="search" id="search">
							<input class="sb-search-submit" type="submit" value="">
							<span class="sb-icon-search"><i class="fa fa-search" style="font-size:1.5em;"></i></span>
						</form>
					</div>
				</li>
			</ul>
			
			<?if($data['type_pc'] != 'pc'){?>
				<!-- мобильное меню категории -->
				<ul id="nav-mobile" class="side-nav">
					<li class="center-align">
						<div>
							<ul style="color: #000; font-size: 14px; font-weight: 500;">
								<li>ООО "Всё для шиномонтажа+"</li>
								<li>г. Тольятти Самарская обл.</li>
								<li>+7(903)3320510</li>
								<li>+7(903)3330211</li>
								<li>(8482) 766-001</li>
							</ul>
						</div>
					</li>
					<li class="center-align">
						<div class="ui search">
							<div class="ui icon input" style="width: 90%;">
								<input class="prompt" type="text" id="search_mobile" placeholder="Поиск по сайту...">
								<i class="search icon"></i>
							</div>
						</div>
					</li>
					<!--<li><a href="#modal1">Каталог</a></li>-->
					<li><a href="http://rossvik163.ru/">Шиномонтаж</a></li>
					<?foreach($data['menu_catalog'] as $item){?>
						<li><a href="<?=$site->check_link($site->addr.'/'.$item['alias'].'/')?>"><?=$item['name']?></a></li>
					<?}?>
					<li onclick="to_compare()"><a>Форма сравнения</a></li>
					<li><a href="<?=$site->addr?>/modules/php_excel/Examples/01simple-download-xlsx.php">Прайс-лист</a></li>
					<li><a href="<?=$site->check_link($site->addr.'/novinki/')?>">Новые поступления</a></li>
					<li><a href="<?=$site->check_link($site->addr.'/akcii/')?>">Акции</a></li>
					<li><a href="<?=$site->check_link($site->addr.'/kontakty/')?>">Контакты</a></li>
					<li><a href="<?=$site->check_link($site->addr.'/kak_oformit_zakaz/')?>">Как оформить заказ</a></li>
					<li><a href="<?=$site->check_link($site->addr.'/novosti/')?>">Новости</a></li>
					<li id="reg_mobile"><a href="<?=$site->check_link($site->addr.'/registration/')?>">Регистрация</a></li>
					<li id="log_mobile"><a href="#login">Войти</a></li>
					<li id="lk_mobile" style="display: none;"><a href="<?=$site->check_link($site->addr.'/lichnyj_kabinet/')?>">Личный кабинет</a></li>
					<li id="logout_mobile" style="display: none;"><a href="#" onclick="logout()">Выйти</a></li>
				</ul>
				<a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-bars fa-2x" aria-hidden="true"></i></a>
			<?}?>	
		</div>
	</nav>
</div>

<div id="login" class="modal">
    <div class="modal-content">
		<span class="h5">Авторизация</span>
		<div>
			<div class="input-field">
				<input id="email_login" type="tel" class="validate" />
				<label for="email_login">E-mail или номер телефона</label>
			</div>
			<div class="input-field">
				<input id="pass_login" type="password" class="validate" />
				<label for="pass_login">Пароль</label>
			</div>
			<div><a class="modal-close" href="#res_pas">Восстановить пароль</a></div>
		</div>
    </div>
    <div class="modal-footer">
		<a href="#!" class="modal-action waves-effect waves-green btn-flat" onclick="login()">Войти</a>
    </div>
</div>

<div id="res_pas" class="modal">
    <div class="modal-content">
		<span class="h5">Восстановление пароля</span>
		<div>
			<div class="input-field">
				<input id="email_res" type="email" class="validate" />
				<label for="email_res">Введите е-mail, который вы указывали при регистрации</label>
			</div>
		</div>
    </div>
    <div class="modal-footer">
		<a href="#!" class="modal-action waves-effect waves-green btn-flat" onclick="res_pas()">Отправить</a>
    </div>
</div>

<?if($data['type_pc'] == 'pc' || $data['type_pc'] == 'tablet'){?>
	<nav class="white hide-on-med-and-down" id="submenu">
		<div class="nav-wrapper" style="">
			
			<ul id="nav-mobile_" class="center nav_menu flex-box_menu">
				<li style="">
					<a href="#" class="dropdown-button" data-beloworigin="true" data-constrainwidth="false" data-activates="katalogs">Каталог</a>
						
					<ul id='katalogs' class='dropdown-content'>
						<?foreach($data['menu_catalog'] as $item){?>
							<li><a href="<?=$site->check_link($site->addr.'/'.$item['alias'].'/')?>"><?=$item['name']?></a></li>
							<li class="divider"></li>
						<?}?>
					</ul>	
				</li>
				<li style=""><a href="<?=$site->addr?>/modules/php_excel/Examples/01simple-download-xlsx.php" class="price_">Прайс-лист</a></li>
				<li style=""><a href="<?=$site->check_link($site->addr.'/novinki/')?>">Новые поступления</a></li>
				<li style=""><a href="<?=$site->check_link($site->addr.'/akcii/')?>">Акции</a></li>
				<li style=""><a href="<?=$site->check_link($site->addr.'/master-klassy/')?>">Мастер-классы</a></li>
				<li style=""><a href="http://rossvik163.ru/">Шиномонтаж</a></li>
				<li style=""><a href="<?=$site->check_link($site->addr.'/novosti/')?>">Новости</a></li>
				<li style="" id="reg_">
					<a href="#" class="dropdown-button" data-beloworigin="true" data-constrainwidth="false" data-activates="login_">Регистрация</a>
						
					<ul id='login_' class='dropdown-content'>
						<li><a href="#login">Войти</a></li>
						<li><a href="<?=$site->check_link($site->addr.'/registration/')?>">Зарегистрироваться</a></li>
					</ul>
				</li>
				<li style=" display: none;" id="log_">
					<a href="#" class="dropdown-button" data-beloworigin="true" data-constrainwidth="false" data-activates="LK">Личный кабинет</a>
						
					<ul id='LK' class='dropdown-content'>
						<li><a href="<?=$site->check_link($site->addr.'/lichnyj_kabinet/')?>">Личный кабинет</a></li>
						<li><a href="#" onclick="logout()">Выйти</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
<?}?>
	
<script>
	function to_compare(){
		if(sessionStorage.keys && sessionStorage.keys.length>0){
			location.href = "/sravnenie_tovarov&items="+sessionStorage.keys+"/";
		}
	}

	function res_pas(){
		$.ajax({
			url: "/admin/modules/php/route.php",
			data: {
					type: 'res_pas',
					mail: $('#email_res').val()
				},
			type: 'POST',
			cache: false,
			success: function(data) {
				data = data.trim();
				console.log(data)
				
				if(data != 'er_mail'){
					$('#res_pas').modal('close');
					alert('На указанный e-mail выслано письмо с новым паролем.');
					
					$.ajax({
						url: "/modules/send_post.php",
						data: {
								pass: data,
								mail_to: $('#email_res').val()
							},
						type: 'POST',
						cache: false,
						success: function(data) {
							console.log(data)
						}.bind(this)
					});
					
				}else{
					alert('E-mail указан неверно!');
				}
				
			}.bind(this)
		});
	}

	function logout(){
		localStorage['myCart'] = '';
		localStorage['login'] = '';
		
		location.reload();
	}
	
	function login(){
		$.ajax({
			url: "/admin/modules/php/route.php",
			dataType: 'json',
			data: {
					type: 'login_full',
					mail: $('#email_login').val(),
					pass: $('#pass_login').val()
				},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				
				if(data['phone'] || data['mail']){
					$('#reg_').hide();
					$('#log_').show();
					
					localStorage['login'] = data['mail']?data['mail']:data['phone'];
					
					if(data.cart.length > 0){
						var arr = [];
						
						data.cart.map(function(item){
							arr = arr.concat({id: item.item_id, count: item.count})
						})
						
						localStorage['myCart'] = JSON.stringify(arr)
					}
					
					$('#login').modal('close');
					location.reload();
					
				}else{
					alert('Email, номер телефона или пароль указаны неверно!');
				}
				
			}.bind(this)
		});
	}	
</script>

<?if($data['type_pc'] == 'pc' || $data['type_pc'] == 'tablet'){?>
	<?if(count($data['breadcrumbs'])>=1){?>
		<nav class="white " id="breadcrumbs" style="min-height: 56px; height: 100%;">
			<div class="nav-wrapper col s12" style="width: 92%; margin-left: 4%;" xmlns:v="http://rdf.data-vocabulary.org/#">
				<span typeof="v:Breadcrumb" class="breadcrumb"><a rel="v:url" property="v:title" href="<?=$site->addr?>">Главная</a></span>
				<?foreach($data['breadcrumbs'] as $item){?>
					<?if($item['alias']){?>
						<span typeof="v:Breadcrumb" class="breadcrumb"><a rel="v:url" property="v:title" href="<?=$item['alias']?>" class="breadcrumb"><?=$item['name']?></a></span>
					<?}else{?>
						<span class="breadcrumb"><?=$item['name']?></span>
					<?}?>
				<?}?>
			</div>
		</nav>
	<?}?>
<?}?>	
