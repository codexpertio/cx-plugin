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
class Auth {
	
	public function login( $request ) {
		$username = $request->get_param( 'username' );
        $password = $request->get_param( 'password' );

        if( ! username_exists( $username ) ) {
            return new \WP_Error( 401, __( 'Username doesn\'t exist' ) );
        }

        // if( ! wp_check_password( $password, get_user_by( 'login', $username )->data->user_pass ) ) {
        //     return new \WP_Error( 401, __( 'Invalid password!' ) );
        // }

        // $user = wp_authenticate($username, $password);

        $user = wp_signon(
            [
                'user_login'    => $username,
                'user_password' => $password,
                'remember'      => true
            ],
            is_ssl()
        );

        if( ! is_wp_error( $user ) ) {

            $action = 'wp_rest';

            $uid  = (int) $user->ID;
            $token = wp_get_session_token( $action );
            $i     = wp_nonce_tick( $action );

            return [
                'nonce'     => substr( wp_hash( $i . '|' . $action . '|' . $uid . '|' . $token, 'nonce' ), -12, 10 ),
                'hash'      => 'wordpress_logged_in_' . COOKIEHASH,
                'cookie'    => $_COOKIE[ LOGGED_IN_COOKIE ],
            ];
        }
	}
}