<?php
/**
 * All settings related functions
 */
namespace codexpert\CX_Plugin;
use codexpert\plugin\Base;
use codexpert\plugin\Table;

/**
 * @package Plugin
 * @subpackage Settings
 * @author codexpert <hello@codexpert.io>
 */
class Settings extends Base {

	public $plugin;

	/**
	 * Constructor function
	 */
	public function __construct( $plugin ) {
		$this->plugin	= $plugin;
		$this->slug		= $this->plugin['TextDomain'];
		$this->name		= $this->plugin['Name'];
		$this->version	= $this->plugin['Version'];
	}
	
	public function init_menu() {
		
		$settings = [
			'id'            => $this->slug,
			'label'         => $this->name,
			'title'         => $this->name,
			'header'        => $this->name,
			// 'parent'     => 'woocommerce',
			// 'priority'   => 10,
			// 'capability' => 'manage_options',
			// 'icon'       => 'dashicons-wordpress',
			// 'position'   => 25,
			'sections'      => [
				'cx-plugin_basic'	=> [
					'id'        => 'cx-plugin_basic',
					'label'     => __( 'Basic Settings', 'cx-plugin' ),
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
					'label'     => __( 'Advanced Settings', 'cx-plugin' ),
					'icon'      => 'dashicons-admin-generic',
					'color'		=> '#d30c5c',
					'fields'    => [
						'sample_select3' => [
							'id'      => 'sample_select3',
							'label'     => __( 'Select with Chosen', 'cx-plugin' ),
							'type'      => 'select',
							'desc'      => __( 'jQuery Chosen plugin enabled. <a href="https://harvesthq.github.io/chosen/" target="_blank">[See more]</a>', 'cx-plugin' ),
							// 'class'     => '',
							'options'   => cx_plugin_get_posts( 'page', false, true ),
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
						],
						'sample_tabs' => [
							'id'      => 'sample_tabs',
							'label'     => __( 'Sample Tabs' ),
							'type'      => 'tabs',
							'tabs'     => [
								'sample_tab1' => [
									'id'      => 'sample_tab1',
									'label'     => __( 'First Tab', 'cx-plugin' ),
									'fields'    => [
										'sample_tab1_email' => [
											'id'      => 'sample_tab1_email',
											'label'     => __( 'Tab Email Field', 'cx-plugin' ),
											'type'      => 'email',
											'desc'      => __( 'This is an email field.', 'cx-plugin' ),
											// 'class'     => '',
											'default'   => 'john@doe.com',
											'readonly'  => false, // true|false
											'disabled'  => false, // true|false
										],
										'sample_tab1_url' => [
											'id'      => 'sample_tab1_url',
											'label'     => __( 'Tab URL Field', 'cx-plugin' ),
											'type'      => 'url',
											'desc'      => __( 'This is a url field.', 'cx-plugin' ),
											// 'class'     => '',
											'default'   => 'https://johndoe.com',
											'readonly'  => false, // true|false
											'disabled'  => false, // true|false
										],
									],
								],
								'sample_tab2' => [
									'id'      => 'sample_tab2',
									'label'     => __( 'Second Tab', 'cx-plugin' ),
									'fields'    => [
										'sample_tab2_text' => [
											'id'        => 'sample_tab2_text',
											'label'     => __( 'Tab Text Field', 'cx-plugin' ),
											'type'      => 'text',
											'desc'      => __( 'This is a text field.', 'cx-plugin' ),
											// 'class'     => '',
											'default'   => 'Hello World!',
											'readonly'  => false, // true|false
											'disabled'  => false, // true|false
										],
										'sample_tab2_number' => [
											'id'      => 'sample_tab2_number',
											'label'     => __( 'Tab Number Field', 'cx-plugin' ),
											'type'      => 'number',
											'desc'      => __( 'This is a number field.', 'cx-plugin' ),
											// 'class'     => '',
											'default'   => 10,
											'readonly'  => false, // true|false
											'disabled'  => false, // true|false
										],
									],
								],
							],
						],
					]
				],
				'cx-plugin_table' => [
					'id'        => 'cx-plugin_table',
					'label'     => __( 'Table', 'cx-plugin' ),
					'icon'      => 'dashicons-editor-table',
					'color'		=> '#28c9ee',
					'hide_form'	=> true,
					'fields'    => [],
				],
				'cx-plugin_help' => [
					'id'        => 'cx-plugin_help',
					'label'     => __( 'Help', 'cx-plugin' ),
					'icon'      => 'dashicons-sos',
					'color'		=> '#0b8a07',
					'hide_form'	=> true,
					'fields'    => [],
				],
				'cx-plugin_license' => [
					'id'        => 'cx-plugin_license',
					'label'     => __( 'License', 'cx-plugin' ),
					'icon'      => 'dashicons-admin-network',
					'color'		=> '#e828ee',
					'hide_form'	=> true,
					'fields'    => [],
				],
			],
		];

		new \codexpert\plugin\Settings( $settings );
	}
	
