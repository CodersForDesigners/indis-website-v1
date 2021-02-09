
/*
 *
 * The images belonging to a set can be tagged independent of whether they fall under some designated scope, be it an enclosing `div` or what have you. The images belonging to a set can be distributed across the page, maybe in the future be solely declared in JavaScript as well.
 *
 * Infrastructure:
 *  - All galleries leverage the same lightbox markup
 *  - Not all images that belong to a gallery are capable of "triggering" the gallery open. Some are deliberately rendered that way.
 *
 *
 * js_gallery_item -> specifies that this element belongs to a gallery
 * js_trigger_gallery -> specifies that this element triggers the opening of a gallery
 * [ data-gallery = "name" ] -> specifies that this element contains items belonging to the gallery "name"
 *
 *
 *
 */

function Gallery () {

}


/*
 * ----- When a gallery is set to open
 *
 * Hide the next/previous buttons (in case there's only one image in the set)
 * Set the current gallery image
 * Show the lightbox
 *
 */
Gallery.open = function ( name, $items, startAt ) {

	startAt = startAt || 0;

	var $galleryLightbox = $( ".js_gallery_lightbox" );
	$galleryLightbox.data( "gallery", name );

	var itemData = null;
	if ( window.__DATA && __DATA.galleries && __DATA.galleries[ name ] )
		itemData = __DATA.galleries[ name ];

	// Hide the next/previous buttons (in case there's only one image in the set)
	if ( ( itemData && itemData.length === 1 ) || $items.length === 1 )
		$galleryLightbox.find( ".js_arrow" ).hide();

	// Set the current gallery image
	Gallery.setImage( name, $items, startAt );

	// // Show the lightbox
	// $galleryLightbox.fadeIn( 350 );
	// 	// Freeze the page layer
	// $( document.body ).addClass( "modal-open" );

};


/*
 * ----- When a gallery is closed
 *
 * Unset the `src` / `srcset' attributes from the image box
 * Unset the `gallery` attribute
 * Unset the `index` attribute
 * Restore the arrow buttons (if they were hidden)
 *
 */
Gallery.close = function close () {

	// event.stopImmediatePropagation();
	// event.preventDefault();

	// var $galleryLightbox = $( ".js_gallery_lightbox" );
	// $galleryLightbox.fadeOut( 350 );
	// 	// Un-freeze the page layer
	// $( document.body ).removeClass( "modal-open" );

	Gallery.unsetImage();

};

Gallery.setImage = function ( galleryName, $items, index ) {

	// Store references
	var $galleryLightbox = $( ".js_gallery_lightbox" );
	var $imageBox = $galleryLightbox.find( ".js_image_box" );

	// Declare some attributes and set default values
	var caption = "";

	// Set the image from memory
	if ( window.__DATA && __DATA.galleries && __DATA.galleries[ galleryName ] ) {
		var image = __DATA.galleries[ galleryName ][ index ].image;
		caption = __DATA.galleries[ galleryName ][ index ].caption;
		var imageSizes = image.sizes;
		var thumbnailImageURL = imageSizes.thumbnail;
		var smallImageURL = imageSizes.small;
		var mediumImageURL = imageSizes.medium;
		var largeImageURL = imageSizes.large;

		var srcset = "";
		if ( thumbnailImageURL )
			srcset += thumbnailImageURL + " " + imageSizes[ "thumbnail-width" ] + "w,";
		if ( smallImageURL )
			srcset += smallImageURL + " " + imageSizes[ "small-width" ] + "w,";
		if ( mediumImageURL )
			srcset += mediumImageURL + " " + imageSizes[ "medium-width" ] + "w,";
		if ( largeImageURL )
			srcset += largeImageURL + " " + imageSizes[ "large-width" ] + "w";

		$imageBox.find( "img" ).attr( {
			src: mediumImageURL || largeImageURL || image.url,
			srcset: srcset,
			sizes: "100vw"
		} );
	}
	// Set the image from the DOM element
	else {
		var domImage = $items[ index ];
		$imageBox.find( "img" ).attr( {
			src: domImage.url,
			srcset: domImage.srcset,
			sizes: "100vw"
		} );
	}

	$galleryLightbox.data( "currentIndex", index );
	$imageBox.find( ".js_caption" ).text( caption );

};

