
$( function () {

	/*
	 * References to elements
	 */
	var $planSection = $( ".js_plan_section" );
	var $planGroupTitles = $planSection.find( ".js_plan_group_titles" );
	var $planGroups = $planSection.find( "[ data-plan-group ]" );


	/*
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 *  Individual Plan Level
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 */
	/*
	 * When a plan title is "clicked" on,
	 * 	display the corresponding plan and hide the rest
	 */
	$planGroups.on( "click", ".js_plan_title", function ( event ) {
		var $planTitle = $( event.target );
		var $planGroup = $planTitle.closest( "[ data-plan-group ]" );
		// Get the selected plan group name, and the selected individual plan name
		var planGroupName = $planGroup.data( "plan-group" );
		var planName = $planTitle.text();
		// Toggle the plan
		togglePlan( planGroupName, planName );
	} );
	/*
	 * When a plan title is "selected" ( via the select box ),
	 * 	display the corresponding plan and hide the rest
	 */
	$planGroups.on( "change", ".js_plan_titles", function ( event ) {
		var $planGroup = $( event.target ).closest( "[ data-plan-group ]" );
		// Get the selected plan group name, and the selected individual plan name
		var planGroupName = $planGroup.data( "plan-group" );
		var planName = event.target.value;
		// Toggle the amenity sub-group
		togglePlan( planGroupName, planName );
	} );

	/*
	 * Selects a plan given its name and its containing group's name
	 */
	function togglePlan ( group, name ) {
		var $planGroup = $planGroups.filter( "[ data-plan-group = '" + group + "' ]" );
		var $planTitles = $planGroup.find( ".js_plan_titles" );
		// Select the `div` version of the input
		var $planTitle__DivElement = $planTitles.find( ".js_plan_title" ).filter( ":contains('" + name + "')" );
		$planTitles.find( ".js_plan_title" ).removeClass( "active" );
		$planTitle__DivElement.addClass( "active" );
		// Select the `select` version of the input
		var $planTitle__OptionElement = $planTitles.filter( "select" );
		$planTitle__OptionElement.val( name );
		// Toggle the corresponding UI
		var $plans = $planGroup.find( "[ data-plan ]" );
		var $plan = $plans.filter( "[ data-plan = '" + name + "' ]" );
		$plans.addClass( "hidden" );
		$plan.removeClass( "hidden" );
	}



	/*
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 *  Plan Group Level
	 * -/-/-/-/-/-/-/-/-/-/-/-/-/-
	 */
	/*
	 * When a plan group title is "clicked" on,
	 * 	display the corresponding group and hide the rest
	 */
	$planGroupTitles.on( "click", ".js_plan_group_title", function ( event ) {
		var planGroupName = $( event.target ).text();
		togglePlanGroup( planGroupName );
	} );
	/*
	 * When a plan title is "selected" ( via the select box ),
	 * 	display the corresponding group and hide the rest
	 */
	$planGroupTitles.on( "change", function ( event ) {
		var planGroupName = event.target.value;
		togglePlanGroup( planGroupName );
	} );

	/*
	 * Selects a plan group given its name
	 */
	function togglePlanGroup ( name ) {
		// Select the `div` version of the input
		var $planGroupTitle__DivElement = $planGroupTitles.find( ".js_plan_group_title" ).filter( ":contains('" + name + "')" );
		$planGroupTitles.find( ".js_plan_group_title" ).removeClass( "active" );
		$planGroupTitle__DivElement.addClass( "active" );
		// Select the `select` version of the input
		var $planGroupTitle__OptionElement = $planGroupTitles.filter( "select" );
		$planGroupTitle__OptionElement.val( name );
		// Toggle the corresponding UI
		var $planGroup = $planGroups.filter( "[ data-plan-group = '" + name + "' ]" );
		$planGroups.addClass( "hidden" );
		$planGroup.removeClass( "hidden" );
		// By default, select the first sub-group
		$planGroup.find( ".js_plan_title" ).first().trigger( "click" );
	}



	/*
	 *
	 * Default UI State
	 *
	 */
	// Select the first plan group title
	$planGroupTitles.find( ".js_plan_group_title" ).first().trigger( "click" );


} );
