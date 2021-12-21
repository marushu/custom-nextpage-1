<?php
namespace CustomNextpage;

new CustomNextpage_WPEnqueueScripts();
class CustomNextpage_WPEnqueueScripts extends CustomNextpage_Init {

	public function __construct() {
		parent::__construct();
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
	}

	public function wp_enqueue_scripts() {
		$options   = get_option( 'custom-next-page' );
		$styletype = ( isset( $options['styletype'] ) ) ? (int) $options['styletype'] : 0;
		$style     = strip_tags( file_get_contents( $this->dir . 'assets/css/custom-nextpage-style.css' ) );
		if ( 0 === $styletype ) {
			wp_enqueue_style( 'custom-nextpage', $this->url . 'assets/css/custom-nextpage-style.css', array(), filemtime( $this->dir . 'assets/css/custom-nextpage-style.css' ) );
		} elseif ( 1 == $styletype ) {
			$print_html = sprintf(
				'<style type="text/css" id="custom-nextpage-style">' . "\n"
				. '%s'
				. "\n" . '</style>' . "\n",
				$style
			);
			wp_register_style( 'custom-nextpage', false );
			wp_enqueue_style( 'custom-nextpage' );
			wp_add_inline_style( 'custom-nextpage', $print_html );
		}
	}


}
