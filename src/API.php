<?php
/**
 * All REST API related functions
 */
namespace codexpert\CX_Plugin;
use codexpert\product\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage API
 * @author codexpert <hello@codexpert.io>
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

		$this->namespace	= apply_filters( "{$this->slug}_rest_route_namespace", "{$this->slug}/v{$this->version}" );
	}

	public function register_endpoints() {
		register_rest_route( $this->namespace, '/some-slug/', [
			'methods'   => 'GET',
			'callback'  => [ $this, 'some_callback' ],
			'permission_callback' => function( $request ) {
				// return is_user_logged_in();
				return 1 == 1;
			}
		] );
	}

	public function some_callback( $request ) {
		return $parameters = $request->get_params();
	}
}