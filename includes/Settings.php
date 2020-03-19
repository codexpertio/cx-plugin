<?php
/**
 * All settings facing functions
 */

namespace codexpert\CX_Plugin;
use codexpert\Product\License;

/**
 * @package Plugin
 * @subpackage Settings
 * @author Nazmul Ahsan <n.mukto@gmail.com>
 */
class Settings extends Hooks {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->slug = $this->plugin['TextDomain'];
		$this->name = $this->plugin['Name'];
		$this->version = $this->plugin['Version'];

		$this->init_menu();
	}

	public function add_admin_bar( $admin_bar ) {
		if( is_admin() || current_user_can( 'manage_options' ) ) return;

		$admin_bar->add_menu( [
			'id'    => $this->slug,
			'title' => $this->name,
			'href'  => add_query_arg( 'page', $this->slug, admin_url( 'admin.php' ) ),
			'meta'  => [
				'title' => $this->name,            
			],
		] );
	}
	
	public function init_menu() {
		
		$settings = [
			'id'            => $this->slug,
			'label'         => $this->name,
			'title'         => $this->name,
			'header'        => $this->name,
			'priority'      => 10,
			// 'parent'     => 'woocommerce',
			'capability'    => 'manage_options',
			'icon'          => 'dashicons-wordpress', // dashicon or a URL to an image
			'position'      => 25,
			'sections'      => [
				'cx-plugin_basic'	=> [
					'id'        => 'cx-plugin_basic',
					'label'     => __( 'Basic Settings', 'cx-plugin' ),
					'icon'      => 'dashicons-admin-tools',
					'color'		=> '#4c3f93',
					'sticky'	=> true,
					'fields'    => [
						'sample_text' => [
							'id'        =>  'sample_text',
							'label'     =>  __( 'Text Field', 'cx-plugin' ),
							'type'      =>  'text',
							'desc'      =>  __( 'This is a text field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  'Hello World!',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						],
						'sample_number' => [
							'id'      =>  'sample_number',
							'label'     =>  __( 'Number Field', 'cx-plugin' ),
							'type'      =>  'number',
							'desc'      =>  __( 'This is a number field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  10,
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						],
						'sample_email' => [
							'id'      =>  'sample_email',
							'label'     =>  __( 'Email Field', 'cx-plugin' ),
							'type'      =>  'email',
							'desc'      =>  __( 'This is an email field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  'john@doe.com',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						],
						'sample_url' => [
							'id'      =>  'sample_url',
							'label'     =>  __( 'URL Field', 'cx-plugin' ),
							'type'      =>  'url',
							'desc'      =>  __( 'This is a url field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  'http://johndoe.com',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
						],
						'sample_password' => [
							'id'      =>  'sample_password',
							'label'     =>  __( 'Password Field', 'cx-plugin' ),
							'type'      =>  'password',
							'desc'      =>  __( 'This is a password field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'readonly'  =>  false, // true|false
							'disabled'  =>  false, // true|false
							'default'   => 'uj34h'
						],
						'sample_textarea' => [
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
						],
						'sample_radio' => [
							'id'      =>  'sample_radio',
							'label'     =>  __( 'Radio Field', 'cx-plugin' ),
							'type'      =>  'radio',
							'desc'      =>  __( 'This is a radio field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'options'   => [
								'item_1'  => 'Item One',
								'item_2'  => 'Item Two',
								'item_3'  => 'Item Three',
							],
							'default'   =>  'item_2',
							'disabled'  =>  false, // true|false
						],
						'sample_select' => [
							'id'      =>  'sample_select',
							'label'     =>  __( 'Select Field', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'This is a select field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   =>  'option_2',
							'disabled'  =>  false, // true|false
							'multiple'  =>  false, // true|false
						],
						'sample_multiselect' => [
							'id'      =>  'sample_multiselect',
							'label'     =>  __( 'Multi-select Field', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'This is a multiselect field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   =>  [ 'option_2', 'option_3' ],
							'disabled'  =>  false, // true|false
							'multiple'  =>  true, // true|false
						],
						'sample_multicheck' => [
							'id'      =>  'sample_multicheck',
							'label'     =>  __( 'Multicheck Field', 'cx-plugin' ),
							'type'      =>  'checkbox',
							'desc'      =>  __( 'This is a multicheck field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   =>  [ 'option_2' ],
							'disabled'  =>  false, // true|false
							'multiple'  =>  true, // true|false
						],
						'sample_checkbox' => [
							'id'      =>  'sample_checkbox',
							'label'     =>  __( 'Checkbox Field', 'cx-plugin' ),
							'type'      =>  'checkbox',
							'desc'      =>  __( 'This is a checkbox field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'disabled'  =>  false, // true|false
							'default'   => 'on'
						],
						'sample_color' => [
							'id'      =>  'sample_color',
							'label'     =>  __( 'Color Field', 'cx-plugin' ),
							'type'      =>  'color',
							'desc'      =>  __( 'This is a color field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'default'   =>  '#f0f'
						],
						'sample_wysiwyg' => [
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
						],
						'sample_file' => [
							'id'      =>  'sample_file',
							'label'     =>  __( 'File Field' ),
							'type'      =>  'file',
							'upload_button'     =>  __( 'Choose File', 'cx-plugin' ),
							'select_button'     =>  __( 'Select File', 'cx-plugin' ),
							'desc'      =>  __( 'This is a file field.', 'cx-plugin' ),
							// 'class'     =>  '',
							'disabled'  =>  false, // true|false
							'default'   =>  'http://example.com/sample/file.txt'
						],
					]
				],
				'cx-plugin_advanced'	=> [
					'id'        => 'cx-plugin_advanced',
					'label'     => __( 'Advanced Settings', 'cx-plugin' ),
					'icon'      => 'dashicons-admin-tools',
					'color'		=> '#d30c5c',
					'sticky'	=> true,
					'fields'    => [
						'sample_select2' => [
							'id'      =>  'sample_select2',
							'label'     =>  __( 'Select with Select2', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'jQuery Select2 plugin enabled. <a href="https://select2.org/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     =>  '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   =>  'option_2',
							'disabled'  =>  false, // true|false
							'multiple'  =>  false, // true|false
							'select2'   =>  true
						],
						'sample_multiselect2' => [
							'id'      =>  'sample_multiselect2',
							'label'     =>  __( 'Multi-select with Select2', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'jQuery Select2 plugin enabled. <a href="https://select2.org/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     =>  '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   =>  [ 'option_2', 'option_3' ],
							'disabled'  =>  false, // true|false
							'multiple'  =>  true, // true|false
							'select2'   =>  true
						],
						'sample_select3' => [
							'id'      =>  'sample_select3',
							'label'     =>  __( 'Select with Chosen', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     =>  '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   =>  'option_2',
							'disabled'  =>  false, // true|false
							'multiple'  =>  false, // true|false
							'chosen'    =>  true
						],
						'sample_multiselect3' => [
							'id'      =>  'sample_multiselect3',
							'label'     =>  __( 'Multi-select with Chosen', 'cx-plugin' ),
							'type'      =>  'select',
							'desc'      =>  __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     =>  '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   =>  [ 'option_2', 'option_3' ],
							'disabled'  =>  false, // true|false
							'multiple'  =>  true, // true|false
							'chosen'    =>  true
						],
						'sample_group' => [
							'id'      =>  'sample_group',
							'label'     =>  __( 'Field Group' ),
							'type'      =>  'group',
							'desc'      =>  __( 'A group of fields.', 'cx-plugin' ),
							'items'     => [
								'sample_group_select1' => [
									'id'      =>  'sample_group_select1',
									'label'     =>  __( 'First Item', 'cx-plugin' ),
									'type'      =>  'select',
									'options'   => [
										'option_1'  => 'Option One',
										'option_2'  => 'Option Two',
										'option_3'  => 'Option Three',
									],
									'default'   =>  'option_2',
								],
								'sample_group_select2' => [
									'id'      =>  'sample_group_select2',
									'label'     =>  __( 'Second Item', 'cx-plugin' ),
									'type'      =>  'select',
									'options'   => [
										'option_1'  => 'Option One',
										'option_2'  => 'Option Two',
										'option_3'  => 'Option Three',
									],
									'default'   =>  'option_1',
								],
								'sample_group_select3' => [
									'id'      =>  'sample_group_select3',
									'label'     =>  __( 'Third Item', 'cx-plugin' ),
									'type'      =>  'select',
									'options'   => [
										'option_1'  => 'Option One',
										'option_2'  => 'Option Two',
										'option_3'  => 'Option Three',
									],
									'default'   =>  'option_3',
								],
							],
						],
					]
				],
				'cx-plugin_help' => [
					'id'        => 'cx-plugin_help',
					'label'     => __( 'Help', 'cx-plugin' ),
					'icon'      => 'dashicons-sos',
					'color'		=> '#28c9ee',
					'hide_form'	=> true,
					'fields'    => [],
				],
				'cx-plugin_license' => [
					'id'        => 'cx-plugin_license',
					'label'     => __( 'License', 'cx-plugin' ),
					'icon'      => 'dashicons-admin-network',
					'color'		=> '#0b8a07',
					'hide_form'	=> true,
					'fields'    => [],
				],
			],
		];

		new \CX_Settings_API( $settings );
	}
	
	public function help_content( $section ) {
		if( 'cx-plugin_help' != $section['id'] ) return;

		_e( 'If you need further assistance, please contact us!', 'cx-plugin' );
	}
	
	public function license_form( $section ) {
		if( $section['id'] != 'cx-plugin_license' ) return;

		$license = new License( $this->plugin );
		echo $license->activator_form();
		
		printf( __( 'If you need further assistance, please <a href="%s" target="_blank">contact us</a>!', 'cx-plugin' ), 'https://codexpert.io' );
	}
}