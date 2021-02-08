
( function () {

	// If the URL has a hash in it, don't show the disclaimer

	// If the disclaimer has already been viewed, do not proceed
	try {
		var lastSessionTimestamp = parseInt( localStorage.getItem( "bfs/last_session_timestamp" ), 10 );
		if ( ! lastSessionTimestamp || window.isNaN( lastSessionTimestamp ) )
			lastSessionTimestamp = 0;

		if ( ( ( new Date ).getTime() - lastSessionTimestamp ) < ( 3600 * 100 ) )
			return;
	}
	catch ( e ) {}

	window.__BFS = window.__BFS || { }
	window.__BFS.disclaimerIsDue = true;

	// show the disclaimer
	$( "#page-wrapper" ).addClass( "freeze" );
	$( "#js_laz_disclaimer_markup" ).show();

	$('.js_laz_agree').on('click', function () {

		// record the fact that the disclaimer has been viewed
		try {
			localStorage.setItem( "bfs/last_session_timestamp", ( new Date ).getTime() );
		}
		catch ( e ) {}

		$( "#js_laz_disclaimer_markup" ).remove();
		// $( ".js_laz_disclaimer" ).remove();
		$('#page-wrapper').removeClass('freeze');

		$( document ).trigger( "disclaimer/close" );

	} );

}() );
