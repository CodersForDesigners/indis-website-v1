
window.__CUPID = window.__CUPID || { };
window.__CUPID.nps = { };

XLSX_CALC.import_functions( window.spreadsheetFormulae );

function fetchQuestionnaireSpreadsheet () {

	var url = "/content/data/nps.xlsx" + "?t=" + ( new Date() ).getTime();

	// Set up an async GET request
	var request = new XMLHttpRequest();
	request.open( "GET", url, true );
	request.responseType = "arraybuffer";

	return new Promise( function ( resolve, reject ) {

		request.onload = function ( event ) {

			var data = new Uint8Array( request.response );
			var workbook = XLSX.read(
				data,
				{
					type: "array",
					cellHTML: false,
					cellText: false
				}
			);

			resolve( workbook );

		}

		request.onerror = reject;

		request.send();

	} );

}

function getQueue () {
	var rowCount = __CUPID.nps.workbook.Sheets.Que[ "!ref" ].match( /\d+$/ )[ 0 ];
	var range = "A1:A" + rowCount;
	return XLSX.utils.sheet_to_json( __CUPID.nps.workbook.Sheets.Que, { raw: true, range: range } );
}

function initQuestionnaire () {

	return fetchQuestionnaireSpreadsheet().then( function ( workbook ) {
		// Store a reference to the workbook
		window.__CUPID.nps.workbook = workbook;

		// Prune out all the unsupported formulaes
		var unsupportedFormulaes = [ "VOID" ];
		var unsupportedFormulaesRegex = new RegExp( "(" + unsupportedFormulaes.join( "|" ) + ")\\(" );
		var sheetName
		for ( sheetName in workbook.Sheets ) {
			var sheet = workbook.Sheets[ sheetName ];
			for ( _cellName in sheet ) {
				cell = sheet[ _cellName ];
				if ( cell.f && cell.f.startsWith( "IFERROR(__xludf.DUMMYFUNCTION" ) ) {
					console.log( _cellName )
					if ( unsupportedFormulaesRegex.test( cell.f ) )
						cell.f = "";
					else
						cell.f = cell.f
									.replace( "IFERROR(__xludf.DUMMYFUNCTION(\"", "" )
									.replace( /\n/g, "" )
									.replace( /""/g, "\"" )
									.replace( /"\),(TRUE|FALSE)\)$/, "" );
				}
			}
		}

		// Parse the build the questionnaire object
		window.__CUPID.nps.questionnaire = XLSX.utils.sheet_to_json( workbook.Sheets.Que, { raw: true } ).map( function ( question, _index ) {
			if ( question[ "Options" ] )
				question[ "Options" ] = question[ "Options" ].split( "\n" )
			return {
				index: _index,
				question: question[ "Question" ],
				type: question[ "Option Type" ],
				options: question[ "Options" ],
			};
		} );

		window.__CUPID.nps.currentQuestionIndex = -1;

	} )

}

$( document ).on( "nps/question/render", function () {
	var questionnaire = window.__CUPID.nps.questionnaire;
	var queue = getQueue();
	console.table( queue )

	/*
	 *
	 * Determine the next question in the sequence
	 *
	 */
	// Get the index of the next question
	var nextQuestionIndex;
	for ( let _i = window.__CUPID.nps.currentQuestionIndex + 1; _i < queue.length; _i += 1 ) {
		if ( queue[ _i ].Que ) {
			nextQuestionIndex = _i;
			break;
		}
	}
	var nextQuestion = questionnaire[ nextQuestionIndex ];

	/*
	 *
	 * Render the question
	 *
	 */
	getQuestionMarkup( nextQuestion )
		.then( renderQuestion )
		.then( function () {
			window.__CUPID.nps.currentQuestionIndex = nextQuestionIndex;
		} )

} );



/*
 *
 * Handler for when an answer is submitted
 *
 */
$( document ).on( "submit", ".js_nps_answer", function ( event ) {

	/* -----
	 * Prevent the default form submission behaviour
	 * 	which triggers the loading of a new page
	 ----- */
	event.preventDefault();


	var $form = $( event.target );


	/* -----
	 *  Disable the form and display feedback
	 ----- */
	disableForm( $form, "Sending....." );

	/* -----
	 *  Pull data from the form
	 ----- */
	var type = $form.data( "type" );
	var data = { };
	if ( type === 'nps_range' )
		data.answer = parseInt( $form.find( "input:checked" ).val(), 10 );
	else if ( type === 'text_input' )
		data.answer = $form.find( "textarea" ).val().trim();
	else if ( type === 'single_select' )
		data.answer = $form.find( "input:checked" ).val()
	else if ( type === 'multi_select' )
		data.answer = Array.prototype.slice.call( $form.find( "input:checked" ) ).map( el => el.value )


	/* -----
	 *  TODO: Send the data
	 ----- */



	/* -----
	 *  Write the answer back to the questionnaire and evaluate
	 ----- */
	// XLSX.utils.sheet_add_aoa( inputSheet, inputDataStructure, { origin: "C3" } );
	var inputSheet = window.__CUPID.nps.workbook.Sheets.Que;
	var answer = data.answer;
	if ( Array.isArray( answer ) )
		answer = answer.join( "\n" )
	var inputDataStructure = [ [ answer ] ];
	var origin = "E" + ( window.__CUPID.nps.currentQuestionIndex + 2 );
	XLSX.utils.sheet_add_aoa( inputSheet, inputDataStructure, { origin: origin } );
	XLSX_CALC( window.__CUPID.nps.workbook );


	/* -----
	 *  Render the next question in the sequence
	 ----- */
	$( document ).trigger( "nps/question/render" );

} );



/*
 *
 * The questionnaire structure
 *
 */
// 	var questionnaire = [
// 		{
// 			// inQueue: true,
// 			question: `<div class="label strong text-uppercase text-neutral-2 space-min-bottom">Give us your feedback</div>
// <div class="h4 strong space-25-bottom">How likely are <span class="text-red-2">you</span> to recommend INDIS to a friend or colleague?</div>`,
// 			type: "",
// 			options: [ ],
// 			answer: ""
// 		},
// 		{
// 			// inQueue: false,
// 			question: `<h1>Thank you!! What did <strong>you</strong> like about Guesture?</h1>`,
// 			type: "",
// 			options: [ ],
// 			answer: ""
// 		},
// 	];



/*
 *
 * Get the markup for a question
 *
 */
function getQuestionMarkup ( question ) {

	var ajaxRequest = $.ajax( {
		url: "/inc/get-nps-question.php",
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			"Accept": "text/html; charset=UTF-8"
		},
		data: JSON.stringify( question )
	} );

	return new Promise( function ( resolve, reject ) {
		ajaxRequest.done( function ( response ) {
			resolve( response );
		} );
		ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
			var errorResponse = __CUPID.utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

}

/*
 *
 * Render the question on the page
 *
 */
function renderQuestion ( questionMarkup ) {
	var $question = $( questionMarkup );
	$question.css( "display", "none" );
	var $nps = $( ".js_nps_section" );
	var $existingQuestion = $nps.find( ".js_question_card" );

	$existingQuestion
		.fadeOut( {
			complete: function () {
				$nps.append( $question );
				$question.fadeIn( {
					complete: function () {
						$existingQuestion.remove();
					}
				} );
			}
		} );
}
