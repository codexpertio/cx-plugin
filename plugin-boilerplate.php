<?php
/*
Plugin Name: MyPlugin
Description: Plugin boilerplate
Plugin URI: https://codexpert.io
Author: Nazmul Ahsan
Author URI: https://nazmulahsan.me
Version: 1.0
Text Domain: wpp-plugin
Domain Path: /languages
*/

namespace codexpert\MyPlugin;
use \codexpert\Survey as Survey;
use \codexpert\License as License;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WPPP', __FILE__ );

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

	public function __construct() {
		self::includes();
		self::define();
		self::hooks();
	}

	/**
	 * Define constants
	 */
	public function define(){
		if( !function_exists( 'get_plugin_data' ) ) {
		    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$this->plugin = get_plugin_data( WPPP );

		$this->slug = $this->plugin['TextDomain'];
		$this->name = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];
		$this->server = 'http://codexpert.wp';
	}

	/**
	 * Includes files
	 */
	public function includes(){
		require_once dirname( WPPP ) . '/vendor/autoload.php';
		require_once dirname( WPPP ) . '/includes/wpp-functions.php';
	}

	/**
	 * Hooks
	 */
	public function hooks(){
		// i18n
		add_action( 'plugins_loaded', array( $this, 'i18n' ) );

		// front hooks
		$front = ( isset( $front ) && ! is_null( $front ) ) ? $front : new Front( $this->slug, $this->version );
		add_action( 'wp_head', array( $front, 'head' ) );
		add_action( 'wp_enqueue_scripts', array( $front, 'enqueue_scripts' ) );

		// admin hooks
		$admin = ( isset( $admin ) && ! is_null( $admin ) ) ? $admin : new Admin( $this->slug, $this->version );
		add_action( 'admin_head', array( $admin, 'head' ) );
		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_scripts' ) );

		// ajax hooks
		$ajax = ( isset( $ajax ) && ! is_null( $ajax ) ) ? $ajax : new AJAX( $this->slug, $this->version );

		// settings hooks
		$settings = ( isset( $settings ) && ! is_null( $settings ) ) ? $settings : new Settings( $this->slug, $this->version );
		add_action( 'admin_menu', array( $settings, 'admin_menu' ) );
		add_action( 'admin_init', array( $settings, 'admin_init' ) );

		// survey hooks
		$survey = ( isset( $survey ) && ! is_null( $survey ) ) ? $survey : new Survey( $this->slug, $this->name, WPPP, $this->server );

		// license hooks
		$license = ( isset( $license ) && ! is_null( $license ) ) ? $license : new License( WPPP, $this->server );

	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'wpp-plugin', false, dirname( plugin_basename( WPPP ) ) . '/languages/' );
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