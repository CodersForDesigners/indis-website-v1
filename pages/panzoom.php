<?php

$panZoom = $_GET[ 'id' ];

?><!DOCTYPE html>
<html xml:lang="EN" xmlns="http://www.w3.org/1999/xhtml" lang="en">

	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<style type="text/css">

			.allow-pointer-events {
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

		</style>

	</head>

	<body>

		<div id="container"></div>


		<script type="text/javascript" src="/plugins/zoomify/zoomify-image-viewer-enterprise.v5.23.5.min.js"></script>
		<script type="text/javascript">

			function disablePointerEvents ( domElement ) {
				domElement.className = domElement.className
					.replace( /\s*allow-pointer-events\s*/, "" )
					.trim();
			}

			function addPointerEventsEventually ( domElement, timeout ) {

				var timeout = ( timeout || 1 ) * 1000;
				var timeoutId = null;

				return function addPointerEvents ( event ) {

					if ( timeoutId ) {
						clearTimeout( timeoutId );
						timeoutId = null;
					}

					return new Promise( function ( resolve, reject ) {
						timeoutId = setTimeout( resolve, timeout );
					} )
						.then( function () {
							domElement.className = ( domElement.className + " " + "allow-pointer-events" ).trim();
						} );

				};

			};

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
				zNavigatorRectangleColor: "000000",

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

				zOnReady: function () {
					var domContainer = document.getElementById( "container" );
					var domTransparentOverlay = document.createElement( "div" );
					domTransparentOverlay.className = "transparent-overlay allow-pointer-events";
					// domTransparentOverlay.className = "transparent-overlay";
					domTransparentOverlay.tabIndex = 0;
					domContainer.prepend( domTransparentOverlay );

					var overlay__removePointerEventsEventually = removePointerEventsEventually( domTransparentOverlay );
					var overlay__addPointerEventsEventually = addPointerEventsEventually( domTransparentOverlay, 1 );
					var pointerEventsAreEnabled = false;


					/*
					 *
					 * Make overlay "opaque" only for scroll and wheel events
					 *
					 */
					function preventPointerInteractionsHandler ( event ) {
						event.preventDefault();
						event.stopImmediatePropagation();
						event.stopPropagation();

						// Disable pointer events
						disablePointerEvents( domTransparentOverlay );

						domContainer.blur();
						window.focus();

						// Enable pointer events (eventually)
						overlay__addPointerEventsEventually( event );

						return false;
					}
					// Set the event handlers
					domContainer.onwheel = preventPointerInteractionsHandler;
					domContainer.onmousewheel = preventPointerInteractionsHandler;
					domContainer.onscroll = preventPointerInteractionsHandler;
				}
			};
			Z.showImage( "container", "media/plans/<?= $panZoom ?>", settings );
		</script>

	</body>

</html>
