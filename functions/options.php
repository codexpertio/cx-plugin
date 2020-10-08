<?php
/**
 * Usually functions that return settings values
 */

if( ! function_exists( 'cx_plugin_site_url' ) ) :
function cx_plugin_site_url() {
	return get_bloginfo( 'url' );
}
endif;