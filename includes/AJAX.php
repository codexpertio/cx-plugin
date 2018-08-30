<?php
/**
 * All AJAX facing functions
 */

namespace codexpert\MyPlugin;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @package Plugin
 * @subpackage AJAX
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class AJAX {

    /**
     * Constructor function
     */
    public function __construct( $name, $version ) {
        $this->name = $name;
        $this->version = $version;
    }

}