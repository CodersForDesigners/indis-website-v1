<?php

$mapId = $_REQUEST[ 'id' ];
if ( empty( $mapId ) ) {
	http_response_code( 400 );
	$response = [
		'code' => 400,
		'message' => 'Please provide a map to delete'
	];
	die( json_encode( $response ) );
}

// Delete the map directory if it already exists
$mapDirectory = $_SERVER[ 'DOCUMENT_ROOT' ] . '/content/plans/' . $mapId;
if ( is_dir( $mapDirectory ) )
	exec( 'rm -rf "' . $mapDirectory . '"', $commandOutput, $commandExitStatus );

if ( isset( $commandExitStatus ) and $commandExitStatus !== 0 ) {
	http_response_code( 500 );
	$response = [
		'code' => 500,
		'message' => 'There was an issue in deleting this map.',
		'data' => [
			'directory' => $mapDirectory,
			'log' => $commandOutput
		]
	];
	die( json_encode( $response ) );
}


http_response_code( 200 );
$response = [
	'code' => 200,
	'message' => 'Map deleted successfully.'
];
die( json_encode( $response ) );
