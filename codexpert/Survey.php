<?php

/**
 * All survey facing functions
 */

namespace codexpert\Product;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage Survey
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Survey {
	
	public $plugin_slug;
	public $plugin_name;
	public $base_file;

	public $notice_heading;
	public $notice_message;
	public $notice_button_text;

	public function __construct( $base_file, $server = 'http://codexpert.wp' ) {

		if( !function_exists('get_plugin_data') ){
		    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$this->plugin 	= get_plugin_data( $base_file );
		$this->plugin_slug = $this->plugin['TextDomain'];

		$this->plugin_name = $this->plugin['Name'];
		$this->base_file = $base_file;
		$this->api_baseurl = "{$server}/wp-json/codexpert-lead/v1.0/";
		
		$this->notice_heading = '<h3>' . sprintf( __( 'Help us improve your experience of using \'%s\'' ), $this->plugin_name ) . '</h3>';
		$this->notice_message = '<span> ' . sprintf( __( 'We want to know what type of sites use our plugin. So that we can improve <strong>%s</strong> accordingly. Help us with your site URL and a few basic information. It doesn\'t include your password or any sercret data. Would you like to help us?' ), $this->plugin_name ) . '</span>';
		$this->notice_button_text = __( 'Okay. Don\'t bother me again!' );

		self::hooks();
	}

	public function hooks(){
		register_activation_hook( $this->base_file, array( $this, 'activate' ) );
		register_deactivation_hook( $this->base_file, array( $this, 'deactivate' ) );
		add_action( 'admin_head', array( $this, 'head' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( "wp_ajax_{$this->plugin_slug}_survey", array( $this, 'survey' ) );
	}

	/**
	 * Supports HTML
	 */
	public function set_heading( $heading = null ) {
		$this->notice_heading = $heading;
	}

	public function get_heading() {
		return $this->notice_heading;
	}

	/**
	 * Supports HTML
	 */
	public function set_message( $message = null ) {
		$this->notice_message = $message;
	}

	public function get_message() {
		return $this->notice_message;
	}

	/**
	 * Does not support noHTML
	 */
	public function set_button_text( $button_text = null ) {
		$this->notice_button_text = $button_text;
	}

	public function get_button_text() {
		return $this->notice_button_text;
	}

	/**
	 * Trigger when activates
	 *
	 */
	public function activate() {
		
		if( get_option( "{$this->plugin_slug}_survey_agreed" ) == 1 ) :
		
		$endpoint = $this->api_baseurl . 'update-lead';

		$params = array(
			'item'			=> $this->plugin_slug,
			'siteurl'		=> get_option( 'siteurl' ),
			'is_active'		=> 1,
		);

		$endpoint = add_query_arg( $params, $endpoint );
		@file_get_contents( $endpoint );
		
		endif;
	}

	/**
	 * Trigger when deactivates
	 *
	 */
	public function deactivate() {
		if( get_option( "{$this->plugin_slug}_survey_agreed" ) == 1 ) :
		
		$endpoint = $this->api_baseurl . 'update-lead';

		$params = array(
			'item'			=> $this->plugin_slug,
			'siteurl'		=> get_option( 'siteurl' ),
			'is_active'		=> 0,
		);

		$endpoint = add_query_arg( $params, $endpoint );
		@file_get_contents( $endpoint );
		
		endif;
	}

	public function head() {
		?>
		<script>
			jQuery(document).ready(function($){
				// survey
			    $(document).on('click', '.is-dismissible.<?php echo $this->plugin_slug; ?>-survey-notice .notice-dismiss, .<?php echo $this->plugin_slug; ?>-survey', function(e){
			        $(this).prop('disabled', true)
			        $.ajax({
			            url: ajaxurl,
			            data: { 'action' : '<?php echo $this->plugin_slug; ?>_survey', 'participate' : $(this).data('participate') },
			            type: 'POST',
			            success: function(ret) {
			                $('.<?php echo $this->plugin_slug; ?>-survey-notice').slideToggle(500)
			            }
			        })
			    })
			})
		</script>
		<?php
	}

    /**
     * Show admin notices
     *
     */
    public function admin_notices() {
        if( get_option( "{$this->plugin_slug}_survey" ) != 1 ) :
        ?>
        <div class="notice notice-success is-dismissible <?php echo $this->plugin_slug; ?>-survey-notice survey-notice">

        	<img style="float: left;height: 136px;" src="https://codexpert.io/resources/minion.png" />
            <div>
                <?php echo $this->get_heading(); ?>
                <?php echo $this->get_message(); ?>
            </div>
            <p>
                <button class="button button-primary <?php echo $this->plugin_slug; ?>-survey" data-participate="1">
                	<?php echo $this->get_button_text(); ?>
                </button>
            </p>
        </div>
        <?php
        endif;
    }

	/**
	 * Gather user data
	 *
	 * @uses AJAX
	 */
	public function survey() {
		if( isset( $_POST['participate'] ) && $_POST['participate'] == 1 ) {
			$endpoint = $this->api_baseurl . 'store-lead';

			$user_id = get_current_user_id();
			$userdata = get_userdata( $user_id );

			$all_plugins = get_plugins();
			// $plugins_installed = array();
			// foreach ( $all_plugins as $plugin => $data ) {
			// 	$plugins_installed[] = $data['Name'];
			// }
			// wp_send_json( $plugins_installed );
			$params = array(
				'init'					=> 1,
				'item'					=> $this->plugin_slug,
				'siteurl'				=> get_option( 'siteurl' ),
				'admin_email'			=> get_option( 'admin_email' ),
				'first_name'			=> $userdata->first_name,
				'last_name'				=> $userdata->last_name,
				'plugins_installed'		=> implode( ',', array_keys( $all_plugins ) ),
			);


			$endpoint = add_query_arg( $params, $endpoint );
			@file_get_contents( $endpoint );
			update_option( "{$this->plugin_slug}_survey_agreed", 1 );
		}

		update_option( "{$this->plugin_slug}_survey", 1 );
		wp_die();
	}
}