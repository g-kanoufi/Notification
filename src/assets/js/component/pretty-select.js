/* eslint no-alert: 0 */
/* global notification, jQuery */
( function( $ ) {
	$( document ).ready( function() {
		$( '.notification-pretty-select:visible' ).selectize();

		notification.hooks.addAction( 'notification.carrier.recipients.recipient.replaced', function( $input ) {
			if ( $input.hasClass( 'notification-pretty-select' ) ) {
				const selectized = $input.selectize();

				if ( ! selectized[ 1 ] ) {
					return;
				}

				if ( selectized[ 1 ].classList.contains( 'description' ) ) {
					const parent = selectized[ 0 ].parentNode;
					const clonedField = parent.querySelector( '.selectize-control.description' );
					selectized[ 1 ].style.display = 'block';
					clonedField.style.display = 'none';
				}
			}
		} );

		notification.hooks.addAction( 'notification.repeater.row.added', function( $row ) {
			$row.find( 'select.notification-pretty-select' ).each( function() {
				$( this ).selectize();
			} );
		} );
	} );
}( jQuery ) );