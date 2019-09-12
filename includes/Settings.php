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
class Settings extends Hooks {

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->slug = $plugin['TextDomain'];
		$this->name = $plugin['Name'];
		$this->version = $plugin['Version'];
	}
	
	public function init() {
		
		$settings = array(
			'id'            => $this->slug,
			'label'         => $this->name,
			'title'         => $this->name,
			'header'        => $this->name,
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
							'label'     =>  __( 'Text Field', 'cx-plugin' ),
							'type'      =>  'text',
							'desc'      =>  __( 'This is a text field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  'Hello World!',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						),
						array(
							'id'      =>  'sample_number',
							'label'     =>  __( 'Number Field', 'cx-plugin' ),
							'type'      =>  'number',
							'desc'      =>  __( 'This is a number field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  10,
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						),
						array(
							'id'      =>  'sample_email',
							'label'     =>  __( 'Email Field', 'cx-plugin' ),
							'type'      =>  'email',
							'desc'      =>  __( 'This is an email field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  'john@doe.com',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						),
						array(
							'id'      =>  'sample_url',
							'label'     =>  __( 'URL Field', 'cx-plugin' ),
							'type'      =>  'url',
							'desc'      =>  __( 'This is a url field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  'http://johndoe.com',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						),
						array(
							'id'      =>  'sample_password',
							'label'     =>  __( 'Password Field', 'cx-plugin' ),
							'type'      =>  'password',
							'desc'      =>  __( 'This is a password field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
							'default'   => 'uj34h'
						),
						array(
							'id'      =>  'sample_textarea',
							'label'     =>  __( 'Textarea Field', 'cx-plugin' ),
							'type'      =>  'textarea',
							'desc'      =>  __( 'This is a textarea field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'columns'   =>  24,
							'rows'      =>  5,
							'default'   =>  'lorem ipsum dolor sit amet',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						),
						array(
							'id'      =>  'sample_radio',
							'label'     =>  __( 'Radio Field', 'cx-plugin' ),
							'type'      =>  'radio',
							'desc'      =>  __( 'This is a radio field.', 'cx-plugin' ),
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
							'label'     =>  __( 'Select Field', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'This is a select field.', 'cx-plugin' ),
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
							'label'     =>  __( 'Multi-select Field', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'This is a multiselect field.', 'cx-plugin' ),
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
							'label'     =>  __( 'Multicheck Field', 'cx-plugin' ),
							'type'      =>  'checkbox',
							'desc'      =>  __( 'This is a multicheck field.', 'cx-plugin' ),
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
							'label'     =>  __( 'Checkbox Field', 'cx-plugin' ),
							'type'      =>  'checkbox',
							'desc'      =>  __( 'This is a checkbox field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'disabled'  =>  false, // true|false
							'default'   => 'on'
						),
						array(
							'id'      =>  'sample_color',
							'label'     =>  __( 'Color Field', 'cx-plugin' ),
							'type'      =>  'color',
							'desc'      =>  __( 'This is a color field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  '#f0f'
						),
						array(
							'id'      =>  'sample_wysiwyg',
							'label'     =>  __( 'WYSIWYG Field', 'cx-plugin' ),
							'type'      =>  'wysiwyg',
							'desc'      =>  __( 'This is a wysiwyg field.', 'cx-plugin' ),
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
							'upload_button'     =>  __( 'Choose File', 'cx-plugin' ),
							'select_button'     =>  __( 'Select File', 'cx-plugin' ),
							'desc'      =>  __( 'This is a file field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'disabled'  =>  false, // true|false
							'default'   =>  'http://example.com/sample/file.txt'
						),
						array(
							'id'      =>  'sample_select2',
							'label'     =>  __( 'Select with Select2', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'jQuery Select2 plugin enabled. <a href="https://select2.org/" target="_blank">[See more]</a>', 'cx-plugin' ),
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
							'label'     =>  __( 'Multi-select with Select2', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'jQuery Select2 plugin enabled. <a href="https://select2.org/" target="_blank">[See more]</a>', 'cx-plugin' ),
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
							'label'     =>  __( 'Select with Chosen', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>', 'cx-plugin' ),
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
							'label'     =>  __( 'Multi-select with Chosen', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>', 'cx-plugin' ),
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
				array(
					'id'        => 'cx-plugin_help',
					'label'     => __( 'Help', 'cx-plugin' ),
					'icon'      => 'dashicons-sos',
					'hide_form'	=> true,
					'fields'    => array(),
				),
				array(
					'id'        => 'cx-plugin_license',
					'label'     => __( 'License', 'cx-plugin' ),
					'icon'      => 'dashicons-admin-network',
					'hide_form'	=> true,
					'fields'    => array(),
				),
			),
		);

		new \CX_Settings_API( $settings );
	}

	public function help_content( $section ) {
		if( 'cx-plugin_help' != $section['id'] ) return;

		echo "If you need further assistance, please contac us!";
	}
}