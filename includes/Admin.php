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
 * @subpackage Admin
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Admin {

    /**
     * Constructor function
     */
    public function __construct( $name, $version ) {
        $this->name = $name;
        $this->version = $version;
    }
    
    /**
     * Enqueue JavaScripts and stylesheets
     */
    public function enqueue_scripts() {
        wp_enqueue_style( $this->name, plugins_url( '/assets/css/admin.css', CXP ), '', $this->version, 'all' );

        wp_enqueue_script( $this->name, plugins_url( '/assets/js/admin.js', CXP ), array( 'jquery' ), $this->version, true );
    }

    /**
     * Add some script to head
     */
    public function head() {

    }
}