




		<!-- ~/~/~/~/~/~/~/~/~/~/~/~/~/~/~/~/ -->
		<!-- Page-specific content goes here. -->
		<!-- ~/~/~/~/~/~/~/~/~/~/~/~/~/~/~/~/ -->

	</div> <!-- END : Page Content -->

	<script type="text/javascript">

		/*
		 * This function returns a version of the function that you provide
		 * 	that runs only for the first time, regardless of how many times
		 * 	it is called.
		 */
		function runFunctionOnlyOnce ( fn ) {
			var calledAtleastOnce = false;
			return function ( event ) {
				if ( calledAtleastOnce )
					return;
				calledAtleastOnce = true;
				fn( event );
			}
		}

		/*
		 * Report a status of "ready" back to the parent page
		 */
		var reportStatusOfReady = runFunctionOnlyOnce( function ( event ) {
			setTimeout( function () {
				window.parent.postMessage( {
					status: "ready"
				}, location.origin );
			}, 1000 );
		} );

		/*
		 * Attach the `reportStatusOfReady` to a bunch of DOM-ready related
		 * 	events.
		 */
		document.onreadystatechange = function () {
			if ( document.readyState == "interactive" )
				reportStatusOfReady();
		};
		window.DOMContentLoaded = reportStatusOfReady;
		window.onload = reportStatusOfReady;

	</script>

</body>
</html>
