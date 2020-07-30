<?php
/*
Plugin Name: CX_Plugin
Description: CX_Plugin by codexpert
Plugin URI: https://codexpert.io
Author: codexpert
Author URI: https://codexpert.io
Version: 1.0
Text Domain: cx-plugin
Domain Path: /languages
*/

namespace codexpert\CX_Plugin;
use codexpert\Product\License;
use codexpert\Product\Survey;
use codexpert\Product\Update;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Main class for the plugin
 * @package Plugin
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Plugin {
	
	public static $_instance;

	public function __construct() {
		self::include();
		self::define();
		self::hook();
	}

	/**
	 * Includes files
	 */
	public function include() {
		require_once dirname( __FILE__ ) . '/vendor/autoload.php';
	}

	/**
	 * Define varibles and constants
	 */
	public function define() {
		// constants
		define( 'CXP', __FILE__ );
		define( 'CXP_DIR', dirname( CXP ) );
		define( 'CXP_DEBUG', true );

		// plugin data
		$this->plugin					= get_plugin_data( CXP );
		$this->plugin['File']			= CXP;
		$this->plugin['Server']			= 'https://my.codexpert.io';
		$this->plugin['min_php']		= '5.6';
		$this->plugin['min_wp']			= '4.0';
		$this->plugin['dependencies']	= [ 'woocommerce/woocommerce.php' => 'WooCommerce' ];
	}

	/**
	 * Hooks
	 */
	public function hook() {
		// i18n

		/**
		 * Front facing hooks
		 *
		 * To add an action, use $front->action()
		 * To apply a filter, use $front->filter()
		 */
		$front = new Front( $this->plugin );
		$front->action( 'wp_head', 'head' );
		$front->action( 'wp_enqueue_scripts', 'enqueue_scripts' );

		/**
		 * Admin facing hooks
		 *
		 * To add an action, use $admin->action()
		 * To apply a filter, use $admin->filter()
		 */
		$admin = new Admin( $this->plugin );
		$admin->action( 'plugins_loaded', 'i18n' );
		$admin->action( 'admin_head', 'head' );
		$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
		$admin->action( 'admin_notices', 'admin_notices' );

		/**
		 * Settings related hooks
		 *
		 * To add an action, use $settings->action()
		 * To apply a filter, use $settings->filter()
		 */
		$settings = new Settings( $this->plugin );
		$settings->action( 'plugins_loaded', 'init_menu' );
		$settings->action( 'admin_bar_menu', 'add_admin_bar', 70 );
		$settings->action( 'cx-settings-before-form', 'tab_content' );

		/**
		 * AJAX facing hooks
		 *
		 * To add a hook for logged in users, use $ajax->priv()
		 * To add a hook for non-logged in users, use $ajax->nopriv()
		 */
		$ajax = new AJAX( $this->plugin );

		/**
		 * Shortcode hooks
		 *
		 * To enable a shortcode, use $shortcode->register()
		 */
		$shortcode = new Shortcode( $this->plugin );

		/**
		 * API hooks
		 *
		 * Custom REST API
		 */
		$api = new API( $this->plugin );
		$api->action( 'rest_api_init', 'register_endpoints' );

		// Product related classes
		$survey = new Survey( $this->plugin );
		$license = new License( $this->plugin );
		$update = new Update( $this->plugin );
	}

	/**
	 * Cloning is forbidden.
	 */
	private function __clone() { }

	/**
	 * Unserializing instances of this class is forbidden.
	 */
	private function __wakeup() { }

	/**
	 * Instantiate the plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

Plugin::instance();