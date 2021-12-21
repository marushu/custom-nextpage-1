<?php
namespace CustomNextpage;

class CustomNextpage_NextPageOptions extends CustomNextpage_Init {
	/**
	 * The option name.
	 *
	 * @var string
	 */
	protected $key;

	public function __construct( $key ) {
		parent::__construct();
		$this->key = $key;
		$this->css = strip_tags( file_get_contents( $this->dir . 'assets/css/custom-nextpage-style.css' ) );
	}

	public function defaults() {
		$defaults = array(
			'filter'           => false,
			'beforetext'       => '',
			'aftertext'        => '',
			'show_all'         => true,
			'end_size'         => 1,
			'mid_size'         => 2,
			'show_boundary'    => 1,
			'show_adjacent'    => 1,
			'firstpagelink'    => __( '&#171;', $this->domain ),
			'lastpagelink'     => __( '&#187;', $this->domain ),
			'nextpagelink'     => __( '&gt;', $this->domain ),
			'previouspagelink' => __( '&lt;', $this->domain ),
			'show_title'       => true,
			'styletype'        => 0,
			'style'            => $this->css,
		);
		return $defaults;
	}

	public function get() {
		$defaults      = self::defaults();
		$this->options = get_option( $this->key, $defaults );
		return $this->options;
	}

}
