
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





/*
 *
 * When scrolling through the page,
 * 1. Change the URL fragment to match the section that is currently being viewed.
 * 2. Reflect the current section in the navigation menu ( if applicable ).
 *
 */
var intervalToCheckForEngagement = 250;
var thresholdTimeForEngagement = 2000;
var timeSpentOnASection = 0;

var trackEngagementWithSections = function () {

	var currentScrollTop;
	var previousScrollTop;
	var currentSectionName;
	var previousSectionName;
	var sectionScrollTop;
	var $currentNavItem;
	var lastRecordedSection;

	// Get all the sections in the reverse order
	var $sections = Array.prototype.slice.call( $( "[ data-section ]" ) )
					.filter( function ( domSection ) {
						return ! $( domSection ).hasClass( "hidden" );
					} )
					.reverse()
					.map( function ( el ) { return $( el ) } );

	return function trackEngagementWithSections () {

		var viewportHeight = $( window ).height();
		currentScrollTop = window.scrollY || document.body.scrollTop;
		currentSectionName = null;

		var _i
		for ( _i = 0; _i < $sections.length; _i += 1 ) {
			sectionScrollTop = $sections[ _i ].position().top;
			if (
				( currentScrollTop >= sectionScrollTop - viewportHeight / 2 )
				&&
				( currentScrollTop <= sectionScrollTop + $sections[ _i ].height() + viewportHeight / 2 )
			) {
				currentSectionName = $sections[ _i ].data( "section" );
				break;
			}
		}

		/*
		 * If the previous and the current section are the same, then add time
		 * Else, reset the "time spent on a section" counter
		 */
		if ( currentSectionName == previousSectionName ) {
			timeSpentOnASection += intervalToCheckForEngagement
			if ( timeSpentOnASection >= thresholdTimeForEngagement ) {
				if ( currentSectionName != lastRecordedSection ) {
					if ( window.dataLayer )
				    	window.dataLayer.push( {
				    		event: "section-view",
				    		currentSectionName: currentSectionName
				    	} );
				    console.log( "Section: " + currentSectionName )
				    lastRecordedSection = currentSectionName;
				}
			}
		}
		else {
			timeSpentOnASection = 0
		}

		previousScrollTop = currentScrollTop;
		previousSectionName = currentSectionName;

	};

}();


executeEvery( intervalToCheckForEngagement, trackEngagementWithSections )




} );
