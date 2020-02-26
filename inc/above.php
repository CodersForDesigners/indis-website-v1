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
	if ( empty( $thePost ) and ! in_array( $postType, [ 'page', null ] ) ) {
		// echo 'Please create a corresponding page or post with the slug' . '"' . $urlSlug . '"' . 'in the CMS.';
		http_response_code( 404 );
		return header( 'Location: /', true, 302 );
		exit;
	}
	// If there is neither a corresponding post in the database nor a dedicated template for the given route, return a 404 and redirect
	else if ( empty( $thePost ) and ! $hasDedicatedTemplate ) {
		http_response_code( 404 );
		return header( 'Location: /', true, 302 );
		exit;
	}
	else if ( ! empty( $thePost ) )
		$postId = $thePost->ID;
}


// Construct the page's title ( for use in the title tag )
$siteTitle = getContent( '', 'page_title', $urlSlug ) ?: getContent( 'Indis', 'page_title' );
$pageUrl = $siteUrl . $requestPath;

// Build the Page Title ( if an explicit one is set, use that )
if ( cmsIsEnabled() and ! empty( $thePost ) )
	$pageTitle = ( $pageTitle ?? $thePost->post_title ) . ' | ' . $siteTitle;
else
	$pageTitle = empty( $pageTitle ) ? $siteTitle : ( $pageTitle . ' | ' . $siteTitle );


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
			<section class="navigation-section space-25-top js_navigation_section">
				<div class="navigation-toggle-button row show-for-medium text-right">
					<div class="container">
						<button class="icon-button menu clickable inline js_menu_button" tabindex="-1" style="background-image: url('../media/icon/icon-menu.svg<?php echo $ver ?>');"></button>
					</div>
				</div>
				<?php

					$navigationMenuName = $postType === 'projects' ? 'Projects' : 'Primary';
					$navigationMenuItems = getContent( [ ], $navigationMenuName, 'navigation' );
					foreach ( $navigationMenuItems as &$item ) {
						$field = getContent( '', 'nav_override_from_field', $item[ 'ID' ] );
						if ( ! empty( $field ) and ! empty( getContent( '', $field ) ) ) {
							$item[ 'url' ] = getContent( '', $field );
							// If the override value is a phone number, perform some modifications
							if ( preg_match( '/^\+?[\d\-]+$/', $item[ 'url' ] ) ) {
								// Prepend the `+91` country code if one isn't provided
								if ( $item[ 'url' ][ 0 ] !== '+' )
									$item[ 'url' ] = '+91' . $item[ 'url' ];
								// replace the navigation item's label as well
								$item[ 'title' ] = $item[ 'url' ];
								// Prepend the `tel:` protocol to the URL
								$item[ 'url' ] = 'tel:' . str_replace( '-', '', $item[ 'url' ] );
							}
						}
						$itemUrl = $item[ 'url' ];
						// If the URL starts with a `#`, that means it links to a section
						if ( ! empty( $itemUrl[ 0 ] ) and $itemUrl[ 0 ] === '#' )
							$itemUrl = $requestPath . $itemUrl;
						$item = [
							'label' => $item[ 'title' ],
							'url' => $itemUrl,
							'classes' => implode( ' ', $item[ 'classes' ] )
						];
					}
					unset( $item );

				?>
				<div class="navigation row">
					<div class="container">
						<div class="navigation-sticky-info columns small-12 large-3 inline-middle space-25-left">
							<div class="row">
								<div class="inline-middle space-min-right">
									<a href="<?php echo $baseURL ?>" class="logo clickable float-left"><img class="block" src="../media/indis-symbol-color.svg<?php echo $ver ?>"></a>	
								</div>
								<div class="inline-middle">
									<div class="title h5 strong"><?= $thePost->post_title ?></div>
									<div class="location label strong text-uppercase text-neutral-4"><?= getContent( '', 'location' ) ?></div>
								</div>								
							</div>
						</div>
						<div class="position-relative columns small-12 large-9 inline-middle text-right space-50-right">
							<div class="link h4 strong text-uppercase show-for-medium">Menu</div>
							<span class="link h6 strong text-uppercase space-min-top-bottom position-relative no-pointer">
								Projects
								<select class="nested-link clickable js_projects_selector hidden">
									<?php if ( $postType === 'projects' ) : ?>
										<option data-href="<?= get_permalink( $thePost->ID ) ?>"><?= $thePost->post_title ?></option>
									<?php else : ?>
										<option disabled selected>Select Project</option>
									<?php endif; ?>
									<?php foreach ( $allProjectsExcludingCurrent as $project ) : ?>
										<option data-href="<?= get_permalink( $project[ 'ID' ] ) ?>"><?= $project[ 'post_title' ] ?></option>
									<?php endforeach; ?>
								</select>
							</span><br class="show-for-medium">
							<?php foreach ( $navigationMenuItems as $item ) : ?>
								<a href="<?= $item[ 'url' ] ?>" class="link clickable h6 strong text-uppercase space-min-top-bottom position-relative <?= $item[ 'classes' ] ?> js_navigation_item"><?= $item[ 'label' ] ?></a><br class="show-for-medium">
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</section>
			<!-- END: Navigation Section -->
