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



<!-- Blog Header -->
<section class="blog-page">
	<div class="blog-header fill-dark">
		<div class="container">
			<div class="row">
				<div class="columns small-12">
					<div class="logo"><a href="<?php echo $baseURL ?>" class="inline"><img class="block" src="../media/indis-logo-light.svg<?php echo $ver ?>"></a></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- END: Blog Header -->
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
					<span class="block strong text-dark">File Name:</span>
					<p class="block space-min-bottom">The File Name should <span class="strong">NOT</span> contain any spaces. Use a Dash/Hyphen/Minus character as a separator. Alternatively You can use the CamelCase naming convention. This is important since the file name will be part of the Link/URL generated to view the image.</p>
					<span class="block strong text-dark">File Size:</span>
					<p class="block space-min-bottom">Provide a Large .PNG or .JPG Image File of Minimum Size: 14304 × 9888.</p>
					<span class="block strong text-dark">File Format:</span>
					<p class="block space-min-bottom">Ensure the .PNG file contains no transparency.</p>
					<span class="block strong text-dark">File Aspect Ratio:</span>
					<p class="block space-min-bottom">The recommended aspect ratio for this project is that of an A1 size Paper (2384 x 2384 at 72DPI) in the landscape orientation.</p>
				</div>
			</div>
		</div>
		<!-- END: Intro -->
		<!-- Upload -->
		<div class="row">
			<div class="columns small-12 medium-10 large-8">
				<input id="file" class="js_map_image_input visuallyhidden" type="file" name="map-image" accept="image/*" multiple required>

				<!-- Hide when Processing -->
				<label for="file" class="upload-button button fill-red-2 button-icon js_image_upload_button" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg?v=20200127'); --bg-c: var(--red-1);">
					Upload New Images
				</label>

				<!-- Hide when Not Processing -->
				<label class="processing-button button fill-red-1 text-light no-pointer button-icon hidden js_image_upload_indicator" style="--bg-i: url('../media/icon/icon-hour-glass-light.svg?v=20200127'); --bg-c: var(--red-1);">
					Generating Tiles&nbsp;
				</label>

				<br>
				<!-- Print Active Upload File Name Here -->
				<div class="file-name label space-min-top space-50-bottom hidden js_upload_progress">
					<b>(</b>
						<b class="js_upload_queue_numerator"></b>
							/
						<b class="js_upload_queue_denominator"></b>
					<b>)</b>
					&nbsp;&nbsp;<span class="js_file_currently_processing"></span>
				</div>

				<div class="file-name label space-min-top space-50-bottom hidden js_upload_error_log">
					There were issues uploading/processing the following file(s):
					<br>
					<span></span>
				</div>

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

		event.preventDefault();

		if ( thingsBeingDropped.length < 1 )
			return;

		if ( ! typesOfThingsBeingDropped.includes( "Files" ) ) {
			alert( "Please provide images only." );
			return;
		}

		if ( ! thingsBeingDropped[ 0 ].type.startsWith( "image" ) ) {
			alert( "Please provide images only." );
			return;
		}

		var imageFiles = thingsBeingDropped;

		// Reset the global vars
		thingsBeingDropped = [ ];
		typesOfThingsBeingDropped = [ ];

		// Scroll to the top so the use can see the feedback
		window.scrollTo( { top: 0, behavior: "smooth" } );

		// Now, upload the image(s)
		$( document ).trigger( "upload/queue/add", { images: [ ...imageFiles ] } );

		return false;

	} );


	$( document ).on( "change", ".js_map_image_input", function ( event ) {
		var domFileInput = event.target;
		$( document ).trigger( "upload/queue/add", { images: [ ...domFileInput.files ] } );
	} );


	var imageQueue = [ ];
	var uploadIsInSession = false;
	var queueLengthForCurrentUploadSession = 0;
	/*
	 *
	 * This event fires whenever a new batch of images are set for uploading
	 *
	 */
	$( document ).on( "upload/queue/add", function ( event, { images } ) {

		// Add the images to the upload queue
		imageQueue.push( ...images );
		queueLengthForCurrentUploadSession += images.length;

		// Reflect the increase in the queue size
		$( ".js_upload_queue_denominator" ).text( queueLengthForCurrentUploadSession );


		if ( uploadIsInSession )
			return;



		uploadIsInSession = true
		// Toggle loading indicator
		$( ".js_image_upload_button" ).text( "Upload more images" );
		$( ".js_image_upload_indicator" ).removeClass( "hidden" );
		$( ".js_upload_progress" ).removeClass( "hidden" );
		// Schedule the image(s) for uploading
		scheduleUpload( imageQueue, 0, uploadImage ).then( function () {
			uploadIsInSession = false;
			// Reset the queue length
			queueLengthForCurrentUploadSession = 0;
			// Restore the upload input button
			$( ".js_image_upload_button" ).text( "Upload New Images" );
			// Hide the loading indicator
			$( ".js_image_upload_indicator" ).addClass( "hidden" );

			$( ".js_upload_progress" ).addClass( "hidden" );
			alert( "Uploading and processing has completed. Please refresh the page." )
		} );

	} );

	/*
	 *
	 * This essentially runs an async function against every element in an array,
	 * 	**in sequence**
	 *
	 */
	function scheduleUpload ( queue, index, fn ) {

		// If the upload queue is empty
		if ( index >= queue.length )
			return Promise.resolve();

		// Reflect upload progress to the UI
		$( ".js_upload_queue_numerator" ).text( index + 1 );
		$( ".js_file_currently_processing" ).text( queue[ index ].name );

		return fn( queue[ index ] )
			.then( function () {
				return scheduleUpload( queue, index + 1, fn )
			} )
			.catch( function () {
				// Log the error
				$( ".js_upload_error_log" )
					.removeClass( "hidden" )
					.find( "span" )
					.html( function ( _i, existingMarkup ) {
						return queue[ index ].name + "<br>" + existingMarkup;
					} );
				// Continue uploading the next image in queue
				return scheduleUpload( queue, index + 1, fn )
			} )

	}

	function uploadImage ( imageFile ) {

		// If no image was selected, return
		if ( ! imageFile )
			return Promise.resolve();

		var imageFilename = imageFile.name;

		var formData = new FormData();
		var mapId = imageFilename.replace( /\.[^\.]+$/, "" );
		formData.append( "map-name", mapId );
		formData.append( "map-image", imageFile );

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

		return new Promise( function ( resolve, reject ) {
			ajaxRequest.done( function ( response ) {
				// console.log( "done:" );
				// console.log( response );
				// alert( response.message );
				// window.location.reload();
				resolve( response );
			} );
			ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
				var errorResponse = getErrorResponse( jqXHR, textStatus, e );
				reject( errorResponse );
				// console.log( errorResponse );
				// alert( errorResponse.message );
			} );
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

		var url = location.origin + "/leaflet-map?id=" + mapId;
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
