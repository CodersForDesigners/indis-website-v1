
/*
 * ------------------------\
 *  Common event handlers
 * ------------------------|
 */
function onOTPSubmit ( event ) {

	var loginPrompt = this;
	var $form = loginPrompt.$OTPForm;

	// Fetch the OTP value from the form
	var formData;
	try {
		formData = getFormData( $form, {
			otp: { type: "OTP", $: "[ name = 'otp' ]" }
		} );
	}
	catch ( e ) {
		// Reflect back sanitized values to the form
		setFormData( $form, e );
		// Trigger the OTP Error event
		loginPrompt.trigger( "OTPError", {
			message: "Please provide a valid OTP."
		} );
		return;
	}

	// Reflect back sanitized values to the form
	setFormData( $form, formData );

	// Convert the form-data array to an object
	var data = formData.reduce( function ( acc, f ) {
		acc[ f.name ] = f.value;
		return acc;
	}, { } );

	// Now, verify the OTP
	__.Person.get().verifyOTP( data.otp )
		.then( function () {
			loginPrompt.trigger( "OTPVerified" );
		} )
		.catch( function ( e ) {
			loginPrompt.trigger( "OTPError", e );
		} );

}
function onOTPVerified () {
	var loginPrompt = this;
	// Trigger the login event
	loginPrompt.trigger( "login", __.Person.get() );
}
function trackConversion ( loginPrompt ) {
	// Track the conversion
	var conversionUrl = loginPrompt.trackingURL || $( loginPrompt.triggerElement ).data( "c" );
	if ( ! conversionUrl )
		throw new Error( "No coversion URL was attached to the login prompt trigger element." );
	__.utils.trackPageVisit( conversionUrl );
}
function onLogin ( person ) {
	var loginPrompt = this;

	__.Person.login( person );
	person.associateClientId();

	function restoreTriggerRegion () {
		// Bring back the trigger element
		$( loginPrompt.triggerRegion ).slideDown( 500, function () {
			// Trigger the original event
			$( loginPrompt.triggerElement ).trigger( loginPrompt.triggerEvent );
		} );
	}
	// Hide the OTP form
	$( loginPrompt.$OTPForm ).slideUp( 500, function () {
		// Hide the phone form if present
		if ( loginPrompt.$phoneForm && loginPrompt.$phoneForm.length )
			$( loginPrompt.$phoneForm ).slideUp( 500, restoreTriggerRegion );
		else
			restoreTriggerRegion();

	} );

	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			person.hasDeviceId( deviceId );
			let page = document.title.split( "|" )[ 0 ].trim();
			person.isOnWebsite( loginPrompt.context + ", " + page );
		} )

	if ( window.unlockSpotlights )
		unlockSpotlights();
}





/*
 * ------------------------\
 *  The Login Prompts
 * ------------------------|
 */
var __ = window.__CUPID;
var loginPrompts = { };

/*
 * 0. NPS Questionnaires
 */
