
( function () {

/*
 *
 * Pop Project Tiles as they come **fully** into view
 *
 */
	// This is an Intersection Observer handler; not gonna explain the mechanics of this
	function inViewHandler ( entries, observer ) {
		var _i;
		var numEntries = entries.length;
		for ( _i = 0; _i < numEntries; _i += 1 ) {
			var entry = entries[ _i ];
			var $element = $( entry.target );
			// If it comes into view
			if ( ! $element.data( "previous__isIntersecting" ) && entry.isIntersecting ) {
				$element.addClass( "in-view" );
			}
			// Else if it leaves the viewport
			else if ( $element.data( "previous__isIntersecting" ) && ! entry.isIntersecting ) {
				$element.removeClass( "in-view" );
			}
			$element.data( "previous__isIntersecting", entry.isIntersecting );
		}
	}

	// Set up the Intersection Observer
	var observer = new IntersectionObserver( inViewHandler, {
		root: null,
		rootMargin: "0px",
		threshold: 1
	} );

	$( ".js_project_item" ).each( function ( _i, domProject ) {
		// Set the default `isIntersecting` values for all the project tiles
		$( domProject ).data( "previous__isIntersecting", false );
		// Start "IntersectionObserve"-ing the project tiles
		observer.observe( domProject );
	} );

}() );
