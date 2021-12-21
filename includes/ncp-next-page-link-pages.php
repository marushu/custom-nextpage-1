<?php
namespace CustomNextpage;

new CustomNextpage_NextPageLinkPages();
class CustomNextpage_NextPageLinkPages extends CustomNextpage_Init {

	private static $singleton;

	public function __construct() {
		parent::__construct();
	}

	public static function get_instance() {
		if ( ! isset( self::$singleton ) ) {
			self::$singleton = new CustomNextpage_NextPageLinkPages();
		}

		return self::$singleton;
	}

	public function next_page_link_pages( $post_id = 0 ) {
		echo self::get_next_page_link_pages( $post_id );
	}

	public function get_next_page_link_pages( $post_id = 0 ) {
		$options = new CustomNextpage_NextPageOptions( 'custom-next-page' );
		$options = $options->get();

		$filter = $options['filter'];
		if ( ! $filter ) {
			return;
		}
		global $page, $numpages, $multipage, $pagenow;
		$html = '';

		if ( $multipage ) {
			$show_all         = (bool) $options['show_all'];
			$end_size         = (int) $options['end_size'];
			$mid_size         = (int) $options['mid_size'];
			$show_boundary    = apply_filters( 'custom_next_page_show_boundary', (bool) $options['show_boundary'] );
			$show_adjacent    = apply_filters( 'custom_next_page_show_adjacent', (bool) $options['show_adjacent'] );
			$firstpagelink    = apply_filters( 'custom_next_page_firstpagelink', esc_html( $options['firstpagelink'] ) );
			$lastpagelink     = apply_filters( 'custom_next_page_lastpagelink', esc_html( $options['lastpagelink'] ) );
			$nextpagelink     = apply_filters( 'custom_next_page_nextpagelink', esc_html( $options['nextpagelink'] ) );
			$previouspagelink = apply_filters( 'custom_next_page_previouspagelink', esc_html( $options['previouspagelink'] ) );
			$show_title       = apply_filters( 'custom_next_page_show_title', (bool) $options['show_title'] );
			$id               = get_the_ID();

			$html .= '<div class="page-link-box">' . "\n";
			if ( true === class_exists( 'CustomNextpage\CustomNextpage_NextPageTitle' ) ) {
				$html .= CustomNextpage_NextPageTitle::get_instance()->get_next_page_title();
			}
			$html .= '<ul class="page-links">' . "\n";
			$i     = $page - 1;

			if ( $page > 1 ) {
				$first_link = _wp_link_page( 1 );
				$link       = _wp_link_page( $i );
				if ( $show_boundary ) {
					$html .= '<li class="first">' . $first_link . $firstpagelink . '</a></li>';
				}
				if ( $show_adjacent ) {
					$html .= '<li class="previous">' . $link . $previouspagelink . '</a></li>';
				}
			}

			$p_base   = get_permalink();
			$p_format = '%#%';

			if ( $word = strpos( $p_base, '?' ) ) {
				$p_base = get_option( home ) . ( substr( get_option( home ), -1, 1 ) === '/' ? '' : '/' )
					. '%_%' . substr( $p_base, $word );
			} else {
				$p_base .= ( substr( $p_base, -1, 1 ) === '/' ? '' : '/' ) . '%_%';
			}
			$nav_list = paginate_links(
				array(
					'base'      => $p_base,
					'format'    => $p_format,
					'total'     => $numpages,
					'current'   => ( $page ? $page : 1 ),
					'show_all'  => $show_all,
					'end_size'  => $end_size,
					'mid_size'  => $mid_size,
					'prev_next' => false,
					'type'      => 'array',
				)
			);
			foreach ( $nav_list as $nav ) {
				if ( stristr( $nav, 'span' ) ) {
					if ( stristr( $nav, 'dots' ) ) {
						$html .= '<li class="numpages dots"><span>' . strip_tags( $nav ) . '</span></li>';
					} else {
						$html .= '<li class="numpages current"><span>' . strip_tags( $nav ) . '</span></li>';
					}
				} else {
					$html .= '<li class="numpages">' . $nav . '</li>';
				}
			}

			$i = $page + 1;
			if ( $i <= $numpages ) {
				$last_link = _wp_link_page( $numpages );
				$link      = _wp_link_page( $i );
				if ( $show_adjacent ) {
					$html .= '<li class="next">' . $link . $nextpagelink . '</a></li>';
				}

				if ( $show_boundary ) {
					$html .= '<li class="last">' . $last_link . $lastpagelink . '</a></li>';
				}
			}
			$html .= '</ul>' . "\n";
			$html .= '</div>' . "\n";
		}

		return $html;
	}
}
