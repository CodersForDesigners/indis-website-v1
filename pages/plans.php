<?php

// Get utility functions
require_once __DIR__ . '/../inc/utils.php';

// If this file is requested via an HTTP POST, run the "handle upload" routine
if ( strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) === 'POST' ) {
	return require_once __DIR__ . '/../server/maps/post.php';
	exit;
}
// If this file is requested via an HTTP DELETE, run the "handle deletion" routine
if ( strtoupper( $_SERVER[ 'REQUEST_METHOD' ] ) === 'DELETE' ) {
	require_once __DIR__ . '/../server/maps/delete.php';
	exit;
}

// Else, return the Plans dashboard
$plansDirectory = "${_SERVER[ 'DOCUMENT_ROOT' ]}/content/plans";
$fileNames = array_slice( scandir( $plansDirectory ), 2 );
$directoryNames = array_filter( $fileNames, function ( $fileName ) use ( $plansDirectory ) {
	return is_dir( $plansDirectory . '/' . $fileName );
} );
$maps = array_map( function ( $directoryName ) {
	return [
		'id' => $directoryName,
		'url' => '/content/plans/' . $directoryName
	];
}, $directoryNames );

?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">

	<title>Plans</title>


	<!-- Stylesheets -->
	<?php require __DIR__ . '/../style.php'; ?>
	<style type="text/css">

		body {
			/*background-color: rgba( 0, 0, 0, 0.5 );*/
		}

		.section-maps .library {
			display: grid;
			grid-gap: 10px;
			grid-template-columns: repeat( auto-fill, 100px );
			grid-auto-rows: minmax( 100px, auto );
			/*justify-content: center;*/
		}
		.section-maps .library .map {
			border: 1px solid rgba( 0, 0, 0, 0.25 );
			object-fit: center;
		}

		.section-maps .tab-headings > * {
			position: relative;
			padding: 0.25rem 0;
			border: 1px solid rgba( 0, 0, 0, 0.5 );
			border-bottom-color: white;
		}
			.section-maps .tab-headings > .active:after {
				content: "";
				position: absolute;
				top: calc( 100% - 4px );
				left: 0;
				right: 0;
				bottom: -5px;
				background-color: white;
				z-index: 1;
			}

		.section-maps .tab-content-area {
			min-height: 75vh;
			padding: 1.5rem;
			border: 1px solid rgba( 0, 0, 0, 0.5 );
			z-index: 0;
		}
		.section-maps .map {
			position: relative;
		}
		.section-maps .map .map-remove {
			position: absolute;
			top: 0;
			left: 100%;
			width: 1.5rem;
			height: 1.5rem;
			transform: translate( -120%, 20% );
			border-radius: 50%;
			color: black;
			font-size: 1.7rem;
			line-height: 0.8em;
			border: 1px solid black;
			text-align: center;
			cursor: pointer;
			opacity: 0;
			transition: opacity 0.1s ease-in;
		}
		.section-maps .map:hover .map-remove {
			opacity: 1;
		}

	</style>

