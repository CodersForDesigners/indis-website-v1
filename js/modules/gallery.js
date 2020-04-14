
/*
 *
 * Gallery Modal / Lightbox
 *
 */


/*
 * When opening the gallery for an image set
 */
$( document ).on( "modal/open/image-gallery", function ( event, data ) {
	var $galleryRegion = $( event.target ).closest( ".js_gallery_region" );
	var gallerySet = $galleryRegion.data( "set" );
	var $visibleGalleryImages = $galleryRegion.find( ".js_gallery_item" );
	var startingPosition = $visibleGalleryImages.index( event.target );

	// Set the current gallery image
	setGalleryImage( startingPosition, gallerySet );
} );

/*
 * When navigating within an image set in the gallery
 */
$( document ).on( "click", ".js_gallery_modal .js_arrow", function ( event ) {
	var $galleryModal = $( ".js_gallery_modal" );
	var direction = $( event.target ).closest( ".js_arrow" ).data( "dir" );
	var $imageBox = $galleryModal.find( ".js_image_box" );

	var currentIndex = $imageBox.data( "index" );
	var newIndex;
	if ( direction === "left" )
		newIndex = currentIndex - 1;
	else if ( direction === "right" )
		newIndex = currentIndex + 1;

	setGalleryImage( newIndex );
} );


/*
 * Set an image in the gallery
 */
function setGalleryImage ( index, set ) {
	var $galleryModal = $( ".js_gallery_modal" );
	var set = set || $galleryModal.data( "set" );
	var $imageBox = $galleryModal.find( ".js_image_box" );

	var lengthOfSet = __DATA.galleries[ set ].length;
	var newIndex = index % lengthOfSet;
	if ( newIndex < 0 )
		newIndex = lengthOfSet - 1;

	var image = __DATA.galleries[ set ][ newIndex ].image;
	var caption = __DATA.galleries[ set ][ newIndex ].caption;
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

	$galleryModal.data( "set", set );	// Set the `set` value regardless
	$imageBox.data( "index", newIndex );
	$imageBox.find( "img" ).attr( {
		src: mediumImageURL || largeImageURL || image.url,
		srcset: srcset,
		sizes: "100vw"
	} );
	$imageBox.find( ".js_caption" ).text( caption || "" );

}

$( document ).on( "modal/close/image-gallery", function ( event, data ) {

	var $galleryModal = $( ".js_gallery_modal" );
	var $imageBox = $galleryModal.find( ".js_image_box" );
	$imageBox.find( "img" ).attr( {
		src: null,
		srcset: null
	} );

} );
