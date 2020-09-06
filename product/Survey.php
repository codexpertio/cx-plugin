<?php
namespace codexpert\product;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage Survey
 * @author codexpert <hello@codexpert.io>
 */
class Survey extends Base {
	
	public $slug;
	public $name;
	public $base_file;

	public $notice_heading;
	public $notice_message;
	public $notice_button_text;

	public function __construct( $plugin ) {

		$this->plugin 	= $plugin;

		$this->server 	= $this->plugin['server'];
		$this->slug 	= $this->plugin['TextDomain'];
		$this->name = $this->plugin['Name'];
		$this->api_url = "{$this->server}/wp-json/codexpert-lead/v1.0/";
		
		$this->notice_heading = '<h3>' . sprintf( __( 'Thanks for using \'<strong>%s</strong>\'', 'codexpert' ), $this->name ) . '</h3>';
		$this->notice_message = '<p> ' . __( 'We want to know what type of sites use this plugin. Users\' satisfaction is our first priority and we\'re continuously working on it. This is why we need some information so that we can improve it even more.<br />Help us with your site URL and a few basic information. It doesn\'t include your password or any secret data. Would you like to help us?', 'codexpert' ) . '</p>';
		$this->notice_button_text = __( 'Okay. Don\'t bother me again!', 'codexpert' );

		self::hooks();
	}

	public function hooks(){
		$this->activate( 'activation' );
		$this->deactivate( 'deactivation' );
		$this->action( 'admin_head', 'head' );
		$this->action( 'admin_notices', 'admin_notices' );
		$this->priv( "{$this->slug}_survey", 'survey' );
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
	public function activation() {
		
		if( get_option( "{$this->slug}_survey_agreed" ) == 1 ) :
		
		$endpoint = $this->api_url . 'update-lead';

		$params = array(
			'item'			=> $this->slug,
			'siteurl'		=> get_option( 'siteurl' ),
			'is_active'		=> 1,
		);

		$endpoint = add_query_arg( $params, $endpoint );
		wp_remote_get( $endpoint );
		
		endif;
	}

	/**
	 * Trigger when deactivates
	 *
	 */
	public function deactivation() {
		if( get_option( "{$this->slug}_survey_agreed" ) == 1 ) :
		
		$endpoint = $this->api_url . 'update-lead';

		$params = array(
			'item'			=> $this->slug,
			'siteurl'		=> get_option( 'siteurl' ),
			'is_active'		=> 0,
		);

		$endpoint = add_query_arg( $params, $endpoint );
		wp_remote_get( $endpoint );
		
		endif;
	}

	public function head() {
        if( get_option( "{$this->slug}_survey" ) != 1 ) :
		?>
		<style>
			.notice.cx-notice{border:1px solid #f1f1f1;padding:20px}.notice .cx-notice-content h3{padding:0;margin:0;display:inline-block}p.cx-notice-btn-wrapper{margin:0}.cx-notice-btn-wrapper .cx-notice-btn{display:inline-block;padding:.75em;background-color:#4c3f93;transition:.4s;border-color:#4c3f93;outline:none}.cx-notice-btn-wrapper .cx-notice-btn:hover{background-color:#554D82}
		</style>
		<script>
			jQuery(document).ready(function($){
				// survey
			    $(document).on('click', '.is-dismissible.<?php echo $this->slug; ?>-survey-notice .notice-dismiss, .<?php echo $this->slug; ?>-survey', function(e){
			        $(this).prop('disabled', true)
			        $.ajax({
			            url: ajaxurl,
			            data: { 'action' : '<?php echo $this->slug; ?>_survey', 'participate' : $(this).data('participate') },
			            type: 'POST',
			            success: function(ret) {
			                $('.<?php echo $this->slug; ?>-survey-notice').slideToggle(500)
			            }
			        })
			    })
			})
		</script>
		<?php
        endif;
	}

    /**
     * Show admin notices
     *
     */
    public function admin_notices() {
        if( get_option( "{$this->slug}_survey" ) != 1 ) :
        ?>
        <div class="notice notice-success is-dismissible <?php echo $this->slug; ?>-survey-notice survey-notice cx-notice">

        	<img style="float: left;height: 105px; margin-right: 10px" src="https://static.codexpert.io/img/survey.png" />
            <div class="cx-notice-content">
                <?php echo $this->get_heading(); ?>
                <?php echo $this->get_message(); ?>
            </div>
            <p class="cx-notice-btn-wrapper">
                <button class="button button-primary button-hero cx-notice-btn <?php echo $this->slug; ?>-survey" data-participate="1">
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
			$endpoint = $this->api_url . 'store-lead';

			$user_id = get_current_user_id();
			$userdata = get_userdata( $user_id );

			$all_plugins = get_plugins();
			
			$params = array(
				'init'					=> 1,
				'item'					=> $this->slug,
				'siteurl'				=> get_option( 'siteurl' ),
				'admin_email'			=> get_option( 'admin_email' ),
				'first_name'			=> $userdata->first_name,
				'last_name'				=> $userdata->last_name,
				'plugins_installed'		=> implode( ',', array_keys( $all_plugins ) ),
			);


			$endpoint = add_query_arg( $params, $endpoint );
			wp_remote_get( $endpoint );
			update_option( "{$this->slug}_survey_agreed", 1 );
		}

		update_option( "{$this->slug}_survey", 1 );
		wp_die();
	}
}