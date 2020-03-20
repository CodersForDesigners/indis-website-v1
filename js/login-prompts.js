
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
	__.tempUser.verifyOTP( data.otp )
		.then( function () {
			__.user = __.tempUser;
			loginPrompt.trigger( "OTPVerified" );
		} )
		.catch( function ( e ) {
			loginPrompt.trigger( "OTPError", e );
		} );

}
function onOTPVerified () {
	var loginPrompt = this;
	// Trigger the login event
	loginPrompt.trigger( "login" );
}
function trackConversion ( loginPrompt ) {
	// Track the conversion
	var conversionUrl = loginPrompt.trackingURL || $( loginPrompt.triggerElement ).data( "c" );
	if ( ! conversionUrl )
		throw new Error( "No coversion URL was attached to the login prompt trigger element." );
	__.utils.trackPageVisit( conversionUrl );
}
function onLogin () {
	var loginPrompt = this;
	// Set cookie ( for a month )
	__.utils.setCookie( "cupid-user", __.user, 31 * 24 * 60 * 60 );
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
			__.user.hasDeviceId( deviceId );
			let page = document.title.split( "|" )[ 0 ].trim();
			__.user.isOnWebsite( loginPrompt.context + ", " + page );
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
 * 1. Get in Touch section
 */
loginPrompts.getInTouch = new __.LoginPrompt( "Get in Touch", $( ".qpid_login_site.js_get_in_touch_section" ) );
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

	// Create a new (but temporary) Person object
	__.tempUser = new __.Person( phoneNumber, loginPrompt.context );
		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			__.tempUser.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return __.tempUser.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					if ( person.isVerified() ) {
						__.user = person;
						loginPrompt.trigger( "login", person );
					}
					else
						throw person;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					if ( person instanceof Error || ! person )
						trackConversion( loginPrompt );
					return __.tempUser.add()
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
loginPrompts.getInTouch.on( "requireOTP", function ( event, phoneNumber ) {
	var loginPrompt = this;
	var $form = loginPrompt.$site.find( ".js_get_in_touch_form" );
	disableForm( $form );
	__.tempUser.requestOTP( loginPrompt.context )
		.then( function ( otpSessionId ) {
			__.tempUser.otpSessionId = otpSessionId;
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
	__.tempUser = new __.Person( phoneNumber, "Spotlight" );
		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			__.tempUser.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return __.tempUser.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					if ( person.isVerified() ) {
						__.user = person;
						loginPrompt.trigger( "login", person );
					}
					else
						throw person;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					if ( person instanceof Error || ! person )
						trackConversion( loginPrompt );
					return __.tempUser.add()
						.then( function () {
							loginPrompt.trigger( "requireOTP" );
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
	__.tempUser.requestOTP( loginPrompt.context )
		.then( function ( otpSessionId ) {
			__.tempUser.otpSessionId = otpSessionId;
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
	loginPrompts[ spotlightId ] = new __.LoginPrompt( "Spotlight" + index, $( domEl ) );
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
		// Okay, this part looks dumb, bear with it
	loginPrompts[ spotlightId ].on( "login", function () {
		this.context = "Spotlight"
	} );
	loginPrompts[ spotlightId ].on( "login", onLogin );
	loginPrompts[ spotlightId ].on( "login", function () {
		this.context = "Spotlight" + index;
	} );
} );

/*
 * 2.2 Project Spotlights Dedicated Prompt
 */
loginPrompts.spotlightDedicated = new __.LoginPrompt( "Spotlight", $( ".qpid_login_site.js_spotlight_unlock_form_section" ) );
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
	__.tempUser = new __.Person( phoneNumber, "Spotlight" );
		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			__.tempUser.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return __.tempUser.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					if ( person.isVerified() ) {
						__.user = person;
						loginPrompt.trigger( "login", person );
					}
					else
						throw person;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					if ( person instanceof Error || ! person )
						trackConversion( loginPrompt );
					return __.tempUser.add()
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
loginPrompts.spotlightDedicated.on( "requireOTP", function ( event, phoneNumber ) {
	var loginPrompt = this;
	var $form = loginPrompt.$site.find( ".js_spotlights_unlock_form" );
	disableForm( $form );
	__.tempUser.requestOTP( loginPrompt.context )
		.then( function ( otpSessionId ) {
			__.tempUser.otpSessionId = otpSessionId;
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
loginPrompts.spotlightDedicated.on( "login", onLogin );











/*
 * 3. Book a Site Visit
 */
loginPrompts.bookSiteVisit = new __.LoginPrompt( "Book Site Visit", $( ".qpid_login_site.js_book_site_visit_section" ) );
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
	__.tempUser = new __.Person( phoneNumber, loginPrompt.context );
		// Set the device id
	__.utils.getAnalyticsId()
		.then( function ( deviceId ) {
			__.tempUser.hasDeviceId( deviceId );
		} )
		// Attempt to find the person in the database
		.then( function () {
			return __.tempUser.getFromDB()
				// If the person exists, log in
				.then( function ( person ) {
					if ( person.isVerified() ) {
						__.user = person;
						loginPrompt.trigger( "login", person );
					}
					else
						throw person;
				} )
				// If the person don't exist, add the person, and send an OTP
				.catch( function ( person ) {
					if ( person instanceof Error || ! person )
						trackConversion( loginPrompt );
					return __.tempUser.add()
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
	__.tempUser.requestOTP( loginPrompt.context )
		.then( function ( otpSessionId ) {
			__.tempUser.otpSessionId = otpSessionId;
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
