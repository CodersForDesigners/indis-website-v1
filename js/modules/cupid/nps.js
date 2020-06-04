
window.__CUPID = window.__CUPID || { };
window.__CUPID.NPS = { };

XLSX_CALC.import_functions( window.spreadsheetFormulae );

/*
 *
 * Fetch the questionnaire
 *
 */
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


/*
 *
 * Get the list of **current** queue statuses of all the questions
 *
 */
function getQueue () {
	var rowCount = __CUPID.NPS.workbook.Sheets.Que[ "!ref" ].match( /\d+$/ )[ 0 ];
	var range = "A1:A" + rowCount;
	return XLSX.utils.sheet_to_json( __CUPID.NPS.workbook.Sheets.Que, { raw: true, range: range } );
}


/*
 *
 * Prune out unsupported formulaes so that they don't error out the calculation process.
 * 	Also, remove the padding that Google Sheets add in for formulaes that **it** thinks are not supported, when in fact **we** support them.
 *
 */
var sanitizeUnsupportedFormulae = function () {
	var unsupportedFormulaes = [ "VOID" ];
	var unsupportedFormulaesRegex = new RegExp( "(" + unsupportedFormulaes.join( "|" ) + ")\\(" );
	return function sanitizeUnsupportedFormulae ( formulae ) {
		if ( ! formulae )
			return;

		if ( ! formulae.startsWith( "IFERROR(__xludf.DUMMYFUNCTION" ) )
			return formulae;

		if ( unsupportedFormulaesRegex.test( formulae ) )
			return "";

		// If the formulae is supported but is enclosed in all nonsense, then trim it out
		return formulae
			.replace( "IFERROR(__xludf.DUMMYFUNCTION(\"", "" )
			.replace( /\n/g, "" )
			.replace( /""/g, "\"" )
			.replace( /"\),(TRUE|FALSE)\)$/, "" )
	};
}();



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
			resolve( $( response ) );
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
function renderQuestion ( $question ) {
	$question.css( "display", "none" );
	var $nps = $( ".js_nps_section" );
	var $existingQuestion = $nps.find( ".js_nps_card" );

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

	return $question;
}



/*
 *
 * Interpret the spreadsheet and build the questionnaire data structure
 *
 */
function initQuestionnaire ( workbook ) {

	// Store a reference to the workbook
	window.__CUPID.NPS.workbook = workbook;

	// Prune out all the unsupported formulaes
	var sheetName;
	var _cellName;
	for ( sheetName in workbook.Sheets ) {
		var sheet = workbook.Sheets[ sheetName ];
		for ( _cellName in sheet ) {
			var cell = sheet[ _cellName ];
			if ( cell.f )
				cell.f = sanitizeUnsupportedFormulae( cell.f )
		}
	}

	// Parse the build the questionnaire object
	window.__CUPID.NPS.questionnaire = XLSX.utils.sheet_to_json( workbook.Sheets.Que, { raw: true } ).map( function ( question, _index ) {
		if ( question[ "Options" ] )
			question[ "Options" ] = question[ "Options" ].split( "\n" )
		return {
			index: _index + 1,
			question: question[ "Question" ],
			type: question[ "Option Type" ],
			options: question[ "Options" ],
		};
	} );

	window.__CUPID.NPS.questionnaireSettings = getSpreadsheetKeysAndValues( workbook, "Settings" );

	// Initialise the current question index (it'll become 0 eventually)
	// window.__CUPID.NPS.currentQuestionIndex = -1;

}



function getSpreadsheetKeysAndValues ( workbook, sheetName ) {

	var sheet = workbook.Sheets[ sheetName ];
	var startAndEndCells = sheet[ "!ref" ].split( ":" );
	var firstRow = parseInt( startAndEndCells[ 0 ].match( /\d+/ )[ 0 ], 10 );
	var lastRow = parseInt( startAndEndCells[ 1 ].match( /\d+/ )[ 0 ], 10 );
	var lastColumn = startAndEndCells[ 1 ].match( /[A-Z]+/ )[ 0 ];

	keyValuePairs = { };
	var currentRow, key, value;
	for ( currentRow = firstRow; currentRow <= lastRow; currentRow += 1 ) {
		if ( ! sheet[ "A" + currentRow ] )
			continue;
		key = sheet[ "A" + currentRow ].v
		value = sheet[ "B" + currentRow ] ? sheet[ "B" + currentRow ].v : "";
		keyValuePairs[ key ] = value
	}

	return keyValuePairs;

}


/*
 *
 * Write answers to the questionnaire and evaluate
 *
 */
function setAnswers ( answers, fromIndex ) {

	fromIndex = fromIndex || 0;
	// An answer can be a string or an array.
	// First, we determine if we've been given a single answer or multiple answers
	var inputDataStructure;

	if ( typeof answers === "string" || typeof answers === "number" )
		inputDataStructure = [ [ answers ] ];
	else if ( Array.isArray( answers ) ) {
		var multipleAnswersHaveBeenProvided = Array.isArray( answers.find( function ( answer ) {
			return Array.isArray( answer )
		} ) );
		if ( multipleAnswersHaveBeenProvided ) {
			var formattedAnswers = answers.map( function ( answer ) {
				if ( ! answer )
					answer = "";
				else if ( Array.isArray( answer ) )
					answer = answer.join( "\n" );
				return [ answer ];
			} );
			inputDataStructure = formattedAnswers;
		}
		else
			inputDataStructure = [ [ answers.join( "\n" ) ] ];
	}
	else
		return;

	var inputSheet = window.__CUPID.NPS.workbook.Sheets.Que;
	var origin = "E" + ( fromIndex + 2 );
	XLSX.utils.sheet_add_aoa( inputSheet, inputDataStructure, { origin: origin } );
	XLSX_CALC( window.__CUPID.NPS.workbook );

}
window.__CUPID.NPS.setAnswers = setAnswers;

/*
 *
 * Get the index of the next question
 *
 */
function getNextQuestionIndex ( currentQuestionIndex ) {
	var questionnaire = window.__CUPID.NPS.questionnaire;
	var queue = getQueue();

	var nextQuestionIndex;
	for ( let _i = currentQuestionIndex + 1; _i < queue.length; _i += 1 ) {
		if ( queue[ _i ].Que ) {
			nextQuestionIndex = _i;
			break;
		}
	}

	return nextQuestionIndex;
}
window.__CUPID.NPS.getNextQuestionIndex = getNextQuestionIndex;



function askQuestion ( questionIndex ) {

	questionIndex = questionIndex || 0;
	var questionnaire = window.__CUPID.NPS.questionnaire;
	var question = questionnaire[ questionIndex ];

	/*
	 *
	 * Render the question
	 *
	 */
	// But first, if there is no NPS spot on the page, do nothing, just abort
	var $nps = $( ".js_nps_section" );
	if ( ! $nps.length )
		return;

	getQuestionMarkup( question )
		.then( renderQuestion )
		.then( function ( $question ) {
			// Advance the current question index pointer
			window.__CUPID.NPS.currentQuestionIndex = questionIndex;
			// If the end of the questionnaire has been reached, acknowledge and store that fact
			if ( ! $question.find( "[ type = 'submit' ]" ).length )
				acknowledgeQuestionnaireCompletion();
		} )

}
window.__CUPID.NPS.askQuestion = askQuestion;


/*
 *
 * ----- Only show the submit button when the input provided is sufficient and valid
 *
 */
function allowFormSubmitIfDataIsValid ( event ) {

	var $form = $( event.target ).closest( "form" );
	var type = $form.data( "type" );
	var $submitButton = $form.find( "[ type = 'submit' ]" )
	var inputIsValid = false;

	if ( type === "nps_range" )
		inputIsValid = !! $form.find( "input:checked" ).length;
	else if ( type === "text_input" )
		inputIsValid = $form.find( "textarea" ).val().trim().length > 1;
	else if ( type === "single_select" )
		inputIsValid = !! $form.find( "input:checked" ).length;
	else if ( type === "multi_select" )
		inputIsValid = !! $form.find( "input:checked" ).length;

	if ( inputIsValid )
		$submitButton.prop( "disabled", false ).removeClass( "invisible opacity-0" )
	else
		$submitButton.prop( "disabled", true ).addClass( "invisible opacity-0" )

}
$( document ).on( "change", ".js_nps_answer input", allowFormSubmitIfDataIsValid );
$( document ).on( "input", ".js_nps_answer textarea", allowFormSubmitIfDataIsValid );


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
	 *  Pull data from the form and validate it
	 ----- */
	var type = $form.data( "type" );
	var answer;
	var providedInputIsInvalid = false;
	var invalidInputMessage;
	if ( type === 'nps_range' ) {
		answer = parseInt( $form.find( "input:checked" ).val(), 10 );
		if ( ! $form.find( "input:checked" ).length ) {
			providedInputIsInvalid = true;
			invalidInputMessage = "Kindly select a score."
		}
	}
	else if ( type === 'text_input' ) {
		answer = $form.find( "textarea" ).val().trim();
		if ( answer.length < 2 ) {
			providedInputIsInvalid = true;
			invalidInputMessage = "Kindly fill in a response."
		}
	}
	else if ( type === 'single_select' ) {
		answer = $form.find( "input:checked" ).val()
		if ( ! $form.find( "input:checked" ).length ) {
			providedInputIsInvalid = true;
			invalidInputMessage = "Kindly select an answer."
		}
	}
	else if ( type === 'multi_select' ) {
		answer = Array.prototype.slice.call( $form.find( "input:checked" ) ).map( el => el.value )
		if ( ! answer.length ) {
			providedInputIsInvalid = true;
			invalidInputMessage = "Kindly select at least one answer."
		}
	}

	if ( providedInputIsInvalid )
		return alert( invalidInputMessage );


	/* -----
	 *  Disable the form and display feedback
	 ----- */
	disableForm( $form, "Sending....." );



	/* -----
	 *  Send the data
	 ----- */
	// Trigger the send queue (asynchronously) (i.e. there can be more than one Q&A pairs that need to be synced)
		// If the first one in the queue fails, do not move on to the next one (remember, they have to be synced in sequence)
	var currentQuestionIndex = window.__CUPID.NPS.currentQuestionIndex;
	var questionnaire = window.__CUPID.NPS.questionnaire
	var currentQuestion = questionnaire[ currentQuestionIndex ];
	var data = {
		index: currentQuestion.index,
		question: currentQuestion.question,
		answer: answer
	};
	submitQAndA( data );



	/* -----
	 *  TODO: Append the stored data with this new answer; and sync all this to the cookie
	 ----- */
	// But first, simply acknowledge that the questionnaire has been interacted with
	var person = __CUPID.Person.get();
	person.setQuestionnaireVersion( window.__CUPID.NPS.questionnaireSettings.Version );
	person.answeredQuestion( currentQuestion.index, currentQuestion.question, answer );
	person.saveLocally();



	/* -----
	 *  Present the next question in the sequence
	 ----- */
	setAnswers( answer, currentQuestionIndex );
	var nextQuestionIndex = getNextQuestionIndex( currentQuestionIndex );
	if ( questionnaire[ nextQuestionIndex ].type === "phone_number" )
		if ( person.isRegistered() )
			nextQuestionIndex = getNextQuestionIndex( nextQuestionIndex );
	askQuestion( nextQuestionIndex );

} );



