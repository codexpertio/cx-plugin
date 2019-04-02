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

		$this->slug = $this->plugin['TextDomain'];
		$this->name = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];
		$this->server = 'http://codexpert.wp';
	}

	/**
	 * Version compatibility
	 */
	public function _compatible() {
		$_compatible = true;

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
		add_action( 'init', array( $settings, 'init' ) );

		
		// Product related classes
		$survey = ( isset( $survey ) && ! is_null( $survey ) ) ? $survey : new Survey( CXP, $this->server );
		$license = ( isset( $license ) && ! is_null( $license ) ) ? $license : new License( CXP, $this->server );
		$update = ( isset( $update ) && ! is_null( $update ) ) ? $update : new Update( CXP, $this->server );

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