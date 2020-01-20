<?php
/*
 *
 * The is the Home page
 *
 */
require_once __DIR__ . '/../inc/above.php';

// In the context of this page,
// 	`allProjectsExcludingCurrent` literally refers to "all the projects"
$projects = &$allProjectsExcludingCurrent;
$offers = getContent( [ ], 'offers_list' );
	$numberOfOffers = str_pad( count( $offers ), 2, '0', STR_PAD_LEFT );

?>





<!-- Sample Page Content -->
<section class="sample-section">
	<div class="container">
		<div class="row">
			<div class="columns small-12">
			</div>
		</div>
	</div>
</section>
<!-- END: Sample Page Content -->


<!-- Project List Section -->
<section class="project-list-section space-25-top space-100-bottom">
	<div class="container">
		<div class="project-list row">
			<div class="project-item-container columns small-12 medium-6 large-4">
				<div class="project-list-intro space-25-left">
					<div class="logo"><img class="block" src="../media/indis-logo-dark.svg<?php echo $ver ?>"></div>
					<div class="list-title space-50-top-bottom">
						<div class="h2 strong text-lowercase">Find an <span class="text-red-2">Indis</span> home near you</div>
					</div>
				</div>
			</div>
			<?php foreach ( $projects as $project ) : ?>
				<div class="project-item-container columns small-12 medium-6 large-4">
					<a href="<?= $project[ 'permalink' ] ?>" class="project-item block fill-neutral-2 <?php if ( getContent( '', 'cover_images -> 0 -> sizes -> large-width', $project[ 'ID' ] ) / getContent( '', 'cover_images -> 0 -> sizes -> large-height', $project[ 'ID' ] ) < 1.25 ) echo 'fit-image' ?>" tabindex="-1" style="background-image: url( '<?= getContent( '', 'cover_images -> 0 -> sizes -> large', $project[ 'ID' ] ) ?>' );">
						<div class="project-card fill-dark space-25">
							<div class="title h4 strong"><?= $project[ 'post_title' ] ?></div>
							<div class="location label"><?= getContent( '', 'location', $project[ 'ID' ] ) ?></div>
							<hr class="dash">
							<div class="type h6 strong space-25-top"><?= getContent( '', 'type', $project[ 'ID' ] ) ?></div>
							<div class="price h5 condensed space-min-top"><?= getContent( '', 'price', $project[ 'ID' ] ) ?></div>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<!-- END: Project List Section -->


<!-- Carousel: Offers -->
<?php if ( ! empty( $offers ) ) : ?>
<div id="offers" class="carousel indis-carousel js_carousel_container">
	<div class="carousel-list js_carousel_content">
		<div class="carousel-list-item js_carousel_item">
			<div class="carousel-title h2 strong">
				<!-- <span class="text-red-2">offers</span> <br>and best <br>sellers -->
				<span class="text-red-2">spotlight</span> <br>apartment <br>units
			</div>
		</div>
		<?php foreach ( $offers as $index => $offer ) : ?>
			<div class="carousel-list-item js_carousel_item">
				<div class="card-index text-neutral-2">
					<div class="count h3 inline-bottom"><?= str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ?></div>
					<div class="total label strong text-uppercase inline-bottom"><?= $numberOfOffers ?></div>
				</div>
				<div class="carousel-card fill-dark">
					<div class="info space-25">
						<div class="title h4 strong"><?= $offer[ 'offer_title' ] ?></div>
						<div class="price h5 condensed"><?= $offer[ 'offer_price' ] ?></div>
						<div class="time label strong space-min-top"><span class="text-uppercase">Valid For :</span> <?= getIntervalString( $offer[ 'offer_expiry' ] ) ?></div>
					</div>
				</div>
				<a href="<?= $offer[ 'offer_page_url' ] ?>" class="button fill-neutral-4 text-light button-icon" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--neutral-2);">Enquire Now</a>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="carousel-controls clearfix">
		<div class="container">
			<div class="prev float-left"><button class="button fill-light js_pager" data-dir="left"><img class="block" src="../media/icon/icon-left-triangle-dark.svg<?php echo $ver ?>"></button></div>
			<div class="next float-right"><button class="button fill-light js_pager" data-dir="right"><img class="block" src="../media/icon/icon-right-triangle-dark.svg<?php echo $ver ?>"></button></div>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- END: Carousel: Offers -->


<?php require_once __DIR__ . '/../inc/below.php'; ?>
