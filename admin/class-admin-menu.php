<?php
namespace CustomNextpage;

new CustomNextpage_Admin();
class CustomNextpage_Admin extends CustomNextpage_Init {
	public function __construct() {
		parent::__construct();

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'add_general_custom_fields' ) );
		add_filter( 'admin_init', array( $this, 'add_custom_whitelist_options_fields' ) );
		add_action( 'wp_ajax_reset_css', array( $this, 'reset_css' ) );
	}

	public function admin_menu() {
		add_options_page( __( 'Custom Nextpage', $this->domain ), __( 'Custom Nextpage', $this->domain ), 'edit_themes', $this->domain, array( $this, 'add_admin_edit_page' ) );
	}

	public function add_admin_edit_page() {
		$title = __( 'Set Custom Nextpage', $this->domain );
		echo '<div class="wrap">' . PHP_EOL;
		echo '<h2>' . esc_html( $title ) . '</h2>' . PHP_EOL;
		echo '<form method="post" action="options.php">' . PHP_EOL;
		settings_fields( $this->domain );
		do_settings_sections( $this->domain );
		echo '<div class="submit">' . PHP_EOL;
		echo submit_button() . PHP_EOL;
		if ( get_option( 'custom-next-page-previouspagelink' ) ) {
			echo '<h2>' . esc_html__( 'Convert to new options', $this->domain ) . '</h2>' . PHP_EOL;
			submit_button( __( 'Convert', $this->domain ), 'primary', 'custom-next-page-convert' );
		}
		echo '<h2>' . esc_html__( 'Setting initialization', $this->domain ) . '</h2>' . PHP_EOL;
		submit_button( __( 'Initialization', $this->domain ), 'primary', 'custom-next-page-initialization' );
		echo '</div>' . PHP_EOL;
		echo '</form>' . PHP_EOL;
		echo '</div>' . PHP_EOL;

	}

	public function add_general_custom_fields() {
		global $wp_version;
		$options = new CustomNextpage_NextPageOptions( 'custom-next-page' );
		$options = $options->get();

		add_settings_section(
			'general',
			__( 'General', $this->domain ),
			'',
			$this->domain
		);
		if ( version_compare( $wp_version, '3.6', '>=' ) ) {
			add_settings_field(
				'custom-next-page-filter',
				__( 'Automatically replace the wp_link_pages.', $this->domain ),
				array( $this, 'check_field' ),
				$this->domain,
				'general',
				array(
					'name'  => 'custom-next-page[filter]',
					'value' => $options['filter'],
				)
			);
		}
		add_settings_field(
			'custom-next-page-before-text',
			__( 'Before Text', $this->domain ),
			array( $this, 'text_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[beforetext]',
				'value' => $options['beforetext'],
			)
		);
		add_settings_field(
			'custom-next-page-after-text',
			__( 'After Text', $this->domain ),
			array( $this, 'text_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[aftertext]',
				'value' => $options['aftertext'],
			)
		);

		add_settings_field(
			'custom-next-page-show_all',
			__( 'Show all numbers', $this->domain ),
			array( $this, 'check_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[show_all]',
				'value' => $options['show_all'],
			)
		);
		add_settings_field(
			'custom-next-page-end_size',
			__( 'End size', $this->domain ),
			array( $this, 'text_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[end_size]',
				'value' => $options['end_size'],
				'class' => 'small-text',
				'desc'  => __( 'How many numbers on either the start and the end list edges.', $this->domain ),
			)
		);
		add_settings_field(
			'custom-next-page-mid_size',
			__( 'Mid size', $this->domain ),
			array( $this, 'text_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[mid_size]',
				'value' => $options['mid_size'],
				'class' => 'small-text',
				'desc'  => __( 'How many numbers to either side of current page, but not including current page.', $this->domain ),
			)
		);
		add_settings_field(
			'custom-next-page-boundary',
			__( 'The first and last page links displayed.', $this->domain ),
			array( $this, 'check_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[show_boundary]',
				'value' => $options['show_boundary'],
			)
		);
		add_settings_field(
			'custom-next-page-adjacent',
			__( 'Next and previous page links to display.', $this->domain ),
			array( $this, 'check_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[show_adjacent]',
				'value' => $options['show_adjacent'],
			)
		);
		add_settings_field(
			'custom-next-page-firstpagelink',
			__( 'Text For First Page', $this->domain ),
			array( $this, 'text_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[firstpagelink]',
				'value' => $options['firstpagelink'],
			)
		);
		add_settings_field(
			'custom-next-page-lastpagelink',
			__( 'Text For Last Page', $this->domain ),
			array( $this, 'text_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[lastpagelink]',
				'value' => $options['lastpagelink'],
			)
		);
		add_settings_field(
			'custom-next-page-nextpagelink',
			__( 'Text For Next Page', $this->domain ),
			array( $this, 'text_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[nextpagelink]',
				'value' => $options['nextpagelink'],
			)
		);
		add_settings_field(
			'custom-next-page-previouspagelink',
			__( 'Text For Previous Page', $this->domain ),
			array( $this, 'text_field' ),
			$this->domain,
			'general',
			array(
				'name'  => 'custom-next-page[previouspagelink]',
				'value' => $options['previouspagelink'],
			)
		);
		add_settings_section(
			'style',
			__( 'Style', $this->domain ),
			'',
			$this->domain
		);
		add_settings_field(
			'custom-next-page-style-type',
			__( 'Select Style type', $this->domain ),
			array( $this, 'select_field' ),
			$this->domain,
			'style',
			array(
				'name'   => 'custom-next-page[styletype]',
				'option' => array(
					'0' => __( 'Default', $this->domain ),
					'1' => __( 'Style Edit', $this->domain ),
					'2' => __( 'Disable', $this->domain ),
				),
				'id'     => 'styletype',
				'value'  => $options['styletype'],
			)
		);
		add_settings_field(
			'custom-next-page-style',
			__( 'Style Edit', $this->domain ),
			array( $this, 'textarea_field' ),
			$this->domain,
			'style',
			array(
				'id'    => 'style-editor',
				'name'  => 'custom-next-page[style]',
				'value' => $options['style'],
				'desc'  => __( 'Press ctrl-space to activate autocompletion. <span class="button button-primary" id="reset-css">Reset</span>', $this->domain ),
			)
		);
	}

	public function text_field( $args ) {
		extract( $args );

		$id     = ! empty( $id ) ? $id : $name;
		$desc   = ! empty( $desc ) ? $desc : '';
		$class  = ! empty( $class ) ? $class : 'regular-text';
		$output = '<input type="text" name="' . $name . '" id="' . $id . '" class="' . $class . '" value="' . $value . '" />' . "\n";
		if ( $desc ) {
			$output .= '<p class="description">' . $desc . '</p>' . "\n";
		}

		echo $output;
	}

	public function textarea_field( $args ) {
		extract( $args );

		$id     = ! empty( $id ) ? $id : $name;
		$desc   = ! empty( $desc ) ? $desc : '';
		$output = '<textarea name="' . $name . '" rows="10" cols="50" id="' . $id . '" class="large-text code">' . $value . '</textarea>' . "\n";
		if ( $desc ) {
			$output .= '<p class="description">' . $desc . '</p>' . "\n";
		}
		echo $output;
	}

	public function check_field( $args ) {
		extract( $args );

		$id      = ! empty( $id ) ? $id : $name;
		$desc    = ! empty( $desc ) ? $desc : '';
		$output  = '<label for="' . $name . '">' . "\n";
		$output .= '<input name="' . $name . '" type="checkbox" id="' . $id . '" value="1"' . checked( $value, 1, false ) . '>' . "\n";
		if ( $desc ) {
			$output .= $desc . "\n";
		}
		$output .= '</label>' . "\n";

		echo $output;
	}

	public function select_field( $args ) {
		extract( $args );

		$id             = ! empty( $id ) ? $id : $name;
		$desc           = ! empty( $desc ) ? $desc : '';
		$multi          = ! empty( $multi ) ? ' multiple' : '';
		$multi_selected = ! empty( $multi ) ? true : false;
		$output         = '<select name="' . $name . '" id="' . $id . '"' . $multi . '>' . "\n";
		foreach ( $option as $key => $val ) {
			$output .= '<option value="' . $key . '"' . selected( $value, $key, $multi_selected ) . '>' . $val . '</option>' . "\n";
		}
		$output .= '</select>' . "\n";
		if ( $desc ) {
			$output .= $desc . "\n";
		}

		echo $output;
	}

	public function selected( $value = '', $val = '', $multi = false ) {
		$select = '';
		if ( $multi ) {

			$select = selected( true, in_array( $val, $value ), false );
		} else {
			$select = selected( $value, $val, false );
		}
		return $select;
	}

	public function reset_css() {
		check_ajax_referer( 'reset-css', 'security' );
		$options = new CustomNextpage_NextPageOptions( 'custom-next-page' );

		$return = array(
			'style' => $options->css,
		);
		wp_send_json( $return );
	}

	public function add_custom_whitelist_options_fields() {
		register_setting( $this->domain, 'custom-next-page', array( $this, 'register_setting_check' ) );
		register_setting( $this->domain, 'custom-next-page-convert', array( $this, 'register_setting_convert' ) );
		register_setting( $this->domain, 'custom-next-page-initialization', array( $this, 'register_setting_initialization' ) );
	}

	public function register_setting_check( $value ) {
		$value['filter']        = (int) $value['filter'];
		$value['show_all']      = (int) $value['show_all'];
		$value['end_size']      = (int) $value['end_size'];
		$value['end_size']      = (int) $value['end_size'];
		$value['show_boundary'] = (int) $value['show_boundary'];
		$value['show_adjacent'] = (int) $value['show_adjacent'];
		$value['style']         = preg_replace( '/(\&lt;(.*)\&gt;)/ism', '', esc_textarea( $value['style'] ) );
		return $value;
	}

	public function register_setting_convert( $value ) {
		if ( __( 'Convert', $this->domain ) != $value ) {
			return $value;
		}
		$convert_options                     = get_option( 'custom-next-page' );
		$convert_options['filter']           = get_option( 'custom-next-page-filter' );
		$convert_options['before-text']      = get_option( 'custom-next-page-before-text' );
		$convert_options['after-text']       = get_option( 'custom-next-page-after-text' );
		$convert_options['nextpagelink']     = get_option( 'custom-next-page-nextpagelink', __( '&#187;', $this->domain ) );
		$convert_options['previouspagelink'] = get_option( 'custom-next-page-previouspagelink', __( '&#171;', $this->domain ) );
		update_option( 'custom-next-page', $convert_options );
		delete_option( 'custom-next-page-filter' );
		delete_option( 'custom-next-page-before-text' );
		delete_option( 'custom-next-page-after-text' );
		delete_option( 'custom-next-page-firstpagelink' );
		delete_option( 'custom-next-page-lastpagelink' );
		delete_option( 'custom-next-page-nextpagelink' );
		delete_option( 'custom-next-page-previouspagelink' );
		return $value;
	}

	public function register_setting_initialization( $value ) {
		if ( __( 'Initialization', $this->domain ) != $value ) {
			return $value;
		}
		$options  = new CustomNextpage_NextPageOptions( 'custom-next-page' );
		$defaults = $options->defaults();

		delete_option( 'custom-next-page' );
		update_option( 'custom-next-page', $defaults );
		return $value;
	}

}
