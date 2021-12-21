<?php
/**
 * Plugin Name:     Custom Nextpage
 * Plugin URI: http://wordpress.org/plugins/custom-nextpage/
 * Description: MultiPage is a customizable plugin. Can any title on the page.
 * Author:          Webnist
 * Author URI:      http://profiles.wordpress.org/webnist
 * Text Domain:     custom-nextpage
 * Domain Path:     /languages
 * Version:         1.2
 * License:         GPLv2 or later
 */

namespace CustomNextpage;

class CustomNextpage_Init {

	public function __construct() {
		$this->basename    = plugin_basename( __FILE__ );
		$this->plugin_name = dirname( $this->basename );
		$this->dir         = plugin_dir_path( __FILE__ );
		$this->url         = plugin_dir_url( __FILE__ );
		$headers           = array(
			'name'        => 'Plugin Name',
			'version'     => 'Version',
			'domain'      => 'Text Domain',
			'domain_path' => 'Domain Path',
		);
		$data              = get_file_data( __FILE__, $headers );
		$this->name        = $data['name'];
		$this->version     = $data['version'];
		$this->domain      = $data['domain'];
		$this->domain_path = $data['domain_path'];

	}

}
new CustomNextpage_Set();
class CustomNextpage_Set extends CustomNextpage_Init {

	public function __construct() {
		parent::__construct();
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_action( 'init', array( $this, 'load_textdomain' ) );
	}

	public function plugins_loaded() {

		require_once $this->dir . 'admin/class-admin-menu.php';
		require_once $this->dir . 'admin/class-admin-editor.php';
		require_once $this->dir . 'admin/wp-admin-enqueue-scripts.php';
		require_once $this->dir . 'includes/wp-add-shortcode.php';
		require_once $this->dir . 'includes/ncp-next-page-options.php';

		if ( ! is_admin() ) {
			require_once $this->dir . 'includes/wp-enqueue-scripts.php';
			require_once $this->dir . 'includes/ncp-next-page-link-pages.php';
			require_once $this->dir . 'includes/ncp-next-page-title.php';
			require_once $this->dir . 'includes/wp-the-posts.php';
			require_once $this->dir . 'includes/wp-link-pages.php';
		}
	}

	public function load_textdomain() {
		load_plugin_textdomain( $this->domain, false, $this->plugin_name . $this->domain_path );
	}

}