</head>
<body>

	<section class="heading">
		<div class="container">
			<h1 class="h1">Plans</h1>
		</div>
	</section>

	<section class="section-maps js_tab_container">
		<div class="container">
			<div class="row tab-headings js_tab_headings">
				<h5 class="columns small-1 h5 text-center cursor-pointer js_tab_heading">Upload</h5>
				<h5 class="columns small-1 h5 text-center cursor-pointer js_tab_heading">Library</h5>
			</div>
			<div class="tab-content-area container">
				<div class="row">
					<div class="columns small-12 upload-form js_tab" data-tab="Upload">
						<form>
							<input class="js_map_name" type="text" name="map-name" placeholder="Plan name" value="<?= $_GET[ 'id' ] ?? '' ?>" required>
							<input class="js_map_image" type="file" name="map-image" accept="image/*" required disabled>
						</form>
					</div>
				</div>
				<div class="row library js_tab" data-tab="Library">
					<?php foreach ( $maps as $map ) : ?>
						<div class="map js_map" data-id="<?= $map[ 'id' ] ?>">
							<img class="cursor-pointer" src="<?= $map[ 'url' ] ?>/0/0/0.png">
							<span class="map-remove js_map_remove">&times;</span>
						</div>
					<?php endforeach; ?>
				</div>
				<textarea class="visuallyhidden js_url"></textarea>
			</div>
		</div>
	</section>

	<script type="text/javascript" src="/plugins/jquery/jquery-3.0.0.min.js"></script>
	<script type="text/javascript" src="/js/modules/tabs.js"></script>

	<script type="text/javascript">

		/*
		 * If a default map id is set (via the URL), then remove it from the URL
		 */
		if ( location.search ) {
			var fullURL = location.origin + location.pathname;
			window.history.replaceState( { }, "", fullURL )
		}

		/*
		 *
		 * Handle error / exception response helper
		 *
		 */
		function getErrorResponse ( jqXHR, textStatus, e ) {
			var code = -1;
			var message;
			if ( jqXHR.responseJSON ) {
				code = jqXHR.responseJSON.code || jqXHR.responseJSON.statusCode;
				message = jqXHR.responseJSON.message;
			}
			else if ( typeof e == "object" ) {
				message = e.stack;
			}
			else {
				message = jqXHR.responseText;
			}
			var error = new Error( message );
			error.code = code;
			return error;
		}


		$( "form" ).on( "submit", function ( event ) {
			event.preventDefault();
		} );


		$( document ).on( "keyup change", ".js_map_name", function ( event ) {
			if ( ! event.target.value.trim() )
				$( ".js_map_image" ).prop( "disabled", true );
			else
				$( ".js_map_image" ).prop( "disabled", false );
		} );

		$( document ).on( "change", ".js_map_image", function ( event ) {
			var domFileInput = event.target;
			// If no image was selected, return
			if ( ! domFileInput.files.length )
				return;

			// TODO: Toggle loading indicator

			var formData = new FormData();
			var mapId = $( ".js_map_name" ).val();
			formData.append( "map-name", mapId );
			formData.append( "map-image", domFileInput.files[ 0 ] );

			var endpoint = "/plans";
			var ajaxRequest = $.ajax( {
				url: endpoint,
				method: "POST",
				accepts: "json",
				cache: false,
				data: formData,
				dataType: "json",
				processData: false,
				contentType: false,
			} );

			ajaxRequest.done( function ( response ) {
				console.log( "done:" );
				console.log( response );
				alert( response.message );
				window.location.href = window.location.origin + window.location.pathname + "?id=" + mapId;
			} );
			ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
				var errorResponse = getErrorResponse( jqXHR, textStatus, e );
				console.log( errorResponse );
				alert( errorResponse.message );
			} );

		} );



		/*
		 *
		 * Deleting a map
		 *
		 */
		$( document ).on( "click", ".js_map_remove", function ( event ) {

			if ( ! window.confirm( "Are you sure you want to remove this map?" ) )
				return;

			var $map = $( event.target ).closest( ".js_map" );
			var mapId = $map.data( "id" );

			var endpoint = "/plans?id=" + mapId;
			var ajaxRequest = $.ajax( {
				url: endpoint,
				data: { id: mapId },
				method: "DELETE",
				dataType: "json"
			} );

			ajaxRequest.done( function ( response ) {
				$map.remove();
			} );
			ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
				var errorResponse = getErrorResponse( jqXHR, textStatus, e );
				console.log( errorResponse );
				alert( errorResponse.message );
			} );

		} );


		/*
		 *
		 * Copy Map URL to Clipboard
		 *
		 */
		$( document ).on( "click", ".js_share_url", function ( event ) {
			event.preventDefault();
		} );
		$( document ).on( "click", ".js_map img", function ( event ) {

			event.preventDefault();

			var $map = $( event.target ).closest( ".js_map" );
			var mapId = $map.data( "id" )

			var url = "/leaflet-map?id=" + mapId;
			var $url = $( ".js_url" );
			var domUrl = $url.get( 0 );
			$url.text( url );
			domUrl.select();

			try {
				document.execCommand( "copy" );
				alert( "Copied to Clipboard" );
			}
			catch ( e ) {}

			domUrl.blur();

		} );

	</script>

</body>
</html>
