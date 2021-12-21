<?php
namespace CustomNextpage;

new CustomNextpage_NextPageTitle();
class CustomNextpage_NextPageTitle extends CustomNextpage_Init {

	private static $singleton;

	public function __construct() {
		parent::__construct();
	}

	public static function get_instance() {
		if ( ! isset( self::$singleton ) ) {
			self::$singleton = new CustomNextpage_NextPageTitle();
		}

		return self::$singleton;
	}

	public function next_page_title( $post_id = 0 ) {
		echo self::get_next_page_title( $post_id );
	}

	public function get_next_page_title( $post_id = 0 ) {
		global $page, $numpages, $multipage;
		$html = '';
		if ( empty( $post_id ) ) {
			$post_id = get_the_id();
		}
		if ( $multipage ) {
			$pattern      = '/\[nextpage[^\]]*\]/';
			$content      = get_post_field( 'post_content', $post_id );
			$matche_count = $page - 1;
			$page_count   = $page + 1;
			if ( preg_match_all( $pattern, $content, $matches ) ) {
				$page_title = isset( $matches[0][ $matche_count ] ) ? $matches[0][ $matche_count ] : '';
				if ( $page_title ) {
					$pattern = '/title=["?](.*)["?]/';
					if ( preg_match( $pattern, $page_title, $matches ) ) {
						$title  = isset( $matches[1] ) ? esc_html( $matches[1] ) : '';
						$before = apply_filters( 'custom_next_page_beforetext', $this->beforetext );
						$after  = apply_filters( 'custom_next_page_aftertext', $this->aftertext );
						$html  .= '<p class="custom-page-links">' . "\n";
						if ( $page_count <= $numpages ) {
							$html .= _wp_link_page( $page_count );
							$html .= $before . $title . $after . '</a>';
						}
						$html .= '</p>' . "\n";
					}
				}
			}
		}
		return $html;
	}
}
