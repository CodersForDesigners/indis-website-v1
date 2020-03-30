<?php
/*
 *
 * This is a sample page you can copy and use as boilerplate for any new page.
 *
 */
require_once __DIR__ . '/../inc/utils.php';
initWordPress();

if ( ! current_user_can( 'administrator' ) ) {
	return header( 'Location: /', true, 302 );
	exit;
}

require_once __DIR__ . '/../inc/above.php';

// Get the list of uploaded maps
$plansDirectory = "${_SERVER[ 'DOCUMENT_ROOT' ]}/content/plans";
$fileNames = array_slice( scandir( $plansDirectory ), 2 );
$directoryNames = array_filter( $fileNames, function ( $fileName ) use ( $plansDirectory ) {
	return is_dir( $plansDirectory . '/' . $fileName );
} );
$maps = array_map( function ( $directoryName ) {
	return [
		'id' => $directoryName,
		'path' => '/content/plans/' . $directoryName
	];
}, $directoryNames );

?>




<!-- TMV Styles -->
<style>

	.button {
		overflow: hidden;
	}

	/*.dropping,
	.dropping * {
		pointer-events: none !important;
	}
	.dropping:after {
		content: "";
		position: absolute;
		top: -10vh;
		right: -10vw;
		bottom: -10vh;
		left: -10vw;
		background-color: var(--red-1);
		z-index: 999;
	}*/

	.processing-button:after {
		animation: loading-hourglass 2.5s infinite steps(4);
	}

	.tmv-section .clipboard-button.copied:after {
		content: 'Copied';
		font-size: 10px;
		position: absolute;
		left: 100%;
		color: var(--dark);
		animation: fadeout 2s 1 ease-out forwards;
	}

	@keyframes loading-hourglass {
		from {
			transform: rotate( 0deg );
		}
		to {
			transform: rotate( 360deg );
		}
	}

	@keyframes fadeout {
	  0%, 50% {
		opacity: 1;
	  }
	  100% {
		opacity: 0;
	  }
	}

</style>
<!-- END: TMV Styles -->
<!-- TMV Section -->
<!-- @Adi: Show this Section only if user is Signed into Wordpress !!! -->
<section class="tmv-section" ondragover="return false" ondragend="return false">
	<div class="container">
		<!-- Intro -->
		<div class="row">
			<div class="columns small-12 medium-10 large-8">
				<div class="h2 strong text-lowercase space-50-top space-min-bottom">Tile Map Viewer</div>
				<div class="h5 text-neutral-2 space-50-bottom">
					Provide a Large .PNG or .JPG File of Minimum Size: 14304 × 9888. Ensure the .PNG file contains no transparency. The recommended aspect ratio for this project is that of an A1 size Paper (2384 x 2384 at 72DPI) in the landscape orientation.
				</div>
			</div>
		</div>
		<!-- END: Intro -->
		<!-- Upload -->
		<div class="row">
			<div class="columns small-12 medium-10 large-8">
				<input id="file" class="js_map_image_input visuallyhidden" type="file" name="map-image" accept="image/*" required>

				<!-- Hide when Processing -->
				<label for="file" class="upload-button button fill-red-2 button-icon js_image_upload_button" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg?v=20200127'); --bg-c: var(--red-1);">
					Upload New Image
				</label>

				<!-- Hide when Not Processing -->
				<label class="processing-button button fill-red-1 text-light no-pointer button-icon hidden js_image_upload_indicator" style="--bg-i: url('../media/icon/icon-hour-glass-light.svg?v=20200127'); --bg-c: var(--red-1);">
					Generating Tiles&nbsp;
				</label>

				<br>
				<!-- Print Active Upload File Name Here -->
				<div class="file-name label space-min-top space-50-bottom js_file_selected">No Files Selected</div>

			</div>
		</div>
		<!-- END: Upload -->
		<!-- Listing -->
		<div class="row">
			<div class="columns small-11 medium-8 large-6">
				<div class="h5 strong space-50-top space-min-bottom">Generated Tiles:</div>

				<?php foreach ( $maps as $map ) : ?>
				<div class="row js_map" style="border-top: solid 1px var(--neutral-2);" data-id="<?= $map[ 'id' ] ?>">
					<div class="columns small-10 medium-11 inline-middle">
						<!-- If you check to see if the original.png file is present in the folder you will know if the tiles have been processed -->
						<a class="name h6 condensed text-red-2" target="_blank" href="/leaflet-map?id=<?= $map[ 'id' ] ?>"><?= $map[ 'id' ] ?></a>
					</div>
					<div class="columns small-2 medium-1 inline-middle">
						<button class="clipboard-button icon-button copied inline js_copy_map_url" tabindex="-1" style="background-image: url('../media/icon/icon-clipboard-red.svg<?php echo $ver ?>');"><!-- Copy to CLipboard --></button>
					</div>
				</div>
				<?php endforeach; ?>

			</div>
		</div>
		<!-- END: Listing -->
	</div>
