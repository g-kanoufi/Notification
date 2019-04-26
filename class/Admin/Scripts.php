<?php
/**
 * Enqueues admin scripts
 *
 * @package notification
 */

namespace BracketSpace\Notification\Admin;

use BracketSpace\Notification\Utils\Files;

/**
 * Scripts class
 */
class Scripts {

	/**
	 * Files class
	 *
	 * @var object
	 */
	private $files;

	/**
	 * Runtime class
	 *
	 * @var object
	 */
	private $runtime;

	/**
	 * Scripts constructor
	 *
	 * @since 5.0.0
	 * @param object $runtime Plugin Runtime class.
	 * @param Files  $files   Files class.
	 */
	public function __construct( $runtime, Files $files ) {
		$this->files   = $files;
		$this->runtime = $runtime;
	}

	/**
	 * Enqueue scripts and styles for admin
	 *
	 * @action admin_enqueue_scripts
	 *
	 * @param  string $page_hook current page hook.
	 * @return void
	 */
	public function enqueue_scripts( $page_hook ) {

		$allowed_hooks = apply_filters( 'notification/scripts/allowed_hooks', [
			$this->runtime->admin_extensions->page_hook,
			$this->runtime->core_settings->page_hook,
			$this->runtime->admin_share->page_hook,
			$this->runtime->admin_wizard->page_hook,
			'plugins.php',
			'post-new.php',
			'post.php',
		] );

		if ( 'notification' !== get_post_type() && ! in_array( $page_hook, $allowed_hooks, true ) ) {
			return;
		}

		wp_enqueue_script( 'notification', $this->files->asset_url( 'js', 'scripts.min.js' ), [ 'jquery', 'wp-color-picker' ], $this->files->asset_mtime( 'js', 'scripts.min.js' ), false );

		wp_enqueue_style( 'notification', $this->files->asset_url( 'css', 'style.css' ), [], $this->files->asset_mtime( 'css', 'style.css' ) );

		wp_localize_script( 'notification', 'notification', [
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'i18n'    => [
				'copied'              => __( 'Copied', 'notification' ),
				'remove_confirmation' => __( 'Do you really want to delete this?', 'notification' ),
				'select_image'        => __( 'Select image', 'notification' ),
				'use_selected_image'  => __( 'Use selected image', 'notification' ),
				'valid_json_only'     => __( 'Please upload only valid JSON files', 'notification' ),
				'importing_data'      => __( 'Importing data...', 'notification' ),
				'synchronizing'       => __( 'Synchronizing...', 'notification' ),
				'synchronized'        => __( 'Synchronized', 'notification' ),
			],
		] );

		// Remove TinyMCE styles as they are not applied to any frontend content.
		remove_editor_styles();

		do_action( 'notification/scripts', $page_hook );

	}

}
