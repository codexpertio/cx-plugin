<?php
if( !function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if( ! function_exists( 'cx_plugin_site_url' ) ) :
function cx_plugin_site_url() {
	return get_bloginfo( 'url' );
}
endif;