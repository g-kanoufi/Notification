<?php
/**
 * Media updated trigger
 *
 * @package notification
 */

namespace underDEV\Notification\Defaults\Trigger\Media;

use underDEV\Notification\Defaults\MergeTag;
use underDEV\Notification\Abstracts;

/**
 * Media added trigger class
 */
class MediaUpdated extends Abstracts\Trigger {

	/**
	 * Constructor
	 */
	public function __construct() {

		parent::__construct( 'wordpress/media_updated', 'Media updated' );

		$this->add_action( 'attachment_updated', 10, 2 );
		$this->set_group( 'Media' );
		$this->set_description( 'Fires when new attachment is updated' );

	}

	/**
	 * Assigns action callback args to object
	 *
	 * @return void
	 */
	public function action() {

		$this->attachment = get_post( $this->callback_args[0] );
		$this->updating_user = get_current_user_id();

	}

	/**
	 * Registers attached merge tags
	 *
	 * @return void
	 */
	public function merge_tags() {

		$this->add_merge_tag( new MergeTag\Media\AttachmentID( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentPage( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentTitle( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentDate( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentMimeType( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentDirectUrl( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentAuthorID( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentAuthorName( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentAuthorEmail( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentAuthorLogin( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentUpdatingUserID( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentUpdatingUserName( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentUpdatingUserEmail( $this ) );
		$this->add_merge_tag( new MergeTag\Media\AttachmentUpdatingUserLogin( $this ) );


    }

}
