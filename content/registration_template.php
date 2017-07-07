<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['this_page']['h1']?></h1>

<div class="row" style="padding-left: 4%;padding-right: 4%; margin-top: 15px;">
	<div class="card-panel row col-md-12 col-xs-12 col-sm-12 col-lg-12" style="padding: 1px; margin-bottom: 0; min-height: 500px;">
		<div class="row col-md-6 col-xs-12 col-sm-6 col-lg-6 col-md-offset-3 col-sm-offset-3 col-lg-offset-3" id="reg">
			<div class="input-field">
				<input id="first_name" type="url" class="">
				<label for="first_name">Имя</label>
			</div>
			<div class="input-field">
				<input id="last_name" type="url" class="">
				<label for="last_name">Фамилия</label>
			</div>
			<div class="input-field">
				<input id="phone" type="tel" class="validate">
				<label for="phone" data-error="Номер телефона введен некорректно" data-success="">Номер телефона</label>
			</div>
			<div class="input-field">
				<input id="email" type="email" class="validate">
				<label for="email" data-error="E-mail введен некорректно">E-mail</label>
			</div>
			<div class="input-field">
				<input id="pass" type="password" class="validate">
				<label for="pass" data-error="Пароль слишком простой">Пароль</label>
			</div>
			<div class="input-field" style="padding-bottom: 25px;">
				<input type="checkbox" id="politic" class="validate" />
				<label for="politic" id="politic_for">Я даю соглашение на обработку моих персональных данных, согласно настоящей <a target="blank_" href="<?=$site->addr?>/politika_konfidencialnosti/">политики конфиденциальности</a></label>
			</div>
			
			<div class='g-recaptcha' data-sitekey='6LdgSBkTAAAAAJCnlv-r4v7pL9kJqxyjQrvS1aJE'></div>
			
			<button class="waves-effect waves-light btn" style="margin-top: 15px;" onclick="reg()">Зарегистрироваться</button>
		</div>
	</div>	
</div>
	
<script>

	function reg(){
		var name 	= $('#first_name').val(),
			fam 	= $('#last_name').val(),
			phone 	= $('#phone').val(),
			email 	= $('#email').val(),
			politic = $('#politic')[0].checked,
			pass 	= $('#pass').val();
			
			if(!name){ $('#first_name').addClass('invalid'); }else{$('#first_name').removeClass('invalid');}
			
			if(!fam){ $('#last_name').addClass('invalid'); }else{$('#last_name').removeClass('invalid');}
			
			if(!politic){ 
				$('#politic_for').css('color', 'red'); 
				$('#politic').addClass('invalid');
			}else{ 
				$('#politic_for').css('color', '#9e9e9e'); 
				$('#politic').removeClass('invalid');
			}
			
			//if(!email){ $('#email').addClass('invalid'); }
			if(email){
				var pattern_email = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
				if(!pattern_email.test(email)){
					$('#email').addClass('invalid');
				}else{
					$('#email').removeClass('invalid');
				}
			}
			
			
			if(!phone){ $('#phone').addClass('invalid'); }
			
			var pattern_phone = /^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i;
			if(!pattern_phone.test(phone)){
				$('#phone').addClass('invalid');
            }else{
				$('#email').removeClass('invalid');
			}
			
			if(!pass){ $('#pass').addClass('invalid'); }else{$('#email').removeClass('invalid');}
			
			var err_count = $('#reg > div > .invalid');
			
			if(err_count.length == 0){
				$.ajax({
					url: "/admin/modules/php/route.php",
					data: {
							type: 'reg',
							name: name,
							fam: fam,
							phone: phone,
							email: email,
							pass: pass,
							data: document.getElementById('g-recaptcha-response').value
						},
					type: 'POST',
					cache: false,
					success: function(data) {
						console.log(data)
						
						if(data.trim() == 'true'){
							localStorage['login'] = email;
							window.location.href = "/";
						}
						
					}.bind(this)
				});
			}
			
			
	}

</script>
