<?php
/**
 * WordPress integration class
 *
 * @package notification
 */

namespace BracketSpace\Notification\Integration;

/**
 * WordPress integration class
 */
class WordPress {

	/**
	 * Filters default Email From Name
	 *
	 * @filter wp_mail_from_name 1000
	 *
	 * @since  5.2.2
	 * @param  string $from_name Default From Name.
	 * @return string
	 */
	public function filter_email_from_name( $from_name ) {

		$setting = notification_get_setting( 'notifications/email/from_name' );

		return empty( $setting ) ? $from_name : $setting;

	}

	/**
	 * Filters default Email From Email
	 *
	 * @filter wp_mail_from 1000
	 *
	 * @since  5.2.2
	 * @param  string $from_email Default From Email.
	 * @return string
	 */
	public function filter_email_from_email( $from_email ) {

		$setting = notification_get_setting( 'notifications/email/from_email' );

		return empty( $setting ) ? $from_email : $setting;

	}

	/**
	 * Proxies the wp_insert_comment action to check
	 * if comment is a reply.
	 *
	 * @action wp_insert_comment
	 *
	 * @since [Next]
	 * @param integer $comment_id Comment ID.
	 * @param object  $comment    Comment object.
	 * @return void
	 */
	public function proxy_comment_reply( $comment_id, $comment ) {
		$status = '1' === $comment->comment_approved ? 'approved' : 'unapproved';
		do_action( 'notification_insert_comment_proxy', $status, 'insert', $comment );
	}

}
