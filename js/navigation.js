
$( function ( $ ) {





function smoothScrollTo ( locationHash ) {

	if ( ! locationHash )
		return;

	var locationId = locationHash.replace( "#", "" );
	var domLocation = document.getElementById( locationId );
	if ( ! domLocation )
		return;

	window.scrollTo( { top: domLocation.offsetTop, behavior: "smooth" } );

}

/*
 *
 * Smooth-scroll to sections
 *
 */
$( document ).on( "click", "a[ href ]", function ( event ) {

	var $anchor = $( event.target ).closest( "a" );
	var domAnchor = $anchor.get( 0 );

	var urlParts = domAnchor.href.split( "#" );
	// If the url has more than one `#`es in it, we're not even going to try
	if ( urlParts.length !== 2 )
		return;

	var path = urlParts[ 0 ];
	var sectionId = urlParts[ 1 ];

	// If the path does not match that of the current page
	if ( path !== window.location.href )
		return;

	// If the section id is empty or a stub
	if ( ! sectionId.trim() || sectionId === "0" )
		return;

	// Prevent default behaviour
	event.preventDefault();
	event.stopPropagation();
	event.stopImmediatePropagation();

	// Close the navigation menu
	$( ".js_navigation_section" ).removeClass( "open" );

	smoothScrollTo( sectionId );

	return false;

} );



/*
 *
 * Un-hide in-page navigation menu items if the section they point to is present
 *
 */
var hashRegex = /#([^#\?]+)/;
$( ".js_navigation_item[ data-type = 'in-page' ]" ).each( function ( _i, el ) {
	var $el = $( el );
	var href;
	if ( $el.is( "a" ) )
		href = $el.attr( "href" );
	else
		href = $el.find( "a" ).attr( "href" )
	var sectionId = ( href.match( hashRegex ) || [ ] )[ 1 ];
	if ( document.getElementById( sectionId ) )
		$el.removeClass( "hidden" )
} )



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
 * For Navigation Items that are Post Selectors
 *
 */
if ( $( ".js_navigation_post_selector" ).length ) {
	// Prevent the default behavior for an anchor click
	$( ".js_navigation_post_selector" ).on( "click", function ( event ) {
		event.preventDefault();
	} );
	// Navigate to the post/page that is selected
	$( ".js_navigation_post_selector" ).on( "change", function ( event ) {
		var $selector = $( event.target );
		var link = $selector.find( ":selected" ).data( "href" );
		location.href = link;
	} );
}





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

var thingsToDoOnEveryInterval = function () {

	var currentScrollTop;
	var previousScrollTop;
	var $currentSection;
	var currentSectionName;
	var previousSectionName;
	var sectionScrollTop;
	var $currentNavItem;
	var lastRecordedSection;
	var $navigationItems = $( ".js_navigation_item" );
	var $currentNavigationItem;

	// Get all the sections in the reverse order
	var $sections = Array.prototype.slice.call( $( "[ data-section ]" ) )
					.filter( function ( domSection ) {
						return ! $( domSection ).hasClass( "hidden" );
					} )
					.reverse()
					.map( function ( el ) { return $( el ) } );

	return function thingsToDoOnEveryInterval () {

		var viewportHeight = $( window ).height();
		currentScrollTop = window.scrollY || document.body.scrollTop;
		$currentSection = null;
		currentSectionName = null;

		var _i
		for ( _i = 0; _i < $sections.length; _i += 1 ) {
			$currentSection = $sections[ _i ];
			sectionScrollTop = $currentSection.position().top;
			if (
				( currentScrollTop >= sectionScrollTop - viewportHeight / 2 )
				&&
				( currentScrollTop <= sectionScrollTop + $currentSection.height() + viewportHeight / 2 )
			) {
				currentSectionName = $currentSection.data( "section" );
				currentSectionId = $currentSection.get( 0 ).id;
				break;
			}
		}

		// Mark the corresponding item in the navigation menu
		$currentNavigationItem = $navigationItems
							.removeClass( "active" )
							.filter( "[ href $= '#" + currentSectionId + "' ]" )
		$currentNavigationItem.addClass( "active" );

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


executeEvery( intervalToCheckForEngagement, thingsToDoOnEveryInterval )






/*
 *
 * When scrolling through the page,
 * 	1. Stick the navigation bar to the top after a certain point on the page
 * 	2. Show the navigation bar while scrolling down, hide it while scrolling up
 *
 */
var controlDisplayAndStickinessOfNavigationBar = function () {

	var currentScrollY;
	var previousScrollY = 0;

	var $navigationBar = $( ".js_navigation_section" );
	var scrollThreshold = 5;

	/*
	 * Get the navigation bar sticky point
	 *
	 * The sticky point can be a DOM element, or a value set in CSS
	 *
	 */
	// The `navigationBarStickyPoint` holds a jQuery DOM element before which the bar should not be sticky
	var navigationBarStickyPoint = $( ".js_navigation_sticky_point" ).get( 0 ) || getComputedStyle( document.documentElement );

	return function controlDisplayAndStickinessOfNavigationBar ( event ) {

		var stickyOffset;

		if ( ! navigationBarStickyPoint )
			return;
		else if ( navigationBarStickyPoint.constructor.name.indexOf( "CSS" ) !== -1 )
			stickyOffset = parseInt( navigationBarStickyPoint.getPropertyValue( "--navigation-sticky-point" ), 10 );
		else if ( navigationBarStickyPoint.constructor.name.indexOf( "HTML" ) !== -1 )
			stickyOffset = navigationBarStickyPoint.offsetTop

		currentScrollY = window.scrollY || document.body.scrollTop;

		if ( currentScrollY >= stickyOffset )
			$navigationBar.addClass( "sticky" );
		else
			$navigationBar.removeClass( "sticky" );

		if ( currentScrollY > previousScrollY )
			$navigationBar.addClass( "show" );
		else if ( previousScrollY - currentScrollY > scrollThreshold )
			$navigationBar.removeClass( "show" );

		previousScrollY = currentScrollY;

	};

}();
$( window ).on( "scroll", controlDisplayAndStickinessOfNavigationBar );




/*
 *
 * If the URL has a hash value,
 * 	smooth-scroll to that section
 *	and restore the hash to the URL
 *
 */
// The hash was removed but cached in this variable
if ( window.__BFS.scrollTo ) {
	if ( window.scrollY < 1 )
		smoothScrollTo( window.__BFS.scrollTo );
	var fullURL = location.origin + location.pathname + location.search + window.__BFS.scrollTo;
	window.history.replaceState( { }, "", fullURL )
}





} );
