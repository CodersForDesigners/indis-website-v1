<?php
/* ------------------------------- \
 * Script Bootstrapping
 \-------------------------------- */
# * - Error Reporting
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );
# * - Date and Timezone
date_default_timezone_set( 'Asia/Kolkata' );
# * - Prevent Script Cancellation by Client
ignore_user_abort( true );
# * - Script Timeout
set_time_limit( 0 );

$input = [ ];
$input[ 'name' ] = $_POST[ 'map-name' ];
$input[ 'image' ] = $_FILES[ 'map-image' ];

if ( empty( $input[ 'name' ] ) ) {
	http_response_code( 400 );
	$response = [
		'code' => 400,
		'message' => 'Please provide a name for the image.'
	];
	die( json_encode( $response ) );
}
if ( empty( $input[ 'image' ] ) ) {
	http_response_code( 400 );
	$response = [
		'code' => 400,
		'message' => 'Please provide an image.'
	];
	die( json_encode( $response ) );
}

$contentDirectory = "${_SERVER[ 'DOCUMENT_ROOT' ]}/content/plans";
$imageExtension = preg_replace( '/.+\.([^\.]+)$/', '$1', $input[ 'image' ][ 'name' ] );
$mapId = $input[ 'name' ];
$mapDirectory = $contentDirectory . '/' . $mapId;


/*
 *
 * Process the newly uploaded media file
 *
 */
// Delete the directory if it already exists
if ( is_dir( $mapDirectory ) )
	exec( 'rm -rf "' . $mapDirectory . '"', $commandOutput, $commandExitStatus );

if ( isset( $commandExitStatus ) and $commandExitStatus !== 0 ) {
	http_response_code( 500 );
	$response = [
		'code' => 500,
		'message' => 'This map has already been uploaded before. However, there was an issue in replacing that with the one you\'ve provided.',
		'data' => [
			'directory' => $mapDirectory,
			'log' => $commandOutput
		]
	];
	die( json_encode( $response ) );
}

// Process the image and generate all the tiles
$scriptPath = "${_SERVER[ 'DOCUMENT_ROOT' ]}/server/maps/generate-map-tiles.sh";
$tileGeneratorScriptPath = __DIR__ . '/gdal2tiles.py';
// $command = "sh ${scriptPath} ${tileGeneratorScriptPath} ${mapDirectory} ${input[ 'image' ][ 'tmp_name' ]} ${imageExtension}";
$command = implode( ' ', [
	'sh',
	$scriptPath,
	$tileGeneratorScriptPath,
	$mapDirectory,
	$input[ 'image' ][ 'tmp_name' ],
	$imageExtension
] );
exec( $command, $commandOutput, $commandExitStatus );

if ( isset( $commandExitStatus ) and $commandExitStatus !== 0 ) {
	http_response_code( 500 );
	$response = [
		'code' => 500,
		'message' => 'The tiles for the image could not be generated.',
		'data' => [
			'log' => $commandOutput
		]
	];
	die( json_encode( $response ) );
}

// Store a copy of the original
$imageDestinationPath = $contentDirectory . '/' . $mapId . '/original.' . $imageExtension;
move_uploaded_file(
	$input[ 'image' ][ 'tmp_name' ],
	$imageDestinationPath
);

http_response_code( 200 );
$response = [
	'code' => 200,
	'message' => 'Image successfully uploaded and processed.',
	'data' => [
		'image' => $input[ 'image' ]
	]
];
die( json_encode( $response ) );
