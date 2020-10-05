<?php

// Get utility functions
require_once __DIR__ . '/utils.php';
// Include WordPress for Content Management
initWordPress();

/* -- Lazaro disclaimer and footer -- */
require_once __DIR__ . '/signatures-and-disclaimers.php';

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
 * Figure out the base URL
 * 	We diff the document root and the directory of this file to determine it
 */
$pathFragments = array_values( array_filter( explode( '/', substr( __DIR__, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) ) ) ) );
if ( count( $pathFragments ) > 1 )
	$baseURL = '/' . $pathFragments[ 0 ] . '/';
else
	$baseURL = '/';


// Construct the page's title ( for use in the title tag )
$siteTitle = getContent( '', 'page_title', $urlSlug ) ?: getContent( 'INDIS', 'page_title' );
$pageUrl = $siteUrl . '/' . $requestPath;

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
$navigationMenuItems = getNavigationMenu( $navigationMenuName );
$footerNavigation = getNavigationMenu( 'Footer' );


/* -- Social Media Links -- */
$twitter_link = getContent( '', 'twitter_link' );
$facebook_link = getContent( '', 'facebook_link' );
$youtube_link = getContent( '', 'youtube_link' );
$instagram_link = getContent( '', 'instagram_link' );
$whatsapp_link = getContent( '', 'whatsapp_link' );
$linkedin_link = getContent( '', 'linkedin_link' );

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
									<div class="title h5 strong"><?= $postType === 'projects' ? $thePost[ 'post_title' ] : 'INDIS' ?></div>
									<div class="location label strong text-uppercase text-neutral-4"><?= getContent( 'Welcome', 'location' ) ?></div>
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
												<option data-href="<?= get_permalink( $thePost[ 'ID' ] ) ?>" selected>&nbsp;&nbsp;&nbsp;<?= $thePost[ 'post_title' ] ?>&nbsp;&nbsp;&nbsp;</option>
											<?php else : ?>
												<option disabled selected>&nbsp;&nbsp;&nbsp;Select <?= $item[ 'selectorOf' ] ?>&nbsp;&nbsp;&nbsp;</option>
											<?php endif; ?>
											<?php foreach ( $item[ 'posts' ] as $post ) : ?>
												<option data-href="<?= get_permalink( $post[ 'ID' ] ) ?>">&nbsp;&nbsp;&nbsp;<?= $post[ 'post_title' ] ?>&nbsp;&nbsp;&nbsp;</option>
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
