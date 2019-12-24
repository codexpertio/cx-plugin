<?php
/**
 * All AJAX facing functions
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
 * @subpackage AJAX
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class AJAX extends Hooks {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->slug = $this->plugin['TextDomain'];
		$this->name = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];
	}

}