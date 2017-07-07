var max = 5;

if(
	device.mobile() ||
	device.iphone() ||
	device.ipod() ||
	device.androidPhone() ||
	device.blackberryPhone() ||
	device.windowsPhone() ||
	device.fxosPhone()
){
	console.log('phone');
	
	max = 1;
	
	$('.logos').hide();
	$('#submenu').hide();

	//$('#nav_contact > a > span:first').css("right", "71px")
	//$('#nav_contact > a > span:last').css("left", "10px")
	$('#nav_contact > a > span').css("font-size", "0.9em")
	
	$('#items_category').css({"padding-left": "0px", "padding-right": "0px"})
	$('.sb-icon-search_items').css({"right": "31px"});
}


var mql = window.matchMedia("(orientation: portrait)");

// Прослушка события изменения ориентации
mql.addListener(function(m) {
    if(m.matches) {
        // Изменено на портретный режим
		$('#items_category > div').removeClass('col-xs-6').addClass('col-xs-12');
		$('#items_category_ > div').removeClass('col-xs-6').addClass('col-xs-12');
		console.log('portret');
    }
    else {
		$('#items_category > div').removeClass('col-xs-12').addClass('col-xs-6');
		$('#items_category_ > div').removeClass('col-xs-12').addClass('col-xs-6');
		console.log('horisont');
        // Изменено на горизонтальный режим
    }
});


if(
	device.tablet() ||
	device.ipad() ||
	device.androidTablet() ||
	device.blackberryTablet() ||
	device.fxosTablet() ||
	device.windowsTablet() 
){
	console.log('tablet');	
	
	max = 4;
	
	//$('#submenu ul a').css("font-size", "0.8em")
	//$('#breadcrumbs > div > div > a').css("font-size", "1rem")
	//$('#nav_contact > a > span:first').css("left", "283px")
	//$('#nav_contact > a > span:last').css("left", "10px")
	$('.sb-icon-search_items').css({"right": "46px"});
}

function add_compare(id){
	//console.log(id)
	var keys = sessionStorage.keys?sessionStorage.keys:'',
		count = 0,
		keys_arr = keys.split(','),
		check = false;
	
	keys_arr.map(function(items){
		if(items == id){
			check = true;
		}
	})
	
	if(!check){
		keys += keys.length>0?','+id:id;
	}
	
	if(keys[0] == '0'){
		count = keys.split(',').length-1;
	}else{
		count = keys.split(',').length;
	}
	
	$('.badge').text(count);
	
	sessionStorage.keys = keys;
}

(function($){
	$(function(){
		$('.button-collapse').sideNav();
		$('.slider').slider({full_width: true});
		$('.modal').modal();
		$(".dropdown-button").dropdown({ hover: false, belowOrigin: true, constrain_width: true });
		new UISearch( document.getElementById( 'sb-search' ) );
		//$('#submenu ul a').css("font-size", "1.3rem")
		$('ul.tabs').tabs({swipeable: true});
		//console.log(localStorage['login']);
		
		$('#search_mobile').bind('keypress', function(e){
			if(e.keyCode == 13){
				location.href = "/search/"+$('#search_mobile').val()+"/";
			}
		});
		
		$('#pass_login, #email_login').bind('keypress', function(e){
			if(e.keyCode == 13){
				login();
			}
		});

		
		
		var keys = sessionStorage.keys?sessionStorage.keys:'',
			count = 0;
		
		if(keys){
			if(keys[0] == '0'){
				count = keys.split(',').length-1;
			}else{
				count = keys.split(',').length;
			}
		}else{
			count = '0';
		}
		
		
		$('.badge').text(count);
		
		//Materialize.updateTextFields();
	}); // end of document ready
})(jQuery); // end of jQuery name space