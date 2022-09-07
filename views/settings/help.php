<?php
$base_url 	= cx_plugin_site_url();
$buttons 	= [
	'changelog' => [
		'url' 	=> 'https://wordpress.org/plugins/cx-plugin/#developers',
		'label' => __( 'Changelog', 'cx_plugin' ) 
	],
	'community' 	=> [
		'url' 	=> 'https://facebook.com/groups/codexpert.io',
		'label' => __( 'Community', 'cx_plugin' ) 
	],
	'website' 	=> [
		'url' 	=> 'https://codexpert.io/',
		'label' => __( 'Official Website', 'cx_plugin' ) 
	],
	'support' 	=> [
		'url' 	=> 'https://help.codexpert.io/',
		'label' => __( 'Ask Support', 'cx_plugin' ) 
	],
];
$buttons 	= apply_filters( 'cx-plugin_help_btns', $buttons );
?>
<script type="text/javascript">
	jQuery(function($){ $.get( ajaxurl, { action : 'cx-plugin_fetch-docs' }); });
</script>
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
		        echo '<p>' . __( 'Something is wrong! No help found!', 'cx-plugin' ) . '</p>';
		    endif;
		    ?>
		    </div>
		</div>
	</div>
	<div class="cx-plugin-help-links">
		<?php 
		foreach ( $buttons as $key => $button ) {
			$button_url = add_query_arg( $utm, $button['url'] );
			echo "<a target='_blank' href='" . esc_url( $button_url ) . "' class='cx-plugin-help-link'>" . esc_html( $button['label'] ) . "</a>";
		}
		?>
	</div>
</div>

<?php do_action( 'cx-plugin_help_tab_content' ); ?>