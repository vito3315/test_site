(function($){
	$(function(){
		if(localStorage['login']){
			$.ajax({
				url: "/admin/modules/php/route.php",
				dataType: 'json',
				data: {type: 'my_account', data: localStorage['login']},
				type: 'POST',
				cache: false,
				success: function(data) {
					//console.log(data);
					
					if(data){
						$('#user_name').text(data.name);
						$('#user_fam').text(data.fam);
						$('#user_mail').text(data.mail);
						$('#user_phone').text(data.phone);
						
						if(!data.mail){
							$('#email_row').hide();
						}
						
						var table = "",
							scetchik = 0;
						
						data.orders.map(function(order){
							var mini_table = "";
							
							table += "<tr><td style='vertical-align: sub;'>"+order.date+"</td><td style='text-align: center;'>";
							mini_table += "<table class='bordered'>";
							
							var del_order = '';
							
							if(order.type == 0){//незавершен
								del_order = '<a onclick="delete_order(`'+order.date+'`, `'+localStorage['login']+'`)"><i style="font-size: 1.5em; color: #333; cursor: pointer;" class="fa fa-trash"></a></a>';
							}
							//"'+order.date+'", "'+localStorage['login']+'"
							var price = 0;
							
							//table += "<table>";
							
							data.order.map(function(item){
								
								if(item.date == order.date){
									
									//console.log(item);
									
									mini_table += "<tr><td><a href='/item/"+item.id+"'>"+item.item+"</a></td><td>"+item.count+" шт.</td><td>"+item.price+" руб.</td></tr>";
									
									//table += "<div><a href='/item/"+item.id+"'>"+item.item+"</a></div>";
									price += parseFloat(item.price)*parseInt(item.count);
								}
							})
							
							var type = '';
							
							switch(order.type){
								case '0':{
									type = 'Незавершен';
									break;}
								case '1':{
									type = 'Завершен';
									break;}
								case '2':{
									type = 'Отменен';
									break;}		
							}
							
							mini_table += "</table>";
							
							table += 
								'<div id="modal'+scetchik+'" class="modal">'+
									'<div class="modal-content">'+
										'<h4>Заказ от '+order.date+'</h4>'+
										mini_table+
									'</div>'+
									'<div class="modal-footer">'+
										'<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Закрыть</a>'+
									'</div>'+
								'</div>';
							
							table += "<a class='waves-effect waves-light' href='#modal"+scetchik+"'>Список товаров</a>  </td><td style='vertical-align: sub; text-align: center;'>"+price+" руб.</td><td style='vertical-align: sub; text-align: center;'>"+type+" "+del_order+"</td></tr>";
							
							scetchik++;
						})
						
						$('#test-swipe-2').append(
							"<table class='bordered'>"+
								"<thead>"+
									"<tr>"+
										"<th>Дата заказа</th>"+
										"<th style='text-align: center;'>Товары</th>"+
										"<th style='text-align: center;'>Цена заказа</th>"+
										"<th style='text-align: center;'>Статус заказа</th>"+
									"</tr>"+
								"</thead>"+
								"<tbody id='to_items_cart'>"+
									table+
								"</tbody>"+
							"</table>"
						);
						
						
						
						$('.modal').modal();
						
					}
					
				}.bind(this)
			});
		}else{
			location.href = "/";
		}
		
		
		
		
	}); // end of document ready
})(jQuery); // end of jQuery name space


function delete_order(date, user){
	//console.log(date, user)
	if (confirm("Отменить заказ?")) {
		$.ajax({
			url: "/admin/modules/php/route.php",
			data: {type: 'del_order', date: date, user: user},
			type: 'POST',
			cache: false,
			success: function(data) {
				if(data.trim() == 'true'){
					alert("Заказ успешно отменен");
				}
			}.bind(this)
		});
	} else {
		
	}

}