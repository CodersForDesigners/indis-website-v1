
/*
 *
 * /
 *
 * Does not handle the case when the "code editor" is toggled on and then back off
 *
 */

( function () {




const { uniq: unique } = lodash;

const { select, subscribe } = wp.data;



let userRoles = { };
for ( let role of [ "Editor", "Events Editor", "Spotlights Editor", "Construction Updates Editor" ] )
	userRoles[ role ] = role.toLowerCase().replace( /\s+/g, "_" )

let blocks = {
	socialMediaLinks: { name: "Social Media Links", _name: "acf/bfs-social-media-links" },
	projectEvents: { name: "Project Events", _name: "acf/bfs-project-events" },
	projectSpotlights: { name: "Project Spotlights", _name: "acf/bfs-project-spotlights" },
	projectConstructionUpdates: { name: "Construction Updates", _name: "acf/bfs-project-construction-updates" },
	projectConstructionUpdateListing: { name: "Construction Update Listing", _name: "bfs/construction-update-listing" },
	projectPricing: { name: "Project Pricing", _name: "bfs/project-pricing" },
	linkedProject: { name: "Linked Project", _name: "bfs/linked-project" },
}



let unsubscribe = subscribe( function () {

	let currentUser = select( "core" ).getCurrentUser();
	if ( ! currentUser )
		return;
	currentUser = select( "core" ).getUser( currentUser.id )
	if ( ! currentUser )
		return;

	let currentUserRoles = currentUser.roles;

	if ( currentUserRoles.includes( "administrator" ) )
		return;


	let $ = jQuery;

	// Fade out the block content area
	var $blockContentArea = $( ".block-editor-block-list__layout" );
	$blockContentArea.addClass( "faded-out" );

	// Make the block navigation leaves faded out
	let css = `
		<style id="bfs-block-visibility">
			.block-editor-block-navigation-leaf {
				opacity: 0;
				transition: opacity 0.41s;
			}
		</style>
	`;
	$( "head" ).append( $( css ) );

	// currentUserRoles = currentUserRoles.filter( role => "administrator" );

	let blocksThatAreVisible = [ ];

	if ( currentUserRoles.includes( userRoles[ "Editor" ] ) )
		blocksThatAreVisible = blocksThatAreVisible.concat( [ blocks.socialMediaLinks, blocks.projectEvents, blocks.projectSpotlights, blocks.projectConstructionUpdates, blocks.projectConstructionUpdateListing ] );
	if ( currentUserRoles.includes( userRoles[ "Events Editor" ] ) )
		blocksThatAreVisible = blocksThatAreVisible.concat( [ blocks.projectEvents ] );
	if ( currentUserRoles.includes( userRoles[ "Spotlights Editor" ] ) )
		blocksThatAreVisible = blocksThatAreVisible.concat( [ blocks.projectSpotlights ] );
	if ( currentUserRoles.includes( userRoles[ "Construction Updates Editor" ] ) )
		blocksThatAreVisible = blocksThatAreVisible.concat( [ blocks.projectConstructionUpdates, blocks.projectConstructionUpdateListing ] );

	blocksThatAreVisible = unique( blocksThatAreVisible, "name" );


	/*
	 * ----- Hide the blocks from the UI
	 */
	// Content Area
	let internalNamesOfBlocksThatAreVisible = blocksThatAreVisible.map( block => block._name );
	$( ".block-editor-block-list__block" ).each( ( _i, domBlock ) => {
		if ( internalNamesOfBlocksThatAreVisible.includes( domBlock.dataset.type ) )
			return;
		$( domBlock ).hide();
	} );
	$blockContentArea.css( { opacity: 1 } );

	// Block Navigation Widget
	function hideCertainBlockNavItems () {
		let $blockNavItems = $( ".block-editor-block-navigation-leaf" );
		if ( ! $blockNavItems )
			return;

		let namesOfBlocksThatAreVisible = blocksThatAreVisible.map( block => block.name );
		$blockNavItems.each( ( _i, domEl ) => {
				// When a block is selected through the nav, its text content gets augmented, hence the split...
			let navLabel = $( domEl ).find( "button" ).text().split( "(" )[ 0 ];
			if ( namesOfBlocksThatAreVisible.includes( navLabel ) )
				return;

			$( domEl ).css( { visibility: "collapse" } );
		} );
		$( ".block-editor-block-navigation" ).focus();
		$blockNavItems.css( { opacity: 1 } );
	}
	$( ".block-editor-block-navigation" ).on( "click", function ( event ) {
		setTimeout( hideCertainBlockNavItems, 100 );
	} );

	unsubscribe();

} );





}() );
