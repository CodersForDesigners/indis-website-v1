
/*
 *
 * Construction Updates
 *
 */

$( function () {

	/*
	 * References to elements
	 */
	var $updatesSection = $( ".js_construction_updates_section" );
	var $updateGroupTitles = $updatesSection.find( ".js_update_group_titles" );
	var $updateGroups = $updatesSection.find( "[ data-update-group ]" );


	/*
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 *  Individual Update Level
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 */
	/*
	 * When an update title is "clicked" on,
	 * 	display the corresponding update and hide the rest
	 */
	$updateGroups.on( "click", ".js_update_title", function ( event ) {
		var $updateTitle = $( event.target );
		var $updateGroup = $updateTitle.closest( "[ data-update-group ]" );
		// Get the selected update group name, and the selected individual update name
		var updateGroupName = $updateGroup.data( "update-group" );
		var updateName = $updateTitle.text();
		// Toggle the update
		toggleUpdate( updateGroupName, updateName );
	} );
	/*
	 * When an update title is "selected" ( via the select box ),
	 * 	display the corresponding update and hide the rest
	 */
	$updateGroups.on( "change", ".js_update_titles", function ( event ) {
		var $updateGroup = $( event.target ).closest( "[ data-update-group ]" );
		// Get the selected update group name, and the selected individual update name
		var updateGroupName = $updateGroup.data( "update-group" );
		var updateName = event.target.value;
		// Toggle the amenity sub-group
		toggleUpdate( updateGroupName, updateName );
	} );

	/*
	 * Selects an update given its name and its containing group's name
	 */
	function toggleUpdate ( group, name ) {
		var $updateGroup = $updateGroups.filter( "[ data-update-group = '" + group + "' ]" );
		var $updateTitles = $updateGroup.find( ".js_update_titles" );
		// Select the `div` version of the input
		var $updateTitle__DivElement = $updateTitles.find( ".js_update_title" ).filter( ":contains('" + name + "')" );
		$updateTitles.find( ".js_update_title" ).removeClass( "active" );
		$updateTitle__DivElement.addClass( "active" );
		// Select the `select` version of the input
		var $updateTitle__OptionElement = $updateTitles.filter( "select" );
		$updateTitle__OptionElement.val( name );
		// Toggle the corresponding UI
		var $updates = $updateGroup.find( "[ data-update ]" );
		var $update = $updates.filter( "[ data-update = '" + name + "' ]" );
		$updates.addClass( "hidden" );
		$update.removeClass( "hidden" );
	}



	/*
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 *  Update Group Level
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 */
	/*
	 * When an update group title is "clicked" on,
	 * 	display the corresponding group and hide the rest
	 */
	$updateGroupTitles.on( "click", ".js_update_group_title", function ( event ) {
		var updateGroupName = $( event.target ).text();
		toggleUpdateGroup( updateGroupName );
	} );
	/*
	 * When an update title is "selected" ( via the select box ),
	 * 	display the corresponding group and hide the rest
	 */
	$updateGroupTitles.on( "change", function ( event ) {
		var updateGroupName = event.target.value;
		toggleUpdateGroup( updateGroupName );
	} );

	/*
	 * Selects an update group given its name
	 */
	function toggleUpdateGroup ( name ) {
		// Select the `div` version of the input
		var $updateGroupTitle__DivElement = $updateGroupTitles.find( ".js_update_group_title" ).filter( ":contains('" + name + "')" );
		$updateGroupTitles.find( ".js_update_group_title" ).removeClass( "active" );
		$updateGroupTitle__DivElement.addClass( "active" );
		// Select the `select` version of the input
		var $updateGroupTitle__OptionElement = $updateGroupTitles.filter( "select" );
		$updateGroupTitle__OptionElement.val( name );
		// Toggle the corresponding UI
		var $updateGroup = $updateGroups.filter( "[ data-update-group = '" + name + "' ]" );
		$updateGroups.addClass( "hidden" );
		$updateGroup.removeClass( "hidden" );
		// By default, select the first sub-group
		$updateGroup.find( ".js_update_title" ).first().trigger( "click" );
	}



	/*
	 *
	 * Default UI State
	 *
	 */
	// Select the first update group title
	$updateGroupTitles.find( ".js_update_group_title" ).first().trigger( "click" );


} );
