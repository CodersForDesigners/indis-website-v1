<?php




/*
 * -/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-
 *  Set some useful variables
 * -/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-
 */
$documentRoot = $_SERVER[ 'DOCUMENT_ROOT' ];
$homePage = $documentRoot . '/pages/home.php';
$_requestPathParts = explode( '?', $_SERVER[ 'REQUEST_URI' ], -1 );
$requestPath = trim( $_requestPathParts[ 0 ] ?? $_SERVER[ 'REQUEST_URI' ], '/' );



/*
 * -/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-
 *  Route the request to the correct file
 * -/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-
 */
// Home page
if ( $requestPath === '' )
	return require_once $homePage;

// Every other page
$filename = $documentRoot . '/pages/' . $requestPath . '.php';
if ( file_exists( $filename ) ) {
	// Set a query param
	$_GET[ '_slug' ] = $requestPath;
	return require_once $filename;
}
else
	return header( 'Location: /', true, 302 );
