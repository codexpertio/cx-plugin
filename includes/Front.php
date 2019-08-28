<?php
/**
 * All public facing functions
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
 * @subpackage Front
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Front extends Hooks {

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
        $min = defined( 'CXP_DEBUG' ) && CXP_DEBUG ? '.min' : '';

        wp_enqueue_style( $this->slug, plugins_url( "/assets/css/front{$min}.css", CXP ), '', $this->version, 'all' );

        wp_enqueue_script( $this->slug, plugins_url( "/assets/js/front{$min}.js", CXP ), array( 'jquery' ), $this->version, true );
    }

    /**
     * Add some script to head
     */
    public function head() {
        echo '
        <script>
            var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '";
        </script>';
    }
}