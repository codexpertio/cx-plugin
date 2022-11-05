let cx_plugin_modal = ( show = true ) => {
	if(show) {
		jQuery('#cx-plugin-modal').show();
	}
	else {
		jQuery('#cx-plugin-modal').hide();
	}
}

jQuery(function($){
	$('.cx-plugin-help-heading').click(function(e){
		var $this = $(this);
		var $target = $this.data('target');
		$('.cx-plugin-help-text:not('+$target+')').slideUp();
		if($($target).is(':hidden')){
			$($target).slideDown();
		}
		else {
			$($target).slideUp();
		}
	});

	$('#cx-plugin_report-copy').click(function(e) {
		e.preventDefault();
		$('#cx-plugin_tools-report').select();

		try {
			var successful = document.execCommand('copy');
			if( successful ){
				$(this).html('<span class="dashicons dashicons-saved"></span>');
			}
		} catch (err) {
			console.log('Oops, unable to copy!');
		}
	});
})