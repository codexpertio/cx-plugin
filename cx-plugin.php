<?php
/**
 * Plugin Name: CX_Plugin
 * Description: CX_Plugin by codexpert
 * Plugin URI: https://codexpert.io
 * Author: codexpert
 * Author URI: https://codexpert.io
 * Version: 1.0
 * Text Domain: cx-plugin
 * Domain Path: /languages
 *
 * CX_Plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * CX_Plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

namespace codexpert\CX_Plugin;
use codexpert\product\License;
use codexpert\product\Survey;
use codexpert\product\Update;
use codexpert\product\Notice;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for the plugin
 * @package Plugin
 * @author codexpert <hello@codexpert.io>
 */
final class Plugin {
	
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
		require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	}

	/**
	 * Define variables and constants
	 */
	public function define() {
		// constants
		define( 'CXP', __FILE__ );
		define( 'CXP_DIR', dirname( CXP ) );
		define( 'CXP_DEBUG', true );

		// plugin data
		$this->plugin				= get_plugin_data( CXP );
		$this->plugin['basename']	= plugin_basename( CXP );
		$this->plugin['file']		= CXP;
		$this->plugin['server']		= apply_filters( 'cx-plugin_server', 'https://my.codexpert.io' );
		$this->plugin['min_php']	= '5.6';
		$this->plugin['min_wp']		= '4.0';
		$this->plugin['depends']	= [ 'woocommerce/woocommerce.php' => 'WooCommerce' ];
		$this->plugin['license']	= new License( $this->plugin );
	}

	/**
	 * Hooks
	 */
	public function hook() {

		if( is_admin() ) :

			/**
			 * Setup wizard facing hooks
			 *
			 * To add an action, use $admin->action()
			 * To apply a filter, use $admin->filter()
			 */
			$wizard = new Wizard( $this->plugin );
			$wizard->action( 'plugins_loaded', 'run' );

			/**
			 * Admin facing hooks
			 *
			 * To add an action, use $admin->action()
			 * To apply a filter, use $admin->filter()
			 */
			$admin = new Admin( $this->plugin );
			$admin->action( 'plugins_loaded', 'i18n' );
			$admin->action( 'admin_init', 'add_meta_boxes' );
			$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
			$admin->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );
			$admin->filter( 'plugin_row_meta', 'plugin_row_meta', 10, 2 );
			$admin->action( 'save_post', 'update_cache', 10, 3 );
			$admin->action( 'admin_footer_text', 'footer_text' );

			/**
			 * Settings related hooks
			 *
			 * To add an action, use $settings->action()
			 * To apply a filter, use $settings->filter()
			 */
			$settings = new Settings( $this->plugin );
			$settings->action( 'plugins_loaded', 'init_menu' );
			$settings->action( 'cx-settings-before-form', 'tab_content' );

			// Product related classes
			$survey		= new Survey( $this->plugin );
			$notice		= new Notice( $this->plugin );
			// $update		= new Update( $this->plugin );

		else : // !is_admin() ?

			/**
			 * Front facing hooks
			 *
			 * To add an action, use $front->action()
			 * To apply a filter, use $front->filter()
			 */
			$front = new Front( $this->plugin );
			$front->action( 'wp_enqueue_scripts', 'enqueue_scripts' );
			$front->action( 'admin_bar_menu', 'add_admin_bar', 70 );

			/**
			 * Shortcode hooks
			 *
			 * To enable a shortcode, use $shortcode->register()
			 */
			$shortcode = new Shortcode( $this->plugin );
			$shortcode->register( 'my-shortcode', 'my_shortcode' );

			/**
			 * API hooks
			 *
			 * Custom REST API
			 */
			$api = new API( $this->plugin );
			$api->action( 'rest_api_init', 'register_endpoints' );

		endif;

		/**
		 * AJAX facing hooks
		 *
		 * To add a hook for logged in users, use $ajax->priv()
		 * To add a hook for non-logged in users, use $ajax->nopriv()
		 */
		$ajax = new AJAX( $this->plugin );
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