loginPrompts.nps = new __.LoginPrompt( "nps", "NPS", $( "head" ) );
$( document ).on( "submit", ".js_nps_card .js_phone_form", function ( event ) {
	event.preventDefault();

	var loginPrompt = loginPrompts.nps;
	var $form = $( event.target ).closest( "form" );

	// Pull data from the form
	var formData;
	try {
		formData = getFormData( $form, {
			phoneNumber: { type: "phone number", $: ".js_phone_country_code, [ name = 'phone-number' ]" }
		} );
	}
	catch ( e ) {
		// Reflect back sanitized values to the form
		setFormData( $form, e );
		// Report the message
		alert( "Please provide a valid phone number." );
		return;
	}

	// Reflect back sanitized values to the form
	setFormData( $form, formData );

	// Get the relevant data
	var phoneNumber = formData[ 0 ].value.join( "" );

	// Set data on the Person object
	var projectName = window.__BFS.content.project.name;
	var user = __.Person.get();
	user.hasPhoneNumber( phoneNumber );

		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			user.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return user.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					person.name = user.name || person.name;
					person.emailAddress = user.emailAddress || person.emailAddress;
					person.isInterestedIn( user.interests );
					person.hasDeviceId( user.getDeviceId() );
					user = person;

					if ( user.isVerified() )
						loginPrompt.trigger( "login", user );
					else
						throw user;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					var promiseChain;
					if ( typeof person === "object" && ! ( person instanceof Error ) ) {
						var sourcePoint = projectName + ": " + loginPrompt.context;
						user.setSource( null, sourcePoint );
						promiseChain = Promise.resolve();
					}
					if ( ! person ) {
						trackConversion( loginPrompt );
						promiseChain = user.add().then( function () {
							return waitFor( 1.5 );
						} );
					}

					return promiseChain
						.then( function () {
							user.isInterestedIn( projectName );
							return user.update();
						} )
						.then( function () {
							return user.saveLocally();
						} )
						.then( function () {
							return user.associateClientId();
						} )
						.then( function () {
							loginPrompt.trigger( "requireOTP", user.phoneNumber );
						} )
						.catch( function () {
							loginPrompt.trigger( "phoneError" );
						} );
				} )
		} );

} );
loginPrompts.nps.on( "requireOTP", function ( phoneNumber ) {
	var loginPrompt = loginPrompts.nps;
	var $phoneForms = $( ".js_nps_card .js_phone_form" );
	var $otpForms = $( ".js_nps_card .js_otp_form" );
	disableForm( $phoneForms );
	__.Person.get().requestOTP( loginPrompt.context, phoneNumber )
		.then( function ( otpSessionId ) {
			var person = __.Person.get();
			person.otpSessionId = otpSessionId;
			person.saveLocally();
			// Show OTP form, after hiding the phone form
			$phoneForms.slideUp( 500, function () {
				$otpForms.slideDown();
			} );
		} )
		.catch( function ( e ) {
			alert( e.message );
			enableForm( $phoneForms );
		} )
} );
$( document ).on( "submit", ".js_nps_card .js_otp_form", function ( event ) {
	event.preventDefault();

	var loginPrompt = loginPrompts.nps;
	var $form = $( event.target ).closest( ".js_otp_form" );

	// Fetch the OTP value from the form
	var formData;
	try {
		formData = getFormData( $form, {
			otp: { type: "OTP", $: "[ name = 'otp' ]" }
		} );
	}
	catch ( e ) {
		// Reflect back sanitized values to the form
		setFormData( $form, e );
		// Trigger the OTP Error event
		loginPrompt.trigger( "OTPError", {
			message: "Please provide a valid OTP."
		} );
		return;
	}

	// Reflect back sanitized values to the form
	setFormData( $form, formData );

	// Convert the form-data array to an object
	var data = formData.reduce( function ( acc, f ) {
		acc[ f.name ] = f.value;
		return acc;
	}, { } );

	// Now, verify the OTP
	__.Person.get().verifyOTP( data.otp )
		.then( function () {
			loginPrompt.trigger( "OTPVerified" );
		} )
		.catch( function ( e ) {
			loginPrompt.trigger( "OTPError", e );
		} );

} );
loginPrompts.nps.on( "OTPError", function ( e ) {
	alert( e.message );
} );
loginPrompts.nps.on( "OTPVerified", function () {
	var loginPrompt = loginPrompts.nps;
	loginPrompt.trigger( "login", __.Person.get() );
} );
// When the user is logged in
loginPrompts.nps.on( "login", function ( person ) {
	var loginPrompt = loginPrompts.nps;

	__.Person.login( person );
	person.associateClientId();

	var $phoneForms = $( ".js_nps_card .js_phone_form" );
	var $otpForms = $( ".js_nps_card .js_otp_form" );

	$phoneForms.slideUp();
	$otpForms.slideUp();

	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			person.hasDeviceId( deviceId );
			let page = document.title.split( "|" )[ 0 ].trim();
			person.isOnWebsite( loginPrompt.context + ", " + page );
		} )

	if ( window.unlockSpotlights )
		unlockSpotlights();

	// Present the next question
	var currentQuestionIndex = window.__CUPID.NPS.currentQuestionIndex;
	var nextQuestionIndex = window.__CUPID.NPS.getNextQuestionIndex( currentQuestionIndex );
	window.__CUPID.NPS.askQuestion( nextQuestionIndex );

} );

/*
 * 1. Get in Touch section
 */
