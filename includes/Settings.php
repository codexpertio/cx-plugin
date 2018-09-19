<?php
/**
 * All settings facing functions
 */

namespace codexpert\CX_Plugin;

use \WeDevs_Settings_API;

/**
 * @package Plugin
 * @subpackage Settings
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Settings {

    private $settings_api;

    public function __construct( $name, $version ) {
        $this->name = $name;
        $this->version = $version;
        $this->file = $file;
        $this->settings_url = admin_url( "admin.php?page={$this->name}" );
        $this->settings_api = new WeDevs_Settings_API;
    }

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function admin_menu() {
        add_menu_page( __( 'CX_Plugin', 'cx-plugin' ), __( 'CX_Plugin', 'cx-plugin' ), 'manage_options', $this->name, array( $this, 'settings_page' ), 'dashicons-share', 43 );
    }

    public function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'cx-plugin_basics',
                'title' => __( 'Basic Settings', 'cx-plugin' )
            ),
            array(
                'id'    => 'cx-plugin_license',
                'title' => __( 'License', 'cx-plugin' )
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    public function get_settings_fields() {
        $settings_fields = array(
            'cx-plugin_basics' => array(
                array(
                    'name'              => 'sample_text',
                    'label'             => __( 'Sample Text', 'cx-plugin' ),
                    'desc'              => __( 'Sample text field', 'cx-plugin' ),
                    'placeholder'       => __( 'Input text', 'cx-plugin' )
                ),
            )
        );

        return $settings_fields;
    }

    public function settings_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    public function link( $links ) {
        $links[] = "<a href='{$this->settings_url}'>Settings</a>";

        return $links;
    }

}