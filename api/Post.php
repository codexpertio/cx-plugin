<?php
/**
 * All REST API related functions
 */
namespace Codexpert\CX_Plugin\API;
use Codexpert\CX_Plugin\Helper;

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
class Post {
	
	public function list( $request ) {
		return Helper::get_posts( $request->get_params() );
	}
}