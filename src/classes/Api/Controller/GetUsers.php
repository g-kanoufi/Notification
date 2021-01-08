<?php
/**
 * Get Users class
 *
 * @package notification
 */

namespace BracketSpace\Notification\Api\Controller;

/**
 * GetUsers class
 *
 * @action
 */
class GetUsers {

	/**
	 * Sends response
	 *
	 * @since 7.0.0
	 * @param \WP_REST_Request $request WP request instance.
	 * @return void
	 */
	public function send_response() {

		$query = $_GET['query'];
		$limit = $_GET['limit'];

		$users = get_users( array(
			'number'         => $limit,
			'search'         => '*'.esc_attr( $query ).'*',
			'search_columns' => array(
				'user_email',
			),
		) );

		if ( $users ) {
			$results = [];
			foreach ( $users as $user ) {
				$results[] = $user->data;
			}
			notification_ajax_handler()->send( $results );
		} else {
			notification_ajax_handler()->send( [ 'message' => 'no users' ] );
		}

	}

}
