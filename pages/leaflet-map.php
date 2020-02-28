<?php

$mapId = $_GET[ 'id' ];
$mapTilesPath = $_SERVER[ 'DOCUMENT_ROOT' ] . '/content/plans/' . $mapId;
$fullSizeMapPath = $mapTilesPath . '/original';
if ( file_exists( $fullSizeMapPath . '.png' ) )
	$fullSizeMapPath = $fullSizeMapPath . '.png';
else if ( file_exists( $fullSizeMapPath . '.jpg' ) )
	$fullSizeMapPath = $fullSizeMapPath . '.jpg';
[ $imageWidth, $imageHeight ] = getimagesize( $fullSizeMapPath );

$readableMapName = implode( ' ', explode( '-', $mapId ) );

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">


	<title><?= $readableMapName ?> | Indis</title>

	<style type="text/css">

		*:before,
		*,
		*:after {
			margin: 0;
			padding: 0;
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

		var layer = L.tileLayer( "<?= '/content/plans/' . $mapId ?>/{z}/{x}/{y}.png", { noWrap: true } )

		layer.addTo( map );

		// Get the coordinates of the bounds of the image
		var topLeftCoordinates = L.latLng( rasterCoordinates.unproject( [ 0, 0 ] ) );
		var bottomRightCoordinates = L.latLng( rasterCoordinates.unproject( imageDimensions ) );
		var imageBoundCoordinates = L.latLngBounds( topLeftCoordinates, bottomRightCoordinates );

		var additionalControls = [ ];

		var fitToViewportControl = L.easyButton( "<span class=\"icon fit-to-view\"></span>", function ( control, map ) {
			// Get the zoom level at which the map (image) fits the map container
			map.setZoom( map.getBoundsZoom( imageBoundCoordinates ) );
		}, "Reset View" );
		additionalControls.push( fitToViewportControl );

		// Open the leaflet widget on a new tab
		if ( window.parent.location !== window.location ) {
			var launchInNewWindowControl = L.easyButton( "<span class=\"icon launch\"></span>", function ( control, map ) {
				window.open( "<?= $_SERVER[ 'REQUEST_URI' ] ?>", "<?= $readableMapName ?> | Indis" );
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

	</script>

</body>
</html>
