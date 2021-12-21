<?php
namespace CustomNextpage;

new CustomNextpage_WPThePosts();
class CustomNextpage_WPThePosts extends CustomNextpage_Init {

	public function __construct() {
		parent::__construct();
		add_action( 'the_posts', array( $this, 'change_nextpage' ) );
	}



	public function change_nextpage( $posts ) {
		if ( is_feed() || is_404() || ( isset( $_GET['type'] ) && $_GET['type'] == 'netarica_yfeed' ) ) {
			return $posts;
		}
		$content = ( isset( $posts[0] ) ) ? reset( $posts )->post_content : false;
		if ( $content && has_shortcode( $content, 'nextpage' ) ) {
			$pattern                    = array( '/<!-- wp:shortcode -->(.*?)\[nextpage\](.*?)<!-- \/wp:shortcode -->/s', '/<!-- wp:shortcode -->(.*?)\[nextpage([^\]]*)\](.*?)<!-- \/wp:shortcode -->/s', '/<.*?>\[nextpage\]<\/.*?>/', '/\[nextpage([^\]]*)\]/' );
			$replacement                = array( '<!--nextpage-->', '$0<!--nextpage-->', '<!--nextpage-->', '$0<!--nextpage-->' );
				$posts[0]->post_content = preg_replace( $pattern, $replacement, $content );
		}
		return $posts;
	}

}
