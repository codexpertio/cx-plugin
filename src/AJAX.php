<?php
/**
 * All AJAX related functions
 */
namespace Codexpert\Post_Restricted_By_Author;
use Codexpert\Plugin\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage AJAX
 * @author Codexpert <hi@codexpert.io>
 */
class AJAX extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Sync docs from https://help.codexpert.io
	 *
	 * @since 1.0
	 */
	public function fetch_docs() {
	    if( isset( $this->plugin['doc_id'] ) && ! is_wp_error( $_docs_data = wp_remote_get( "https://help.codexpert.io/wp-json/wp/v2/docs/?parent={$this->plugin['doc_id']}&per_page=20" ) ) ) {
	        update_option( 'cx-plugin_docs_json', json_decode( $_docs_data['body'], true ) );
	    }
	}

}