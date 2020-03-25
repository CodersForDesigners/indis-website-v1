<?php

namespace GoogleForms;

ini_set( "display_errors", 1 );
ini_set( "error_reporting", E_ALL );

// Set the timezone
date_default_timezone_set( 'Asia/Kolkata' );
// Do not let this script timeout
set_time_limit( 0 );









function getFormBoundary () {
	return '----ThisIsNotAWallButABoundaryt1n4W34b';
}

/*
 *
 * Returns a `form-data` formatted string for use in a POST request
 *
 * **NOTE**: Leave the double quotes as is in this function.
 * 	The HTTP request won't work otherwise!
 *
 */
function formatToMultipartFormData ( $data ) {

	$formBoundary = getFormBoundary();
	$eol = "\r\n";
	$fieldMeta = "Content-Disposition: form-data; name=";
	$nameFieldQuote = "\"";
	$dataString = '';

	foreach ( $data as $name => $content ) {
		$dataString .= "--" . $formBoundary . $eol
					. $fieldMeta . $nameFieldQuote . $name . $nameFieldQuote
					. $eol . $eol
					. $content
					. $eol;
	}

	$dataString .= "--" . $formBoundary . "--";

	return $dataString;

}

function getAPIResponse ( $endpoint, $method, $data = [ ] ) {

	$httpRequest = curl_init();
	curl_setopt( $httpRequest, CURLOPT_URL, $endpoint );
	curl_setopt( $httpRequest, CURLOPT_RETURNTRANSFER, true );
	// curl_setopt( $httpRequest, CURLOPT_USERAGENT, '' );
	curl_setopt( $httpRequest, CURLOPT_HTTPHEADER, [
		'Cache-Control: no-cache, no-store, must-revalidate',
		'Content-Type: multipart/form-data; boundary=' . getFormBoundary()
	] );
	curl_setopt( $httpRequest, CURLOPT_POSTFIELDS, formatToMultipartFormData( $data ) );
	curl_setopt( $httpRequest, CURLOPT_CUSTOMREQUEST, $method );
	$response = curl_exec( $httpRequest );
	curl_close( $httpRequest );

	return $response;

}

/*
 *
 * Submit a Google Form
 *
 */
function submitPerson ( $data ) {

	$endpoint = 'https://docs.google.com/forms/d/e/'
			. '1FAIpQLSe8k4Y2l6B6Uc59-cCp7NZJf4sT4upYvttHm_7u5eEm0CHHSg/formResponse';
	$requestBody = [
		'entry.1557415165' => $data[ 'when' ],
		'entry.927794621' => $data[ 'id' ],
		'entry.542325372' => $data[ 'phoneNumber' ],
		'entry.593308813' => $data[ 'name' ],
		'entry.778226319' => $data[ 'emailAddress' ],
		'entry.1082231826' => $data[ 'sourceMedium' ],
		'entry.488502914' => $data[ 'sourcePoint' ],
		'entry.2033645995' => $data[ 'interests' ],
		'entry.1587856711' => $data[ 'callRecording' ]
	];

	$response = getAPIResponse( $endpoint, 'POST', $requestBody );

	return $response;

}

function submitPersonActivity ( $data ) {

	$endpoint = 'https://docs.google.com/forms/d/e/'
			. '1FAIpQLSe9BAimkUeAeLARNME7UmQYKUjPXk7YwUbJ883Sasgh6a-wPg/formResponse';
	$requestBody = [
		'entry.555951609' => $data[ 'when' ],
		'entry.1626485478' => $data[ 'activity' ],
		'entry.1252434475' => $data[ 'id' ],
		'entry.1860116392' => $data[ 'phoneNumber' ],
		'entry.1271044735' => $data[ 'verified' ],
		'entry.780318046' => $data[ 'sourceMedium' ],
		'entry.1308748215' => $data[ 'sourcePoint' ],
		'entry.2030254969' => $data[ 'interests' ],
		'entry.614407814' => $data[ 'duration' ],
		'entry.1785515953' => $data[ 'callRecording' ]
	];

	$response = getAPIResponse( $endpoint, 'POST', $requestBody );

	return $response;

}