/*
 *
 * Submit a Q&A pair
 *
 */
function submitQAndA ( data ) {

	if ( ! data.index || ! data.question || ! data.answer )
		return;

	var questionnaireVersion = __CUPID.NPS.questionnaireSettings.Version.match( /\d+/ )[ 0 ];
	var data = {
		questionnaireVersion: questionnaireVersion,
		index: data.index,
		question: data.question,
		answer: data.answer,
		answeredOn: new Date
	};

	var person = __CUPID.Person.get();
	data.client = person.client;
	data.personClientId = person._tempClientId;
	data.context = window.location.pathname;
	if ( person.isRegistered() )
		data.phoneNumber = person.phoneNumber;

	var apiEndpoint = __CUPID.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/hooks/questionnaire/answered-a-question";

	var ajaxRequest = $.ajax( {
		url: url,
		method: "POST",
		data: JSON.stringify( data ),
		contentType: "application/json",
		dataType: "json",
		// xhrFields: {
		// 	withCredentials: true
		// }
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
 * Acknowledge the end of the Questionnaire
 *
 */
function acknowledgeQuestionnaireCompletion () {

	var person = __CUPID.Person.get();
	person.completedQuestionnaire();
	person.saveLocally();

	var data = {
		client: person.client,
		personClientId: person._tempClientId,
		questionnaireVersion: __CUPID.NPS.questionnaireSettings.Version
	};

	if ( person.isRegistered() )
		data.phoneNumber = person.phoneNumber;

	var apiEndpoint = __CUPID.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/hooks/questionnaire/completed";

	var ajaxRequest = $.ajax( {
		url: url,
		method: "POST",
		data: JSON.stringify( data ),
		contentType: "application/json",
		dataType: "json",
		// xhrFields: {
		// 	withCredentials: true
		// }
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
