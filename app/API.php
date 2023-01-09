<?php
/**
 * All common functions to load in both admin and front
 */
namespace Codexpert\CX_Plugin\App;
use Codexpert\Plugin\Base;
use Codexpert\CX_Plugin\API\User;
use Codexpert\CX_Plugin\API\Option;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Common
 * @author Codexpert <hi@codexpert.io>
 */
class API extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin		= $plugin;
		$this->slug			= $this->plugin['TextDomain'];
		$this->version		= $this->plugin['Version'];

		$this->namespace	= apply_filters( "{$this->slug}_rest_route_namespace", sprintf( '%1$s/v%2$d', $this->slug, $this->version ) );
	}

	public function register_endpoints() {

		/**
		 * Options (`wp_options`) API
		 */
		register_rest_route( $this->namespace, '/option/add', [
			'methods'   => 'POST',
			'callback'  => [ new Option, 'add' ],
			'permission_callback' => function( $request ) {
				return current_user_can( 'manage_options' );
			}
		] );

		register_rest_route( $this->namespace, '/option/update', [
			'methods'   => 'POST',
			'callback'  => [ new Option, 'update' ],
			'permission_callback' => function( $request ) {
				return current_user_can( 'manage_options' );
			}
		] );

		register_rest_route( $this->namespace, '/option/get', [
			'methods'   => 'GET',
			'callback'  => [ new Option, 'get' ],
			'permission_callback' => function( $request ) {
				return current_user_can( 'manage_options' );
			}
		] );

		/**
		 * Users API
		 */
		register_rest_route( $this->namespace, '/user/meta/add', [
			'methods'   => 'POST',
			'callback'  => [ new User, 'add_meta' ],
			'permission_callback' => function( $request ) {
				return current_user_can( 'edit_user', $request->get_param( 'user_id' ) );
			}
		] );

		register_rest_route( $this->namespace, '/user/meta/update', [
			'methods'   => 'POST',
			'callback'  => [ new User, 'update_meta' ],
			'permission_callback' => function( $request ) {
				return current_user_can( 'edit_user', $request->get_param( 'user_id' ) );
			}
		] );
		
		register_rest_route( $this->namespace, '/user/meta/get', [
			'methods'   => 'GET',
			'callback'  => [ new User, 'get_meta' ],
			'permission_callback' => function( $request ) {
				return current_user_can( 'edit_user', $request->get_param( 'user_id' ) );
			}
		] );
		
	}
}