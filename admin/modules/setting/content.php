<?
	$data = $site->get_setting();
?>

<h1>Настройки сайта</h1>

<form class="ui form">

	<div class="ui top attached tabular menu">
		<a class="active item" data-tab="first">Кеширование</a>
		<a class="item" data-tab="second">Почтовый сервер</a>
	</div>
	
	<!-- Кеширование -->
	<div class="ui bottom attached active tab segment" data-tab="first">
		<div class="field">
			<label>Время кеширования сайта в браузере в секундах (0 - отключить)</label>
			<input type="text" id="cache_brower" value="<?=$data['cache_brower']?>" placeholder="3600">
		</div>
		<div class="field">
			<label>Время кеширования сайта на прокси-сервере в секундах (0 - отключить)</label>
			<input type="text" id="cache_proxy" value="<?=$data['cache_proxy']?>" placeholder="3600">
		</div>
	</div>
	
	<!-- Почтовый сервер -->
	<div class="ui bottom attached tab segment" data-tab="second">
		<div class="field">
			<label>Основной почтовый ящик (на него будет приходить почта)</label>
			<input type="text" id="main_mail" value="<?=$data['main_mail']?>" placeholder="example@mail.ru">
		</div>
		<div class="field">
			<label>Почтовый ящик (с которого будут приходить письма)</label>
			<input type="text" id="mail_login" value="<?=$data['mail_login']?>" placeholder="example@mail.ru">
		</div>
		<div class="field">
			<label>Пароль</label>
			<input type="password" id="mail_pass" value="<?=$data['mail_pass']?>" placeholder="*******">
		</div>
		<div class="field">
			<label>Сервер</label>
			<select class="ui dropdown" id="mail_host">
				<option value="Yandex">Yandex</option>
			</select>
		</div>
	</div>
</form>
<div style="margin-top: 10px;">
	<button class="ui primary button" onclick="send()">Сохранить</button>
</div>


<script>
	$( document ).ready(function() {
		$('.menu .item').tab();
		$('.ui.dropdown').dropdown();
		
	});
	
	function send(){
		var cache_brower 	= $('#cache_brower').val(),
			cache_proxy 	= $('#cache_proxy').val(),
			mail_login 		= $('#mail_login').val(),
			mail_pass 		= $('#mail_pass').val(),
			mail_host 		= $('#mail_host').val(),
			main_mail 		= $('#main_mail').val();
			
		$.ajax({
			url: "../../modules/php/route.php",
			data: {type: 'save_setting', cache_brower: cache_brower, cache_proxy: cache_proxy, mail_login: mail_login, mail_pass: mail_pass, mail_host: mail_host, main_mail: main_mail},
			type: 'POST',
			cache: false,
			success: function(data) {
				console.log(data)
				
				if(data.trim() == 'true'){
					$('#modal_header').text('Обновление настроек')
					$('#modal_text').text('Настройки успешно обновлены')
					$('#modal_dialog').modal('show')
				}else{
					$('#modal_header').text('Обновление настроек')
					$('#modal_text').text('Произошла ошибка при обновлении настроек')
					$('#modal_dialog').modal('show')
				}
			}.bind(this)
		}); 	
	}
</script>