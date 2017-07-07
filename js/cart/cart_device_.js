jQuery(document).ready(function($){
	var cartWrapper = $('.cd-cart-container');
	//product id - you don't need a counter in your real project but you can use your real product id
	var productId = 0;
	if(localStorage['login']){
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
					$('#reg_mobile').hide();
					$('#log_mobile').hide();
					$('#lk_mobile').show();
					$('#logout_mobile').show();
					if(data.cart.length > 0){
						var arr = [];
						data.cart.map(function(item){
							var count = 1;
							if(parseInt(item.count) <= 0){count = 1;}else{count = item.count}
							arr = arr.concat({id: item.item_id, count: count})
						})
						localStorage['myCart'] = JSON.stringify(arr)
					}else{
						localStorage['myCart'] = '';
					}
				}
			}.bind(this)
		});
	}
	var myCart = localStorage['myCart']?JSON.parse(localStorage['myCart']):[];
	setTimeout(function(){ 
		myCart = localStorage['myCart']?JSON.parse(localStorage['myCart']):[];
		$.ajax({
			url: "/admin/modules/php/route.php",
			dataType: 'json',
			data: {type: 'get_items_from_my_cart', items: myCart},
			type: 'POST',
			cache: false,
			success: function(data) {
				if(data){
					var price_total = 0,
						full_count = 0;
					data.map(function(item){
						var cartIsEmpty = cartWrapper.hasClass('empty'),
							list = document.getElementsByClassName('product'),
							check = false;
						for(var i=0; list[i]; i++){
							if(list[i].dataset['id'] == item.id)
								check = true;
						}
						if(!check){
							myCart.map(function(item2){
								if(item2.id == item.id){
									var count = 1;
									if(parseInt(item2.count) <= parseInt(0)){count = 1;}else{count = item2.count}
									addProduct_(item.id, item.name, count, item.price);
									price_total += parseFloat(item.price)*parseInt(count);
									full_count += parseInt(count);
									updateCartCount(cartIsEmpty, parseInt(count));
								}
							})
							updateCartTotal(item.price, true);
							cartWrapper.removeClass('empty');
						}
					})
					cartTotal.text(price_total.toFixed(2));
				}
			}.bind(this)
		});
	}, 1000);
	
	if( cartWrapper.length > 0 ) {
		var cartBody = cartWrapper.find('.body'),
			cartList = cartBody.find('ul').eq(0),
			cartTotal = cartWrapper.find('.checkout').find('span'),
			cartTrigger = cartWrapper.children('.cd-cart-trigger'),
			cartCount = cartTrigger.children('.count'),
			addToCartBtn = $('.cd-add-to-cart'),
			undo = cartWrapper.find('.undo'),
			undoTimeoutId;
		//add product to cart
		addToCartBtn.on('click', function(event){
			event.preventDefault();
			addToCart($(this));
		});
		//open/close cart
		cartTrigger.on('click', function(event){
			event.preventDefault();
			toggleCart();
		});
		//close cart when clicking on the .cd-cart-container::before (bg layer)
		cartWrapper.on('click', function(event){
			if( $(event.target).is($(this)) ) toggleCart(true);
		});
		//delete an item from the cart
		cartList.on('click', '.delete-item', function(event){
			event.preventDefault();
			removeProduct($(event.target).parents('.product'));
		});
		//update item quantity
		cartList.on('change', 'select', function(event){
			quickUpdateCart();
		});
		//reinsert item deleted from the cart
		undo.on('click', 'a', function(event){
			clearInterval(undoTimeoutId);
			event.preventDefault();
			cartList.find('.deleted').addClass('undo-deleted').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
				$(this).off('webkitAnimationEnd oanimationend msAnimationEnd animationend').removeClass('deleted undo-deleted').removeAttr('style');
				quickUpdateCart();
			});
			undo.removeClass('visible');
		});
	}

	function toggleCart(bool) {
		var cartIsOpen = ( typeof bool === 'undefined' ) ? cartWrapper.hasClass('cart-open') : bool;
		if( cartIsOpen ) {
			cartWrapper.removeClass('cart-open');
			//reset undo
			clearInterval(undoTimeoutId);
			undo.removeClass('visible');
			cartList.find('.deleted').remove();
			setTimeout(function(){
				cartBody.scrollTop(0);
				//check if cart empty to hide it
				if( Number(cartCount.find('li').eq(0).text()) == 0) cartWrapper.addClass('empty');
			}, 500);
		} else {
			cartWrapper.addClass('cart-open');
		}
	}

	function addToCart(trigger) {
		var cartIsEmpty = cartWrapper.hasClass('empty');
		var list = document.getElementsByClassName('product'),
			check = false;
		for(var i=0; list[i]; i++){
			if(list[i].dataset['id'] == trigger.data('id'))
				check = true;
		}
		if(!check){
			//update cart product list
			addProduct(trigger);
			//update number of items 
			updateCartCount(cartIsEmpty);
			//update total price
			updateCartTotal(trigger.data('price'), true);
			//show cart
			cartWrapper.removeClass('empty');
		}
	}

	function addProduct(data) {
		//this is just a product placeholder
		//you should insert an item with the selected product info
		//replace productId, productName, price and url with your real product info
		//productId = productId + 1;
		if(localStorage['login']){
			$.ajax({
				url: "/admin/modules/php/route.php",
				data: {
						type: 'add_to_cart',
						login: localStorage['login'],
						item_id: data.data('id')
					},
				type: 'POST',
				cache: false,
				success: function(data) {
					console.log(data)
				}.bind(this)
			});
		}
		myCart = localStorage['myCart']?JSON.parse(localStorage['myCart']):[];
		myCart = myCart.concat({id: data.data('id'), count: 1});
		localStorage['myCart'] = JSON.stringify(myCart)
		var productAdded = $(
			'<li class="product" data-id="'+data.data('id')+'">'+
				'<input type="hidden" class="item_id" value="'+data.data('id')+'" />'+
				'<div class="product-image">'+
					'<a href="/item/'+data.data('id')+'"><img src="'+data.data('photo')+'" alt="placeholder"></a>'+
				'</div>'+
				'<div class="product-details">'+
					'<span class="h3" style="margin: 0px;">'+
						'<a href="/item/'+data.data('id')+'">'+data.data('name')+'</a>'+
					'</span>'+
					'<span class="price" style="font-size: 2rem;">'+data.data('price')+'</span> <i class="fa fa-rub"></i>'+
					'<div class="actions">'+
						'<a href="#0" class="delete-item">Удалить</a>'+
						
					'</div>'+
				'</div>'+
			'</li>');
		cartList.prepend(productAdded);
	}

	function addProduct_(id, name, count, price) {
		var productAdded = $(
			'<li class="product" data-id="'+id+'">'+
				'<input type="hidden" class="item_id" value="'+id+'" />'+
				'<div class="product-image">'+
					'<a href="/item/'+id+'"><img src="/img/items/'+id+'_main.jpg" alt="placeholder"></a>'+
				'</div>'+
				'<div class="product-details">'+
					'<span class="h3" style="margin: 0px;">'+
						'<a href="/item/'+id+'">'+name+'</a>'+
					'</span>'+
					'<span class="price" style="font-size: 2rem;">'+price+'</span> <i class="fa fa-rub"></i>'+
					'<div class="actions">'+
						'<a href="#0" class="delete-item">Удалить</a>'+
						
					'</div>'+
				'</div>'+
			'</li>');
		cartList.prepend(productAdded);
		$('#cd-product-'+id).val(count);
	}
	
	function removeProduct(product) {
		clearInterval(undoTimeoutId);
		cartList.find('.deleted').remove();
		var this_id = product.find('.item_id').val();
		var topPosition = product.offset().top - cartBody.children('ul').offset().top ,
			productQuantity = Number(product.find('.quantity').find('select').val()),
			productTotPrice = Number(product.find('.price').text().replace('$', '')) * productQuantity;
		product.css('top', topPosition+'px').addClass('deleted');
		//update items count + total price
		updateCartTotal(productTotPrice, false);
		updateCartCount(true, -productQuantity);
		undo.addClass('visible');
		//wait 8sec before completely remove the item
		undoTimeoutId = setTimeout(function(){
			undo.removeClass('visible');
			cartList.find('.deleted').remove();
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
		}, 700);
	}

	function quickUpdateCart() {
		var quantity = 0;
		var price = 0;
		myCart = localStorage['myCart']?JSON.parse(localStorage['myCart']):[];
		var newCart = [];
		cartList.children('li:not(.deleted)').each(function(){
			var singleQuantity = Number($(this).find('select').val());
			var this_id = $(this).find('.item_id').val(),
				this_count = $(this).find('select').val();
			if(localStorage['login']){
				$.ajax({
					url: "/admin/modules/php/route.php",
					data: {
							type: 'kill_from_cart',
							login: localStorage['login'],
							item_id: this_id,
							count: this_count
						},
					type: 'POST',
					cache: false,
					success: function(data) {
						console.log(data)
					}.bind(this)
				});
			}
			myCart.map(function(item){
				if(item.id == this_id){
					newCart = newCart.concat({id: item.id, count: this_count});
				}
			})
			quantity = quantity + singleQuantity;
			price = price + singleQuantity*Number($(this).find('.price').text().replace('$', ''));
		});
		localStorage['myCart'] = JSON.stringify(newCart)
		cartTotal.text(price.toFixed(2));
		cartCount.find('li').eq(0).text(quantity);
		cartCount.find('li').eq(1).text(quantity+1);
	}

	function updateCartCount(emptyCart, quantity) {
		if( typeof quantity === 'undefined' ) {
			var actual = Number(cartCount.find('li').eq(0).text()) + 1;
			var next = actual + 1;
			if( emptyCart ) {
				cartCount.find('li').eq(0).text(actual);
				cartCount.find('li').eq(1).text(next);
			} else {
				cartCount.addClass('update-count');
				setTimeout(function() {
					cartCount.find('li').eq(0).text(actual);
				}, 150);
				setTimeout(function() {
					cartCount.removeClass('update-count');
				}, 200);
				setTimeout(function() {
					cartCount.find('li').eq(1).text(next);
				}, 230);
			}
		} else {
			var actual = Number(cartCount.find('li').eq(0).text()) + quantity;
			var next = actual + 1;
			cartCount.find('li').eq(0).text(actual);
			cartCount.find('li').eq(1).text(next);
		}
	}

	function updateCartTotal(price, bool) {
		bool ? cartTotal.text( (Number(cartTotal.text()) + Number(price)).toFixed(2) )  : cartTotal.text( (Number(cartTotal.text()) - Number(price)).toFixed(2) );
	}
	
	function testinput(re, str){return str.search(re) != -1 ? true : false}
	
	$( document ).on( "keyup", "#search_items", function() {
		var text = $('#search_items').val(),
			items = document.getElementsByClassName('this_items');
		for(var i=0; items[i]; i++){
			if(!testinput(text.toLowerCase(), items[i].dataset.name.toLowerCase()+' '+items[i].dataset.art.toLowerCase())){
				$('.thisId_'+items[i].dataset.id).addClass("toHide");
			}else{
				$('.thisId_'+items[i].dataset.id).removeClass("toHide");
			}
		}
	});
});				