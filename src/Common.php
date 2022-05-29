<?php
/**
 * All common functions to load in both admin and front
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
 * @subpackage Common
 * @author Codexpert <hi@codexpert.io>
 */
class Common extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	public function redirect_home() {
		$post_type = get_post_type();
		
		if ( is_single() && 'post' ==  $post_type ) {
		    wp_redirect( home_url() );
		    exit;
		}
	}
}