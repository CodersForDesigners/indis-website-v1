
$( function ( $ ) {





/*
 *
 * Toggle Navigation when Menu (hamburger) icon is clicked
 *
 */
$( document ).on( "click", ".js_menu_button", function ( event ) {
	event.preventDefault();
	var $target = $( event.currentTarget );
	$target.closest( ".js_navigation_section" ).toggleClass( "open" );
} );





} );
