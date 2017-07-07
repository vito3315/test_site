/*if(localStorage['login']){
	$.ajax({
		url: "/admin/modules/php/route.php",
		dataType: 'json',
		data: {type: 'login', data: localStorage['login']},
		type: 'POST',
		cache: false,
		success: function(data) {
			if(data){
				$('#reg_').hide();
				$('#log_').show();
				
				if(data.cart.length > 0){
					var arr = [];
					
					data.cart.map(function(item){
						arr = arr.concat({id: item.item_id, count: item.count})
					})
					
					localStorage['myCart'] = JSON.stringify(arr)
				}
			}
		}.bind(this)
	});
}else{
	localStorage['myCart'] = JSON.stringify([])
}
*/

var myCart = localStorage['myCart']?JSON.parse(localStorage['myCart']):[];

setTimeout(function(){ 
	myCart = localStorage['myCart']?JSON.parse(localStorage['myCart']):[];
	
	console.log(myCart)
	
	$.ajax({
		url: "/admin/modules/php/route.php",
		dataType: 'json',
		data: {type: 'get_items_from_my_cart', items: myCart},
		type: 'POST',
		cache: false,
		success: function(data) {
			if(data){
				var this_item = 1;
				
				data.map(function(item){
					var price = parseFloat(item['price']);
					
					//var count = 1;
					//if(parseInt(item['count']) <= 0 || !parseInt(item['count'])){count = 1;}else{count = item['count'];}
					
					console.log(item['count'])
					
					
					
					//console.log(myCart);
					
					myCart.map(function(it){
						if(it.id == item['id']){
							
							var count = 1;
							if(parseInt(it.count) <= 0 || !it.count){count = 1;}else{count = it.count}
							
							$('#myCart').append(
								"<div class='col-md-12 col-xs-12 col-sm-12 col-lg-12' data-id='"+item['id']+"' id='this_"+this_item+"' style=\"padding: 15px 0px; display: flex; flex-wrap: wrap;\">"+
									"<div class='col-md-2 col-xs-12 col-sm-2 col-lg-2' style=\"margin: auto; text-align: center;\">"+
										"<img style=\"max-width: 130px; max-height: 130px;\" src=\"/img/items/"+item['id']+"_main.jpg\" style=\"max-width: 100%;\">"+
									"</div>"+
									"<div class=\"col-md-4 col-xs-12 col-sm-4 col-lg-4\" style=\"margin: auto;\">"+
										"<span style=\"width: 100%; float: left;\"><a href='/item/"+item['id']+"'>"+item['name']+"</a></span>"+
										"<span style=\"width: 100%; float: left;\">Артикул: "+item['art']+"</span>"+
									"</div>"+
									"<div class=\"col-md-3 col-xs-12 col-sm-3 col-lg-3\" style=\"margin: auto;\">"+
										"<span>Количество: </span>"+
										"<input type=\"number\" onblur=\"reprice()\" min='1' value='"+count+"'>"+
									"</div>"+
									"<div class=\"col-md-2 col-xs-12 col-sm-2 col-lg-2\" style=\"margin: auto;\">"+
										"<span>Цена: </span>"+
										"<span style=\"font-size: 1.3em; font-family: a_Stamper Bold, arial;\" class=\"price\">"+price+"<i class=\"fa fa-rub\"></i></span>"+
									"</div>"+
									"<div class=\"col-md-1 col-xs-12 col-sm-1 col-lg-1\" style=\"margin: auto;\">"+
										"<i style=\"cursor: pointer;\" onclick=\"remove("+item['id']+", "+this_item+", '"+item['name']+"')\" class=\"fa fa-trash fa-2x\"></i>"+
									"</div>"+
								"</div>")
							//console.log(count);
							
							//$('#this_'+this_item).find('select').val(count);
						}
					})
					
					this_item++;
				})
				
				reprice();
				
				$('.cd-cart-container').hide();
			}else{
				$('#empty_cart').show();
				$('#price_to_pay').hide();
				$('#for_order_now').hide();
			}
		}.bind(this)
	});

}, 300);


/*

"<select onchange=\"reprice()\">"+
									"<option value=\"1\">1</option>"+
									"<option value=\"2\">2</option>"+
									"<option value=\"3\">3</option>"+
									"<option value=\"4\">4</option>"+
									"<option value=\"5\">5</option>"+
									"<option value=\"6\">6</option>"+
									"<option value=\"7\">7</option>"+
									"<option value=\"8\">8</option>"+
									"<option value=\"9\">9</option>"+
								"</select>"+*/