
$( function () {

	/*
	 * References to elements
	 */
	var $amenities = $( ".js_amenities" );
	var $amenityGroups = $amenities.find( "[ data-amenity-group ]" );
	var $amenityHeadings = $amenities.find( ".js_amenity_headings" );


	/*
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 *  Amenity Sub-Group Level
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 */
	/*
	 * When an amenity sub-heading is "clicked" on,
	 * 	display the corresponding sub-group and hide the rest
	 */
	$amenityGroups.on( "click", ".js_amenity_subgroup_heading", function ( event ) {
		var $amenitySubGroupHeading = $( event.target );
		var $amenityGroup = $amenitySubGroupHeading.closest( "[ data-amenity-group ]" );
		// Get the selected amenity group and sub-group names
		var amenityGroupName = $amenityGroup.data( "amenity-group" );
		var amenitySubGroupName = $amenitySubGroupHeading.text();
		// Toggle the amenity sub-group
		toggleAmenitySubGroup( amenityGroupName, amenitySubGroupName );
	} );
	/*
	 * When an amenity sub-heading is "selected" ( via the select box ),
	 * 	display the corresponding sub-group and hide the rest
	 */
	$amenityGroups.on( "change", ".js_amenity_subgroup_headings", function ( event ) {
		var $amenityGroup = $( event.target ).closest( "[ data-amenity-group ]" );
		// Get the selected amenity group and sub-group names
		var amenityGroupName = $amenityGroup.data( "amenity-group" );
		var amenitySubGroupName = event.target.value;
		// Toggle the amenity sub-group
		toggleAmenitySubGroup( amenityGroupName, amenitySubGroupName );
	} );

	/*
	 * Selects an amenity sub-group given its name and parent group's name
	 */
	function toggleAmenitySubGroup ( group, subGroup ) {
		var $amenityGroup = $amenityGroups.filter( "[ data-amenity-group = '" + group + "' ]" );
		var $amenitySubGroupHeadings = $amenityGroup.find( ".js_amenity_subgroup_headings" );
		// Select the `div` version of the input
		var $amenitySubHeading__DivElement = $amenitySubGroupHeadings.find( ".js_amenity_subgroup_heading" ).filter( ":contains('" + subGroup + "')" );
		$amenitySubGroupHeadings.find( ".js_amenity_subgroup_heading" ).removeClass( "active" );
		$amenitySubHeading__DivElement.addClass( "active" );
		// Select the `select` version of the input
		var $amenitySubHeading__OptionElement = $amenitySubGroupHeadings.filter( "select" );
		$amenitySubHeading__OptionElement.val( subGroup );
		// Toggle the corresponding UI
		var $amenitySubGroups = $amenityGroup.find( "[ data-amenity-subgroup ]" );
		var $amenitySubGroup = $amenitySubGroups.filter( "[ data-amenity-subgroup = '" + subGroup + "' ]" );
		$amenitySubGroups.addClass( "hidden" );
		$amenitySubGroup.removeClass( "hidden" );
	}



	/*
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 *  Amenity Group Level
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 */
	/*
	 * When an amenity heading is "clicked" on,
	 * 	display the corresponding group and hide the rest
	 */
	$amenityHeadings.on( "click", ".js_amenity_heading", function ( event ) {
		// Get the selected amenity group name
		var amenityGroupName = $( event.target ).text();
		// Toggle the amenity group
		toggleAmenityGroup( amenityGroupName );
	} );
	/*
	 * When an amenity heading is "selected" ( via the select box ),
	 * 	display the corresponding group and hide the rest
	 */
	$amenityHeadings.on( "change", function ( event ) {
		// Get the selected amenity group name
		var amenityGroupName = event.target.value;
		// Toggle the amenity group
		toggleAmenityGroup( amenityGroupName );
	} );

	/*
	 * Selects an amenity group given its name
	 */
	function toggleAmenityGroup ( name ) {
		// Select the `div` version of the input
		var $amenityHeading__DivElement = $amenityHeadings.find( ".js_amenity_heading" ).filter( ":contains('" + name + "')" );
		$amenityHeadings.find( ".js_amenity_heading" ).removeClass( "active" );
		$amenityHeading__DivElement.addClass( "active" );
		// Select the `select` version of the input
		var $amenityHeading__OptionElement = $amenityHeadings.filter( "select" );
		$amenityHeading__OptionElement.val( name );
		// Toggle the corresponding UI
		var $amenityGroup = $amenityGroups.filter( "[ data-amenity-group = '" + name + "' ]" );
		$amenityGroups.addClass( "hidden" );
		$amenityGroup.removeClass( "hidden" );
		// By default, select the first sub-group
		$amenityGroup.find( ".js_amenity_subgroup_heading" ).first().trigger( "click" );
	}



	/*
	 *
	 * Default UI State
	 *
	 */
	// Select the first amenity heading
	$amenityHeadings.find( ".js_amenity_heading" ).first().trigger( "click" );


} );
