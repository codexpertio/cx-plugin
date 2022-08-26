<?php
/**
 * All REST API related functions
 */
namespace Codexpert\CX_Plugin\API;
use Codexpert\Plugin\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage API
 * @author Codexpert <hi@codexpert.io>
 */
class Init extends Base {

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

		register_rest_route( $this->namespace, '/posts/', [
			'methods'   => 'GET',
			'callback'  => [ new Post, 'list' ],
			'permission_callback' => function( $request ) {
				return true;
			}
		] );
	}
}