
( function ( $ ) {









/* -/-/-/-/- CODE STARTS HERE -/-/-/-/- */

// Export to global state
window.__CUPID = window.__CUPID || { };
// Make convenient references
var __ = window.__CUPID;
var utils = __.utils;





function LoginPrompt ( id, context, $site ) {
	this.id = id;
	this.context = context;
	this.$site = $site || $( document );
	this.$phoneForm = $site.find( "form.js_phone_form" );
	this.$OTPForm = $site.find( "form.js_otp_form" );
	// this.conversionUrl
	this.eventHandlers = { };
	// Store all instances of logins
	if ( ! LoginPrompt._instances )
		LoginPrompt._instances = { };
	LoginPrompt._instances[ id ] = this;

	// Trigger events on actions
	var loginPrompt = this;
	if ( this.$phoneForm.length ) {
		this.$phoneForm.on( "submit", function ( event ) {
			event.preventDefault();
			loginPrompt.trigger( "phoneSubmit", event );
		} );
	}
	this.$OTPForm.on( "submit", function ( event ) {
		event.preventDefault();
		loginPrompt.trigger( "OTPSubmit", event );
	} );
}
LoginPrompt.prototype.events = [
	"requirePhone", "phoneValidationError", "phoneSubmit", "phoneError",
	"requireOTP", "OTPSubmit", "OTPVerified", "OTPError",
	"login", "prepare"
];
LoginPrompt.prototype.triggerFlowOn = function triggerFlowOn ( event, elementSelector ) {
	this.triggerEvent = event;
	this.triggerElement = elementSelector;
	this.triggerRegion = $( elementSelector ).closest( ".js_login_trigger_region" );
	if ( this.triggerRegion.length )
		this.triggerRegion = this.triggerRegion.get( 0 );
	else
		this.triggerRegion = this.triggerElement;
	// Storing a reference to this
	let loginPrompt = this;
	return $( elementSelector ).on( event, function ( event ) {

		if ( Person.get().isRegistered() ) {
			// Restore any hyperlinks
			loginPrompt.$site.find( "a" ).each( function ( _i, domAnchor ) {
				var $anchor = $( domAnchor );
				var url = $anchor.data( "href" );
				if ( url )
					$anchor.attr( "href", url );
			} );
			// Take any other preparatory action
			loginPrompt.trigger( "prepare", Person.get() );
			loginPrompt.off( "prepare" );
			// Default to the default behavior
			return;
		}

		// If the user is **not** logged in,
		// 	prevent the registered event handlers from executing
		event.preventDefault();
		event.stopImmediatePropagation();

		// Prompt the user to log in
		loginPrompt.trigger( "requirePhone", event );

	} );
};
LoginPrompt.prototype.on = function on ( event, fn ) {
	if ( this.eventHandlers[ event ] )
		this.eventHandlers[ event ].push( fn );
	else
		this.eventHandlers[ event ] = [ fn ];
};
LoginPrompt.prototype.off = function on ( event ) {
	if ( this.eventHandlers[ event ] )
		this.eventHandlers[ event ] = [ ];
};
LoginPrompt.prototype.trigger = function trigger ( event, ...args ) {

	var eventHandlers = this.eventHandlers[ event ];
	if ( ! eventHandlers )
		return;

	var _i;
	for ( _i = 0; _i < eventHandlers.length; _i += 1 ) {
		eventHandlers[ _i ].apply( this, args );
	}

};
// Make this function accessible on the Cupid namespace
__.LoginPrompt = LoginPrompt;



function Person ( phoneNumber, sourcePoint ) {

	this.client = __.settings.clientSlug;
	this.source = { medium: __.settings.sourceMedium };

	this.hasPhoneNumber( phoneNumber );

	if ( sourcePoint )
		this.source.point = sourcePoint;

}
// Make this function accessible on the Cupid namespace
__.Person = Person;

/*
 *
 * Return an instance of Person.
 *
 * This user object is built from whatever can be inferred from the environment, else an anonymous user is created and returned.
 *
 */
Person.get = function get () {

	var firstVisit;
	if ( __.user )
		firstVisit = __.user.firstVisit;

	// TODO: Fetch from localStorage

	// Fetch from cookie
	var user = utils.getCookie( "cupid-user-20200430" );
	if ( user ) {
		__.user = new Person( user.phoneNumber );
		if ( __.user.isAnonymous() )
			__.user = new AnonymousPerson( user._tempClientId );
		else
			__.user = new RegisteredPerson( user.phoneNumber )
		__.user = utils.copyObjectProperties( user, __.user );
		__.user.firstVisit = firstVisit || false;
		return __.user;
	}

	// If a user is not present, create an anonymous one
	__.user = new AnonymousPerson();
	__.user.firstVisit = true;
	__.user.saveLocally();

	return __.user;

};

Person.login = function login ( person ) {
	__.user = person;
	person.saveLocally();
	return person;
};

Person.prototype.saveLocally = function saveLocally () {
	var person = utils.copyObjectProperties( this, { } );
	delete person.interests;
	delete person.firstVisit;
	// Set cookie ( for about a year )
	utils.setCookie( "cupid-user-20200430", person, 360 * 24 * 60 * 60 );
};

Person.prototype.isAnonymous = function isAnonymous () {
	return ! this.phoneNumber;
};

Person.prototype.isRegistered = function isRegistered () {
	return !! this.phoneNumber;
};

Person.prototype.isVerified = function isVerified () {
	return this.verification ? ( !! this.verification.isVerified ) : false;
}

Person.prototype.hasPhoneNumber = function hasPhoneNumber ( phoneNumber ) {
	if ( typeof phoneNumber == "string" )
		this.phoneNumber = phoneNumber;
	return this;
}

Person.prototype.setSource = function setSource ( medium, point ) {
	var source = this.source || { };
	if ( typeof medium == "string" )
		source.medium = medium;

	if ( typeof point == "string" )
		source.point = point;

	this.source = source;
	return this;
}

Person.prototype.getDeviceId = function getDeviceId () {
	return this.deviceId;
}

Person.prototype.hasDeviceId = function hasDeviceId ( id ) {
	if ( typeof id == "string" )
		this.deviceId = id;
	return this;
}

Person.prototype.isInterestedIn = function isInterestedIn ( things ) {

	// If the input neither a String or an Array, return
	if ( typeof things != "string" )
		if ( ! Array.isArray( things ) )
			return this;

	if ( typeof things == "string" )
		things = [ things ];

	// For backward compatibility
	if ( Array.isArray( things ) ) {
		things = things
					.reduce( function ( allThings, interest ) {
						if ( typeof interest == "object" )
							return allThings.concat(
								interest.product, interest.variant
							);
						else if ( typeof interest == "string" )
							return allThings.concat( interest );
						else
							return allThings;
					}, [ ] )
					.filter( function ( thing ) { return thing } )
	}


	this.interests = this.interests || [ ];
	this.interests = this.interests.concat( things );
	return this;

}



Person.prototype.getQuestionnaire = function getQuestionnaire () {
	return this.questionnaire;
}

Person.prototype.initializeQuestionnaire = function initializeQuestionnaire () {
	if ( this.questionnaire )
		return this.questionnaire;
	this.questionnaire = {
		completed: false,
		context: window.location.pathname
	};
	return this.questionnaire;
}

Person.prototype.setQuestionnaireVersion = function setQuestionnaireVersion ( version ) {
	if ( typeof version === "number" && ! isNaN( version ) )
		version = version + ""

	if ( typeof version === "string" ) {
		this.questionnaire = this.questionnaire || this.initializeQuestionnaire();
		this.questionnaire.version = version;
	}
	return this;
}

Person.prototype.answeredQuestion = function answeredQuestion ( index, question, answer ) {
	this.questionnaire = this.questionnaire || this.initializeQuestionnaire();
	this.questionnaire.qAndAs = this.questionnaire.qAndAs || [ ];

	var qAndAs = this.questionnaire.qAndAs;
	var existingQAndA = qAndAs.find( function ( qAndA ) { return qAndA.index === index } );
	if ( typeof existingQAndA === "object" )
		return;

	this.questionnaire.qAndAs = qAndAs.concat( {
		index: index,
		question: question,
		answer: answer
	} );
	return this;
}

Person.prototype.hasCompletedQuestionnaire = function hasCompletedQuestionnaire ( version ) {
	if ( typeof this.questionnaire !== "object" )
		return false;
	else if ( this.questionnaire.version === version )
		return !! this.questionnaire.completed;
	else
		return false;
}

Person.prototype.completedQuestionnaire = function completedQuestionnaire () {
	if ( typeof this.questionnaire === "object" )
		this.questionnaire.completed = true;
	return this;
}



/*
 * Fetch the person from the database
 */
Person.prototype.getFromDB = function getFromDB () {

	var data = {
		client: this.client,
		phoneNumber: this.phoneNumber
	};

	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/people";

	var ajaxRequest = $.ajax( {
		url: url,
		method: "GET",
		data: data,
		contentType: "application/json",
		dataType: "json",
		// xhrFields: {
		// 	withCredentials: true
		// }
	} );

	return new Promise( function ( resolve, reject ) {
		ajaxRequest.done( function ( response ) {
			var personFromDB = response.data;
			delete personFromDB._id;	// this is the internal DB id
			var person = Person.get();
			var sourcePoint = personFromDB.source && personFromDB.source.point;
			var newPerson = new RegisteredPerson( personFromDB.phoneNumber, sourcePoint );
			newPerson = utils.copyObjectProperties( personFromDB, newPerson );
			newPerson = utils.copyObjectProperties( person, newPerson );
			resolve( newPerson );
		} );
		ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
			var errorResponse = utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

};

/*
 * Add a person
 */
Person.prototype.add = function add () {

	var data = {
		client: this.client,
		phoneNumber: this.phoneNumber,
		source: this.source,
		deviceId: this.deviceId
	};

	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/people";

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
			var errorResponse = utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

};

/*
 *
 * Request an OTP to be sent to the person
 *
 */
Person.prototype.requestOTP = function requestOTP ( product, phoneNumber ) {

	var data = {
		client: this.client,
		phoneNumber: phoneNumber || this.phoneNumber,
		product: product
	};

	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/people/otp/send";

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

			if ( response.Status.toLowerCase() != "error" ) {
				// return the OTP Session ID
				resolve( response.Details );
				return;
			}

			var responseErrorMessage = response.Details.toLowerCase();
			// Message reads as follows:
				// Invalid Phone Number - Length Mismatch(Expected: 10)
			if ( /invalid/.test( responseErrorMessage ) ) {
				reject( { code: 1, message: "The phone number you've provided is not valid. Please try again." } );
				return;
			}
			else {
				reject( { code: 1, message: responseErrorMessage } );
				return;
			}

			resolve( response );
		} );
		ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
			var errorResponse = utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

}

/*
 * Verify the OTP person provided by a person
 */
Person.prototype.verifyOTP = function verifyOTP ( otp ) {

	var person = this;

	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/people/otp/verify";

	var data = {
		client: this.client,
		otp: otp,
		sessionId: this.otpSessionId
	};

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
			var verificationWasSuccessful = false;
			var responseErrorMessage = response.Details.toLowerCase();

			if ( /mismatch/.test( responseErrorMessage ) )
				message = "OTP does not match. Please try again.";
			else if ( /combination/.test( responseErrorMessage ) )
				message = "OTP does not match. Please try again.";
			else if ( /expire/.test( responseErrorMessage ) )
				message = "OTP has expired. Please try again.";
			else if ( /missing/.test( responseErrorMessage ) )
				message = "Please provide an OTP.";
			else if ( response.Status.toLowerCase() != "error" )
				verificationWasSuccessful = true;
			else
				message = response.Details;

			if ( ! verificationWasSuccessful )
				return reject( { code: 1, message: message } );

			return person.verify()
				.then( function () {
					resolve( response );
				} )
				.catch( function () {
					resolve( response );
				} );

		} );
		ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
			var errorResponse = utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

}

