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

define( 'CXP', __FILE__ );
define( 'CXP_DEBUG', true );

/**
 * Main class for the plugin
 * @package Plugin
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Plugin {
	
	public static $_instance;
	public $slug;
	public $name;
	public $version;
	public $server;
	public $required_php = '5.6';
	public $required_wp = '4.0';

	public function __construct() {
		self::define();
		
		if( !$this->_compatible() ) return;

		self::includes();
		self::hooks();
	}

	/**
	 * Define constants
	 */
	public function define(){
		if( !function_exists( 'get_plugin_data' ) ) {
		    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$this->plugin = get_plugin_data( CXP );

		$this->server = 'https://codexpert.io';
	}

	/**
	 * Compatibility and dependency
	 */
	public function _compatible() {
		$_compatible = true;

		if( !file_exists( dirname( CXP ) . '/vendor/autoload.php' ) ) {
			add_action( 'admin_notices', function() {
				echo "
					<div class='notice notice-error'>
						<p>" . sprintf( __( 'Packages are not installed. Please run <code>%s</code> in <code>%s</code> directory!', 'pointpress-wc' ), 'composer update', dirname( CXP ) ) . "</p>
					</div>
				";
			} );

			$_compatible = false;
		}

		if( version_compare( get_bloginfo( 'version' ), $this->required_wp, '<' ) ) {
			add_action( 'admin_notices', function() {
				echo "
					<div class='notice notice-error'>
						<p>" . sprintf( __( '<strong>%s</strong> requires <i>WordPress version %s</i> or higher. You have <i>version %s</i> installed.', 'cx-plugin' ), $this->name, $this->required_wp, get_bloginfo( 'version' ) ) . "</p>
					</div>
				";
			} );

			$_compatible = false;
		}

		if( version_compare( PHP_VERSION, $this->required_php, '<' ) ) {
			add_action( 'admin_notices', function() {
				echo "
					<div class='notice notice-error'>
						<p>" . sprintf( __( '<strong>%s</strong> requires <i>PHP version %s</i> or higher. You have <i>version %s</i> installed.', 'cx-plugin' ), $this->name, $this->required_php, PHP_VERSION ) . "</p>
					</div>
				";
			} );

			$_compatible = false;
		}

		return $_compatible;
	}

	/**
	 * Includes files
	 */
	public function includes(){
		require_once dirname( CXP ) . '/vendor/autoload.php';
		require_once dirname( CXP ) . '/includes/functions.php';
	}

	/**
	 * Hooks
	 */
	public function hooks(){
		// i18n
		add_action( 'plugins_loaded', array( $this, 'i18n' ) );

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
		$admin->action( 'admin_head', 'head' );
		$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );

		/**
		 * Settings related hooks
		 *
		 * To add an action, use $settings->action()
		 * To apply a filter, use $settings->filter()
		 */
		$settings = new Settings( $this->plugin );
		$settings->action( 'admin_bar_menu', 'add_admin_bar', 1, 70 );
		$settings->action( 'cx-settings-before-form', 'help_content' );
		$settings->action( 'cx-settings-before-form', 'license_form' );

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
		$survey = new Survey( CXP, $this->server );
		$license = new License( CXP, $this->server );
		if( $license->_is_active() ) {
			$update = new Update( CXP, $this->server );
		}
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'cx-plugin', false, dirname( plugin_basename( CXP ) ) . '/languages/' );
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