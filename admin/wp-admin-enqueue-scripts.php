<?php
namespace CustomNextpage;

new CustomNextpage_WPAdminEnqueueScripts();
class CustomNextpage_WPAdminEnqueueScripts extends CustomNextpage_Init {

	public function __construct() {
		parent::__construct();
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}


	public function admin_enqueue_scripts( $hook ) {

		if ( stristr( $hook, $this->domain ) ) {

			wp_enqueue_style( 'codemirror', $this->url . 'assets/vendor/codemirror/lib/codemirror.css', array(), filemtime( $this->dir . 'assets/vendor/codemirror/lib/codemirror.css' ) );
			wp_enqueue_style( 'codemirror-show-hint', $this->url . 'assets/vendor/codemirror/addon/hint/show-hint.css', array(), filemtime( $this->dir . 'assets/vendor/codemirror/addon/hint/show-hint.css' ) );
			wp_enqueue_style( 'codemirror-style', $this->url . 'assets/admin/css/codemirror-style.css', array(), filemtime( $this->dir . 'assets/admin/css/codemirror-style.css' ) );

			wp_enqueue_script( 'codemirror', $this->url . 'assets/vendor/codemirror/lib/codemirror.js', array(), filemtime( $this->dir . 'assets/vendor/codemirror/lib/codemirror.js' ), true );
			wp_enqueue_script( 'codemirror-show-hint', $this->url . 'assets/vendor/codemirror/addon/hint/show-hint.js', array( 'codemirror' ), filemtime( $this->dir . 'assets/vendor/codemirror/addon/hint/show-hint.js' ), true );
			wp_enqueue_script( 'codemirror-css-hint', $this->url . 'assets/vendor/codemirror/addon/hint/css-hint.js', array( 'codemirror' ), filemtime( $this->dir . 'assets/vendor/codemirror/addon/hint/css-hint.js' ), true );
			wp_enqueue_script( 'codemirror-mode-css', $this->url . 'assets/vendor/codemirror/mode/css/css.js', array( 'codemirror' ), filemtime( $this->dir . 'assets/vendor/codemirror/mode/css/css.js' ), true );
			wp_enqueue_script( 'options-customnextpage', $this->url . 'assets/admin/js/options.js', array( 'jquery' ), filemtime( $this->dir . 'assets/admin/js/options.js' ), true );

			wp_localize_script(
				'options-customnextpage',
				'resetCss',
				array(
					'url'      => admin_url( 'admin-ajax.php' ),
					'security' => wp_create_nonce( 'reset-css' ),
				)
			);
		}
	}


}
