<?php
namespace CustomNextpage;

new CustomNextpage_WPLinkPages();
class CustomNextpage_WPLinkPages extends CustomNextpage_Init {

	public function __construct() {
		parent::__construct();
		add_filter( 'wp_link_pages', array( $this, 'wp_link_pages' ), 10, 2 );
	}

	public function wp_link_pages( $html, $args ) {
		if ( true === class_exists( 'CustomNextpage\CustomNextpage_NextPageLinkPages' ) && CustomNextpage_NextPageLinkPages::get_instance()->get_next_page_link_pages() ) {
			$html = CustomNextpage_NextPageLinkPages::get_instance()->get_next_page_link_pages();
		}
		return $html;

	}



}
