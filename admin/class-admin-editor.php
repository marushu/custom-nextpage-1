<?php
namespace CustomNextpage;

new CustomNextpage_Editor();
class CustomNextpage_Editor extends CustomNextpage_Init {
	public function __construct() {
		parent::__construct();

		if ( is_admin() ) {
			global $wp_version;
			add_action( 'admin_print_scripts-post.php', array( &$this, 'admin_print_scripts' ), 999 );
			add_action( 'admin_print_scripts-post-new.php', array( &$this, 'admin_print_scripts' ), 999 );
			add_filter( 'tiny_mce_version', array( &$this, 'tiny_mce_version' ) );
			add_filter( 'mce_external_plugins', array( &$this, 'mce_external_plugins' ) );
			add_filter( 'mce_buttons_3', array( &$this, 'mce_buttons_3' ) );
			add_filter( 'mce_external_languages', array( &$this, 'mce_external_languages' ) );
			if ( version_compare( $wp_version, '3.9', '<' ) ) {
				add_action( 'admin_footer', array( &$this, 'editor_dialog' ) );
			}
			add_action( 'admin_enqueue_scripts', array( &$this, 'quicktags' ) );
		}
	}

	// Admin
	function admin_print_scripts() {
		wp_enqueue_style( 'admin-customnextpage', $this->url . 'assets/admin/css/admin-customnextpage.css', array(), filemtime( $this->dir . 'assets/admin/css/admin-customnextpage.css' ) );
	}

	function mce_external_languages( $locales ) {
		$locales['customnextpage'] = $this->dir . '/admin/tinymce/plugins/customnextpage/langs/langs.php';
		return $locales;
	}

	function mce_buttons_3( $buttons ) {
		array_push( $buttons, 'customnextpage' );
		return $buttons;
	}
	function mce_external_plugins( $plugin_array ) {
		global $wp_version;
		if ( version_compare( $wp_version, '3.9', '>=' ) ) {
			$plugin_array['customnextpage'] = $this->url . 'admin/tinymce/plugins/customnextpage/plugin.js';
		} else {
			$plugin_array['customnextpage'] = $this->url . 'admin/tinymce/plugins/customnextpage/editor_plugin.js';
		}
		return $plugin_array;
	}
	function tiny_mce_version( $version ) {
		return ++$version;
	}
	function editor_dialog() { ?>
		<div style="display:none;">
			<form id="customnextpage-dialog">
				<div id="customnextpage-selector">
					<div id="customnextpage-options">
						<div>
							<label><span><?php _e( 'Title:', 'custom-nextpage' ); ?></span><input id="customnextpage-title-field" type="text" name="title" /></label>
						</div>
					</div>
				</div>
				<div class="submitbox">
					<div id="customnextpage-update">
						<input type="submit" value="<?php esc_attr_e( 'OK', 'custom-nextpage' ); ?>" class="button-primary" id="customnextpage-submit">
					</div>
					<div id="customnextpage-cancel">
						<input type="button" value="<?php _e( 'Cancel', 'custom-nextpage' ); ?>" class="button tagadd" id="customnextpage-submit">
					</div>
				</div>
			</form>
		</div>
		<?php
	}

	/**
	 * Add more buttons to the html editor.
     * This script is not loaded in the case of the block editor.
     *
     * @see https://developer.wordpress.org/reference/functions/has_blocks/
     * @see https://developer.wordpress.org/reference/functions/has_block/
     * @see /wp-includes/js/dist/block-library.js: 26308
	 */
	function quicktags() {
		if ( ! wp_script_is( 'custom-nextpage-quicktags' ) && ! has_blocks() && ! has_block( 'core/freeform' ) ) {
			wp_enqueue_script( 'custom-nextpage-quicktags', $this->url . 'assets/admin/js/quicktags.js', array( 'quicktags' ), filemtime( $this->dir . 'assets/admin/js/quicktags.js' ), true );
			?>
			<script type="text/javascript">
				QTags.addButton( 'custom_nextpage', 'Custom Nextpage', '[nextpage]', '', '', 'Custom Nextpage', 9999 );
			</script>
			<?php
		}
	}
}
