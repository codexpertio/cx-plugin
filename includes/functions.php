<?php
if( ! function_exists( 'pri' ) ) :
function pri( $data ) {
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

if( ! function_exists( 'cx_get_posts' ) ) :
function cx_get_posts( $post_type = 'post', $limit = -1 ) {
	$arg = array(
		'post_type'         => $post_type,
		'posts_per_page'    => $limit
		);
	$p = new WP_Query( $arg );

	$posts = array( '' => __( '- Choose a post -', 'cx-plugin' ) );

	foreach( $p->posts as $post ) :
		$posts[ $post->ID ] = $post->post_title;
	endforeach;

	return apply_filters( 'cx_get_posts', $posts, $post_type, $limit );
}
endif;

if( ! function_exists( 'cx_get_option' ) ) :
function cx_get_option( $key, $section, $default = '' ) {

	$options = get_option( $key );

	if ( isset( $options[ $section ] ) ) {
		return $options[ $section ];
	}

	return $default;
}
endif;

if( !function_exists( 'cx_plugin_get_template' ) ) :
/**
 * Includes a template file resides in /templates diretory
 *
 * It'll look into /cx-plugin directory of your active theme
 * first. if not found, default template will be used.
 * can be overriden with cx-plugin_template_override_dir hook
 *
 * @param string $slug slug of template. Ex: template-slug.php
 * @param string $sub_dir sub-directory under base directory
 * @param array $fields fields of the form
 */
function cx_plugin_get_template( $slug, $base = 'templates', $args = null ) {

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