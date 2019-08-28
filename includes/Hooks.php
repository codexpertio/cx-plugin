<?php
/**
 * All admin facing functions
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
 * @subpackage Hooks
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Hooks {

    /**
     * Constructor function
     */
    public function __construct( $plugin ) {
        $this->name = $plugin['Name'];
        $this->slug = $plugin['TextDomain'];
        $this->version = $plugin['Version'];
    }
    
    /**
     * @see register_activation_hook
     * @uses codexpert\CX_Plugin\Admin
     * @uses codexpert\CX_Plugin\Front
     * @uses codexpert\CX_Plugin\API
     */
    public function activate( $callback ) {
        register_activation_hook( CXP, array( $this, $callback ) );
    }
    
    /**
     * @see register_activation_hook
     * @uses codexpert\CX_Plugin\Admin
     * @uses codexpert\CX_Plugin\Front
     * @uses codexpert\CX_Plugin\API
     */
    public function deactivate( $callback ) {
        register_deactivation_hook( CXP, array( $this, $callback ) );
    }
    
    /**
     * @see add_action
     * @uses codexpert\CX_Plugin\Admin
     * @uses codexpert\CX_Plugin\Front
     */
    public function action( $tag, $callback, $num_args = 1, $priority = 10 ) {
        add_action( $tag, array( $this, $callback ), $priority, $num_args );
    }

    /**
     * @see add_filter
     * @uses codexpert\CX_Plugin\Admin
     * @uses codexpert\CX_Plugin\Front
     */
    public function filter( $tag, $callback, $num_args = 1, $priority = 10 ) {
        add_filter( $tag, array( $this, $callback ), $priority, $num_args );
    }

    /**
     * @see add_shortcode
     * @uses codexpert\CX_Plugin\Shortcode
     */
    public function register( $tag, $callback ) {
        add_shortcode( $tag, array( $this, $callback ) );
    }

    /**
     * @see add_action( 'wp_ajax_..' )
     * @uses codexpert\CX_Plugin\AJAX
     */
    public function priv( $handle, $callback ) {
        $this->action( "wp_ajax_{$handle}", $callback );
    }

    /**
     * @see add_action( 'wp_ajax_nopriv_..' )
     * @uses codexpert\CX_Plugin\AJAX
     */
    public function nopriv( $handle, $callback ) {
        $this->action( "wp_ajax_nopriv_{$handle}", $callback );
    }
}