loginPrompts.getInTouch = new __.LoginPrompt( "get-in-touch", "Get in Touch", $( ".qpid_login_site.js_get_in_touch_section" ) );
loginPrompts.getInTouch.triggerFlowOn( "submit", ".js_get_in_touch_form" );
// Skip the phone form because it is already integrated with the form
loginPrompts.getInTouch.on( "requirePhone", function ( event ) {
	this.trigger( "phoneSubmit", event );
} );
// Since the phone number is already provided in the form, simply submit it programmatically
loginPrompts.getInTouch.on( "phoneSubmit", function ( event ) {
	var loginPrompt = this;
	var $form = $( event.target ).closest( "form" );

	// Pull data from the form
	var formData;
	try {
		formData = getFormData( $form, {
			name: { type: "name", $: "[ name = 'name' ]" },
			phoneNumber: { type: "phone number", $: ".js_phone_country_code, [ name = 'phone-number' ]" }
		} );
	}
	catch ( e ) {
		// Reflect back sanitized values to the form
		setFormData( $form, e );
		// Prepare the error message
		var message = e.reduce( function ( message, issue ) {
			return message + "\n"
				+ ( issue.type[ 0 ].toUpperCase() + issue.type.slice( 1 ) );
		}, "" );
		message = "Please provide valid information for the following fields:" + message;
		// Report the message
		alert( message );
		return;
	}

	// Reflect back sanitized values to the form
	setFormData( $form, formData );

	// Get the relevant data
	var phoneNumber = formData[ 1 ].value.join( "" );

	// Set data on the Person object
	var projectName = window.__BFS.content.project.name;
	var user = __.Person.get();
	user.hasPhoneNumber( phoneNumber );

		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			user.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return user.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					person.name = user.name || person.name;
					person.emailAddress = user.emailAddress || person.emailAddress;
					person.isInterestedIn( user.interests );
					person.hasDeviceId( user.getDeviceId() );
					user = person;

					if ( user.isVerified() )
						loginPrompt.trigger( "login", user );
					else
						throw user;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					var promiseChain;
					if ( typeof person === "object" && ! ( person instanceof Error ) ) {
						var sourcePoint = projectName + ": " + loginPrompt.context;
						user.setSource( null, sourcePoint );
						promiseChain = Promise.resolve();
					}
					if ( ! person ) {
						trackConversion( loginPrompt );
						promiseChain = user.add().then( function () {
							return waitFor( 1.5 );
						} );
					}

					return promiseChain
						.then( function () {
							user.isInterestedIn( projectName + ": " + loginPrompt.context );
							return user.update();
						} )
						.then( function () {
							return user.saveLocally();
						} )
						.then( function () {
							return user.associateClientId();
						} )
						.then( function () {
							loginPrompt.trigger( "requireOTP", user.phoneNumber );
						} )
						.catch( function () {
							loginPrompt.trigger( "phoneError" );
						} );
				} )
		} );

} );
// When the phone number is to be submitted
loginPrompts.getInTouch.on( "requireOTP", function ( event, phoneNumber ) {
	var loginPrompt = this;
	var $form = loginPrompt.$site.find( ".js_get_in_touch_form" );
	disableForm( $form );
	__.Person.get().requestOTP( loginPrompt.context, phoneNumber )
		.then( function ( otpSessionId ) {
			var person = __.Person.get();
			person.otpSessionId = otpSessionId;
			person.saveLocally();
			// Show OTP form, after hiding the Contact form
			$form.slideUp( 500, function () {
				loginPrompt.$OTPForm.slideDown();
			} );
		} )
		.catch( function ( e ) {
			alert( e.message );
			enableForm( $form );
		} )
} );
// When the OTP is required
loginPrompts.getInTouch.on( "OTPSubmit", onOTPSubmit );
loginPrompts.getInTouch.on( "OTPError", function ( e ) {
	alert( e.message );
} );
loginPrompts.getInTouch.on( "OTPVerified", onOTPVerified );
// When the user is logged in
loginPrompts.getInTouch.on( "login", onLogin );






/*
 * 2.1 Project Spotlights Inline Prompts
 */
