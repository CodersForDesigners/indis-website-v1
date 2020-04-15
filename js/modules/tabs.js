
/*
 *
 * Tab Widgets
 *
 */
$( function () {

	$( ".js_tab_heading" ).on( "click", function ( event ) {
		var $tabHeading = $( event.target );
		if ( $tabHeading.hasClass( "active" ) )
			return;
		var tabName = $tabHeading.text();
		var $tabContainer = $tabHeading.closest( ".js_tab_container" );
		toggleTab( $tabContainer, tabName );
	} );

	$( ".js_tab_headings" ).on( "change", function ( event ) {
		var tabName = event.target.value;
		var $tabContainer = $( event.target ).closest( ".js_tab_container" );
		toggleTab( $tabContainer, tabName );
	} );

	function toggleTab ( $container, name ) {

		// Get all the tab heading groups ( that are immediate descendants only )
		var $tabHeadings = $container
			.find( ".js_tab_headings" )
			.filter( function ( _i, el ) {
				return $( el ).closest( ".js_tab_container" ).is( $container );
			} );

		// Select the `div` version of the input
		var $tabHeading__DivElement = $tabHeadings.find( ".js_tab_heading" ).filter( ":contains('" + name + "')" );
		$tabHeadings.find( ".js_tab_heading" ).removeClass( "active" );
		$tabHeading__DivElement.addClass( "active" );

		// Select the `select` version of the input
		var $tabHeading__OptionElement = $tabHeadings.filter( "select" );
		$tabHeading__OptionElement.val( name );

		// Toggle the corresponding UI
		var $tabs = $container
			.find( ".js_tab" )
			.filter( function ( _i, el ) {
				return $( el ).parents( ".js_tab_container" ).first().is( $container );
			} );
		var $tab = $tabs.filter( "[ data-tab = '" + name + "' ]" );
		$tabs.addClass( "hidden" );
		$tab.removeClass( "hidden" );

		// By default, select the first tab within this tab ( if there is one )
		$tab.find( ".js_tab_headings" )
			.filter( function ( _i, el ) {
				return $( el ).closest( ".js_tab" ).is( $tab );
			} )
			.each( function ( _i, el ) {
				$( el ).find( ".js_tab_heading:first" ).trigger( "click" );
			} )

	}



	/*
	 *
	 * Default UI State
	 *
	 */
	// Select the first tab in every tab container
	$( ".js_tab_container" )
		.find( ".js_tab_headings" )
		.filter( function ( _i, el ) {
			return $( el ).parents( ".js_tab_container" ).length === 1;
		} )
		.each( function ( _i, el ) {
			$( el ).find( ".js_tab_heading:first" ).trigger( "click" );
		} )

} );
