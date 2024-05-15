<?php

/*
 *
 * -/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/
 * SCRIPT SETUP
 * /-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-
 *
 * This script sets cookies on a page.
 * It's used for setting cookies asynchronously.
 *
 */
ini_set( 'display_errors', 0 );
ini_set( 'error_reporting', E_ALL );

// Set the timezone
date_default_timezone_set( 'Asia/Kolkata' );

// Do not let this script timeout
set_time_limit( 0 );

// Continue processing this script even if the user closes the tab, or
//  	hits the ESC key
ignore_user_abort( true );

// Allow this script to triggered from another origin
header( 'Access-Control-Allow-Origin: *' );

// Remove / modify certain headers of the response
header_remove( 'X-Powered-By' );
// Since this endpoint is accessed via an implicit GET request by means of an iframe
	// the browser expects and even goes on to interpret the response as HTML
// header( 'Content-Type: application/json' );	// JSON format

$input = &$_GET;

/*
 *
 * Preliminary input sanitization
 *
 */
foreach ( $input as $key => &$value ) {
	$value = trim( $value );
}



/*
 *
 * Attempts to determine if the site is running on HTTPS.
 *  Borrowed code from the WordPress's `is_ssl` function.
 *
 */
function isOnHTTPS () {

	if ( isset( $_SERVER[ 'HTTPS' ] ) ) {
		if ( strtolower( $_SERVER['HTTPS'] ) == 'on' )
			return true;
		if ( $_SERVER[ 'HTTPS' ] == '1' )
			return true;
	}

	if ( isset( $_SERVER[ 'SERVER_PORT' ] ) )
		if ( $_SERVER[ 'SERVER_PORT' ] == '443' )
			return true;

	if ( isset( $_SERVER[ 'REQUEST_SCHEME' ] ) )
		if ( $_SERVER[ 'REQUEST_SCHEME' ] == 'https' )
			return true;

	return false;

}



/*
 *
 * Check if the required inputs are **present**
 *
 */
if ( empty( $input[ 'name' ] ) ) {
	$response[ 'code' ] = 4001;
	$response[ 'message' ] = 'Please provide a name for the cookie.';
	http_response_code( 400 );
	die( json_encode( $response ) );
}
$cookieName = $input[ 'name' ];
if ( empty( $input[ 'duration' ] ) ) {
	$response[ 'code' ] = 4002;
	$response[ 'message' ] = 'Please provide a duration for the cookie.';
	http_response_code( 400 );
	die( json_encode( $response ) );
}

// Cast the duration value to a number
$input[ 'duration' ] = (int) $input[ 'duration' ];
// If the duration is less than 0, then we simply unset the cookie
if ( $input[ 'duration' ] < 0 ) {
	setcookie( $cookieName, false, time() - 3600, '/' );
	// setcookie( $cookieName, false, time() - 3600, '/', '/', isOnHTTPS() );

	$response[ 'code' ] = 200;
	$response[ 'message' ] = 'Cookie cut';
	die( json_encode( $response ) );
}



if ( empty( $input[ 'value' ] ) and empty( $input[ 'data' ] ) ) {
	$response[ 'code' ] = 4003;
	$response[ 'message' ] = 'Please provide a value or some data for the cookie.';
	http_response_code( 400 );
	die( json_encode( $response ) );
}

if ( empty( $input[ 'value' ] ) )
	$cookieValue = base64_encode( $input[ 'data' ] );
else
	$cookieValue = $input[ 'value' ];

$cookieDuration = $input[ 'duration' ];
setcookie( $cookieName, $cookieValue, time() + $cookieDuration, '/' );
// setcookie( $cookieName, $cookieValue, time() + $cookieDuration, '/', '/', isOnHTTPS() );

$response[ 'code' ] = 200;
$response[ 'message' ] = 'Cookie cut';
die( json_encode( $response ) );
