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
$ver = '?v=20200403';

/*
 * A class name for temporarily disabling sections or features or content parts while in development
 */
$hide = 'hidden';
$showMedium = 'show-for-medium';

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


// Construct the page's title ( for use in the title tag )
$siteTitle = getContent( '', 'page_title', $urlSlug ) ?: getContent( 'Indis', 'page_title' );
$pageUrl = $siteUrl . $requestPath;

// Build the Page Title ( if an explicit one is set, use that )
if ( cmsIsEnabled() and ! empty( $thePost ) )
	$pageTitle = ( $pageTitle ?? $thePost[ 'post_title' ] ) . ' | ' . $siteTitle;
else
	$pageTitle = empty( $pageTitle ) ? $siteTitle : ( $pageTitle . ' | ' . $siteTitle );


/*
 * Meta / SEO
 */
$metaDescription = $metaDescription ?? getContent( null, 'meta_description' );
$metaImage = $metaImage ?? getContent( [ ], 'meta_image' );
$metaImage = $metaImage[ 'sizes' ][ 'medium' ] ?? $metaImage[ 'sizes' ][ 'small' ] ?? $metaImage[ 'sizes' ][ 'thumbnail' ] ?? $metaImage[ 'url' ] ?? null;


// #fornow
// Just so that when some social media service (WhatsApp) try to ping URL,
//  	it should not get a 404. This because is setting the response header.
http_response_code( 200 );


// Get all the project but the current one ( if the page is that of a project )
$allProjectsExcludingCurrent = getPostsOf( 'projects', null, $thePost[ 'ID' ] ?? [ ] );
if ( cmsIsEnabled() ) {
	foreach ( $allProjectsExcludingCurrent as &$project ) {
		$project[ 'permalink' ] = get_permalink( $project[ 'ID' ] );
	}
	unset( $project );
}

/*
 *
 * Navigation
 *
 * Build out the data-structure driving the page navigation markup
 *
 */
$navigationMenuName = $postType === 'projects' ? 'Projects' : 'Primary';
$navigationMenuItems = getContent( [ ], $navigationMenuName, 'navigation' );
foreach ( $navigationMenuItems as &$item ) {
	$itemUrl = $item[ 'url' ];

	// If the item has a contextual URL override
	$field = getContent( '', 'nav_override_from_field', $item[ 'ID' ] );
	if ( ! empty( $field ) and ! empty( getContent( '', $field ) ) ) {
		$itemUrl = getContent( '', $field );
		// If the override value is a phone number, perform some modifications
		if ( preg_match( '/^\+?[\d\-]+$/', $itemUrl ) ) {
			// Replace the navigation item's label as well
			$item[ 'title' ] = $itemUrl;
			// Prepend the `tel:` protocol to the URL
			$itemUrl = 'tel:' . str_replace( [ ' ', '-' ], '', $itemUrl );
		}
	}

	// If the item is an in-page (section) link, i.e. it starts with a `#`
	if ( ! empty( $itemUrl[ 0 ] ) and $itemUrl[ 0 ] === '#' ) {
		$itemUrl = $requestPath . $itemUrl;
		$item[ 'type' ] = 'in-page';
		$item[ 'classes' ][ ] = 'hidden';
	}

	// If the item is a "post-selector"
	$item[ 'selectorOf' ] = getContent( '', 'post-type-selector', $item[ 'ID' ] );
	if ( ! empty( $item[ 'selectorOf' ] ) ) {
		$item[ 'type' ] = 'post-selector';
		$item[ 'posts' ] = getPostsOf( $item[ 'selectorOf' ], null, $thePost[ 'ID' ] ?? [ ] );
		$item[ 'classes' ][ ] = 'no-pointer';
	}
	else
		$item[ 'classes' ][ ] = 'clickable';

	// Finally, re-shape the data-structure to include all the relevant fields
	$item = [
		'label' => $item[ 'title' ],
		'url' => $itemUrl,
		'classes' => implode( ' ', $item[ 'classes' ] ),
		'type' => $item[ 'type' ] ?? '',
		'selectorOf' => $item[ 'selectorOf' ],
		'posts' => $item[ 'posts' ] ?? [ ]
	];
}
unset( $item );

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml"
	prefix="og: http://ogp.me/ns# fb: http://www.facebook.com/2008/fbml">

	<?php require_once 'head.php'; ?>

	<body id="body" class="body">

		<?= getContent( '', 'arbitrary_code -> after_body_opening' ); ?>

	<!--  ★  MARKUP GOES HERE  ★  -->

	<div id="page-wrapper"><!-- Page Wrapper -->

		<?php //require_once 'navigation.php'; ?>

		<!-- Page Content -->
		<div id="page-content">

			<!-- Navigation Section -->
			<section class="navigation-section space-25-top js_navigation_section show">
				<div class="navigation-toggle-button row show-for-medium text-right">
					<div class="container">
						<button class="icon-button menu clickable inline js_menu_button" tabindex="-1" style="background-image: url('../media/icon/icon-menu.svg<?php echo $ver ?>');"></button>
					</div>
				</div>
				<div class="navigation row">
					<div class="container">
						<div class="navigation-sticky-info columns small-12 large-3 inline-middle space-25-left">
							<div class="row">
								<div class="inline-middle space-min-right">
									<a href="<?php echo $baseURL ?>" class="logo clickable float-left"><img class="block" src="../media/indis-symbol-color.svg<?php echo $ver ?>"></a>	
								</div>
								<div class="inline-middle">
									<div class="title h5 strong"><?= $thePost[ 'post_title' ] ?? 'indis' ?></div>
									<div class="location label strong text-uppercase text-neutral-4"><?= getContent( 'Group INCOR', 'location' ) ?></div>
								</div>
							</div>
						</div>
						<div class="position-relative columns small-12 large-9 inline-middle text-right space-50-right">
							<div class="link h4 strong text-uppercase show-for-medium">Menu</div>
							<?php foreach ( $navigationMenuItems as $item ) : ?>
								<a href="<?= $item[ 'url' ] ?>" class="link h6 strong text-uppercase space-min-top-bottom position-relative <?= $item[ 'classes' ] ?> js_navigation_item" data-type="<?= $item[ 'type' ] ?>">
									<?= $item[ 'label' ] ?>
									<?php if ( $item[ 'type' ] === 'post-selector' ) : ?>
										<select class="nested-link clickable js_navigation_post_selector">
											<?php if ( $item[ 'selectorOf' ] === $postType ) : ?>
												<option data-href="<?= get_permalink( $thePost[ 'ID' ] ) ?>" selected><?= $thePost[ 'post_title' ] ?></option>
											<?php else : ?>
												<option disabled selected>Select <?= $item[ 'selectorOf' ] ?></option>
											<?php endif; ?>
											<?php foreach ( $item[ 'posts' ] as $post ) : ?>
												<option data-href="<?= get_permalink( $post[ 'ID' ] ) ?>"><?= $post[ 'post_title' ] ?></option>
											<?php endforeach; ?>
										</select>
									<?php endif; ?>
								</a><br class="show-for-medium">
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</section>
			<!-- END: Navigation Section -->
