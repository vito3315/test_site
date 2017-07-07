<html>
	<head>
		<!-- Standard Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

		<!-- Site Properties -->
		<title>Страница входа</title>
		
		<link href="<?=$site->addr?>/admin/css/semantic.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
		<script src="<?=$site->addr?>/admin/js/jquery-3.1.1.min.js"></script>
		<script src="<?=$site->addr?>/admin/js/semantic.min.js"></script>
		
		<style type="text/css">
			body {
			  background-color: #DADADA;
			}
			body > .grid {
			  height: 100%;
			}
			.image {
			  margin-top: -100px;
			}
			.column {
			  max-width: 450px;
			}
		</style>
		
		<script>
			function login(){
				$.ajax({
					url: "/admin/modules/php/route.php",
					type: "POST",
					data: {type: 'log_adm', login: $('#login').val(), pass: $('#password').val()},
					cache: false,
					success: function(data) {
						if(data.trim() == "true"){
							//location.href = "/admin/index.php";
							location.reload();
						}
					}.bind(this),
					error: function(xhr, status, err) {
						console.log(status, err.toString());
					}.bind(this)
				});
			}	
		</script>
	</head>
	<body style="background-image: url(<?=$site->addr?>/css/img/background_img/1-fon-dlya-sayta.png);">
	
		<div class="ui middle aligned center aligned grid">
			<div class="column">
				<div class="ui teal image header">
					<img src="<?=$site->addr?>/img/other_mages/main_logo3_new.png" class="image" style="width: 100%;">
				</div>
				<form class="ui large form">
					<div class="ui stacked segment">
						<div class="field">
							<div class="ui left icon input">
								<i class="user icon"></i>
								<input type="text" name="email" id="login" placeholder="Login">
							</div>
						</div>
						<div class="field">
							<div class="ui left icon input">
								<i class="lock icon"></i>
								<input type="password" name="password" id="password" placeholder="Password">
							</div>
						</div>
						<div class="ui fluid large teal submit button" onclick="login()">Войти</div>
					</div>
					<div class="ui error message"></div>
				</form>
			</div>
		</div>
	
	
		<!--<div class="ui middle aligned center aligned grid">
			<div class="column">
				<div class="ui large form">
					<div class="ui teal image header">
						<img src="<?=$site->addr?>/img/other_mages/main_logo3_new.png" class="image" style="width: 100%;">
					</div>
					<div class="ui stacked segment">
						<div class="field">
							<div class="ui left input">
								<input type="text" name="email" id="login" placeholder="E-mail address">
							</div>
						</div>
						<div class="field">
							<div class="ui left input">
								<input type="password" name="password" id="password" placeholder="Password">
							</div>
						</div>
						<div class="ui fluid large teal submit button" onclick="login()">Войти</div>
					</div>
					<div class="ui error message"></div>
				</div>
			</div>
		</div>-->
	</body>
</html>