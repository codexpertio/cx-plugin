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

if( ! function_exists( 'cx_get_template' ) ) :
function cx_get_template( $slug ) {
	ob_start();
	include_once dirname( CXP ) . "/templates/{$slug}.php";
	$content = ob_get_clean();
	ob_flush();
	return $content;
}
endif;