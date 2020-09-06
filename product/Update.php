<?php
namespace codexpert\product;

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
class Update extends Base {
	
	public $plugin;

	public function __construct( $plugin ) {

		require_once dirname( __FILE__ ) . '/update/plugin-update-checker.php';

		$this->plugin = $plugin;
		
		$this->slug = $this->plugin['TextDomain'];
		$this->server = $this->plugin['Server'];

		$update = \Puc_v4p5_Factory::buildUpdateChecker(
			"{$this->server}/wp-products/?action=get_metadata&slug={$this->slug}", $this->plugin['File'], $this->slug
		);

		$this->filter( 'plugins_api_result', 'set_download_link', 10, 3 );
	}

	/**
	 * Set download_link for the pro package
	 */
	public function set_download_link( $res, $action, $args ) {
		
		if( $res->slug != $this->slug ) return $res;

		$basename = "{$this->slug}-{$this->slug}-php";

		if( get_option( $basename ) == '' ) {
			$res->download_link = false;
		}

		return $res;
	}
}