function onRequirePhone__Spotlight ( event ) {
	var loginPrompt = this;
	$( loginPrompt.triggerRegion ).slideUp( 500, function () {
		loginPrompt.$phoneForm.slideDown();
	} );
}
function onPhoneSubmit__Spotlight ( event ) {
	var loginPrompt = this;
	var $form = $( event.target ).closest( "form" );

	// Pull data from the form
	var formData;
	try {
		formData = getFormData( $form, {
			phoneNumber: { type: "phone number", $: ".js_phone_country_code, [ name = 'phone-number' ]" }
		} );
	}
	catch ( e ) {
		// Reflect back sanitized values to the form
		setFormData( $form, e );
		// Report the message
		alert( "Please provide a valid phone number." );
		return;
	}

	// Reflect back sanitized values to the form
	setFormData( $form, formData );

	// Get the relevant data
	var phoneNumber = formData[ 0 ].value.join( "" );

	// Create a new (but temporary) Person object
	var projectName = window.__BFS.content.project.name;
	var user = __.Person.get();
	user.hasPhoneNumber( phoneNumber );

		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			user.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return user.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					person.name = user.name || person.name;
					person.emailAddress = user.emailAddress || person.emailAddress;
					person.isInterestedIn( user.interests );
					person.hasDeviceId( user.getDeviceId() );
					user = person;

					if ( user.isVerified() )
						loginPrompt.trigger( "login", user );
					else
						throw user;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					var promiseChain;
					if ( typeof person === "object" && ! ( person instanceof Error ) ) {
						var sourcePoint = projectName + ": Spotlight";
						user.setSource( null, sourcePoint );
						promiseChain = Promise.resolve();
					}
					if ( ! person ) {
						trackConversion( loginPrompt );
						promiseChain = user.add().then( function () {
							return waitFor( 1.5 );
						} );
					}

					return promiseChain
						.then( function () {
							user.isInterestedIn( projectName );
							return user.update();
						} )
						.then( function () {
							return user.saveLocally();
						} )
						.then( function () {
							return user.associateClientId();
						} )
						.then( function () {
							loginPrompt.trigger( "requireOTP", user.phoneNumber );
						} )
						.catch( function () {
							loginPrompt.trigger( "phoneError" );
						} );
				} )
		} );

}
function onRequireOTP__Spotlight ( event, phoneNumber ) {
	var loginPrompt = this;
	disableForm( loginPrompt.$phoneForm );
	__.Person.get().requestOTP( loginPrompt.context, phoneNumber )
		.then( function ( otpSessionId ) {
			var person = __.Person.get();
			person.otpSessionId = otpSessionId;
			person.saveLocally();
			// Show OTP form, after hiding the phone form
			loginPrompt.$phoneForm.slideUp( 500, function () {
				loginPrompt.$OTPForm.slideDown();
			} );
		} )
		.catch( function ( e ) {
			alert( e.message );
			enableForm( loginPrompt.$phoneForm );
		} )
}
function onOTPError__Spotlight ( e ) {
	alert( e.message );
}
$( ".qpid_login_site.js_spotlight" ).each( function ( _i, domEl ) {
	var index = _i + 1;
	var spotlightId = $( domEl ).find( "#spotlight-" + index + "-enquire" ).attr( "id" );
	loginPrompts[ spotlightId ] = new __.LoginPrompt( "spotlight-" + index, "Spotlight", $( domEl ) );
	loginPrompts[ spotlightId ].triggerFlowOn( "click", "#" + spotlightId );
	loginPrompts[ spotlightId ].on( "requirePhone", onRequirePhone__Spotlight );
	loginPrompts[ spotlightId ].on( "phoneSubmit", onPhoneSubmit__Spotlight );
	// When the phone number is to be submitted
	loginPrompts[ spotlightId ].on( "requireOTP", onRequireOTP__Spotlight );
	// When the OTP is required
	loginPrompts[ spotlightId ].on( "OTPSubmit", onOTPSubmit );
	loginPrompts[ spotlightId ].on( "OTPError", onOTPError__Spotlight );
	loginPrompts[ spotlightId ].on( "OTPVerified", onOTPVerified );
	// When the user is logged in
	loginPrompts[ spotlightId ].on( "login", onLogin );
} );

/*
 * 2.2 Project Spotlights Dedicated Prompt
 */
