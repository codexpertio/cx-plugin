<?php
/**
 * All admin facing functions
 */
namespace codexpert\CX_Plugin;
use codexpert\product\Base;
use codexpert\product\Wizard;
use codexpert\product\Metabox;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Admin
 * @author codexpert <hello@codexpert.io>
 */
class Admin extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->server	= $this->plugin['server'];
		$this->version	= $this->plugin['Version'];
	}

	/**
	 * Internationalization
	 */
	public function i18n() {
		load_plugin_textdomain( 'cx-plugin', false, CXP_DIR . '/languages/' );
	}

	/**
	 * Adds a sample meta box
	 */
	public function add_meta_boxes() {
		$metabox = [
			'id'            => $this->slug,
			'label'         => $this->name,
			// 'post_type'  => 'post',
			// 'context'    => 'normal',
			// 'box_priority'	=> 'high',
			'sections'      => [
				'cx-plugin_basic'	=> [
					'id'        => 'cx-plugin_basic',
					'label'     => __( 'Basic Meta', 'cx-plugin' ),
					'icon'      => 'dashicons-admin-tools',
					'color'		=> '#4c3f93',
					'sticky'	=> true,
					'fields'    => [
						'sample_text' => [
							'id'        => 'sample_text',
							'label'     => __( 'Text Field', 'cx-plugin' ),
							'type'      => 'text',
							'desc'      => __( 'This is a text field.', 'cx-plugin' ),
							// 'class'     => '',
							'default'   => 'Hello World!',
							'readonly'  => false, // true|false
							'disabled'  => false, // true|false
						],
						'sample_number' => [
							'id'      => 'sample_number',
							'label'     => __( 'Number Field', 'cx-plugin' ),
							'type'      => 'number',
							'desc'      => __( 'This is a number field.', 'cx-plugin' ),
							// 'class'     => '',
							'default'   => 10,
							'readonly'  => false, // true|false
							'disabled'  => false, // true|false
						],
						'sample_email' => [
							'id'      => 'sample_email',
							'label'     => __( 'Email Field', 'cx-plugin' ),
							'type'      => 'email',
							'desc'      => __( 'This is an email field.', 'cx-plugin' ),
							// 'class'     => '',
							'default'   => 'john@doe.com',
							'readonly'  => false, // true|false
							'disabled'  => false, // true|false
						],
						'sample_url' => [
							'id'      => 'sample_url',
							'label'     => __( 'URL Field', 'cx-plugin' ),
							'type'      => 'url',
							'desc'      => __( 'This is a url field.', 'cx-plugin' ),
							// 'class'     => '',
							'default'   => 'https://johndoe.com',
							'readonly'  => false, // true|false
							'disabled'  => false, // true|false
						],
						'sample_password' => [
							'id'      => 'sample_password',
							'label'     => __( 'Password Field', 'cx-plugin' ),
							'type'      => 'password',
							'desc'      => __( 'This is a password field.', 'cx-plugin' ),
							// 'class'     => '',
							'readonly'  => false, // true|false
							'disabled'  => false, // true|false
							'default'   => 'uj34h'
						],
						'sample_textarea' => [
							'id'      => 'sample_textarea',
							'label'     => __( 'Textarea Field', 'cx-plugin' ),
							'type'      => 'textarea',
							'desc'      => __( 'This is a textarea field.', 'cx-plugin' ),
							// 'class'     => '',
							'columns'   => 24,
							'rows'      => 5,
							'default'   => 'lorem ipsum dolor sit amet',
							'readonly'  => false, // true|false
							'disabled'  => false, // true|false
						],
						'sample_radio' => [
							'id'      => 'sample_radio',
							'label'     => __( 'Radio Field', 'cx-plugin' ),
							'type'      => 'radio',
							'desc'      => __( 'This is a radio field.', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => [
								'item_1'  => 'Item One',
								'item_2'  => 'Item Two',
								'item_3'  => 'Item Three',
							],
							'default'   => 'item_2',
							'disabled'  => false, // true|false
						],
						'sample_select' => [
							'id'      => 'sample_select',
							'label'     => __( 'Select Field', 'cx-plugin' ),
							'type'      => 'select',
							'desc'      => __( 'This is a select field.', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   => 'option_2',
							'disabled'  => false, // true|false
							'multiple'  => false, // true|false
						],
						'sample_multiselect' => [
							'id'      => 'sample_multiselect',
							'label'     => __( 'Multi-select Field', 'cx-plugin' ),
							'type'      => 'select',
							'desc'      => __( 'This is a multiselect field.', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   => [ 'option_2', 'option_3' ],
							'disabled'  => false, // true|false
							'multiple'  => true, // true|false
						],
						'sample_multicheck' => [
							'id'      => 'sample_multicheck',
							'label'     => __( 'Multicheck Field', 'cx-plugin' ),
							'type'      => 'checkbox',
							'desc'      => __( 'This is a multicheck field.', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   => [ 'option_2' ],
							'disabled'  => false, // true|false
							'multiple'  => true, // true|false
						],
						'sample_checkbox' => [
							'id'      => 'sample_checkbox',
							'label'     => __( 'Checkbox Field', 'cx-plugin' ),
							'type'      => 'checkbox',
							'desc'      => __( 'This is a checkbox field.', 'cx-plugin' ),
							// 'class'     => '',
							'disabled'  => false, // true|false
							'default'   => 'on'
						],
						'sample_range' => [
							'id'      => 'sample_range',
							'label'     => __( 'Range Field', 'cx-plugin' ),
							'type'      => 'range',
							'desc'      => __( 'This is a range field.', 'cx-plugin' ),
							// 'class'     => '',
							'disabled'  => false, // true|false
							'min'		=> 0,
							'max'		=> 16,
							'step'		=> 2,
							'default'   => 4,
						],
						'sample_date' => [
							'id'      => 'sample_date',
							'label'     => __( 'Date Field', 'cx-plugin' ),
							'type'      => 'date',
							'desc'      => __( 'This is a date field.', 'cx-plugin' ),
							// 'class'     => '',
							'disabled'  => false, // true|false
							'default'   => '1971-12-16',
						],
						'sample_time' => [
							'id'      => 'sample_time',
							'label'     => __( 'Time Field', 'cx-plugin' ),
							'type'      => 'time',
							'desc'      => __( 'This is a time field.', 'cx-plugin' ),
							// 'class'     => '',
							'disabled'  => false, // true|false
							'default'   => '15:45',
						],
						'sample_color' => [
							'id'      => 'sample_color',
							'label'     => __( 'Color Field', 'cx-plugin' ),
							'type'      => 'color',
							'desc'      => __( 'This is a color field.', 'cx-plugin' ),
							// 'class'     => '',
							'default'   => '#f0f'
						],
						'sample_wysiwyg' => [
							'id'      => 'sample_wysiwyg',
							'label'     => __( 'WYSIWYG Field', 'cx-plugin' ),
							'type'      => 'wysiwyg',
							'desc'      => __( 'This is a wysiwyg field.', 'cx-plugin' ),
							// 'class'     => '',
							'width'     => '100%',
							'rows'      => 5,
							'teeny'     => true,
							'text_mode'     => false, // true|false
							'media_buttons' => false, // true|false
							'default'       => 'Hello World'
						],
						'sample_file' => [
							'id'      => 'sample_file',
							'label'     => __( 'File Field' ),
							'type'      => 'file',
							'upload_button'     => __( 'Choose File', 'cx-plugin' ),
							'select_button'     => __( 'Select File', 'cx-plugin' ),
							'desc'      => __( 'This is a file field.', 'cx-plugin' ),
							// 'class'     => '',
							'disabled'  => false, // true|false
							'default'   => 'http://example.com/sample/file.txt'
						],
					]
				],
				'cx-plugin_advanced'	=> [
					'id'        => 'cx-plugin_advanced',
					'label'     => __( 'Advanced Meta', 'cx-plugin' ),
					'icon'      => 'dashicons-admin-generic',
					'color'		=> '#d30c5c',
					'fields'    => [
						'sample_select3' => [
							'id'      => 'sample_select3',
							'label'     => __( 'Select with Chosen', 'cx-plugin' ),
							'type'      => 'select',
							'desc'      => __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   => 'option_2',
							'disabled'  => false, // true|false
							'multiple'  => false, // true|false
							'chosen'    => true
						],
						'sample_multiselect3' => [
							'id'      => 'sample_multiselect3',
							'label'     => __( 'Multi-select with Chosen', 'cx-plugin' ),
							'type'      => 'select',
							'desc'      => __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   => [ 'option_2', 'option_3' ],
							'disabled'  => false, // true|false
							'multiple'  => true, // true|false
							'chosen'    => true
						],
						'sample_select2' => [
							'id'      => 'sample_select2',
							'label'     => __( 'Select with Select2', 'cx-plugin' ),
							'type'      => 'select',
							'desc'      => __( 'jQuery Select2 plugin enabled. <a href="https://select2.org/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   => 'option_2',
							'disabled'  => false, // true|false
							'multiple'  => false, // true|false
							'select2'   => true
						],
						'sample_multiselect2' => [
							'id'      => 'sample_multiselect2',
							'label'     => __( 'Multi-select with Select2', 'cx-plugin' ),
							'type'      => 'select',
							'desc'      => __( 'jQuery Select2 plugin enabled. <a href="https://select2.org/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'default'   => [ 'option_2', 'option_3' ],
							'disabled'  => false, // true|false
							'multiple'  => true, // true|false
							'select2'   => true
						],
						'sample_group' => [
							'id'      => 'sample_group',
							'label'     => __( 'Field Group' ),
							'type'      => 'group',
							'desc'      => __( 'A group of fields.', 'cx-plugin' ),
							'items'     => [
								'sample_group_select1' => [
									'id'      => 'sample_group_select1',
									'label'     => __( 'First Item', 'cx-plugin' ),
									'type'      => 'select',
									'options'   => [
										'option_1'  => 'Option One',
										'option_2'  => 'Option Two',
										'option_3'  => 'Option Three',
									],
									'default'   => 'option_2',
								],
								'sample_group_select2' => [
									'id'      => 'sample_group_select2',
									'label'     => __( 'Second Item', 'cx-plugin' ),
									'type'      => 'select',
									'options'   => [
										'option_1'  => 'Option One',
										'option_2'  => 'Option Two',
										'option_3'  => 'Option Three',
									],
									'default'   => 'option_1',
								],
								'sample_group_select3' => [
									'id'      => 'sample_group_select3',
									'label'     => __( 'Third Item', 'cx-plugin' ),
									'type'      => 'select',
									'options'   => [
										'option_1'  => 'Option One',
										'option_2'  => 'Option Two',
										'option_3'  => 'Option Three',
									],
									'default'   => 'option_3',
								],
							],
						],
						'sample_conditional' => [
							'id'      => 'sample_conditional',
							'label'     => __( 'Conditional Field', 'cx-plugin' ),
							'type'      => 'select',
							'options'   => [
								'option_1'  => 'Option One',
								'option_2'  => 'Option Two',
								'option_3'  => 'Option Three',
							],
							'desc'      => __( 'Shows up if the third option in the  \'Field Group\' above is set as \'Option Two\'', 'cx-plugin' ),
							'default'   => 'option_2',
							'condition'	=> [
								'key'		=> 'sample_group_select3',
								'value'		=> 'option_2',
								'compare'	=> '==',
							]
						]
					]
				],
			]
		];

		new \codexpert\product\Metabox( $metabox );
	}
	
	/**
	 * Enqueue JavaScripts and stylesheets
	 */
	public function enqueue_scripts() {
		$min = defined( 'CXP_DEBUG' ) && CXP_DEBUG ? '' : '.min';
		
		wp_enqueue_style( $this->slug, plugins_url( "/assets/css/admin{$min}.css", CXP ), '', $this->version, 'all' );

		wp_enqueue_script( $this->slug, plugins_url( "/assets/js/admin{$min}.js", CXP ), [ 'jquery' ], $this->version, true );
	}

	public function admin_notices() {
		
		if( version_compare( get_bloginfo( 'version' ), $this->plugin['min_wp'], '<' ) ) {
			echo "
				<div class='notice cx-notice notice-error'>
					<p>" . sprintf( __( '<strong>%s</strong> requires <i>WordPress version %s</i> or higher. You have <i>version %s</i> installed.', 'cx-plugin' ), $this->name, $this->plugin['min_wp'], get_bloginfo( 'version' ) ) . "</p>
				</div>
			";
		}

		if( version_compare( PHP_VERSION, $this->plugin['min_php'], '<' ) ) {
			echo "
				<div class='notice cx-notice notice-error'>
					<p>" . sprintf( __( '<strong>%s</strong> requires <i>PHP version %s</i> or higher. You have <i>version %s</i> installed.', 'cx-plugin' ), $this->name, $this->plugin['min_php'], PHP_VERSION ) . "</p>
				</div>
			";
		}

		/**
		 * Dependencies
		 *
		 * @since 1.0
		 */
		$installed_plugins = get_plugins();
		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		if( isset( $this->plugin['depends'] ) && is_array( $this->plugin['depends'] ) ) :
		foreach ( $this->plugin['depends'] as $plugin => $name ) {
			if( !in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

				$action_links = cx_plugin_action_link( $plugin );
				$button_text = array_key_exists( $plugin, $installed_plugins ) ? __( 'activate', 'cx-plugin' ) : __( 'install', 'cx-plugin' );
				$action_link = array_key_exists( $plugin, $installed_plugins ) ? $action_links['activate'] : $action_links['install'];
			
				echo "
					<div class='notice cx-notice notice-error'>
						<p>" . sprintf( __( '<strong>%s</strong> needs to be activated. Please <a href="%s">%s</a> it now.', 'cx-plugin' ), $name, $action_link, $button_text ) . "</p>
					</div>
				";
			}
		}
		endif;

		/**
		 * Remote notices
		 */
		$url = "{$this->server}/wp-json/banners/latest?plugin={$this->slug}";
		$notices = json_decode( wp_remote_retrieve_body( wp_remote_get( $url ) ) );

		if( count( $notices ) > 0 ) :
		foreach ( $notices as $notice ) {
			echo "
			<div id='notice-{$this->slug}-{$notice->id}' class='notice cx-notice cx-plugin-notice is-dismissible' data-id='{$notice->id}'>
				<a href='{$notice->link}' target='_blank'><img src='{$notice->image}' /></a>
			</div>";
		}
		endif;
	}

	public function update_cache( $post_id, $post, $update ) {
		wp_cache_delete( "cx_plugin_{$post->post_type}", 'cx_plugin' );
	}

	public function footer_text( $text ) {
		if(get_current_screen()->parent_base != $this->slug ) return $text;

		return sprintf( __( 'If you like <strong>%1$s</strong>, please <a href="%2$s" target="_blank">leave us a %3$s rating</a> on WordPress.org! It\'d motivate and inspire us to make the plugin even better!', 'cx-plugin' ), $this->name, "https://wordpress.org/support/plugin/{$this->slug}/reviews/?filter=5#new-post", '⭐⭐⭐⭐⭐' );
	}
}