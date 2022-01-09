<?php
$base_url 	= cx_plugin_site_url();
$buttons 	= [
	'roadmap' 	=> [
		'url' 	=> "{$base_url}/roadmap",
		'label' => __( 'Roadmap', 'cx_plugin' ) 
	],
	'changelog' => [
		'url' 	=> "{$base_url}/changelog",
		'label' => __( 'Changelog', 'cx_plugin' ) 
	],
	'ideas' 	=> [
		'url' 	=> "{$base_url}/ideas",
		'label' => __( 'Ideas', 'cx_plugin' ) 
	],
	'support' 	=> [
		'url' 	=> 'https://help.codexpert.io/?utm_campaign=help-btn',
		'label' => __( 'Ask Support', 'cx_plugin' ) 
	],
];
$buttons 	= apply_filters( 'cx-plugin_help_btns', $buttons );
?>

<div class="cx-plugin-help-tab">
	<div class="cx-plugin-documentation">
		 <div class='wrap'>
		 	<div id='cx-plugin-helps'>
		    <?php

		    $helps = get_option( 'cx-plugin_docs_json', [] );
			$utm = [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'faq' ];
		    if( is_array( $helps ) ) :
		    foreach ( $helps as $help ) {
		    	$help_link = add_query_arg( $utm, $help['link'] );
		        ?>
		        <div id='cx-plugin-help-<?php echo esc_attr( $help['id'] ); ?>' class='cx-plugin-help'>
		            <h2 class='cx-plugin-help-heading' data-target='#cx-plugin-help-text-<?php echo esc_attr( $help['id'] ); ?>'>
		                <a href='<?php echo esc_url( $help_link ); ?>' target='_blank'>
		                <span class='dashicons dashicons-admin-links'></span></a>
		                <span class="heading-text"><?php echo esc_html( $help['title']['rendered'] ); ?></span>
		            </h2>
		            <div id='cx-plugin-help-text-<?php echo esc_attr( $help['id'] ); ?>' class='cx-plugin-help-text' style='display:none'>
		                <?php echo wpautop( wp_trim_words( $help['content']['rendered'], 55, " <a class='sc-more' href='" . esc_url( $help_link ) . "' target='_blank'>[more..]</a>" ) ); ?>
		            </div>
		        </div>
		        <?php

		    }
		    else:
		        _e( 'Something is wrong! No help found!', 'cx-plugin' );
		    endif;
		    ?>
		    </div>
		</div>
	</div>
	<div class="cx-plugin-help-links">
		<?php 
		foreach ( $buttons as $key => $button ) {
			echo "<a target='_blank' href='" . esc_url( $button['url'] ) . "' class='cx-plugin-help-link'>" . esc_html( $button['label'] ) . "</a>";
		}
		?>
	</div>
</div>

<?php do_action( 'cx-plugin_help_tab_content' ); ?>