loginPrompts.spotlightDedicated = new __.LoginPrompt( "spotlight-dedicated", "Spotlight", $( ".qpid_login_site.js_spotlight_unlock_form_section" ) );
loginPrompts.spotlightDedicated.triggerFlowOn( "submit", ".js_spotlights_unlock_form" );
// Skip the phone form because it is already integrated with the contact form
loginPrompts.spotlightDedicated.on( "requirePhone", function ( event ) {
	this.trigger( "phoneSubmit", event );
} );
// Since the phone number is already provided in the contact form, simply submit it programmatically
loginPrompts.spotlightDedicated.on( "phoneSubmit", function ( event ) {
	var loginPrompt = this;
	var $form = $( event.target ).closest( "form" );

	// Pull data from the form
	var formData;
	try {
		formData = getFormData( $form, {
			name: { type: "name", $: "[ name = 'name' ]" },
			emailAddress: { type: "email address", $: "[ name = 'email-address' ]" },
			phoneNumber: { type: "phone number", $: ".js_phone_country_code, [ name = 'phone-number' ]" }
		} );
	}
	catch ( e ) {
		// Reflect back sanitized values to the form
		setFormData( $form, e );
		e.forEach( function ( issue ) {
			$( issue.$ ).addClass( "js_error" );
		} );
		// Prepare the error message
		var message = e.reduce( function ( message, issue ) {
			return message + "\n"
				+ ( issue.type[ 0 ].toUpperCase() + issue.type.slice( 1 ) );
		}, "" );
		message = "Please provide valid information for the following fields:" + message;
		// Report the message
		alert( message );
		enableForm( $form );
		return;
	}

	// Reflect back sanitized values to the form
	setFormData( $form, formData );

	// Get the relevant data
	var phoneNumber = formData[ 2 ].value.join( "" );

	// Create a new (but temporary) Person object
	var projectName = window.__BFS.content.project.name;
	var user = __.Person.get();
	user.hasPhoneNumber( phoneNumber );

		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			user.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return user.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					person.name = user.name || person.name;
					person.emailAddress = user.emailAddress || person.emailAddress;
					person.isInterestedIn( user.interests );
					person.hasDeviceId( user.getDeviceId() );
					user = person;

					if ( user.isVerified() )
						loginPrompt.trigger( "login", user );
					else
						throw user;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					var promiseChain;
					if ( typeof person === "object" && ! ( person instanceof Error ) ) {
						var sourcePoint = projectName + ": Spotlight";
						user.setSource( null, sourcePoint );
						promiseChain = Promise.resolve();
					}
					if ( ! person ) {
						trackConversion( loginPrompt );
						promiseChain = user.add().then( function () {
							return waitFor( 1.5 );
						} );
					}

					return promiseChain
						.then( function () {
							user.isInterestedIn( projectName );
							return user.update();
						} )
						.then( function () {
							return user.saveLocally();
						} )
						.then( function () {
							return user.associateClientId();
						} )
						.then( function () {
							loginPrompt.trigger( "requireOTP", user.phoneNumber );
						} )
						.catch( function () {
							loginPrompt.trigger( "phoneError" );
						} );
				} )
		} );

} );
// When the phone number is to be submitted
loginPrompts.spotlightDedicated.on( "requireOTP", function ( event, phoneNumber ) {
	var loginPrompt = this;
	var $form = loginPrompt.$site.find( ".js_spotlights_unlock_form" );
	disableForm( $form );
	__.Person.get().requestOTP( loginPrompt.context, phoneNumber )
		.then( function ( otpSessionId ) {
			var person = __.Person.get();
			person.otpSessionId = otpSessionId;
			person.saveLocally();
			// Show OTP form, after hiding the Contact form
			$form.slideUp( 500, function () {
				loginPrompt.$OTPForm.slideDown();
			} );
		} )
		.catch( function ( e ) {
			alert( e.message );
			enableForm( $form );
		} )
} );
// When the OTP is required
loginPrompts.spotlightDedicated.on( "OTPSubmit", onOTPSubmit );
loginPrompts.spotlightDedicated.on( "OTPError", function ( e ) {
	alert( e.message );
} );
loginPrompts.spotlightDedicated.on( "OTPVerified", onOTPVerified );
// When the user is logged in
loginPrompts.spotlightDedicated.on( "login", onLogin );











/*
 * 3. Book a Site Visit
 */
