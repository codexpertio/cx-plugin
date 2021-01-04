jQuery(function($){
	$('.cx-plugin-help-heading').click(function(e){
		var $this = $(this);
		var target = $this.data('target');
		$('.cx-plugin-help-text:not('+target+')').slideUp();
		if($(target).is(':hidden')){
			$(target).slideDown();
		}
		else {
			$(target).slideUp();
		}
	});
})