</section>
<!-- END: TMV Section -->

<!-- A hidden text-area element to enable the copy-to-clipboard feature -->
<textarea class="visuallyhidden js_copy_content"></textarea>





<?php require_once __DIR__ . '/../inc/below.php'; ?>

<script type="text/javascript">

/**/

	$( "form" ).on( "submit", function ( event ) {
		event.preventDefault();
	} );



	var thingsBeingDropped;
	var typesOfThingsBeingDropped;

	/*
	 *
	 * Provide a visual indicator that the user is hovering the file over the page
	 *	Feature Status: Abandoned
	 *
	 */
	// $( document.body ).on( "dragover", function ( event ) {
	// 	console.log( "dragover: adding" )
	// 	$( document.body ).addClass( "dropping" );
	// } );
	// $( document.body ).on( "dragleave dragend drop", function ( event ) {
		// $( document.body ).removeClass( "dropping" );
	// } );

	$( document.body ).on( "dragover dragend drop", function ( event ) {
		event.preventDefault();
		var dataTransfer = event.originalEvent.dataTransfer;
		if ( dataTransfer && dataTransfer.files.length ) {
			thingsBeingDropped = dataTransfer.files;
			typesOfThingsBeingDropped = dataTransfer.types;
		}
		return false;
	} );
	$( document.body ).on( "drop", function ( event ) {

		if ( thingsBeingDropped.length !== 1 )
			return;
		if ( ! typesOfThingsBeingDropped.includes( "Files" ) )
			return;

		if ( ! thingsBeingDropped[ 0 ].type.startsWith( "image" ) ) {
			alert( "Please provide an image." );
			return;
		}


		// Scroll to the top so the use can see the feedback
		window.scrollTo( { top: 0, behavior: "smooth" } );

		// Now, upload the image
		uploadImage( thingsBeingDropped );

		// Reset the global vars
		thingsBeingDropped = [ ];
		typesOfThingsBeingDropped = [ ];

		event.preventDefault();
		return false;

	} );


	$( document ).on( "change", ".js_map_image_input", function ( event ) {
		var domFileInput = event.target;
		uploadImage( domFileInput.files );
	} );

	function uploadImage ( fileList ) {

		// If no image was selected, return
		if ( ! fileList.length )
			return;

		var imageFilename = fileList[ 0 ].name;

		// Display the file name that was selected
		$( ".js_file_selected" ).text( imageFilename );
		// Toggle loading indicator
		$( ".js_image_upload_button" ).addClass( "hidden" );
		$( ".js_image_upload_indicator" ).removeClass( "hidden" );



		var formData = new FormData();
		var mapId = imageFilename.replace( /\.[^\.]+$/, "" );
		formData.append( "map-name", mapId );
		formData.append( "map-image", fileList[ 0 ] );

		var endpoint = "/server/maps/post.php";
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
			window.location.reload();
		} );
		ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
			var errorResponse = getErrorResponse( jqXHR, textStatus, e );
			console.log( errorResponse );
			alert( errorResponse.message );
		} );

	}



	/*
	 *
	 * Copy Map URL to Clipboard
	 *
	 */
	$( document ).on( "click", ".js_copy_map_url", function ( event ) {

		event.preventDefault();

		var $target = $( event.target );
		var $map = $target.closest( ".js_map" );
		var mapId = $map.data( "id" )

		var url = "/leaflet-map?id=" + mapId;
		var $url = $( ".js_copy_content" );
		var domUrl = $url.get( 0 );
		$url.text( url );
		domUrl.select();

		try {
			document.execCommand( "copy" );
			$target.addClass( "copied" );
			waitFor( 2 ).then( function () {
				$target.removeClass( "copied" );
			} );
		}
		catch ( e ) {}

		domUrl.blur();


	} );


</script>
