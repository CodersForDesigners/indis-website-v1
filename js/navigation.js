
$( function ( $ ) {





/*
 *
 * Smooth-scroll to sections
 *
 */
$( document ).on( "click", "a[ href ]", function ( event ) {
	var $anchor = $( event.target ).closest( "a" );
	var domAnchor = $anchor.get( 0 );
	var currentUrl = location.origin + location.pathname;

	// Subtract the current URL from the destination URL
	var remainingUrl = domAnchor.href.replace( currentUrl, "" );
	if ( remainingUrl[ 0 ] !== "#" )
		return true;

	event.preventDefault();
	event.stopPropagation();
	event.stopImmediatePropagation();
	var toSectionId = remainingUrl.slice( 1 );
	// setTimeout( function () {
		var domSection = document.getElementById( toSectionId );
		window.scrollTo( { top: domSection.offsetTop - 50, behavior: "smooth" } );
	// }, 0 );
	return false;
} );



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
 * Navigate to the project selected on the Project menu item sub-menu
 *
 */
$( ".js_projects_selector" ).removeClass( "hidden" );
$( ".js_projects_selector" ).on( "change", function ( event ) {
	var $selector = $( event.target );
	var project = $selector.val();
	var link = $selector.find( ":selected" ).data( "href" );
	location.href = link;
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
