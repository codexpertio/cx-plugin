<?php
/**
 * All API facing functions
 */

namespace codexpert\CX_Plugin;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage API
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class API extends Hooks {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->slug = $this->plugin['TextDomain'];
		$this->name = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];

		$this->api_base = $this->plugin['TextDomain'];
		$this->api_version = $this->plugin['Version'];
		$this->namespace = "{$this->slug}/v{$this->version}";
	}

	public function register_endpoints() {
		register_rest_route( $this->namespace, '/some-slug/', array(
			'methods'   => 'GET',
			'callback'  => array( $this, 'some_callback' ),
			'permission_callback' => function( $request ) {
				return is_user_logged_in();
			}
		) );
	}

	public function some_callback( $request ) {
		$parameters = $request->get_params();
	}
}