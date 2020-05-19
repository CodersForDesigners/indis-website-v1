
/*
 *
 * Wait for the specified number of seconds.
 * This facilitates a Promise or syncrhonous (i.e., using async/await ) style
 * 	of programming
 *
 */
function waitFor ( seconds ) {
	return new Promise( function ( resolve, reject ) {
		setTimeout( function () {
			resolve();
		}, seconds * 1000 );
	} );
}



/*
 *
 * Recur a given function every given interval
 *
 */
function executeEvery ( interval, fn ) {

	interval = ( interval || 1 ) * 1000;

	var timeoutId;
	var running = false;

	return {
		_schedule: function () {
			var _this = this;
			timeoutId = setTimeout( function () {
				window.requestAnimationFrame( function () {
					fn();
					_this._schedule()
				} );
			}, interval );
		},
		start: function () {
			if ( running )
				return;
			running = true;
			this._schedule();
		},
		stop: function () {
			clearTimeout( timeoutId );
			timeoutId = null;
			running = false;
		}
	}

}



/*
 *
 * Returns a debounced function that eventually performs a given function
 *
 */
function eventually ( fn, timeout ) {

	var timeout = ( timeout || 1 ) * 1000;
	var timeoutId = null;
	var emptyFunction = function () {};
	var rejectPromise = emptyFunction;

	return function ( event ) {

		rejectPromise();
		clearTimeout( timeoutId );

		return new Promise( function ( resolve, reject ) {
			timeoutId = setTimeout( resolve, timeout );
			rejectPromise = reject;
		} )
			.then( fn )
			.catch( emptyFunction )

	};

}



/*
 * ------------------------\
 *  Form helpers
 * ------------------------|
 */
// Disable the form
function disableForm ( $form, message ) {
	$form.find( "input, select, button" ).prop( "disabled", true );
	if ( message ) {
		var $feedback = $form.find( "[ type = 'submit' ]" );
		$feedback.data( "default", $feedback.text() );
		$feedback.text( message );
	}
}
// Enable the form
function enableForm ( $form, message ) {
	$form.find( "input, select, button" ).prop( "disabled", false );
	var $feedback = $form.find( "[ type = 'submit' ]" );
	if ( message )
		$feedback.text( message );
	else if ( $feedback.data( "default" ) )
		$feedback.text( $feedback.data( "default" ) );
}
