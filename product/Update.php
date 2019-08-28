<?php

/**
 * All Update facing functions
 */

namespace codexpert\Product;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage Update
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Update {
	
	public $plugin;

	public function __construct( $file, $server = 'http://codexpert.wp' ) {

		if( !function_exists('get_plugin_data') ){
		    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		require_once dirname( $file ) . '/product/update/plugin-update-checker.php';

		$this->plugin = get_plugin_data( $file );
		
		$this->plugin_slug = $this->plugin['TextDomain'];
		$this->server = $server;

		$update = \Puc_v4_Factory::buildUpdateChecker(
			"{$this->server}/wp-products/?action=get_metadata&slug={$this->plugin_slug}", $file, $this->plugin_slug
		);
	}
}