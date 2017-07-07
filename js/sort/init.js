(function($){
	$(function(){
		var mixer = mixitup('#items_category', {
			load: {
				sort: 'name:asc'
			},
			multifilter: {
				enable: true
			},
			controls: {
				toggleLogic: 'and'
			},
			animation:{
				enable:false
			},
			callbacks: {
				onMixEnd: function(state) {
					$('#items_not_found').hide(); 
					Materialize.toast('Сортировка завершена', 1800)
				},
				onMixFail: function(state) {
					$('#items_not_found').show();
				}
			}
		});
	});
})(jQuery);