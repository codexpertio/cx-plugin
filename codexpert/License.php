<?php

/**
 * All License facing functions
 */

namespace codexpert;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage License
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
if( !class_exists( 'codexpert\License' ) ) :
class License {
	
	public $plugin;

	public function __construct( $file, $server = 'http://codexpert.wp', $secret_key = '580cc082161006.41870101' ) {

		$this->file 			= $file;
		$this->license_server 	= $server;
		$this->secret_key 		= $secret_key;

		$this->basedir 	= plugin_basename( $this->file );
		$this->basename = str_replace( array( '/', '.' ), array( '-', '-' ), $this->basedir );

		if( !function_exists('get_plugin_data') ){
		    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$this->plugin 	= get_plugin_data( $this->file );

		$this->hooks();
	}

	public function hooks() {
		register_activation_hook( $this->file, array( $this, 'activation' ) );
		register_deactivation_hook( $this->file, array( $this, 'deactivation' ) );
		add_action( "daily_event_{$this->basename}", array( $this, 'check' ) );
		add_filter( 'plugin_action_links_' . $this->basedir, array( $this, 'inline_form' ) );
		add_action( 'admin_head', array( $this, 'head' ) );
		add_action( "wp_ajax_license-activator-{$this->basename}", array( $this, 'verify' ) );
		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
	}

	public function activation() {
	    if ( !wp_next_scheduled ( "daily_event_{$this->basename}" ) ) {
			wp_schedule_event( time(), 'daily', "daily_event_{$this->basename}" );
	    }
	}

	public function deactivation() {
		wp_clear_scheduled_hook( "daily_event_{$this->basename}" );
	}

	public function head() {
		?>
		<script>
			jQuery(function($){
				$('.<?php echo $this->basename; ?>-btn').click(function(e){
				    e.preventDefault()
				    var dis = $(this)
				    var btn = dis.val()
				    $(this).val('Please wait..')
				    var par = $(this).parent()
				    var key = $('input.key-field', par).val()
				    var plugin = $('input[name="plugin_key"]', par).val()
				    var operation = dis.attr('name')
				    $.ajax({
				        url: ajaxurl,
				        type: 'POST',
				        data: { 'action' : 'license-activator-<?php echo $this->basename; ?>', 'operation' : operation, 'plugin' : plugin, 'key' : key, 'product_ref' : '<?php echo $this->plugin['Name'];?>' },
				        success:function(ret){
				            dis.val(btn)
				            $('.cx-message', par).html(ret)
				        }
				    })
				})
			})
		</script>
		<?php
	}

	function inline_form( $links ) {
		$key = $this->basename;
		$links[] = '<a href="#" id="plugin_' . $key . '" class="cb-updater" data-plugin="' . $key . '">Update</a><span class="show-update-msg"></span>';
		
		$links[] = $this->activator_form( $key );

		return $links;
	}

	public function activator_form( $key ) {
		$value = get_option( $key );
		$html = "
		<div id='div_{$key}' class='cx-activation-div'>
		    <input type='password' id='{$key}' name='{$key}' value='{$value}' class='key-field' placeholder='Input your license key' >
	        <input type='hidden' name='plugin_key' value='{$key}' />
	        <input type='button' name='activate_license' value='Activate' class='{$key}-btn button-primary' />
	        <input type='button' name='deactivate_license' value='Deactivate' class='{$key}-btn button' />
	        <span class='cx-message'></span>
		</div>
		";

		return $html;
	}

	public function verify() {
		$license_key = $_POST['key'];
        if ( isset( $_REQUEST['operation'] ) ) {
            $api_params = array(
                'slm_action' => ( $_REQUEST['operation'] != 'deactivate_license' ) ? 'slm_activate' : 'slm_deactivate',
                'secret_key' => $this->secret_key,
                'license_key' => $license_key,
                'registered_domain' => $_SERVER['SERVER_NAME'],
                'item_reference' => urlencode( $this->plugin['Name'] ),
            );

            $query = esc_url_raw( add_query_arg( $api_params, $this->license_server ) );
            $response = wp_remote_get( $query, array( 'timeout' => 20, 'sslverify' => false ) );

            if ( is_wp_error( $response ) ){
                echo "Unexpected Error! Please try again offr contact us.";
            }

            $license_data = json_decode( wp_remote_retrieve_body( $response ) );
            if( $license_data->result == 'success' ) {
                echo '<strong style="color:#07811a">' . $license_data->message . '</strong>';
                update_option( $this->basename, ( $_REQUEST['operation'] == 'deactivate_license' ) ? '' : $license_key );
				update_option( "{$this->basename}-status", 'active' );
				update_option( "{$this->basename}-expiry", strtotime( $license_data->expiry ) );
            }
            else{
                echo '<strong style="color:#C8080E">' . $license_data->message . '</strong>';
            }

            wp_die();
        }
	}

	public function check() {
		if( ( $lic_key = get_option( $this->basename ) ) == '' ) return;
		
		$args = array(
			'slm_action'	=> 'slm_check',
			'secret_key'	=> $this->secret_key,
			'license_key'	=> $lic_key
		);
		$api = add_query_arg( $args, $this->license_server );
		$data = json_decode( file_get_contents( $api ) );

		// something is wrong
		if( $data->result == 'error' ) {
			delete_option( $this->basename );
		}
		elseif( isset( $data->status ) && in_array( $data->status,  array( 'expired', 'blocked' ) ) ) {
			delete_option( $this->basename );
			update_option( "{$this->basename}-status", $data->status );
		}
		elseif( strtotime( $data->date_expiry ) < time() ) {
			delete_option( $this->basename );
			update_option( "{$this->basename}-status", 'expired' );
		}
	}

    public function license_tab( $form ) {
        echo $this->activator_form( $this->basename );
    }

	public function admin_notice() {

		// not activated
		if( get_option( $this->basename ) == '' ) {
			printf( "
			<div class='notice notice-error notice-cbpr' style='background: #ffaf48'>
		        <p>Please <a href='%s'>activate</a> license for <strong>%s</strong>!</p>
		    </div>
			", admin_url( "admin.php?page=cx-plugin#cx-plugin_license" ), $this->plugin['Name'] );
		}

		// about to expire?
		$expiry = get_option( "{$this->basename}-expiry" );
		$day_left = round( ( $expiry - time() ) / DAY_IN_SECONDS );
		if( $expiry != '' && $day_left <= 30 ) :
			printf( "
			<div class='notice notice-error notice-cbpr' style='background: #ffaf48'>
		        <p>The license for <strong>%s</strong> is about to expire in %d days! Please <a href='%s' target='_blank'>renew</a> to get uninterrupted service or <a href='%s' target='_blank'>cancel</a> if you don't want to renew it anymore!</p>
		    </div>
			", $this->plugin['Name'], $day_left, $this->license_server, $this->license_server );
		endif;

		// expired or blocked?
		$status = get_option( "{$this->basename}-status" );
		if( in_array( $status, array( 'expired', 'blocked' ) ) ) :
			printf( "
			<div class='notice notice-error notice-cbpr' style='background: #ffaf48'>
		        <p><strong>%s</strong> was {$status}!</p>
		    </div>
			", $this->plugin['Name'] );
		endif;
	}

	public function _is_active() {
		return get_option( $this->basename ) != '';
	}

}
endif;