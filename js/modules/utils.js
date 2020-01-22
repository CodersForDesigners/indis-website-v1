
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
 * Returns a debounced function that eventually performs a given function
 *
 */
function eventually ( fn, timeout ) {

	var timeout = ( timeout || 1 ) * 1000;
	var timeoutId = null;

	return function ( event ) {

		clearTimeout( timeoutId );

		return new Promise( function ( resolve, reject ) {
			timeoutId = setTimeout( resolve, timeout );
		} )
			.then( fn )

	};

}
