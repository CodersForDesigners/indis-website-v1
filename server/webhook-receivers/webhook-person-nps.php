<?php

/* ------------------------------- \
 * Script Bootstrapping
 \-------------------------------- */
# * - Error Reporting
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );
# * - Request Permissions
header( 'Access-Control-Allow-Origin: *' );
# * - Date and Timezone
date_default_timezone_set( 'Asia/Kolkata' );
# * - Prevent Script Cancellation by Client
ignore_user_abort( true );
# * - Script Timeout
set_time_limit( 0 );



/* ------------------------------- \
 * Response Preparation
 \-------------------------------- */
# Set Headers
header_remove( 'X-Powered-By' );
header( 'Content-Type: application/json' );



/* ------------------------------- \
 * Request Parsing
 \-------------------------------- */
# Get JSON as a string
$json = file_get_contents( 'php://input' );
# Convert the JSON string to an object
$error = null;
try {
	$input = json_decode( $json, true );
	if ( empty( $input ) )
		throw new \Exception( "No data provided." );

	$event = $input[ 'event' ];
	$input = $input[ 'data' ];
}
catch ( \Exception $e ) {
	$error = $e->getMessage();
}
if ( ! empty( $error ) ) {
	echo json_encode( [
		'code' => 400,
		'message' => 'Data not provided'
	] );
	exit;
}



/* ------------------------------------- \
 * Exceptions
 \-------------------------------------- */
if ( ! empty( $input[ 'phoneNumber' ] ) and $input[ 'phoneNumber' ] === '+917760118668' )
	exit;



/* ------------------------------------- \
 * Pull in the dependencies
 \-------------------------------------- */
require_once __DIR__ . '/../../inc/datetime.php';
require_once __DIR__ . '/../../inc/google-forms.php';



/* ------------------------------------- \
 * Ingest the data onto the Spreadsheet
 \-------------------------------------- */
# Interpret the data
$when = CFD\DateTime::getSpreadsheetDateFromISO8601( $input[ 'when' ] );
$questionIndex = $input[ 'questionIndex' ] ?? '';
$question = $input[ 'question' ] ?? '';
$answer = $input[ 'answer' ] ?? [ ];
$context = $input[ 'context' ] ?? '';
$sessionId = $input[ 'sessionId' ] ?? $input[ 'personClientId' ] ?? '';
$personId = $input[ 'personId' ] ?? '';
$verified = $input[ 'personIsVerified' ] ?? '';
$phoneNumber = $input[ 'personPhoneNumber' ] ?? '';
$questionnaireVersion = $input[ 'questionnaireVersion' ] ?? '';

# Shape the data
$data = [
	'when' => $when,
	'questionIndex' => $questionIndex,
	'question' => $question,
	'answer' => implode( PHP_EOL, $answer ),
	'context' => $context,
	'sessionId' => $sessionId,
	'personId' => $personId,
	'verified' => $verified,
	'phoneNumber' => $phoneNumber,
	'questionnaireVersion' => $questionnaireVersion,
];
GoogleForms\submitPersonAnsweredQuestion( $data );



/* ------------------------------- \
 * Respond back to the client
 \-------------------------------- */
$output = $data ?: [ ];
echo json_encode( $output );
