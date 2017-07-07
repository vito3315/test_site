<?$data['load_lib'] = array('lichyi_cabinet');?>

<h1 class="center-align" style="color: #fff; font-size: 2em;"><?=$data['content_page']['h1']?></h1>	
	
<div class="row category" style="padding-left: 4%; padding-right: 4%; min-height: 500px;" id="main_content">
	<div class="row card-panel col-md-12 col-xs-12 col-sm-12 col-lg-12" id="main_content_div">
	
		<ul id="tabs-swipe-demo red darken-2" class="tabs">
			<li class="tab col s6"><a class="active" href="#test-swipe-1">Мои данные</a></li>
			<li class="tab col s6"><a href="#test-swipe-2">Заказы</a></li>
		</ul>
		
		<div id="test-swipe-1" class="col s12">
			<table class="bordered">
				<tbody>
					<tr>
						<td style="width: 50%;">Имя</td>
						<td style="width: 50%;"><span id="user_name"></span></td>
					</tr>
					<tr>
						<td>Фамилия</td>
						<td><span id="user_fam"></span></td>
					</tr>
					<tr id="email_row">
						<td>E-mail</td>
						<td><span id="user_mail"></span></td>
					</tr>
					<tr>
						<td>Телефон</td>
						<td><span id="user_phone"></span></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div id="test-swipe-2" class="col s12">
			
		</div>
	</div>
</div>

<script>
	
</script>
