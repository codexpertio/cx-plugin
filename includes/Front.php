<?php
/**
 * All public facing functions
 */

namespace codexpert\CXPlugin;

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
class Front {

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
        wp_enqueue_style( $this->name, plugins_url( '/assets/css/front.css', CXP ), '', $this->version, 'all' );

        wp_enqueue_script( $this->name, plugins_url( '/assets/js/front.js', CXP ), array( 'jquery' ), $this->version, true );
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