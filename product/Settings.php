<?php
namespace codexpert\product;

/**
 * if accessed directly, exit.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Settings extends Base {
	
	public function __construct( $args = array() ) {
		$this->config = apply_filters( 'cx-settings-args', $args );
		$this->sections = apply_filters( 'cx-settings-sections', $this->config['sections'] );
		
		self::hooks();
	}

	public function hooks() {
		$this->action( 'admin_head', 'callback_head', 99 );
		$this->action( 'admin_enqueue_scripts', 'callback_enqueue_scripts', 99 );
		$this->action( 'admin_menu', 'callback_admin_menu', $this->config['priority'] );
		$this->action( 'wp_ajax_cx-settings', 'callback_save_settings' );
		$this->action( 'wp_ajax_cx-reset', 'callback_reset_settings' );
	}

	public function callback_head() {
		if( strpos( get_current_screen()->id, $this->config['id'] ) == false ) return;
		
		?>
		<script>
			jQuery(function($){$('.cx-color-picker').wpColorPicker();if($('.cx-select2').length>0)$('.cx-select2').select2({width:'100%'});if($('.cx-chosen').length>0)$('.cx-chosen').chosen({width:'100%'});if(localStorage.getItem('active_cx_tab')=='undefined'||localStorage.getItem('active_cx_tab')==null||$(localStorage.getItem('active_cx_tab')).length<=0){localStorage.setItem('active_cx_tab',$('.cx-nav-tab:first-child a').attr('href'))};if(typeof(localStorage)!='undefined'){active_cx_tab=localStorage.getItem('active_cx_tab')};if(window.location.hash){active_cx_tab=window.location.hash;if(typeof(localStorage)!='undefined'){localStorage.setItem('active_cx_tab',active_cx_tab)}};$('.cx-section').hide();$('.cx-nav-tab').removeClass('cx-active-tab');$('[href="'+localStorage.getItem('active_cx_tab')+'"]').parent().addClass('cx-active-tab');$(localStorage.getItem('active_cx_tab')).show();$('.cx-nav-tab').click(function(e){e.preventDefault();$('.cx-section').hide();$('.cx-nav-tab').css('background','inherit').removeClass('cx-active-tab');$(this).addClass('cx-active-tab').css('background',$(this).data('color'));$('.cx-nav-tab a').removeClass('cx-active-tab');$('.cx-nav-tab a').each(function(e){$(this).css('color',$(this).parent().data('color'))});$('a',this).css('color','#fff');var target=$('a',this).attr('href');$(target).show();localStorage.setItem('active_cx_tab',target)});$('.cx-form').submit(function(e){e.preventDefault();if(typeof tinyMCE!='undefined')tinyMCE.triggerSave();var $form=$(this);var $submit=$('.cx-submit',$form);$submit.attr('disabled',!0);$('.cx-message',$form).hide();$.ajax({url:ajaxurl,data:$form.serialize(),type:'POST',dataType:'JSON',success:function(ret){if(ret.status==1||ret.status==0)$('.cx-message',$form).text(ret.message).show().fadeOut(3000);$submit.attr('disabled',!1);if(ret.page_load==1)setTimeout(function(){window.location.href=""},1000)},erorr:function(ret){$submit.attr('disabled',!1)}})});$('.cx-reset-button').click(function(e){var $this=$(this);var $option_name=$this.data('option_name');var $_nonce=$this.data('_nonce');$this.attr('disabled',!0);$('#cx-message-'+$option_name).hide();$.ajax({url:ajaxurl,data:{action:'cx-reset',option_name:$option_name,_wpnonce:$_nonce},type:'POST',dataType:'JSON',success:function(ret){$('#cx-message-'+$option_name).text(ret.message).show();setTimeout(function(){window.location.href=''},1000)},erorr:function(ret){$this.attr('disabled',!1)}})});$('.cx-browse').on('click',function(event){event.preventDefault();var self=$(this);var file_frame=wp.media.frames.file_frame=wp.media({title:self.data('title'),button:{text:self.data('select-text'),},multiple:!1});file_frame.on('select',function(){attachment=file_frame.state().get('selection').first().toJSON();$('.cx-file').val(attachment.url);$('.supports-drag-drop').hide()});file_frame.open()});$('#cx-submit-top').click(function(e){$('.cx-message').hide();$('.cx-form:visible').submit()});$('#cx-reset-top').click(function(e){$('.cx-form:visible .cx-reset-button').click()});$('a[href="'+localStorage.active_cx_tab+'"]').click()})
			jQuery(function($){<?php
				foreach ( $this->sections as $section_id => $section ) {
					foreach ( $section['fields'] as $field ) {
						if( isset( $field['condition'] ) && is_array( $field['condition'] ) ) {
							$key = $field['condition']['key'];
							$value = isset( $field['condition']['value'] ) ? $field['condition']['value'] : 'on';
							$compare = isset( $field['condition']['compare'] ) ? $field['condition']['compare'] : '==';

							if( 'checked' != $compare ) {
								echo "$('#{$section['id']}-{$key}').change(function(e){if( $('#{$section['id']}-{$key}').val() {$compare} '{$value}' ) { $('#cxrow-{$section['id']}-{$field['id']}').show();}else { $('#cxrow-{$section['id']}-{$field['id']}').hide();}}).change();";
							}
							else {
								echo "$('#{$section['id']}-{$key}').change(function(e){if( $('#{$section['id']}-{$key}').is(':checked') ) { $('#cxrow-{$section['id']}-{$field['id']}').show();}else { $('#cxrow-{$section['id']}-{$field['id']}').hide();}}).change();";
							}
						}
					}
				}
				?>
			})
		</script>
		<style>
			.cx-wrapper{background:rgba(0,0,0,0);border:none;box-sizing:border-box;font-family:inherit;font-size:13px;max-width:100%;min-width:100%;padding:0;position:relative;width:100%;display:inline-block}.cx-navs-wrapper{width:12%;z-index:2;position:relative;float:left;background:0 0;border-right:0;margin-top:18px;padding:0;border-radius:0;line-height:inherit}.cx-navs-wrapper ul,.cx-navs-wrapper ul li{margin:0!important;padding:0!important}.cx-navs-wrapper ul li{background:0 0;white-space:normal;list-style:none;width:100 %!important}.cx-navs-wrapper ul li:last-child{border-bottom:none}.cx-navs-wrapper ul li a{display:block;margin:0;padding:15px 12px;text-decoration:none;color:#777;font-size:12px;text-align:center}.cx-field-wrap,.cx-label-wrap{line-height:1.3;display:inline-block}.cx-navs-wrapper ul li a:focus{box-shadow:none}.cx-sections-wrapper{position:relative;padding:5px 16px;width:80%;float:left;background:#fff;color:#444;border-left:none;margin-bottom:40px}.cx-subheading{border-bottom:1px solid #ddd;padding-bottom:18px}.cx-label-wrap{vertical-align:top;text-align:left;padding:20px 10px 20px 0;width:25%;font-weight:600}.cx-field-wrap{padding:15px 10px;vertical-align:middle;width:70%!important}.cx-nav-tab.cx-active-tab{background:#23282d;border-right:none;border-bottom-right-radius:35px;border-top-right-radius:35px}.cx-label-wrap label,.cx-nav-tab.cx-active-tab a{color:#fff}.cx-field-wrap .cx-field-email,.cx-field-wrap .cx-field-number,.cx-field-wrap .cx-field-password,.cx-field-wrap .cx-field-select,.cx-field-wrap .cx-field-text,.cx-field-wrap .cx-field-textarea,.cx-field-wrap .cx-field-url{width:100%}.cx-field-wrap .cx-field-group{width:auto}.cx-field-wrap .cx-field-file{width:80%}.cx-field-wrap p{margin:0;font-family:inherit}.cx-message{display:none;color:#155724;background-color:#d4edda;padding:.75rem 1.25rem;margin-bottom:1rem;border:1px solid #acceb4;position:fixed;right:10px;width:200px;z-index:99;height:48px;line-height:48px;text-align:center;top:162px;font-weight:400;font-size:15px}.chosen-container,.select2-container{width:100%}.cx-sticky-controls{width:69%;background:#fff;position:fixed;bottom:0;left:0;z-index:9999;text-align:right;border-top:1px solid #ddd;padding:25px 0}.cx-subheading>.dashicons{color:#23282d}.cx-label-wrap label{color:#23282d}.cx-field-wrap .cx-field{background:#f9f9f9;border:1px solid #ecebeb;padding:5px 10px}.cx-divider{text-align:center}.cx-divider>span{font-weight:700}.cx-divider::after,.cx-divider::before{height:2px;content:"";width:200px;border-top:1px solid #ddd;display:inline-block;margin:0 6px 0 6px}.cx-sticky-controls .button-primary{background:#4caf50;border-color:#4caf50;color:#fff;text-decoration:none;text-shadow:none;padding:8px 20px;border:1px solid #57b95b}.cx-sticky-controls .button-primary:active,.cx-sticky-controls .button-primary:focus,.cx-sticky-controls .button-primary:hover{background:#57b95b;border-color:#57b95b;border:1px solid #57b95b;box-shadow:none}#wpwrap{background:#fff}.cx-sticky-controls .button.cx-reset-button{color:#b7b7b7;border-color:transparent!important;background:0 0!important;background-color:transparent!important;vertical-align:top;text-decoration:underline;padding-top:8px;outline:0}.cx-sticky-controls .button.cx-reset-button::active,.cx-sticky-controls .button.cx-reset-button::focus,.cx-sticky-controls .button.cx-reset-button::hover{background:0 0!important;background-color:transparent!important;border-color:transparent!important;border:none;box-shadow:none;outline:0}.cx-field-wrap input.button.cx-browse{line-height:38px;float:right}.cx-heading{padding-bottom:20px!important}@media only screen and (min-width:320px){.cx-sections-wrapper{width:73.5%;margin-left:0}.cx-label-wrap{width:100%}.cx-field-wrap{width:100%!important;padding-left:0;padding-top:0;padding-bottom:0}.cx-field-wrap .cx-field-file{width:53%}.cx-nav-label{display:none;font-weight:400;font-size:15px;padding-left:5px!important}.cx-navs-wrapper ul li a{text-align:center;padding:10px}.cx-sticky-controls{width:100%;text-align:center}.cx-field-wrap input.button.cx-browse{padding:0 12px}.cx-sidebar-wrapper{display:none}}@media only screen and (min-width:768px){.cx-sections-wrapper{width:75%;margin-left:20px}.cx-label-wrap{width:25%}.cx-field-wrap{padding:15px 10px;width:67%!important}.cx-field-wrap .cx-field-file{width:65%}.cx-nav-label{display:none;font-weight:400;font-size:15px}.cx-navs-wrapper{width:10%}.cx-field-wrap input.button.cx-browse{padding:0 10px}.cx-sticky-controls .button-primary{padding:4px 20px}}@media only screen and (min-width:900px){.cx-sticky-controls{left:160px;width:calc(100% - 160px)}}@media only screen and (min-width:1200px){.cx-sections-wrapper{width:80%}.cx-label-wrap{width:15%}.cx-field-wrap{padding:15px 0;width:83%!important}.cx-field-wrap .cx-field-file{width:80%}.cx-nav-label{display:unset;font-weight:400;font-size:15px}.cx-navs-wrapper{width:15%}.cx-navs-wrapper ul li a{text-align:left;padding:15px 12px}.cx-field-wrap input.button.cx-browse{padding:0 16px}.cx-sidebar-wrapper{display:block}.cx-sticky-controls .button-primary{padding:8px 20px}}@media only screen and (min-width:1367px){.cx-navs-wrapper{width:13%}.cx-field-wrap input.button.cx-browse{padding:0 40px}}
		</style>
		<?php
	}

	public function callback_enqueue_scripts() {
		if( strpos( get_current_screen()->id, $this->config['id'] ) == false ) return;

		wp_enqueue_media();
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'jquery' );

		wp_register_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js' );
		wp_register_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css' );

		wp_register_script( 'chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js' );
		wp_register_style( 'chosen', 'https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css' );

		if( $this->has_select2() ) {
			wp_enqueue_style( 'select2' );
			wp_enqueue_script( 'select2' );
		}
		if( $this->has_chosen() ) {
			wp_enqueue_style( 'chosen' );
			wp_enqueue_script( 'chosen' );
		}
	}

	public function callback_admin_menu() {
		if( isset( $this->config['parent'] ) && $this->config['parent'] != '' ) {
			add_submenu_page( $this->config['parent'], $this->config['label'], $this->config['label'], $this->config['capability'], $this->config['id'], array( $this, 'callback_fields' ) );
		}
		else {
			add_menu_page( $this->config['label'], $this->config['label'], $this->config['capability'], $this->config['id'], array( $this, 'callback_fields' ), $this->config['icon'], $this->config['position'] );
		}
	}

	public function callback_fields() {
		$config = $this->config;
		
		echo '<div class="wrap">';
		$icon = $this->generate_icon( $config['icon'] );
		echo "<h2 class='cx-heading'>{$icon} {$config['title']}</h2>";

		do_action( 'cx-settings-heading', $config );

		if( !isset( $this->sections ) || count( $this->sections ) <= 0 ) return;

		echo '<div class="cx-wrapper">';

		$sections = $this->sections;

		// nav tabs
		$display = count( $sections ) > 1 ? 'block' : 'none';
		echo '
		<div class="cx-navs-wrapper" style="display: ' . $display . '">
			<ul class="cx-nav-tabs">';
		foreach ( $sections as $section ) {
			$icon = $this->generate_icon( $section['icon'] );
			$color = isset( $section['color'] ) ? $section['color'] : '#23282d';
			echo "<li class='cx-nav-tab' data-color='{$color}'><a href='#{$section['id']}'>{$icon}<span id='cx-nav-label-{$section['id']}' class='cx-nav-label'> {$section['label']}</span></a></li>";
		}
		echo '</ul>
		</div><!--div class="cx-navs-wrapper"-->';

		// form areas
		echo '<div class="cx-sections-wrapper">';
		foreach ( $sections as $section ) {
			$icon = $this->generate_icon( $section['icon'] );
			$color = isset( $section['color'] ) ? $section['color'] : '#23282d';
			$submit_button = isset( $section['submit_button'] ) ? $section['submit_button'] : __( 'Save Settings' );
			$reset_button = isset( $section['reset_button'] ) ? $section['reset_button'] : __( 'Reset Default' );
			$_nonce = wp_create_nonce();

			echo "<div id='{$section['id']}' class='cx-section' style='display:none'>";

			do_action( 'cx-settings-before-title', $section );
			
			echo "<h3 class='cx-subheading'><span style='color: {$color}'>{$icon}</span> {$section['label']}</h3>";
			
			if( isset( $section['desc'] ) && $section['desc'] != '' ) {
				echo "<p class='cx-desc'>{$section['desc']}</p>";
			}

			do_action( 'cx-settings-before-form', $section );

			$fields = apply_filters( 'cx-settings-fields', $section['fields'], $section );
			$show_form = isset( $section['hide_form'] ) && $section['hide_form'] ? false : true;
			$show_form = apply_filters( 'cx-settigns-show-form', $show_form, $section );

			if( $show_form ) :
				
			$page_load = isset( $section['page_load'] ) && $section['page_load'] ? 1 : 0;

			echo "<form id='cx-form-{$section['id']}' class='cx-form'>
					<div id='cx-message-{$section['id']}' class='cx-message'></div>
					<input type='hidden' name='action' value='cx-settings' />
					<input type='hidden' name='option_name' value='{$section['id']}' />
					<input type='hidden' name='page_load' value='{$page_load}' />
			";
			wp_nonce_field();
			endif; // if( $show_form ) :

			do_action( 'cx-settings-before-fields', $section );

			if( isset( $section['template'] ) && $section['template'] != '' ) echo $section['template'];

			if( count( $fields ) > 0 ) :
			foreach ( $fields as $field ) {
				if( isset( $field['type'] ) && $field['type'] == 'divider' ) {
					$style = isset( $field['style'] ) ? $field['style'] : '';
					echo "<div class='cxrow cx-divider' id='cxrow-{$section['id']}-{$field['id']}' style='{$style}'><span>{$field['label']}</span></div>";
				}
				else {
					$field_display = isset( $field['condition'] ) && is_array( $field['condition'] ) ? 'none' : '';
					echo "
					<div class='cxrow' id='cxrow-{$section['id']}-{$field['id']}' style='display: {$field_display}'>
						<div class='cx-label-wrap'>";

						do_action( 'cx-settings-before-label', $field, $section );

						echo "<label for='{$section['id']}-{$field['id']}'>{$field['label']}</label>";

						do_action( 'cx-settings-after-label', $field, $section );

					echo "</div>
						<div class='cx-field-wrap'>";

							do_action( 'cx-settings-before-field', $field, $section );

							if( isset( $field['template'] ) && $field['template'] != '' ) echo $field['template'];

							if( isset( $field['type'] ) && $field['type'] != '' ) echo $this->populate_field( $field, $section );

							do_action( 'cx-settings-after-field', $field, $section );

							if( isset( $field['desc'] ) && $field['desc'] != '' ) {
								echo "<p class='cx-desc'>{$field['desc']}</p>";
							}

						do_action( 'cx-settings-after-description', $field, $section );

					echo "</div>
					</div>";
				}
			}
			endif; // if( count( $fields ) > 0 ) :

			do_action( 'cx-settings-after-fields', $section );

			if( $show_form ) :
			$_is_sticky = isset( $section['sticky'] ) && !$section['sticky'] ? '' : ' cx-sticky-controls';
			echo "<div class='cx-controls-wrapper{$_is_sticky}'>";

			if( $reset_button ) echo "<button type='button' class='button cx-reset-button' data-option_name='{$section['id']}' data-_nonce='{$_nonce}'>{$reset_button}</button>&nbsp;";
			if( $submit_button ) echo "<input type='submit' class='button button-primary cx-submit' value='{$submit_button}' />";
			echo '</div class="cx-controls-wrapper">
				</form>';
			endif; // if( $show_form ) :

			do_action( 'cx-settings-after-form', $section );

			echo "</div><!--div id='{$section['id']}'-->";
		}
		echo '</div><!--div class="cx-sections-wrapper"-->
			 <div class="cx-sidebar-wrapper">';

		do_action( 'cx-settings-sidebar', $config );

		echo '</div><!--div class="cx-sidebar-wrapper"-->
			</div><!--div class="cx-wrapper"-->
		</div><!--div class="wrap"-->';

		if( isset( $config['css'] ) && $config['css'] != '' ) {
			echo "<style>{$config['css']}</style>";
		}
	}

	public function callback_save_settings() {
		if( !wp_verify_nonce( $_POST['_wpnonce'] ) ) {
			wp_send_json( array( 'status' => 0, 'message' => __( 'Unauthorized!' ) ) );
		}
		$option_name = $_POST['option_name'];

		$is_savable = apply_filters( 'cx-settings-savable', true, $option_name, $_POST );

		if( !$is_savable ) wp_send_json( apply_filters( 'cx-settings-response', array( 'status' => -1, 'message' => __( 'Ignored' ) ), $_POST ) );

		$page_load = $_POST['page_load'];
		unset( $_POST['action'] );
		unset( $_POST['option_name'] );
		unset( $_POST['page_load'] );
		unset( $_POST['_wpnonce'] );
		unset( $_POST['_wp_http_referer'] );

		update_option( $option_name, $_POST );
		wp_send_json( apply_filters( 'cx-settings-response', array( 'status' => 1, 'message' => __( 'Settings Saved!' ), 'page_load' => $page_load ), $_POST ) );
	}

	public function callback_reset_settings() {
		if( !wp_verify_nonce( $_POST['_wpnonce'] ) ) {
			wp_send_json( array( 'status' => 0, 'message' => __( 'Unauthorized!' ) ) );
		}
		$option_name = $_POST['option_name'];

		$is_savable = apply_filters( 'cx-settings-resetable', true, $option_name, $_POST );

		if( !$is_savable ) wp_send_json( apply_filters( 'cx-settings-response', array( 'status' => -1, 'message' => __( 'Ignored' ) ), $_POST ) );

		delete_option( $_POST['option_name'] );
		wp_send_json( apply_filters( 'cx-settings-response', array( 'status' => 1, 'message' => __( 'Settings Reset!' ) ), $_POST ) );
	}

	public function populate_field( $field, $section ) {
		if ( in_array( $field['type'], array( 'text', 'number', 'email', 'url', 'password', 'color', 'range' ) ) ) {
			return $this->field_text( $field, $section );
		}
		elseif( $field['type'] == 'textarea' ){
			return $this->field_textarea( $field, $section );
		}
		elseif( $field['type'] == 'radio' ){
			return $this->field_radio( $field, $section );
		}
		elseif( $field['type'] == 'select' ){
			return $this->field_select( $field, $section );
		}
		elseif( $field['type'] == 'checkbox' ){
			return $this->field_checkbox( $field, $section );
		}
		elseif( $field['type'] == 'color' ){
			return $this->field_color( $field, $section );
		}
		elseif( $field['type'] == 'file' ){
			return $this->field_file( $field, $section );
		}
		elseif( $field['type'] == 'wysiwyg' ){
			return $this->field_wysiwyg( $field, $section );
		}
		elseif( $field['type'] == 'divider' ){
			return $this->field_divider( $field, $section );
		}
		elseif( $field['type'] == 'group' ){
			return $this->field_group( $field, $section );
		}
	}

	public function field_text( $field, $section ){
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value = $this->esc_str( cx_get_option( $section['id'], $field['id'], $default ) );

		$type 			= $field['type'];
		$name 			= $field['id'];
		$label 			= $field['label'];
		$id 			= "{$section['id']}-{$field['id']}";

		$class 			= "cx-field cx-field-{$field['type']}";
		$class 			.= isset( $field['class'] ) ? $field['class'] : '';

		$placeholder	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
		$required 		= isset( $field['required'] ) && $field['required'] ? " required" : "";
		$readonly 		= isset( $field['readonly'] ) && $field['readonly'] ? " readonly" : "";
		$disabled 		= isset( $field['disabled'] ) && $field['disabled'] ? " disabled" : "";
		$min 			= isset( $field['min'] ) && $field['min'] ? " min='{$field['min']}'" : "";
		$max 			= isset( $field['max'] ) && $field['max'] ? " max='{$field['max']}'" : "";
		$step 			= isset( $field['step'] ) && $field['step'] ? " step='{$field['step']}'" : "";

		if( $type == 'color' ) {
			$class .= ' cx-color-picker';
			$type = 'text';
		}

		$html = "<input type='{$type}' class='{$class}' id='{$id}' name='{$name}' value='{$value}' placeholder='{$placeholder}' {$min} {$max} {$step} {$required} {$readonly} {$disabled}/>";

		return $html;
	}

	public function field_textarea( $field, $section ){
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value = $this->esc_str( cx_get_option( $section['id'], $field['id'], $default ) );

		$name 			= $field['id'];
		$label 			= $field['label'];
		$id 			= "{$section['id']}-{$field['id']}";

		$class 			= "cx-field cx-field-{$field['type']}";
		$class 			.= isset( $field['class'] ) ? $field['class'] : '';

		$placeholder	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
		$required 		= isset( $field['required'] ) && $field['required'] ? " required" : "";
		$readonly 		= isset( $field['readonly'] ) && $field['readonly'] ? " readonly" : "";
		$disabled 		= isset( $field['disabled'] ) && $field['disabled'] ? " disabled" : "";
		$rows 			= isset( $field['rows'] ) ? $field['rows'] : 5;
		$cols 			= isset( $field['cols'] ) ? $field['cols'] : 3;

		$html  = "<textarea class='{$class}' id='{$id}' name='{$name}' cols='{$cols}' rows='{$rows}' placeholder='{$placeholder}' {$required} {$readonly} {$disabled}>{$value}</textarea>";

		return $html;
	}

	public function field_radio( $field, $section ){
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value = cx_get_option( $section['id'], $field['id'], $default );

		$name 			= $field['id'];
		$label 			= $field['label'];
		$id 			= "{$section['id']}-{$field['id']}";

		$class 			= "cx-field cx-field-{$field['type']}";
		$class 			.= isset( $field['class'] ) ? $field['class'] : '';

		$placeholder	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
		$required 		= isset( $field['required'] ) && $field['required'] ? " required" : "";
		$readonly 		= isset( $field['readonly'] ) && $field['readonly'] ? " readonly" : "";
		$disabled 		= isset( $field['disabled'] ) && $field['disabled'] ? " disabled" : "";
		$options 		= isset( $field['options'] ) ? $field['options'] : array();

		$html = '';
		foreach ( $options as $key => $title ) {
			$html .= "<input type='radio' name='{$name}' id='{$id}-{$key}' class='{$class}' value='{$key}' {$required} {$disabled} " . checked( $value, $key, false ) . "/>";
			$html .= "<label for='{$id}-{$key}'>{$title}</label><br />";
		}

		return $html;
	}

	public function field_checkbox( $field, $section ){
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value = cx_get_option( $section['id'], $field['id'], $default );

		$name 			= $field['id'];
		$label 			= $field['label'];
		$id 			= "{$section['id']}-{$field['id']}";

		$class 			= "cx-field cx-field-{$field['type']}";
		$class 			.= isset( $field['class'] ) ? $field['class'] : '';

		$placeholder	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
		$required 		= isset( $field['required'] ) && $field['required'] ? " required" : "";
		$disabled 		= isset( $field['disabled'] ) && $field['disabled'] ? " disabled" : "";
		$multiple 		= isset( $field['multiple'] ) && $field['multiple'];
		$options 		= isset( $field['options'] ) ? $field['options'] : array();

		$html  = '';
		if( $multiple ) {
			foreach ( $options as $key => $title ) {
				$html .= "
				<p>
					<input type='checkbox' name='{$name}[]' id='{$id}-{$key}' class='{$class}' value='{$key}' {$required} {$disabled} " . ( in_array( $key, (array)$value ) ? 'checked' : '' ) . "/>
					<label for='{$id}-{$key}'>{$title}</label>
				</p>";
			}
		}
		else {
			$html .= "<input type='checkbox' name='{$name}' id='{$id}' class='{$class}' value='on' {$required} {$disabled} " . checked( $value, 'on', false ) . "/>";
		}

		return $html;
	}

	public function field_select( $field, $section ){
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value = cx_get_option( $section['id'], $field['id'], $default );

		$name 			= $field['id'];
		$label 			= $field['label'];
		$id 			= "{$section['id']}-{$field['id']}";

		$class 			= "cx-field cx-field-{$field['type']}";
		$class 			.= isset( $field['class'] ) ? $field['class'] : '';
		$class 			.= isset( $field['select2'] ) && $field['select2'] ? ' cx-select2' : '';
		$class 			.= isset( $field['chosen'] ) && $field['chosen'] ? ' cx-chosen' : '';

		$placeholder	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
		$required 		= isset( $field['required'] ) && $field['required'] ? " required" : "";
		$disabled 		= isset( $field['disabled'] ) && $field['disabled'] ? " disabled" : "";
		$multiple 		= isset( $field['multiple'] ) && $field['multiple'] ? 'multiple' : false;
		$options 		= isset( $field['options'] ) ? $field['options'] : array();

		$html  = '';
		if( $multiple ) {
			$html .= "<select name='{$name}[]' id='{$id}' class='{$class}' multiple {$required} {$disabled}>";
			foreach ( $options as $key => $title ) {
				$html .= "<option value='{$key}' " . ( in_array( $key, (array)$value ) ? 'selected' : '' ) . ">{$title}</option>";
			}
			$html .= '</select>';
		}
		else {
			$html .= "<select name='{$name}' id='{$id}' class='{$class}' {$required} {$disabled}>";
			foreach ( $options as $key => $title ) {
				$html .= "<option value='{$key}' " . selected( $value, $key, false ) . ">{$title}</option>";
			}
			$html .= '</select>';
		}

		return $html;
	}

	public function field_file( $field, $section ) {
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value = $this->esc_str( cx_get_option( $section['id'], $field['id'], $default ) );

		$type 			= $field['type'];
		$name 			= $field['id'];
		$label 			= $field['label'];
		$id 			= "{$section['id']}-{$field['id']}";

		$class 			= "cx-field cx-field-{$field['type']}";
		$class 			.= isset( $field['class'] ) ? $field['class'] : '';

		$placeholder	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
		$required 		= isset( $field['required'] ) && $field['required'] ? " required" : "";
		$readonly 		= isset( $field['readonly'] ) && $field['readonly'] ? " readonly" : "";
		$disabled 		= isset( $field['disabled'] ) && $field['disabled'] ? " disabled" : "";

		$upload_button	= isset( $field['upload_button'] ) ? $field['upload_button'] : __( 'Choose File' );
		$select_button	= isset( $field['select_button'] ) ? $field['select_button'] : __( 'Select' );

		$html  = '';
		$html .= "<input type='text' class='{$class} cx-file' id='{$id}' name='{$name}' value='{$value}' placeholder='{$placeholder}' {$readonly} {$required} {$disabled}/>";
		$html  .= "<input type='button' class='button cx-browse' data-title='{$label}' data-select-text='{$select_button}' value='{$upload_button}' {$required} {$disabled} />";

		return $html;
	}

	public function field_wysiwyg( $field, $section ) {
		$default = isset( $field['default'] ) ? $field['default'] : '';
		$value = stripslashes( cx_get_option( $section['id'], $field['id'], $default ) );

		$name 			= $field['id'];
		$label 			= $field['label'];
		$id 			= "{$section['id']}-{$field['id']}";

		$class 			= "cx-field cx-field-{$field['type']}";
		$class 			.= isset( $field['class'] ) ? $field['class'] : '';

		$placeholder	= isset( $field['placeholder'] ) ? $field['placeholder'] : '';
		$readonly 		= isset( $field['readonly'] ) && $field['readonly'] ? " readonly" : "";
		$disabled 		= isset( $field['disabled'] ) && $field['disabled'] ? " disabled" : "";
		$teeny			= isset( $field['teeny'] ) && $field['teeny'];
		$text_mode		= isset( $field['text_mode'] ) && $field['text_mode'];
		$media_buttons  = isset( $field['media_buttons'] ) && $field['media_buttons'];
		$rows 			= isset( $field['rows'] ) ? $field['rows'] : 10;

		$html  = '';
		$settings = array(
			'teeny'         => $teeny,
			'textarea_name' => $name,
			'textarea_rows' => $rows,
			'quicktags'		=> $text_mode,
			'media_buttons'	=> $media_buttons,
		);

		if ( isset( $field['options'] ) && is_array( $field['options'] ) ) {
			$settings = array_merge( $settings, $field['options'] );
		}

		ob_start();
		wp_editor( $value, $id, $settings );
		$html .= ob_get_contents();
		ob_end_clean();

		return $html;
	}

	public function field_divider( $field, $section ) {
		return $field['label'];
	}

	public function field_group( $field, $section ) {
		// pri($field);

		// $class 			= "cx-field cx-field-{$field['type']}";
		$items = $field['items'];
		$html = '';
		foreach ( $items as $item ) {
			$item['class'] = ' cx-field-group';
			$html .= $this->populate_field( $item, $section );
		}

		return $html;
	}

	public function generate_icon( $value ) {
		if( $value == '' ) return '';
		if( strpos( $value, '://' ) !== false ) {
			return "<img class='cx-icon-{$this->config['id']}' src='{$value}' />";
		}
		return "<span class='dashicons {$value}'></span>";
	}

	public function esc_str( $string ) {
		return stripslashes( esc_attr( $string ) );
	}

	public function deep_key_exists( $arr, $key ){
		if ( array_key_exists( $key, $arr ) && $arr[ $key ] == true ) return true;
		foreach( $arr as $element ) {
			if( is_array( $element ) && $this->deep_key_exists( $element, $key ) ) {
				return true;
			}
		}
		return false;
	}

	public function has_select2() {
		return $this->deep_key_exists( $this->config, 'select2' );
	}

	public function has_chosen() {
		return $this->deep_key_exists( $this->config, 'chosen' );
	}
}

if( ! function_exists( 'cx_get_option' ) ) :
function cx_get_option( $key, $section, $default = '' ) {

	$options = get_option( $key );

	if ( isset( $options[ $section ] ) ) {
		return $options[ $section ];
	}

	return $default;
}
endif;