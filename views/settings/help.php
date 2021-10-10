<?php

$args = [
	'cx_plugin_faq' 	=> __( 'FAQ', 'cx-plugin' ),
	'cx_plugin_video' 	=> __( 'Video Tutorial', 'cx-plugin' ),
	'cx_plugin_support' => __( 'Ask Support', 'cx-plugin' ),
];
$tab_links = apply_filters( 'cx_plugin_help_tab_link', $args );

echo "<div class='cx_plugin_tab_btns'>";
echo "<ul class='cx_plugin_help_tablinks'>";

$count 	= 0;
foreach ( $tab_links as $id => $tab_link ) {
	$active = $count == 0 ? 'active' : '';
	echo "<li class='cx_plugin_help_tablink {$active}' id='{$id}'>{$tab_link}</li>";
	$count++;
}

echo "</ul>";
echo "</div>";
?>

<div id="cx_plugin_faq_content" class="cx_plugin_tabcontent active">
	 <div class='wrap'>
	 	<div id='cx-plugin-helps'>
	    <?php

	    $helps = get_option( 'cx-plugin_docs_json', [] );
		$utm = [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'faq' ];
	    if( is_array( $helps ) ) :
	    foreach ( $helps as $help ) {
	    	$help_link = add_query_arg( $utm, $help['link'] );
	        ?>
	        <div id='cx-plugin-help-<?php echo $help['id']; ?>' class='cx-plugin-help'>
	            <h2 class='cx-plugin-help-heading' data-target='#cx-plugin-help-text-<?php echo $help['id']; ?>'>
	                <a href='<?php echo $help_link; ?>' target='_blank'>
	                <span class='dashicons dashicons-admin-links'></span></a>
	                <span class="heading-text"><?php echo $help['title']['rendered']; ?></span>
	            </h2>
	            <div id='cx-plugin-help-text-<?php echo $help['id']; ?>' class='cx-plugin-help-text' style='display:none'>
	                <?php echo wpautop( wp_trim_words( $help['content']['rendered'], 55, " <a class='sc-more' href='{$help_link}' target='_blank'>[more..]</a>" ) ); ?>
	            </div>
	        </div>
	        <?php

	    }
	    else:
	        _e( 'Something is wrong! No help found!', 'cx-plugin' );
	    endif;
	    ?>
	    </div>
	    <?php printf( __( '<p>If you need further assistance, please <a href="%s" target="_blank">reach out to us!</a></p>', 'cx-plugin' ), add_query_arg( $utm, 'https://codexpert.io/hire/' ) ); ?>
	</div>
</div>

<div id="cx_plugin_video_content" class="cx_plugin_tabcontent">
	<iframe width="900" height="525" src="https://www.youtube.com/embed/videoseries?list=PLljE6A-xP4wKNreIV76Tl6uQUw-40XQsZ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

<div id="cx_plugin_support_content" class="cx_plugin_tabcontent">
	<p><?php _e( 'Having an issue or got something to say? Feel free to reach out to us! Our award winning support team is always ready to help you.', 'shop-catalog' ); ?></p>
	<div id="support_btn_div">
		<a href="https://help.codexpert.io/?utm_campaign=help-btn" class="button" id="support_btn" target="_blank"><?php _e( 'Submit a Ticket', 'shop-catalog' ); ?></a>
	</div>
</div>
<?php