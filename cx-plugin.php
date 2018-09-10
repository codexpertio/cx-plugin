<?php
/*
Plugin Name: CX_Plugin
Description: Plugin boilerplate
Plugin URI: https://codexpert.io
Author: Nazmul Ahsan
Author URI: https://nazmulahsan.me
Version: 1.0
Text Domain: cx-plugin
Domain Path: /languages
*/

namespace codexpert\CX_Plugin;
use codexpert\Remote\License;
use codexpert\Remote\Survey;
use codexpert\Remote\Update;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CXP', __FILE__ );

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
		$this->plugin = get_plugin_data( CXP );

		$this->slug = $this->plugin['TextDomain'];
		$this->name = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];
		$this->server = 'http://codexpert.wp';
	}

	/**
	 * Includes files
	 */
	public function includes(){
		require_once dirname( CXP ) . '/vendor/autoload.php';
		require_once dirname( CXP ) . '/includes/wpp-functions.php';
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

		
		// Product related classes
		$survey = ( isset( $survey ) && ! is_null( $survey ) ) ? $survey : new Survey( CXP, $this->server );
		$license = ( isset( $license ) && ! is_null( $license ) ) ? $license : new License( CXP, $this->server );
		$update = ( isset( $update ) && ! is_null( $update ) ) ? $update : new Update( CXP, $this->server );

	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'wpp-admin', false, dirname( plugin_basename( CXP ) ) . '/languages/' );
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