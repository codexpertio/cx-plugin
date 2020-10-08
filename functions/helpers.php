<?php

if( ! function_exists( 'cx_plugin_pri' ) ) :
function cx_plugin_pri( $data ) {
	echo '<pre>';
	if( is_object( $data ) || is_array( $data ) ) {
		print_r( $data );
	}
	else {
		var_dump( $data );
	}
	echo '</pre>';
}
endif;

if( ! function_exists( 'cx_plugin_get_posts' ) ) :
function cx_plugin_get_posts( $post_type = 'post', $limit = -1 ) {
	$arg = [
		'post_type'         => $post_type,
		'posts_per_page'    => $limit
	];
	$p = new WP_Query( $arg );

	$posts = [ '' => __( '- Choose a post -', 'cx-plugin' ) ];

	foreach( $p->posts as $post ) :
		$posts[ $post->ID ] = $post->post_title;
	endforeach;

	return apply_filters( 'cx_plugin_get_posts', $posts, $post_type, $limit );
}
endif;

if( ! function_exists( 'cx_plugin_get_option' ) ) :
function cx_plugin_get_option( $key, $section, $default = '' ) {

	$options = get_option( $key );

	if ( isset( $options[ $section ] ) ) {
		return $options[ $section ];
	}

	return $default;
}
endif;

if( !function_exists( 'cx_plugin_get_template' ) ) :
/**
 * Includes a template file resides in /views diretory
 *
 * It'll look into /cx-plugin directory of your active theme
 * first. if not found, default template will be used.
 * can be overriden with cx-plugin_template_override_dir hook
 *
 * @param string $slug slug of template. Ex: template-slug.php
 * @param string $sub_dir sub-directory under base directory
 * @param array $fields fields of the form
 */
function cx_plugin_get_template( $slug, $base = 'views', $args = null ) {

	// templates can be placed in this directory
	$override_template_dir = apply_filters( 'cx_plugin_template_override_dir', get_stylesheet_directory() . '/cx-plugin/', $slug, $base, $args );
	
	// default template directory
	$plugin_template_dir = dirname( CXP ) . "/{$base}/";

	// full path of a template file in plugin directory
	$plugin_template_path =  $plugin_template_dir . $slug . '.php';
	
	// full path of a template file in override directory
	$override_template_path =  $override_template_dir . $slug . '.php';

	// if template is found in override directory
	if( file_exists( $override_template_path ) ) {
		ob_start();
		include $override_template_path;
		return ob_get_clean();
	}
	// otherwise use default one
	elseif ( file_exists( $plugin_template_path ) ) {
		ob_start();
		include $plugin_template_path;
		return ob_get_clean();
	}
	else {
		return __( 'Template not found!', 'cx-plugin' );
	}
}
endif;

/**
 * Generates some action links of a plugin
 *
 * @since 1.0
 */
if( !function_exists( 'cx_plugin_action_link' ) ) :
function cx_plugin_action_link( $plugin, $action = '' ) {

	$exploded	= explode( '/', $plugin );
	$slug		= $exploded[0];

	$links = [
		'install'		=> wp_nonce_url( admin_url( "update.php?action=install-plugin&plugin={$slug}" ), "install-plugin_{$slug}" ),
		'update'		=> wp_nonce_url( admin_url( "update.php?action=upgrade-plugin&plugin={$plugin}" ), "upgrade-plugin_{$plugin}" ),
		'activate'		=> wp_nonce_url( admin_url( "plugins.php?action=activate&plugin={$plugin}&plugin_status=all&paged=1&s" ), "activate-plugin_{$plugin}" ),
		'deactivate'	=> wp_nonce_url( admin_url( "plugins.php?action=deactivate&plugin={$plugin}&plugin_status=all&paged=1&s" ), "deactivate-plugin_{$plugin}" ),
	];

	if( $action != '' && array_key_exists( $action, $links ) ) return $links[ $action ];

	return $links;
}
endif;