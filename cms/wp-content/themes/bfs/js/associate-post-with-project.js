
wp.domReady( function () {

if ( wp.data.select( "core/editor" ).getCurrentPostType() !== "update" )
	return;


// Blur focus from the post title field
window.document.activeElement.blur();




const { get, groupBy } = lodash;

const { registerPlugin } = wp.plugins;
const { compose } = wp.compose;
const { PluginDocumentSettingPanel, PluginPrePublishPanel } = wp.editPost;
const { PageAttributesParent } = wp.editor;

const { select, dispatch, withSelect, withDispatch, useSelect, useDispatch } = wp.data;

const { __experimentalNumberControl: NumberControl, SelectControl, TreeSelect } = wp.components;

const { __ } = wp.i18n;
const { createElement: el } = wp.element;

const { useState, useEffect } = wp.element;



/*
 *
 * State
 *
 */
const PLUGIN_NAME = "bfs-associate-post-with-project-plugin";
// let projectPosts;
let selectedProject;
let selectedMonth;
let selectedYear;

// Set initial values
{
	let defaultPublishDateString = wp.data.select( "core/editor" ).getEditedPostAttribute( "date" )
	let dateInISOFormat = defaultPublishDateString + ".000Z";
	let dateObject = new Date( dateInISOFormat );

	selectedMonth = dateObject.getMonth() + 1;
	selectedYear = dateObject.getFullYear();
}
updatePostSlugBasedOnDate();
updatePostTitleBasedOnDateAndProject();





function ProjectSelectorComponent ( {
	parent,
	postType,
	postTypeSingularLabel,
	postTypePluralLabel,
	items,
	setParentPost
} ) {
	const pageItems = items || [ ];
	if ( ! pageItems.length ) {
		return "No " + postTypePluralLabel + " found.";
	}

	let postOptions = pageItems.map( item => {
		return { label: item.title.rendered, value: item.id };
	} );
	postOptions.unshift( { label: "Select a " + postTypeSingularLabel + ".", value: "", disabled: true } );

	useEffect( function () {
		// let post = pagesTree.find( page => page.id == parent );
		let post = postOptions.find( post => post.value == parent );
		if ( post && post.value ) {
			// let postTitle = post.name;
			let postTitle = post.label;
			wp.hooks.doAction( `on${ postTypeSingularLabel }Update`, postTitle );
		}
	}, [ parent ] );

	return el( SelectControl, {
		value: parent || "",
		options: postOptions,
		onChange: setParentPost
	} );
}

const applyWithSelect = withSelect( ( select ) => {
	const { getEntityRecords } = select( "core" );
	const { getEditedPostAttribute } = select( "core/editor" );
	const postType = "projects";
	const postTypeSingularLabel = "Project";
	const postTypePluralLabel = "Projects";
	const query = {
		per_page: -1,
		orderby: "menu_order",
		order: "asc",
		_fields: "id,title,parent",
	};

	return {
		parent: getEditedPostAttribute( "parent" ),
		items: getEntityRecords( "postType", postType, query ),
		postType,
		postTypeSingularLabel,
		postTypePluralLabel
	};
} );

const applyWithDispatch = withDispatch( ( dispatch ) => {
	const { editPost } = dispatch( "core/editor" );
	return {
		setParentPost( parent ) {
			editPost( { parent: parent || 0 } );
		},
	};
} );

const ProjectSelector = compose( [ applyWithSelect, applyWithDispatch ] )( ProjectSelectorComponent );




/*
 *
 * Date Selection
 *
 */
let monthOptions = [
	{ label: "January", value: 0 },
	{ label: "February", value: 1 },
	{ label: "March", value: 2 },
	{ label: "April", value: 3 },
	{ label: "May", value: 4 },
	{ label: "June", value: 5 },
	{ label: "July", value: 6 },
	{ label: "August", value: 7 },
	{ label: "September", value: 8 },
	{ label: "October", value: 9 },
	{ label: "November", value: 10 },
	{ label: "December", value: 11 }
];

function DateSelector ( { date, setDate } ) {

	function onMonthChange ( month ) {
		dateObject.setDate( 1 );
		dateObject.setMonth( month );
		setDate( dateObject );
	}
	function onYearChange ( year ) {
		dateObject.setDate( 1 );
		dateObject.setFullYear( year );
		setDate( dateObject );
	}

	let dateInISOFormat = date + ".000Z";
	let dateObject = new Date( dateInISOFormat );

	let month = dateObject.getMonth();
	let year = dateObject.getFullYear();

	return el( wp.element.Fragment, { },
		el( SelectControl, {
			label: "Month",
			value: month,
			options: monthOptions,
			onChange: onMonthChange
		} ),
		el( NumberControl, {
			label: "Year",
			value: year,
			onChange: onYearChange
		} )
	)
}





function DocumentSettingsPanelWidget ( { date, setDate } ) {
	return el( wp.element.Fragment, { },
		el( PluginDocumentSettingPanel,
			{ title: "Associated Project", panelName: "document-panel-associated-project", opened: true, className: "document-panel-associated-project", icon: "..." },
			el( ProjectSelector )
		),
		el( PluginDocumentSettingPanel,
			{ title: "Date", panelName: "document-panel-date", opened: true, className: "document-panel-date", icon: "..." },
			el( DateSelector, { date, setDate } )
		)
	);
}
function PrePublishPanelWidget ( { date, setDate } ) {
	return el( wp.element.Fragment, { },
		el( PluginPrePublishPanel,
			{ title: "Associated Project", initialOpen: true, icon: "..." },
			el( ProjectSelector )
		),
		el( PluginPrePublishPanel,
			{ title: "Date", initialOpen: true, icon: "..." },
			el( DateSelector, { date, setDate } )
		)
	);
}
function RootContext ( { children } ) {

	function setDate ( dateObjectOrString ) {
		let dateString;
		if ( typeof dateObjectOrString === "string" )
			dateString = dateObjectOrString;
		else
			dateString = dateObjectOrString.toISOString().slice( 0, -5 );

		setDateString( dateString );
		editPost( { date: dateString } );
		// wp.hooks.doAction( "onDateUpdate", dateString );
	}
	let { dateString__FromDB } = useSelect( function ( select ) {
		return {
			dateString__FromDB: select( "core/editor" ).getEditedPostAttribute( "date" )
		}
	} );
	// This is a local cache of the date value (to prevent it from being changed externally)
	let [ dateString, setDateString ] = useState( dateString__FromDB );
	let { editPost } = useDispatch( "core/editor" );

	// If the date from the DB/Environment does not match what's in the local cache, use the value from the cache
	if ( dateString !== dateString__FromDB )
		setDate( dateString );


	useEffect( function () {
		wp.hooks.doAction( "onDateUpdate", dateString );
	}, [ dateString ] );


	return el( wp.element.Fragment, { }, [
		DocumentSettingsPanelWidget( { date: dateString, setDate } ),
		PrePublishPanelWidget( { date: dateString, setDate } )
	] );

}



/*
 *
 * Update the post slug whenever the date changes
 *
 */
wp.hooks.addAction( "onDateUpdate", PLUGIN_NAME, function ( dateString ) {
	let dateInISOFormat = dateString + ".000Z";
	let dateObject = new Date( dateInISOFormat );

	selectedMonth = dateObject.getMonth() + 1;
	selectedYear = dateObject.getFullYear();

	updatePostSlugBasedOnDate();
	updatePostTitleBasedOnDateAndProject();
} );
wp.hooks.addAction( "onProjectUpdate", PLUGIN_NAME, function ( projectName ) {
	selectedProject = projectName;
	updatePostTitleBasedOnDateAndProject();
} );

function updatePostSlugBasedOnDate () {
	let monthIndexMap = { "1": "jan", "2": "feb", "3": "mar", "4": "apr", "5": "may", "6": "jun", "7": "jul", "8": "aug", "9": "sept", "10": "oct", "11": "nov", "12": "dec" };
	let monthName = monthIndexMap[ selectedMonth ];
	let slug = monthName + "-" + selectedYear;
	wp.data.dispatch( "core/editor" ).editPost( { slug } );
}
function updatePostTitleBasedOnDateAndProject () {
	let monthIndexMap = { "1": "January", "2": "February", "3": "March", "4": "April", "5": "May", "6": "June", "7": "July", "8": "August", "9": "September", "10": "October", "11": "November", "12": "December" };
	let monthName = monthIndexMap[ selectedMonth ];
	let title = `${ selectedProject || "Project" } | ${ monthName }, ${ selectedYear }`;
	wp.data.dispatch( "core/editor" ).editPost( { title } );
}









/*
 *
 *
 *
 */
function AssociatePostWithProjectPlugin () {
	return el( RootContext );
}

registerPlugin( PLUGIN_NAME, {
	render: AssociatePostWithProjectPlugin
} );



/*
 *
 * Open the panels up by default, and close some default ones
 *
 */
setTimeout( function () {

	let allPanels = select( "core/edit-post" ).getPreference( "panels" );
	let ourPanels = [ `${ PLUGIN_NAME }/document-panel-associated-project`, `${ PLUGIN_NAME }/document-panel-date`, `${ PLUGIN_NAME }/undefined` ];

	if ( allPanels[ "post-status" ] && allPanels[ "post-status" ].opened )
		dispatch( "core/edit-post" ).toggleEditorPanelOpened( "post-status" );

	for ( let panelName of ourPanels )
		if ( ! allPanels[ panelName ] || ! allPanels[ panelName ].opened )
			dispatch( "core/edit-post" ).toggleEditorPanelOpened( panelName );

}, 1000 );





} );
