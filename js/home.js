
( function () {

	function inViewHandler ( entries, observer ) {
		entries.forEach( function ( entry ) {
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
		} );
	}

	var observer = new IntersectionObserver( inViewHandler, {
		root: null,
		rootMargin: "0px",
		threshold: 1
	} );

	$( ".js_project_item" ).each( function ( _i, domProject ) {
		$( domProject ).data( "previous__isIntersecting", false );
		observer.observe( domProject );
	} );

}() );