loginPrompts.bookSiteVisit = new __.LoginPrompt( "book-site-visit", "Book Site Visit", $( ".qpid_login_site.js_book_site_visit_section" ) );
loginPrompts.bookSiteVisit.triggerFlowOn( "submit", ".js_book_site_visit_form" );
// Skip the phone form because it is already integrated with the contact form
loginPrompts.bookSiteVisit.on( "requirePhone", function ( event ) {
	this.trigger( "phoneSubmit", event );
} );
// Since the phone number is already provided in the contact form, simply submit it programmatically
loginPrompts.bookSiteVisit.on( "phoneSubmit", function ( event ) {
	var loginPrompt = this;
	var $form = $( event.target ).closest( "form" );

	// Pull data from the form
	var formData;
	try {
		formData = getFormData( $form, {
			name: { type: "name", $: "[ name = 'name' ]" },
			emailAddress: { type: "email address", $: "[ name = 'email-address' ]" },
			phoneNumber: { type: "phone number", $: ".js_phone_country_code, [ name = 'phone-number' ]" }
		} );
	}
	catch ( e ) {
		// Reflect back sanitized values to the form
		setFormData( $form, e );
		e.forEach( function ( issue ) {
			$( issue.$ ).addClass( "js_error" );
		} );
		// Prepare the error message
		var message = e.reduce( function ( message, issue ) {
			return message + "\n"
				+ ( issue.type[ 0 ].toUpperCase() + issue.type.slice( 1 ) );
		}, "" );
		message = "Please provide valid information for the following fields:" + message;
		// Report the message
		alert( message );
		enableForm( $form );
		return;
	}

	// Reflect back sanitized values to the form
	setFormData( $form, formData );

	// Get the relevant data
	var phoneNumber = formData[ 2 ].value.join( "" );

	// Create a new (but temporary) Person object
	var projectName = window.__BFS.content.project.name;
	var user = __.Person.get();
	user.hasPhoneNumber( phoneNumber );

		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			user.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return user.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					person.name = user.name || person.name;
					person.emailAddress = user.emailAddress || person.emailAddress;
					person.isInterestedIn( user.interests );
					person.hasDeviceId( user.getDeviceId() );
					user = person;

					if ( user.isVerified() )
						loginPrompt.trigger( "login", user );
					else
						throw user;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					var promiseChain;
					if ( typeof person === "object" && ! ( person instanceof Error ) ) {
						var sourcePoint = projectName + ": " + loginPrompt.context;
						user.setSource( null, sourcePoint );
						promiseChain = Promise.resolve();
					}
					if ( ! person ) {
						trackConversion( loginPrompt );
						promiseChain = user.add().then( function () {
							return waitFor( 1.5 );
						} );
					}

					return promiseChain
						.then( function () {
							user.isInterestedIn( projectName + ": " + loginPrompt.context );
							return user.update();
						} )
						.then( function () {
							return user.saveLocally();
						} )
						.then( function () {
							return user.associateClientId();
						} )
						.then( function () {
							loginPrompt.trigger( "requireOTP" );
						} )
						.catch( function () {
							loginPrompt.trigger( "phoneError" );
						} );
				} )
		} );

} );
// When the phone number is to be submitted
loginPrompts.bookSiteVisit.on( "requireOTP", function ( event, phoneNumber ) {
	var loginPrompt = this;
	var $form = loginPrompt.$site.find( ".js_book_site_visit_form" );
	disableForm( $form );
	__.Person.get().requestOTP( loginPrompt.context, phoneNumber)
		.then( function ( otpSessionId ) {
			var person = __.Person.get();
			person.otpSessionId = otpSessionId;
			person.saveLocally();
			// Show OTP form, after hiding the phone form
			$form.slideUp( 500, function () {
				loginPrompt.$OTPForm.slideDown();
			} );
		} )
		.catch( function ( e ) {
			alert( e.message );
			enableForm( $form );
		} )
} );
// When the OTP is required
loginPrompts.bookSiteVisit.on( "OTPSubmit", onOTPSubmit );
loginPrompts.bookSiteVisit.on( "OTPError", function ( e ) {
	alert( e.message );
} );
loginPrompts.bookSiteVisit.on( "OTPVerified", onOTPVerified );
// When the user is logged in
loginPrompts.bookSiteVisit.on( "login", onLogin );
