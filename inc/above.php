<?php

// Get utility functions
require_once __DIR__ . '/utils.php';
// Include WordPress for Content Management
initWordPress();

/* -- Lazaro disclaimer and footer -- */
require_once __DIR__ . '/lazaro.php';

/*
 * A version number for versioning assets to invalidate the browser cache
 */
$ver = '?v=20200127';

/*
 * Get all the links on the site
 */
$defaultLinks = require __DIR__ . '/default-nav-links.php';
$links = getContent( $defaultLinks, 'pages' );

/*
 * Figure out the base URL
 * 	We diff the document root and the directory of this file to determine it
 */
$pathFragments = array_values( array_filter( explode( '/', substr( __DIR__, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) ) ) ) );
if ( count( $pathFragments ) > 1 )
	$baseURL = '/' . $pathFragments[ 0 ] . '/';
else
	$baseURL = '/';

/*
 * Get the title and URL of the website and current page
 */
if ( cmsIsEnabled() ) {
	$thePost = getCurrentPost( $urlSlug, $postType );
	if ( empty( $thePost ) ) {
		// echo 'Please create a corresponding page or post with the slug' . '"' . $urlSlug . '"' . 'in the CMS.';
		http_response_code( 404 );
		return header( 'Location: /', true, 302 );
		exit;
	}
	else
		$postId = $thePost->ID;
}


// Construct the page's title ( for use in the title tag )
$siteTitle = getContent( '', 'page_title', $urlSlug ) ?: getContent( 'Indis', 'page_title' );
$pageUrl = $siteUrl . $requestPath;

if ( cmsIsEnabled() )
	$pageTitle = $thePost->post_title . ' | ' . $siteTitle;
else
	$pageTitle = $siteTitle;


// Get the page's image for SEO and other related purposes
$pageImage = getContent( '', 'page_image', $urlSlug ) ?: getContent( '', 'page_image' );
if ( ! empty( $pageImage[ 'sizes' ] ) )
	$pageImage = $pageImage[ 'sizes' ][ 'medium' ] ?: $pageImage[ 'sizes' ][ 'thumbnail' ] ?: $pageImage[ 'url' ];
else
	$pageImage = $pageImage[ 'url' ] ?? null;

// #fornow
// Just so that when some social media service (WhatsApp) try to ping URL,
//  	it should not get a 404. This because is setting the response header.
http_response_code( 200 );


// Get all the project but the current one ( if the page is that of a project )
$allProjectsExcludingCurrent = getPostsOf( 'projects', null, $thePost->ID );
foreach ( $allProjectsExcludingCurrent as &$project ) {
	$project[ 'permalink' ] = get_permalink( $project[ 'ID' ] );
}
unset( $project );

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"
	prefix="og: http://ogp.me/ns# fb: http://www.facebook.com/2008/fbml">

	<?php require_once 'head.php'; ?>

	<body id="body" class="body">

		<?php
			/*
			 * Arbitrary Code ( Top of Body )
			 */
			echo getContent( '', 'arbitrary_code_body_top' );
		?>

	<!--  ★  MARKUP GOES HERE  ★  -->

	<div id="page-wrapper"><!-- Page Wrapper -->

		<?php //require_once 'navigation.php'; ?>

		<!-- Page Content -->
		<div id="page-content">

			<!-- Navigation Section -->
			<section class="navigation-section sticky space-25-top js_navigation_section">
				<div class="navigation-toggle-button row show-for-medium text-right">
					<div class="container">
						<button class="icon-button menu inline js_menu_button" tabindex="-1" style="background-image: url('../media/icon/icon-menu.svg<?php echo $ver ?>');"></button>
					</div>
				</div>
				<?php

					$navigationMenuName = $postType === 'projects' ? 'Projects' : 'Primary';
					$navigationMenuItems = getContent( [ ], $navigationMenuName, 'navigation' );
					foreach ( $navigationMenuItems as &$item ) {
						$itemUrl = $item[ 'url' ];
						if ( $itemUrl[ 0 ] !== '/' ) {
							if ( $itemUrl[ 0 ] === '#' )
								$itemUrl = $requestPath . $itemUrl;
							else if ( strpos( substr( $itemUrl, 0, 5 ), ':' ) === false )
								$itemUrl = $requestPath . '/' . $itemUrl;
						}
						$item = [
							'label' => $item[ 'title' ],
							'url' => $itemUrl
						];
					}
					unset( $item );

				?>
				<div class="navigation row">
					<div class="container">
						<div class="navigation-sticky-info hide-for-medium columns small-12 large-3 inline-bottom space-min-top-bottom space-25-left">
							<div class="title h5 strong"><?= $thePost->post_title ?></div>
							<div class="location label strong text-uppercase text-neutral-4"><?= getContent( '', 'location' ) ?></div>
						</div>
						<div class="position-relative columns small-12 large-9 inline-bottom text-right space-50-right">
							<div class="link h4 strong text-uppercase show-for-medium">Menu</div>
							<span class="link h6 strong text-uppercase space-min-top-bottom position-relative no-pointer">
								Projects
								<select class="nested-link">
									<option value="">One City, HYD</option>
									<option value="">PBEL City, HYD</option>
									<option value="">VB City, HYD</option>
									<option value="">Viva City, HYD</option>
								</select>
							</span><br class="show-for-medium">
							<?php foreach ( $navigationMenuItems as $item ) : ?>
								<a href="<?= $item[ 'url' ] ?>" class="link h6 strong text-uppercase space-min-top-bottom position-relative"><?= $item[ 'label' ] ?></a><br class="show-for-medium">
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</section>
			<!-- END: Navigation Section -->
