<?php
namespace CustomNextpage;

new CustomNextpage_WPLoopStart();
class CustomNextpage_WPLoopStart extends CustomNextpage_Init {

	public function __construct() {
		parent::__construct();
		add_action( 'loop_start', array( $this, 'change_nextpage' ), 0 );
	}

	public function change_nextpage( $query ) {
		if ( is_feed() || is_404() ) {
			return;
		}

		$posts       = $query->posts;
		$pattern     = array( '/<.*?>\[nextpage[^\]]*\]<\/.*?>/', '/\[nextpage[^\]]*\]/' );
		$replacement = array( '<!--nextpage-->', '<!--nextpage-->' );
		$count       = 0;
		foreach ( $posts as $post ) {
			$content                              = $post->post_content;
			$query->posts[ $count ]->post_content = preg_replace( $pattern, $replacement, $content );
			$count++;
		}
		echo $query->posts[0]->post_content;
		return $query;
	}

}
