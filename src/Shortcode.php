<?php
/**
 * All Shortcode related functions
 */
namespace codexpert\CX_Plugin;
use codexpert\product\Base;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage Shortcode
 * @author codexpert <hello@codexpert.io>
 */
class Shortcode extends Base {

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
    
    /**
     * Enqueue JavaScripts and stylesheets
     */
    public function enqueue_scripts() {
        $min = defined( 'CXP_DEBUG' ) && CXP_DEBUG ? '.min' : '';
        
        wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin{$min}.css", CXP ), '', $this->version, 'all' );

        wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin{$min}.js", CXP ), [ 'jquery' ], $this->version, true );
    }

    /**
     * Add some script to head
     */
    public function head() {}
}