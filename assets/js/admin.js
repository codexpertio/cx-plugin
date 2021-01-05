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

	$('.cx_plugin_help_tablinks .cx_plugin_help_tablink').on( 'click', function(e){
        e.preventDefault();
        var tab_id = $(this).attr('id');
        $('.cx_plugin_help_tablink').removeClass('active');
        $(this).addClass('active');

        $('.cx_plugin_tabcontent').hide();
        $('#'+tab_id+'_content').show();
    } );
})