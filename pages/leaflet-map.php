<?php

$mapId = $_GET[ 'id' ];
$mapTilesPath = $_SERVER[ 'DOCUMENT_ROOT' ] . '/content/plans/' . $mapId;
$fullSizeMapPath = $mapTilesPath . '/original';
if ( file_exists( $fullSizeMapPath . '.png' ) )
	$fullSizeMapPath = $fullSizeMapPath . '.png';
else if ( file_exists( $fullSizeMapPath . '.jpg' ) )
	$fullSizeMapPath = $fullSizeMapPath . '.jpg';
[ $imageWidth, $imageHeight ] = getimagesize( $fullSizeMapPath );

$imageVersion = filemtime( $fullSizeMapPath );

$readableMapName = implode( ' ', explode( '-', $mapId ) );

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">


	<title><?= $readableMapName ?> | INDIS</title>

	<style type="text/css">

		*:before,
		*,
		*:after {
			margin: 0;
			padding: 0;
		}

		.map {
			height: 100vh;
		}

		.icon {
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-image: url( "/media/leaflet/full-screen.svg" );
			background-repeat: no-repeat;
			background-position: center center;
		}
		.fit-to-view {
			background-image: url( "/media/leaflet/full-screen.svg" );
		}
		.launch {
			background-image: url( "/media/leaflet/launch.svg" );
		}

		/*
		 * The zoom tooltip
		 */
		.zoom-tooltip:before {
			content: '';
			display: block;
			position: absolute;
			z-index: 9998;
			bottom: 72px;
			right: 10px;
			background: transparent;
			width: 26px;
			height: 53px;
			border-radius: 4px;
			box-shadow: 0 0 300px 200px rgba(192, 52, 60, .25), 0 0 100px 50px rgba(192, 52, 60, .25);
			pointer-events: none;
		}
		.zoom-tooltip:after {
			content: '';
			display: block;
			position: absolute;
			z-index: 9999;
			bottom: 98px;
			right: 36px;
			width: 180px;
			height: 120px;
			pointer-events: none;
			transform: translate(50%, 50%);
			background-image: url( '/media/icon/zoom-tooltip.svg' );
			background-repeat: no-repeat;
			background-size: 180px 120px;
			background-position: center center;
		}

		/* -- Exception for touch supported buttons -- */
		/* -- Exception for firefox because leaflet thinks it's touch supported -- */
		@supports (-webkit-touch-callout: none) or (-moz-appearance:none) {
			.zoom-tooltip:before {
				bottom: 84px;
				right: 10px;
				width: 34px;
				height: 65px;
			}

			.zoom-tooltip:after {
				bottom: 117px;
				right: 44px;
				transform: translate(50%, 50%) scale(1.25);
			}
		}


		/*
		 * The zoom tooltip Embeded
		 */
		.zoom-tooltip.embeded:before {
			bottom: 98px;
		}
		.zoom-tooltip.embeded:after {
			bottom: 124px;
		}
		@supports (-webkit-touch-callout: none) or (-moz-appearance:none) {
			.zoom-tooltip.embeded:before {
				bottom: 114px;
			}

			.zoom-tooltip.embeded:after {
				bottom: 147px;
		}


	</style>
	<link rel="stylesheet" type="text/css" href="/plugins/leaflet/leaflet-v1.6.css">
	<link rel="stylesheet" type="text/css" href="/plugins/leaflet/leaflet-easybutton-v2.4.0.css">

</head>
<body>

	<div id="map" class="map"></div>

	<script type="text/javascript" src="/plugins/leaflet/leaflet-v1.6.js"></script>
	<script type="text/javascript" src="/plugins/leaflet/leaflet-rastercoords-v1.0.3.js"></script>
	<script type="text/javascript" src="/plugins/leaflet/leaflet-easybutton-v2.4.0.js"></script>
	<script type="text/javascript">

		// Create the map
		var map = L.map( "map", {
			zoomDelta: 0.5,
			zoomSnap: 0,
			animate: true,
			inertia: true,
			zoomControl: false,
			scrollWheelZoom: false,
			attributionControl: false
		} );

		var imageDimensions = [ <?= $imageWidth ?>, <?= $imageHeight ?> ];
		var rasterCoordinates = new L.RasterCoords( map, imageDimensions )

		map.setMaxZoom( rasterCoordinates.zoomLevel() )

		map.setView( rasterCoordinates.unproject( imageDimensions ), 0 );

		var layer = L.tileLayer( "<?= '/content/plans/' . $mapId ?>/{z}/{x}/{y}.png?v=<?= $imageVersion ?>", { noWrap: true } )

		layer.addTo( map );

		// Get the coordinates of the bounds of the image
		var topLeftCoordinates = L.latLng( rasterCoordinates.unproject( [ 0, 0 ] ) );
		var bottomRightCoordinates = L.latLng( rasterCoordinates.unproject( imageDimensions ) );
		var imageBoundCoordinates = L.latLngBounds( topLeftCoordinates, bottomRightCoordinates );

		var additionalControls = [ ];

		var fitToViewportControl = L.easyButton( "<span class=\"icon fit-to-view\"></span>", function ( control, map ) {
			// Get the zoom level at which the map (image) fits the map container
			map.setZoom( map.getBoundsZoom( imageBoundCoordinates ) );
			// Hide the overlay on the parent page once the map is interacted with
			hideZoomTooltipOverlay();
		}, "Reset View" );
		additionalControls.push( fitToViewportControl );

		// Open the leaflet widget on a new tab
		if ( window.parent.location !== window.location ) {
			var launchInNewWindowControl = L.easyButton( "<span class=\"icon launch\"></span>", function ( control, map ) {
				window.open( "<?= $_SERVER[ 'REQUEST_URI' ] ?>", "<?= $readableMapName ?> | INDIS" );
				// Hide the overlay on the parent page once the map is interacted with
				hideZoomTooltipOverlay();
			}, "Open in new tab" );
			additionalControls.push( launchInNewWindowControl );
		}
		L.easyBar( additionalControls, { position: "bottomright" } ).addTo( map );
		L.control.zoom( { position: "bottomright" } ).addTo( map );


		// Set the initial view and zoom of the map (image)
		setTimeout( function () {
			map.setView( rasterCoordinates.unproject( imageDimensions ), map.getBoundsZoom( imageBoundCoordinates ) )
		}, 1500 );

		// Redo the fit-to-view whenever the map container resizes
		map.on( "resize", function ( event ) {
			setTimeout( function () {
				map.setZoom( map.getBoundsZoom( imageBoundCoordinates ) );
			}, 1000 );
		} );


		/*
		 *
		 * The Zoom Tool-tip Overlay
		 *
		 * This shows up initially but goes away once the map is interacted with
		 *
		 */
		var overlayIsHidden = false;
		function hideZoomTooltipOverlay () {
			if ( overlayIsHidden )
				return;

			document.getElementById( "map" ).classList.remove( "zoom-tooltip" );
			overlayIsHidden = true;
		}

		// Add the zoom tooltip overlay, once the initial to zoom to viewport is done
		map.once( "zoomend", function () {
			document.getElementById( "map" ).classList.add( "zoom-tooltip" );
		} );

		// Hide the overlay on the parent page once the map is interacted with
		map.once( "click", function () {
			hideZoomTooltipOverlay();
		} );
		// Hide the overlay on the parent page once the map is interacted with
		map.once( "zoomstart", function () {
			map.once( "zoomstart", function () {
				hideZoomTooltipOverlay();
			} );
		} );

	</script>

</body>
</html>
