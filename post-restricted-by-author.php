<?php
/**
 * Plugin Name: Post Restricted by Author
 * Description: Post Restricted by Author by Codexpert
 * Plugin URI: https://wpplugines.com/
 * Author: WPPlugines
 * Author URI: https://wpplugines.com/
 * Version: 0.1.0
 * Text Domain: post-restricted-by-author
 * Domain Path: /languages
 *
 * Post_Restricted_By_Author is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Post_Restricted_By_Author is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 */

namespace Codexpert\Post_Restricted_By_Author;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main class for the plugin
 * @package Plugin
 * @author Codexpert <hi@codexpert.io>
 */
final class Plugin {
	
	/**
	 * Plugin instance
	 * 
	 * @access private
	 * 
	 * @var Plugin
	 */
	private static $_instance;

	/**
	 * The constructor method
	 * 
	 * @access private
	 * 
	 * @since 0.9
	 */
	private function __construct() {
		/**
		 * Includes required files
		 */
		$this->include();

		/**
		 * Defines contants
		 */
		$this->define();

		/**
		 * Runs actual hooks
		 */
		$this->hook();
	}

	/**
	 * Includes files
	 * 
	 * @access private
	 * 
	 * @uses composer
	 * @uses psr-4
	 */
	private function include() {
		require_once( dirname( __FILE__ ) . '/vendor/autoload.php' );
	}

	/**
	 * Define variables and constants
	 * 
	 * @access private
	 * 
	 * @uses get_plugin_data
	 * @uses plugin_basename
	 */
	private function define() {

		/**
		 * Define some constants
		 * 
		 * @since 0.9
		 */
		define( 'CXP', __FILE__ );
		define( 'CXP_DIR', dirname( CXP ) );
		define( 'CXP_ASSET', plugins_url( 'assets', CXP ) );
		define( 'CXP_DEBUG', apply_filters( 'cx-plugin_debug', true ) );

		/**
		 * The plugin data
		 * 
		 * @since 0.9
		 * @var $plugin
		 */
		$this->plugin					= get_plugin_data( CXP );
		$this->plugin['basename']		= plugin_basename( CXP );
		$this->plugin['file']			= CXP;
		$this->plugin['server']			= apply_filters( 'cx-plugin_server', 'https://codexpert.io/dashboard' );
		$this->plugin['min_php']		= '5.6';
		$this->plugin['min_wp']			= '4.0';
		$this->plugin['doc_id']			= 1960;
		$this->plugin['icon']			= CXP_ASSET . '/img/icon.png';
		$this->plugin['depends']		= [ 'woocommerce/woocommerce.php' => 'WooCommerce' ];

		/**
		 * Set a global variable
		 * 
		 * @global $Post_Restricted_By_Author
		 */
		global $Post_Restricted_By_Author;
		$Post_Restricted_By_Author = $this->plugin;
	}

	/**
	 * Hooks
	 * 
	 * @access private
	 * 
	 * Executes main plugin features
	 *
	 * To add an action, use $instance->action()
	 * To apply a filter, use $instance->filter()
	 * To register a shortcode, use $instance->register()
	 * To add a hook for logged in users, use $instance->priv()
	 * To add a hook for non-logged in users, use $instance->nopriv()
	 * 
	 * @return void
	 */
	private function hook() {

		if( is_admin() ) :

			/**
			 * Admin facing hooks
			 */
			$admin = new Admin( $this->plugin );
			$admin->activate( 'install' );
			$admin->action( 'admin_footer', 'modal' );
			$admin->action( 'plugins_loaded', 'i18n' );
			$admin->action( 'admin_init', 'add_meta_boxes' );
			$admin->action( 'admin_enqueue_scripts', 'enqueue_scripts' );
			$admin->filter( "plugin_action_links_{$this->plugin['basename']}", 'action_links' );
			$admin->filter( 'plugin_row_meta', 'plugin_row_meta', 10, 2 );
			$admin->action( 'save_post', 'update_cache', 10, 3 );
			$admin->action( 'admin_footer_text', 'footer_text' );

			/**
			 * Settings related hooks
			 */
			$settings = new Settings( $this->plugin );
			$settings->action( 'plugins_loaded', 'init_menu' );

		else : // !is_admin() ?

			/**
			 * Front facing hooks
			 */
			$front = new Front( $this->plugin );
			$front->action( 'wp_head', 'head' );
			$front->action( 'wp_footer', 'modal' );
			$front->action( 'wp_enqueue_scripts', 'enqueue_scripts' );
			$front->action( 'admin_bar_menu', 'add_admin_bar', 70 );

		endif;

		/**
		 * Common hooks
		 *
		 * Executes on both the admin area and front area
		 */
		$common = new Common( $this->plugin );
		$common->action( 'template_redirect', 'redirect_home' );

		/**
		 * AJAX related hooks
		 */
		$ajax = new AJAX( $this->plugin );
		$ajax->priv( 'cx-plugin_fetch-docs', 'fetch_docs' );
	}

	/**
	 * Cloning is forbidden.
	 * 
	 * @access public
	 */
	public function __clone() { }

	/**
	 * Unserializing instances of this class is forbidden.
	 * 
	 * @access public
	 */
	public function __wakeup() { }

	/**
	 * Instantiate the plugin
	 * 
	 * @access public
	 * 
	 * @return $_instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

Plugin::instance();