Gallery.unsetImage = function () {

	// Store references
	var $galleryLightbox = $( ".js_gallery_lightbox" );
	var $imageBox = $galleryLightbox.find( ".js_image_box" );

	// If no gallery name was provided, then unset the image and related data
	// if ( ! galleryName ) {
		$imageBox.find( "img" ).attr( {
			src: null,
			srcset: null
		} );
		$galleryLightbox.data( "gallery", null );
		$galleryLightbox.data( "currentIndex", null );

		// Restore the next/previous buttons (in case they were hidden)
		$galleryLightbox.find( ".js_arrow" ).show();

		return;
	// }

}

Gallery.next = function next () {
	var $galleryLightbox = $( ".js_gallery_lightbox" );

	var galleryName = $galleryLightbox.data( "gallery" );
	var $galleryItemsOrContainers = $( "[ data-gallery = '" + galleryName + "' ]" );
	var $galleryImages = $galleryItemsOrContainers.find( ".js_gallery_item" );

	var galleryLength;
	if ( window.__DATA && __DATA.galleries && __DATA.galleries[ galleryName ] )
		galleryLength = __DATA.galleries[ galleryName ].length;
	else
		galleryLength = $galleryImages.length;
	var currentIndex = parseInt( $galleryLightbox.data( "currentIndex" ), 10 );

	var newIndex = ( currentIndex + 1 ) % galleryLength;

	Gallery.setImage( galleryName, $galleryImages, newIndex );
};

Gallery.prev = function prev () {
	var $galleryLightbox = $( ".js_gallery_lightbox" );

	var galleryName = $galleryLightbox.data( "gallery" );
	var $galleryItemsOrContainers = $( "[ data-gallery = '" + galleryName + "' ]" );
	var $galleryImages = $galleryItemsOrContainers.find( ".js_gallery_item" );

	var galleryLength;
	if ( window.__DATA && __DATA.galleries && __DATA.galleries[ galleryName ] )
		galleryLength = __DATA.galleries[ galleryName ].length;
	else
		galleryLength = $galleryImages.length;
	var currentIndex = parseInt( $galleryLightbox.data( "currentIndex" ), 10 );

	var newIndex;
	if ( currentIndex === 0 )
		newIndex = galleryLength - 1;
	else
		newIndex = currentIndex - 1;

	Gallery.setImage( galleryName, $galleryImages, newIndex );
};




$( function () {





/*
 * ----- When a gallery is triggered
 *
 * Get the gallery name
 * Get the gallery images
 * Get the gallery starting index (if possible)
 * Trigger the gallery to open
 *
 */
// $( document ).on( "click", ".js_trigger_gallery", function ( event ) {
$( document ).on( "modal/open/image-gallery", function ( event, data ) {

	event.preventDefault();

	var $galleryLabel = $( event.target ).closest( "[ data-gallery ]" );
	var galleryName = $galleryLabel.data( "gallery" );
	var $galleryItemsOrContainers = $( "[ data-gallery = '" + galleryName + "' ]" );
	var $galleryImages = $galleryItemsOrContainers.find( ".js_gallery_item" );;

	// Get the starting position of the gallery if possible
	var $galleryItem = $( event.target ).closest( ".js_gallery_item" );	// if one exists; the gallery trigger is not always a gallery item
	var startingPosition = $galleryImages.index( event.target );
		if ( startingPosition < 0 )
			startingPosition = 0;

	Gallery.open( galleryName, $galleryImages, startingPosition );

} );

$( document ).on( "click", ".js_gallery_lightbox .js_arrow", function ( event ) {

	var direction = $( event.target ).closest( ".js_arrow" ).data( "dir" );
	Gallery[ direction ]();

} );

// Close Lightbox,
// on clicking the close button
// $( ".js_lightbox_close" ).on( "click", Gallery.close );
$( document ).on( "modal/close/image-gallery", Gallery.close );

// // on hitting the escape key
// $( document ).on( "keyup", function ( event ) {

// 	var keyAlias = ( event.key || String.fromCharCode( event.which ) ).toLowerCase();
// 	var keyCode = parseInt( event.which || event.keyCode );

// 	if ( keyAlias == "esc" || keyAlias == "escape" || keyCode == 27 ) {
// 		event.preventDefault();
// 		Gallery.close( event );
// 	}

// } )





} );
