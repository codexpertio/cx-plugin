<?php
/**
 * All common functions to load in both admin and front
 */
namespace Codexpert\CX_Plugin\App;
use Codexpert\Plugin\Base;
use Codexpert\CX_Plugin\API\Post;
use Codexpert\CX_Plugin\API\Auth;

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

		register_rest_route( $this->namespace, '/auth/', [
			'methods'   => 'POST',
			'callback'  => [ new Auth, 'login' ],
			'permission_callback' => function( $request ) {
				return ! is_user_logged_in();
			}
		] );

		register_rest_route( $this->namespace, '/posts/', [
			'methods'   => 'GET',
			'callback'  => [ new Post, 'list' ],
			'permission_callback' => function( $request ) {
				return true;
			}
		] );
	}
}