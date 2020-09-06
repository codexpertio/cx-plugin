<?php
/**
 * All admin facing functions
 */
namespace codexpert\CX_Plugin;
use codexpert\product\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Admin extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->slug = $this->plugin['TextDomain'];
		$this->name = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'cx-plugin', false, CXP_DIR . '/languages/' );
	}

	/**
	 * Add some script to head
	 */
	public function head() {}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'CXP_DEBUG' ) && CXP_DEBUG ? '' : '.min';
		
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin{$min}.css", CXP ), '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin{$min}.js", CXP ), [ 'jquery' ], $this->version, true );
	}

	public function admin_notices() {
		
		if( version_compare( get_bloginfo( 'version' ), $this->plugin['min_wp'], '<' ) ) {
			echo "
				<div class='notice cx-notice notice-error'>
					<p>" . sprintf( __( '<strong>%s</strong> requires <i>WordPress version %s</i> or higher. You have <i>version %s</i> installed.', 'cx-plugin' ), $this->name, $this->plugin['min_wp'], get_bloginfo( 'version' ) ) . "</p>
				</div>
			";
		}

		if( version_compare( PHP_VERSION, $this->plugin['min_php'], '<' ) ) {
			echo "
				<div class='notice cx-notice notice-error'>
					<p>" . sprintf( __( '<strong>%s</strong> requires <i>PHP version %s</i> or higher. You have <i>version %s</i> installed.', 'cx-plugin' ), $this->name, $this->plugin['min_php'], PHP_VERSION ) . "</p>
				</div>
			";
		}

		/**
		 * Dependencies
		 *
		 * @since 1.0
		 */
		$installed_plugins = get_plugins();
		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		foreach ( $this->plugin['depends'] as $plugin => $name ) {
			if( !in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

				$action_links = cx_plugin_action_link( $plugin );
				$button_text = array_key_exists( $plugin, $installed_plugins ) ? __( 'activate', 'cx-plugin' ) : __( 'install', 'cx-plugin' );
				$action_link = array_key_exists( $plugin, $installed_plugins ) ? $action_links['activate'] : $action_links['install'];
			
				echo "
					<div class='notice cx-notice notice-error'>
						<p>" . sprintf( __( '<strong>%s</strong> needs to be activated. Please <a href="%s">%s</a> it now.', 'cx-plugin' ), $name, $action_link, $button_text ) . "</p>
					</div>
				";
			}
		}
	}
}