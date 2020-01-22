<?php

$panZoom = $_GET[ 'id' ];
$navigatorZoomRectangle = $_GET[ 'navigatorZoomRectangle' ] ?? '000000';

?><!DOCTYPE html>
<html xml:lang="EN" xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<style type="text/css">

			.allow-pointer-events {
				pointer-events: auto;
			}

			.disable-pointer-events {
				pointer-events: none;
			}

			/* An overlay that prevents pointer events */
			.transparent-overlay {
				content: "";
				position: fixed;
				top: -25vh;
				right: -25vw;
				bottom: -25vh;
				left: -25vw;
				z-index: 1;
				background-color: transparent;
			}

			*:before,
			*,
			*:after {
				margin: 0;
				padding: 0;
			}

			html, body {
				height: 100%;
				width: 100%;
				margin: 0;
			}

			#container {
				width: 100%;
				height: 100%;
			}

			/* Hide the Full-screen button on mobile */
			@media ( max-width: 640px ) {
				#buttonFullView {
					display: none !important;
				}
			}

		</style>

	</head>

	<body>

		<div id="container"></div>


		<script type="text/javascript" src="/js/modules/utils.js"></script>
		<script type="text/javascript" src="/plugins/zoomify/zoomify-image-viewer-enterprise.v5.23.5.min.js"></script>
		<script type="text/javascript">

			/*
			 *
			 * Disable pointer events on an element
			 *
			 */
			function disablePointerEvents ( domElement ) {
				domElement.className = domElement.className
					.replace( /\s*allow-pointer-events\s*/, "" )
					.trim();
			}

			var settings = {
				// zDebug: 3,

				// Path to resources
				zSkinPath: "media/zoomify/Skins/Default",

				zProgressVisible: 1,

				zAutoResize: 1,
				// Extend the widget to the boundaries of the viewport
				zInitialFullPage: 0,
				// Enable the option to go full-screen
				zFullPageVisible: 0,
				zFullScreenVisible: 1,
				zInitialZoom: "fill",

				// zMinZoom: 15,
				zNavigatorVisible: 1,
				zNavigatorRectangleColor: "<?= $navigatorZoomRectangle ?>",

				// Toolbar
				zToolbarVisible: 1,
				zTooltipsVisible: 0,
				zResetVisible: 1,
				zHelpVisible: 0,
				zLogoVisible: 0,
				zMinimizeVisible: 0,
				zSliderVisible: 1,
				zPanButtonsVisible: 0,
				zToolbarBackgroundVisible: 0,

				// Interactive capabilities
				zZoomRectangle: 1,	// alt-click-drag to zoom to a selected region
				zSmoothPan: 1,
				zSmoothPanEasing: 5,
				zSmoothPanGlide: 0,
				zConstrainPan: 3,	// strict
				zPanSpeed: 5,
				zSmoothZoom: 1,
				zSmoothZoomEasing: 4,
				zZoomSpeed: 2,

				// Events
				zMouseWheel: 0,	// Prevent scroll events from being swallowed
				zMousePan: 0,
				zClickPan: 0,

				zOnReady: function () {

				// 	// Inject an overlay on top of the map
				// 	var domContainer = document.getElementById( "container" );
				// 	var domTransparentOverlay = document.createElement( "div" );
				// 	domTransparentOverlay.className = "transparent-overlay";
				// 	domTransparentOverlay.tabIndex = 0;
				// 	domContainer.prepend( domTransparentOverlay );

				// 	// Create a debounced function that eventually allows pointer events
				// 	var addPointerEventsEventually = eventually( function () {
				// 		domTransparentOverlay.className = ( domTransparentOverlay.className + " " + "allow-pointer-events" ).trim();
				// 	}, 1 );

				// 	/*
				// 	 *
				// 	 * Make overlay "opaque" only for scroll and wheel events
				// 	 *
				// 	 */
				// 	function preventPointerInteractionsHandler ( event ) {
				// 		event.preventDefault();
				// 		event.stopImmediatePropagation();
				// 		event.stopPropagation();

				// 		// Disable pointer events
				// 		disablePointerEvents( domTransparentOverlay );

				// 		domContainer.blur();
				// 		window.focus();

				// 		// Enable pointer events (eventually)
				// 		addPointerEventsEventually( event );

				// 		return false;
				// 	}
				// 	// Set the event handlers
				// 	domContainer.onwheel = preventPointerInteractionsHandler;
				// 	domContainer.onmousewheel = preventPointerInteractionsHandler;
				// 	domContainer.onscroll = preventPointerInteractionsHandler;

				// 	// Disable the default "mousewheel" event that is set on the ViewerDisplay element
				// 	Z.Utils.removeEventListener( Z.ViewerDisplay, "mousewheel", Z.Viewer.viewerEventsHandler );


					/*
					 *
					 * Disable pointer events on the ViewerDisplay once the boundaries have been reached from all that panning
					 *
					 */
					// Create a debounced function that eventually allows pointer events
					var allowPointerEventsEventually = eventually( function () {
						Z.ViewerDisplay.className = Z.ViewerDisplay.className
							.replace( /\s*disable-pointer-events\s*/, "" )
							.trim();
					}, 0.5 );

					var previousViewportY = Math.round( Z.Viewport.getY() );
					Z.setCallback( "viewPanned", function () {
						var currentViewportY = Math.round( Z.Viewport.getY() );
						if ( previousViewportY === currentViewportY ) {
							Z.ViewerDisplay.classList.add( "disable-pointer-events" );
							allowPointerEventsEventually();
						}
						previousViewportY = currentViewportY;
					} );

				}
			};
			Z.showImage( "container", "media/plans/<?= $panZoom ?>", settings );
		</script>

	</body>

</html>
