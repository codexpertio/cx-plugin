<?php
/**
 * All Wizard related functions
 */
namespace codexpert\CX_Plugin;
use codexpert\plugin\Base;
use codexpert\plugin\Setup;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package Plugin
 * @subpackage Wizard
 * @author Codexpert <hi@codexpert.io>
 */
class Wizard extends Base {

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

	public function action_links( $links ) {
		$this->admin_url = admin_url( 'admin.php' );

		$new_links = [
			'wizard'	=> sprintf( '<a href="%1$s">%2$s</a>', add_query_arg( [ 'page' => "{$this->slug}_setup" ], $this->admin_url ), __( 'Setup Wizard', 'cx-plugin' ) )
		];
		
		return array_merge( $new_links, $links );
	}

	public function render() {

		// force setup once
		if( get_option( "{$this->slug}_setup" ) != 1 ) {
			update_option( "{$this->slug}_setup", 1 );
			wp_safe_redirect( add_query_arg( [ 'page' => "{$this->slug}_setup" ], admin_url( 'admin.php' ) ) );
			exit;
		}

		$this->plugin['steps'] = [
			'one'	=> [
				'label'		=> __( 'One' ),
				'callback'	=> [ $this, 'callback_step_1' ],
				'action'	=> [ $this, 'save_one' ],
			],
			'two'	=> [
				'label'		=> __( 'Two' ),
				'callback'	=> [ $this, 'callback_step_2' ],
				'action'	=> [ $this, 'save_two' ],
			],
			'three'	=> [
				'label'		=> __( 'Three' ),
				'template'	=> CXP_DIR . '/views/setup-wizard/step-3.php',
				'action'	=> [ $this, 'save_three' ],
			],
			'four'	=> [
				'label'		=> __( 'Four' ),
				'content'	=> __( 'This is Step-4 of the setup wizard! Added as a string!', 'cx-plugin' ),
				'action'	=> [ $this, 'save_three' ],
				'redirect'	=> add_query_arg( [ 'page' => "{$this->slug}" ], admin_url( 'admin.php' ) )
			],
		];

		new Setup( $this->plugin );
	}

	public function callback_step_1() {
		_e( 'This is Step-1 of the setup wizard. Generated from a callback method!', 'cx-plugin' );
		?>
		<input type="date" name="date">
		<?php
	}

	public function callback_step_2() {
		_e( 'This is Step-2 of the setup wizard. Generated from a callback method!', 'cx-plugin' );
		?>
		<input type="time" name="time">
		<?php
	}

	public function save_one() {
		// save one to DB
		if( isset( $_POST['date'] ) ) {
			update_option( 'date', $_POST['date'] );
		}
	}

	public function save_two() {
		// save two to DB
		if( isset( $_POST['time'] ) ) {
			update_option( 'time', $_POST['time'] );
		}
	}

	public function save_three() {
		// save three to DB
	}

}