<?php
/**
 * All admin facing functions
 */

namespace codexpert\CX_Plugin;
use codexpert\Product\License;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Admin extends Hooks {

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->slug = $plugin['TextDomain'];
		$this->name = $plugin['Name'];
		$this->version = $plugin['Version'];
	}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'CXP_DEBUG' ) && CXP_DEBUG ? '' : '.min';
		
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin{$min}.css", CXP ), '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin{$min}.js", CXP ), array( 'jquery' ), $this->version, true );
	}

	/**
	 * Add some script to head
	 */
	public function head() {

	}

	public function license_form( $section ) {
		if( $section['id'] != 'cx-plugin_license' ) return;

		$license = new License( CXP );
		echo $license->activator_form();
		echo '<p>' . __( 'Please input your license key and click Activate.', 'cx-plugin' ) . '</p>';
	}
}