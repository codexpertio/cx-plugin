<?php
/**
 * All admin facing functions
 */
namespace Codexpert\CX_Plugin\App;
use Codexpert\Plugin\Base;
use Codexpert\Plugin\Metabox;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author Codexpert <hi@codexpert.io>
 */
class Admin extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'cx-plugin', false, CXP_DIR . '/languages/' );
	}

	/**
	 * Installer. Runs once when the plugin in activated.
	 *
	 * @since 1.0
	 */
	public function install() {

		if( ! get_option( 'cx-plugin_version' ) ){
			update_option( 'cx-plugin_version', $this->version );
		}
		
		if( ! get_option( 'cx-plugin_install_time' ) ){
			update_option( 'cx-plugin_install_time', time() );
		}
	}

	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'CXP_DEBUG' ) && CXP_DEBUG ? '' : '.min';
		
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin{$min}.css", CXP ), '', $this->version, 'all' );
		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin{$min}.js", CXP ), [ 'jquery' ], $this->version, true );

	    wp_enqueue_style( "{$this->slug}-react", plugins_url( 'build/index.css', CXP ) );
	    wp_enqueue_script( "{$this->slug}-react", plugins_url( 'build/index.js', CXP ), [ 'wp-element' ], '1.0.0', true );
	}

	public function admin_menu() {

		add_menu_page(
			__( 'CX Plugin', 'cx-plugin' ),
			__( 'CX Plugin', 'cx-plugin' ),
			'manage_options',
			'cx-plugin',
			function(){},
			'dashicons-wordpress',
			25
		);

		add_submenu_page(
			'cx-plugin',
			__( 'Help', 'cx-plugin' ),
			__( 'Help', 'cx-plugin' ),
			'manage_options',
			'cx-plugin-help',
			function() {
				printf( '<div id="cx-plugin_help"><p>%s</p></div>', __( 'Loading..', 'cx-plugin' ) );
			}
		);

		add_submenu_page(
			'cx-plugin',
			__( 'License', 'cx-plugin' ),
			__( 'License', 'cx-plugin' ),
			'manage_options',
			'cx-plugin-license',
			function() {
				echo $this->plugin['license']->activator_form();
			}
		);
	}

	public function action_links( $links ) {
		$this->admin_url = admin_url( 'admin.php' );

		$new_links = [
			'settings'	=> sprintf( '<a href="%1$s">' . __( 'Settings', 'cx-plugin' ) . '</a>', add_query_arg( 'page', $this->slug, $this->admin_url ) )
		];
		
		return array_merge( $new_links, $links );
	}

	public function plugin_row_meta( $plugin_meta, $plugin_file ) {
		
		if ( $this->plugin['basename'] === $plugin_file ) {
			$plugin_meta['help'] = '<a href="https://help.codexpert.io/" target="_blank" class="cx-help">' . __( 'Help', 'cx-plugin' ) . '</a>';
		}

		return $plugin_meta;
	}

	public function update_cache( $post_id, $post, $update ) {
		wp_cache_delete( "cx_plugin_{$post->post_type}", 'cx_plugin' );
	}

	public function footer_text( $text ) {
		if( get_current_screen()->parent_base != $this->slug ) return $text;

		return sprintf( __( 'If you like <strong>%1$s</strong>, please <a href="%2$s" target="_blank">leave us a %3$s rating</a> on WordPress.org! It\'d motivate and inspire us to make the plugin even better!', 'cx-plugin' ), $this->name, "https://wordpress.org/support/plugin/{$this->slug}/reviews/?filter=5#new-post", '⭐⭐⭐⭐⭐' );
	}

	public function modal() {
		echo '
		<div id="cx-plugin-modal" style="display: none">
			<img id="cx-plugin-modal-loader" src="' . esc_attr( CXP_ASSET . '/img/loader.gif' ) . '" />
		</div>';
	}
}