/*
 * Mark a person as "verified"
 * TODO: This is temporary
 */
Person.prototype.verify = function verify () {

	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/people/verify";
	var data = {
		client: __.settings.clientSlug,
		phoneNumbers: [ this.phoneNumber ],
		verificationMethod: "OTP"
	};

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
			var errorResponse = getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );
}

/*
 * TODO: Update a person's information
 */
Person.prototype.update = function update () {

	var data = {
		client: this.client,
		phoneNumber: this.phoneNumber,
		interests: this.interests,
		deviceId: this.deviceId,
		name: this.name,
		emailAddress: this.emailAddress
	};

	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/people";

	var ajaxRequest = $.ajax( {
		url: url,
		method: "PUT",
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
			var errorResponse = utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

}

Person.prototype.associateClientId = function associateClientId () {

	if ( typeof this._tempClientId !== "string" )
		return;

	var data = {
		client: this.client,
		phoneNumber: this.phoneNumber,
		personClientId: this._tempClientId
	};

	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/people/associate-with-client-id";

	var ajaxRequest = $.ajax( {
		url: url,
		method: "PUT",
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
			var errorResponse = utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

};

/*
 * Notifiy the Person's presence on the website
 */
Person.prototype.isOnWebsite = function isOnWebsite ( place ) {

	place = place || document.title.split( "|" )[ 0 ].trim();

	var data = {
		client: this.client,
		phoneNumber: this.phoneNumber,
		interests: this.interests,
		deviceId: this.deviceId,
		name: this.name,
		emailAddress: this.emailAddress,
		where: place
	};

	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/hooks/person-on-website";

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
			var errorResponse = utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );
	} );

}



/*
 *
 * Establish the variants of a Person
 *
 */
function AnonymousPerson ( clientId ) {
	Person.call( this );
	this._tempClientId = clientId || utils.getRandomId( 19 );
}
// Inherit from `Person`
AnonymousPerson.prototype = Object.create( Person.prototype );
AnonymousPerson.prototype.constructor = "AnonymousPerson";

function RegisteredPerson ( phoneNumber, sourcePoint ) {
	Person.call( this, phoneNumber, sourcePoint );
}
// Inherit from `Person`
RegisteredPerson.prototype = Object.create( Person.prototype );
RegisteredPerson.prototype.constructor = "RegisteredPerson";





// TODO: Remove
function getUserById ( id, options ) {

	options = options || { };

	var getUserPromise;

	if ( options.updated )
		getUserPromise = getUser__FromDB( id, "id", options );

	getUserPromise = getUser__FromLocalStorage( id, "id", options )
		.catch( function ( e ) {
			return getUser__FromDB( id, "id", options );
		} );

	return getUserPromise;

}

// TODO: Remove
function getUserByPhoneNumber ( phoneNumber, options ) {

	options = options || { };

	var getUserPromise;

	if ( options.updated )
		getUserPromise = getUser__FromDB( phoneNumber, "phoneNumber", options );

	getUserPromise = getUser__FromLocalStorage( phoneNumber, "phoneNumber", options )
		.catch( function ( e ) {
			return getUser__FromDB( phoneNumber, "phoneNumber", options );
		} );

	return getUserPromise;

}

// TODO: Remove
function getUser__FromLocalStorage ( identifyingAttribute, by, options ) {

	var user = utils.getCookie( "cupid-user-20200430" );

	if ( ! user )
		return Promise.reject( null );
	if ( user[ by ] != identifyingAttribute )
		return Promise.reject( null );

	return Promise.resolve( user );

}

// TODO: Remove
function getUser__FromDB ( identifyingAttribute, by, options ) {

	var client = __.settings.clientSlug;
	var apiEndpoint = __.settings.cupidApiEndpoint;
	var url = apiEndpoint + "/v2/people";
	var data = { client: client };
	data[ by ] = identifyingAttribute;

	var ajaxRequest = $.ajax( {
		url: url,
		method: "GET",
		data: data,
		dataType: "json"
	} );

	return new Promise( function ( resolve, reject ) {

		ajaxRequest.done( function ( response ) {
			var user = response.data;
			utils.setCookie( "cupid-user-20200430", user );
			resolve( user );
		} );
		ajaxRequest.fail( function ( jqXHR, textStatus, e ) {
			var errorResponse = utils.getErrorResponse( jqXHR, textStatus, e );
			reject( errorResponse );
		} );

	} );

}

// TODO: Remove
function authenticationRequired ( event ) {

	var $target = $( event.target );
	var $triggerElement = $target.closest( ".qpid_auth" );
	var $trapSite = $target.closest( ".qpid_login_site" );
	var context = $trapSite.data( "context" );
	var loginPrompt = LoginPrompt._instances[ context ];

	if ( Person.get().isRegistered() ) {
		// Restore any hyperlinks
		$trapSite.find( "a" ).each( function ( _i, domAnchor ) {
			var $anchor = $( domAnchor );
			var url = $anchor.data( "href" );
			$anchor.attr( "href", url );
		} );
		// Default to the default behavior
		return;
	}

	// If the user is **not** logged in,
	// 	prevent the registered event handlers from executing
	event.preventDefault();
	event.stopImmediatePropagation();

	// Prompt the user to log in
	if ( loginPrompt )
		loginPrompt.trigger( "requirePhone", event );
}
// $( "body" ).on( "click", ".qpid_auth:not( form )", authenticationRequired );
// If the trap site it_this is a form, then we want to hook on the form submission
// $( "body" ).on( "submit", "form.qpid_auth", authenticationRequired );





/* -/-/-/-/- CODE ENDS HERE -/-/-/-/- */









}( jQuery ) );