	public function tab_content( $section ) {
		if( 'cx-plugin_help' == $section['id'] ) {

			$args = [
				'cx_plugin_faq' 	=> __( 'FAQ', 'cx-plugin' ),
				'cx_plugin_video' 	=> __( 'Video Tutorial', 'cx-plugin' ),
				'cx_plugin_support' => __( 'Ask Support', 'cx-plugin' ),
			];
			$tab_links = apply_filters( 'cx_plugin_help_tab_link', $args );

			echo "<div class='cx_plugin_tab_btns'>";
			echo "<ul class='cx_plugin_help_tablinks'>";

			$count 	= 0;
			foreach ( $tab_links as $id => $tab_link ) {
				$active = $count == 0 ? 'active' : '';
				echo "<li class='cx_plugin_help_tablink {$active}' id='{$id}'>{$tab_link}</li>";
				$count++;
			}

			echo "</ul>";
			echo "</div>";
			?>

			<div id="cx_plugin_faq_content" class="cx_plugin_tabcontent active">
				 <div class='wrap'>
				 	<div id='cx-plugin-helps'>
				    <?php

				    $helps = get_option( 'cx-plugin-docs-json', [] );
					$utm = [ 'utm_source' => 'dashboard', 'utm_medium' => 'settings', 'utm_campaign' => 'faq' ];
				    if( is_array( $helps ) ) :
				    foreach ( $helps as $help ) {
				    	$help_link = add_query_arg( $utm, $help['link'] );
				        ?>
				        <div id='cx-plugin-help-<?php echo $help['id']; ?>' class='cx-plugin-help'>
				            <h2 class='cx-plugin-help-heading' data-target='#cx-plugin-help-text-<?php echo $help['id']; ?>'>
				                <a href='<?php echo $help_link; ?>' target='_blank'>
				                <span class='dashicons dashicons-admin-links'></span></a>
				                <span class="heading-text"><?php echo $help['title']['rendered']; ?></span>
				            </h2>
				            <div id='cx-plugin-help-text-<?php echo $help['id']; ?>' class='cx-plugin-help-text' style='display:none'>
				                <?php echo wpautop( wp_trim_words( $help['content']['rendered'], 55, " <a class='sc-more' href='{$help_link}' target='_blank'>[more..]</a>" ) ); ?>
				            </div>
				        </div>
				        <?php

				    }
				    else:
				        _e( 'Something is wrong! No help found!', 'cx-plugin' );
				    endif;
				    ?>
				    </div>
				    <?php printf( __( '<p>If you need further assistance, please <a href="%s" target="_blank">reach out to us!</a></p>', 'cx-plugin' ), add_query_arg( $utm, 'https://codexpert.io/hire/' ) ); ?>
				</div>
			</div>

			<div id="cx_plugin_video_content" class="cx_plugin_tabcontent">
				<iframe width="900" height="525" src="https://www.youtube.com/embed/videoseries?list=PLljE6A-xP4wKNreIV76Tl6uQUw-40XQsZ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>

			<div id="cx_plugin_support_content" class="cx_plugin_tabcontent">
				<p><?php _e( 'Having an issue or got something to say? Feel free to reach out to us! Our award winning support team is always ready to help you.', 'shop-catalog' ); ?></p>
				<div id="support_btn_div">
					<a href="https://help.codexpert.io" class="button" id="support_btn" target="_blank"><?php _e( 'Submit a Ticket', 'shop-catalog' ); ?></a>
				</div>
			</div>
			<?php
		}

		elseif( 'cx-plugin_table' == $section['id'] ) {
			$config = [
				'per_page'		=> 5,
				'columns'		=> [
					'id'			=> __( 'Order #', 'cx-plugin' ),
					'products'			=> __( 'Products', 'cx-plugin' ),
					'order_total'		=> __( 'Order Total', 'cx-plugin' ),
					'commission'		=> __( 'Commission', 'cx-plugin' ),
					'payment_status'	=> __( 'Payment Status', 'cx-plugin' ),
					'time'				=> __( 'Time', 'cx-plugin' ),
				],
				'sortable'		=> [ 'visit', 'id', 'products', 'commission', 'payment_status', 'time' ],
				'orderby'		=> 'time',
				'order'			=> 'desc',
				'data'			=> [
					[ 'id' => 345, 'products' => 'Abc', 'order_total' => '$678', 'commission' => '$98', 'payment_status' => 'Unpaid', 'time' => '2020-06-29' ],
					[ 'id' => 567, 'products' => 'Xyz', 'order_total' => '$178', 'commission' => '$18', 'payment_status' => 'Paid', 'time' => '2020-05-26' ],
					[ 'id' => 451, 'products' => 'Mno', 'order_total' => '$124', 'commission' => '$12', 'payment_status' => 'Paid', 'time' => '2020-07-01' ],
					[ 'id' => 588, 'products' => 'Uji', 'order_total' => '$523', 'commission' => '$22', 'payment_status' => 'Pending', 'time' => '2020-07-02' ],
					[ 'id' => 426, 'products' => 'Rim', 'order_total' => '$889', 'commission' => '$33', 'payment_status' => 'Paid', 'time' => '2020-08-01' ],
					[ 'id' => 109, 'products' => 'Rio', 'order_total' => '$211', 'commission' => '$11', 'payment_status' => 'Unpaid', 'time' => '2020-08-12' ],
				],
				'bulk_actions'	=> [
					'delete'	=> __( 'Delete', 'cx-plugin' ),
					'draft'		=> __( 'Draft', 'cx-plugin' ),
				],
			];

			$table = new Table( $config );
			echo '<form method="post">';
			$table->prepare_items();
			$table->search_box( 'Search', 'search' );
			$table->display();
			echo '</form>';
		}

		elseif( 'cx-plugin_license' == $section['id'] ) {
			echo $this->plugin['license']->activator_form();
		}
	}
}