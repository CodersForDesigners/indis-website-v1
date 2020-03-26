<script type="text/javascript">

	/*
	 *
	 * Add a resize handler (if not already added) that solves a bug that occurs when switching
	 *	from landscape to portrait mode on iOS
	 *
	 */
	( function conditionallyAddResizeHandler () {

		if ( ! /AppleWebKit/.test( navigator.userAgent ) || ! /Mobile\/\w+/.test( navigator.userAgent ) )
			return;

		// If the page is **not** being loaded within an iframe, nothing has to be done
		var pageIsInAnIframe = false;
		try {
			pageIsInAnIframe = ( window.self !== window.top );
		}
		catch ( e ) {
			pageIsInAnIframe = true;
		}
		if ( ! pageIsInAnIframe )
			return;

		var onResize = function ( async ) {
			[ 0, 250, 1000, 2000 ].forEach( function ( delay ) {
				setTimeout( function () {
					var viewer = document.querySelector( "#viewer" );
					var scale = window.innerWidth / document.documentElement.clientWidth;
					var width = document.documentElement.clientWidth;
					var height = Math.round( window.innerHeight / scale );
					viewer.style.width = width + "px";
					viewer.style.height = height + "px";
					viewer.style.left = Math.round( ( window.innerWidth - width ) * 0.5 ) + "px";
					viewer.style.top = Math.round( ( window.innerHeight - height ) * 0.5 ) + "px";
					viewer.style.transform = "scale(" + scale + ", " + scale + ")";
					window.scrollTo( 0, 0 );
				}, delay );
			} );
		};
		window.addEventListener( "resize", onResize );
		onResize();

	}() );

</script>
