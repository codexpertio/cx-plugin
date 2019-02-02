<?php
/**
 * All settings facing functions
 */

namespace codexpert\CX_Plugin;

/**
 * @package Plugin
 * @subpackage Settings
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Settings {
    
    public function init() {
        
        $settings = array(
            'id'            => 'cx-settings',
            'label'         => __( 'CX Settings' ),
            'title'         => __( 'CX Settings API' ),
            'header'        => __( 'CX Settings API by codexpert' ),
            'priority'      => 60,
            // 'parent'     => 'woocommerce',
            'capability'    => 'manage_options',
            'icon'          => 'dashicons-wordpress', // dashicon or a URL to an image
            'position'      => 25,
            'sections'      => array(
                array(
                    'id'        => 'basic-settings',
                    'label'     => 'Basic Settings',
                    'icon'      => 'dashicons-admin-tools',
                    'fields'    => array(
                        array(
                            'id'        =>  'sample_text',
                            'label'     =>  __( 'Text Field' ),
                            'type'      =>  'text',
                            'desc'      =>  __( 'This is a text field.' ),
                            // 'class'     =>  '',
                            'default'   =>  'Hello World!',
                            'readonly'  =>  false, // true|false
                            'disabled'  =>  false, // true|false
                        ),
                        array(
                            'id'      =>  'sample_number',
                            'label'     =>  __( 'Number Field' ),
                            'type'      =>  'number',
                            'desc'      =>  __( 'This is a number field.' ),
                            // 'class'     =>  '',
                            'default'   =>  10,
                            'readonly'  =>  false, // true|false
                            'disabled'  =>  false, // true|false
                        ),
                        array(
                            'id'      =>  'sample_email',
                            'label'     =>  __( 'Email Field' ),
                            'type'      =>  'email',
                            'desc'      =>  __( 'This is an email field.' ),
                            // 'class'     =>  '',
                            'default'   =>  'john@doe.com',
                            'readonly'  =>  false, // true|false
                            'disabled'  =>  false, // true|false
                        ),
                        array(
                            'id'      =>  'sample_url',
                            'label'     =>  __( 'URL Field' ),
                            'type'      =>  'url',
                            'desc'      =>  __( 'This is a url field.' ),
                            // 'class'     =>  '',
                            'default'   =>  'http://johndoe.com',
                            'readonly'  =>  false, // true|false
                            'disabled'  =>  false, // true|false
                        ),
                        array(
                            'id'      =>  'sample_password',
                            'label'     =>  __( 'Password Field' ),
                            'type'      =>  'password',
                            'desc'      =>  __( 'This is a password field.' ),
                            // 'class'     =>  '',
                            'readonly'  =>  false, // true|false
                            'disabled'  =>  false, // true|false
                            'default'   => 'uj34h'
                        ),
                        array(
                            'id'      =>  'sample_textarea',
                            'label'     =>  __( 'Textarea Field' ),
                            'type'      =>  'textarea',
                            'desc'      =>  __( 'This is a textarea field.' ),
                            // 'class'     =>  '',
                            'columns'   =>  24,
                            'rows'      =>  5,
                            'default'   =>  'lorem ipsum dolor sit amet',
                            'readonly'  =>  false, // true|false
                            'disabled'  =>  false, // true|false
                        ),
                        array(
                            'id'      =>  'sample_radio',
                            'label'     =>  __( 'Radio Field' ),
                            'type'      =>  'radio',
                            'desc'      =>  __( 'This is a radio field.' ),
                            // 'class'     =>  '',
                            'options'   => array(
                                'item_1'  => 'Item One',
                                'item_2'  => 'Item Two',
                                'item_3'  => 'Item Three',
                                ),
                            'default'   =>  'item_2',
                            'disabled'  =>  false, // true|false
                        ),
                        array(
                            'id'      =>  'sample_select',
                            'label'     =>  __( 'Select Field' ),
                            'type'      =>  'select',
                            'desc'      =>  __( 'This is a select field.' ),
                            // 'class'     =>  '',
                            'options'   => array(
                                'option_1'  => 'Option One',
                                'option_2'  => 'Option Two',
                                'option_3'  => 'Option Three',
                                ),
                            'default'   =>  'option_2',
                            'disabled'  =>  false, // true|false
                            'multiple'  =>  false, // true|false
                        ),
                        array(
                            'id'      =>  'sample_multiselect',
                            'label'     =>  __( 'Multi-select Field' ),
                            'type'      =>  'select',
                            'desc'      =>  __( 'This is a multiselect field.' ),
                            // 'class'     =>  '',
                            'options'   => array(
                                'option_1'  => 'Option One',
                                'option_2'  => 'Option Two',
                                'option_3'  => 'Option Three',
                                ),
                            'default'   =>  array( 'option_2', 'option_3' ),
                            'disabled'  =>  false, // true|false
                            'multiple'  =>  true, // true|false
                        ),
                        array(
                            'id'      =>  'sample_multicheck',
                            'label'     =>  __( 'Multicheck Field' ),
                            'type'      =>  'checkbox',
                            'desc'      =>  __( 'This is a multicheck field.' ),
                            // 'class'     =>  '',
                            'options'   => array(
                                'option_1'  => 'Option One',
                                'option_2'  => 'Option Two',
                                'option_3'  => 'Option Three',
                                ),
                            'default'   =>  array( 'option_2' ),
                            'disabled'  =>  false, // true|false
                            'multiple'  =>  true, // true|false
                        ),
                        array(
                            'id'      =>  'sample_checkbox',
                            'label'     =>  __( 'Checkbox Field' ),
                            'type'      =>  'checkbox',
                            'desc'      =>  __( 'This is a checkbox field.' ),
                            // 'class'     =>  '',
                            'disabled'  =>  false, // true|false
                            'default'   => 'on'
                        ),
                        array(
                            'id'      =>  'sample_color',
                            'label'     =>  __( 'Color Field' ),
                            'type'      =>  'color',
                            'desc'      =>  __( 'This is a color field.' ),
                            // 'class'     =>  '',
                            'default'   =>  '#f0f'
                        ),
                        array(
                            'id'      =>  'sample_wysiwyg',
                            'label'     =>  __( 'WYSIWYG Field' ),
                            'type'      =>  'wysiwyg',
                            'desc'      =>  __( 'This is a wysiwyg field.' ),
                            // 'class'     =>  '',
                            'width'     =>  '100%',
                            'rows'      =>  5,
                            'teeny'     =>  true,
                            'text_mode'     =>  false, // true|false
                            'media_buttons' =>  false, // true|false
                            'default'       =>  'Hello World'
                        ),
                        array(
                            'id'      =>  'sample_fise',
                            'label'     =>  __( 'File Field' ),
                            'type'      =>  'file',
                            'upload_button'     =>  __( 'Choose File' ),
                            'select_button'     =>  __( 'Select File' ),
                            'desc'      =>  __( 'This is a file field.' ),
                            // 'class'     =>  '',
                            'disabled'  =>  false, // true|false
                            'default'   =>  'http://example.com/sample/file.txt'
                        )
                    )
                ),
                array(
                    'id'        => 'other-settings',
                    'label'     => 'Other Settings',
                    'icon'      => 'dashicons-admin-settings',
                    'fields'    => array(
                        array(
                            'id'      =>  'sample_select2',
                            'label'     =>  __( 'Select with Select2' ),
                            'type'      =>  'select',
                            'desc'      =>  __( 'jQuery Select2 plugin enabled. <a href="https://select2.org/" target="_blank">[See more]</a>' ),
                            // 'class'     =>  '',
                            'options'   => array(
                                'option_1'  => 'Option One',
                                'option_2'  => 'Option Two',
                                'option_3'  => 'Option Three',
                                ),
                            'default'   =>  'option_2',
                            'disabled'  =>  false, // true|false
                            'multiple'  =>  false, // true|false
                            'select2'   =>  true
                        ),
                        array(
                            'id'      =>  'sample_multiselect2',
                            'label'     =>  __( 'Multi-select with Select2' ),
                            'type'      =>  'select',
                            'desc'      =>  __( 'jQuery Select2 plugin enabled. <a href="https://select2.org/" target="_blank">[See more]</a>' ),
                            // 'class'     =>  '',
                            'options'   => array(
                                'option_1'  => 'Option One',
                                'option_2'  => 'Option Two',
                                'option_3'  => 'Option Three',
                                ),
                            'default'   =>  array( 'option_2', 'option_3' ),
                            'disabled'  =>  false, // true|false
                            'multiple'  =>  true, // true|false
                            'select2'   =>  true
                        ),
                        array(
                            'id'      =>  'sample_select3',
                            'label'     =>  __( 'Select with Chosen' ),
                            'type'      =>  'select',
                            'desc'      =>  __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>' ),
                            // 'class'     =>  '',
                            'options'   => array(
                                'option_1'  => 'Option One',
                                'option_2'  => 'Option Two',
                                'option_3'  => 'Option Three',
                                ),
                            'default'   =>  'option_2',
                            'disabled'  =>  false, // true|false
                            'multiple'  =>  false, // true|false
                            'chosen'    =>  true
                        ),
                        array(
                            'id'      =>  'sample_multiselect3',
                            'label'     =>  __( 'Multi-select with Chosen' ),
                            'type'      =>  'select',
                            'desc'      =>  __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>' ),
                            // 'class'     =>  '',
                            'options'   => array(
                                'option_1'  => 'Option One',
                                'option_2'  => 'Option Two',
                                'option_3'  => 'Option Three',
                                ),
                            'default'   =>  array( 'option_2', 'option_3' ),
                            'disabled'  =>  false, // true|false
                            'multiple'  =>  true, // true|false
                            'chosen'    =>  true
                        ),
                    )
                ),
            ),
        );

        new \CX_Settings_API( $settings );
    }
}