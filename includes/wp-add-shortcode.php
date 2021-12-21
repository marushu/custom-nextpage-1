<?php
namespace CustomNextpage;

new CustomNextpage_WPAddShortcode();
class CustomNextpage_WPAddShortcode extends CustomNextpage_Init {

	public function __construct() {
		parent::__construct();
		add_shortcode( 'nextpage', array( $this, 'shortcode' ) );

	}

	public function shortcode() {
		return;
	}


}
