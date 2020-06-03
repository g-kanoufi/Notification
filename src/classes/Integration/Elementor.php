<?php
/**
 * Elementor integration class
 *
 * @package notification
 */

namespace BracketSpace\Notification\Integration;

/**
 * Elementor integration
 */
class Elementor {

	/**
	 * Checks if posts was edited with elementor
	 *
	 * @filter notification/integration/gutenberg
	 *
	 * @param boolean     $bool If Gutenberg integration.
	 * @param string      $post_type Post type.
	 * @param   Triggerable $trigger  Trigger object.
	 *
	 * @return  boolean
	 */
	public static function check_post( $bool, $post_type, $trigger ) {

		if ( class_exists( '\Elementor\Plugin' ) && ( \Elementor\Plugin::$instance->db->is_built_with_elementor( $trigger->post->ID ) ) ) {
			return false;
		}

		return true;
	}
}
