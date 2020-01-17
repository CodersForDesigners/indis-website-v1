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
					<a href="<?= $project[ 'permalink' ] ?>" class="project-item block fill-neutral-2" tabindex="-1" style="background-image: url( '<?= getContent( '', 'cover_images -> 0 -> sizes -> large', $project[ 'ID' ] ) ?>' );">
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
<div id="offers" class="carousel indis-carousel js_carousel_container">
	<div class="carousel-list js_carousel_content">
		<div class="carousel-list-item js_carousel_item">
			<div class="carousel-title h2 strong">
				<span class="text-red-2">offers</span> <br>and best <br>sellers
			</div>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">01</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-dark">
				<div class="info space-25">
					<div class="title h4 strong">1600sft 3BHK.</div>
					<div class="price h5 condensed">Starting at 80 Lakhs</div>
					<div class="time label strong space-min-top"><span class="text-uppercase">Valid For :</span> 2 days, 11 hrs, 33 mins</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">02</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-dark">
				<div class="info space-25">
					<div class="title h4 strong">New Tower Launch.</div>
					<div class="price h5 condensed">Starting at 1.2Cr</div>
					<div class="time label strong space-min-top"><span class="text-uppercase">Valid For :</span> 2 days, 11 hrs, 33 mins</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">03</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-dark">
				<div class="info space-25">
					<div class="title h4 strong">Pay 20% now, 80% on possession.</div>
					<div class="price h5 condensed">Starting at 45Lakhs</div>
					<div class="time label strong space-min-top"><span class="text-uppercase">Valid For :</span> 2 days, 11 hrs, 33 mins</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">04</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-dark">
				<div class="info space-25">
					<div class="title h4 strong">1930sft 3BHK, Pool View Units.</div>
					<div class="price h5 condensed">Starting at 1.0 Cr</div>
					<div class="time label strong space-min-top"><span class="text-uppercase">Valid For :</span> 2 days, 11 hrs, 33 mins</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">05</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-dark">
				<div class="info space-25">
					<div class="title h4 strong">Ready to move-in 2BHK. Only 5 left.</div>
					<div class="price h5 condensed">Starting at 40Lakhs</div>
					<div class="time label strong space-min-top"><span class="text-uppercase">Valid For :</span> 2 days, 11 hrs, 33 mins</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
	</div>
	<div class="carousel-controls clearfix">
		<div class="container">
			<div class="prev float-left"><button class="button fill-light js_pager" data-dir="left"><img class="block" src="../media/icon/icon-left-triangle-dark.svg<?php echo $ver ?>"></button></div>
			<div class="next float-right"><button class="button fill-light js_pager" data-dir="right"><img class="block" src="../media/icon/icon-right-triangle-dark.svg<?php echo $ver ?>"></button></div>
		</div>
	</div>
</div>
<!-- END: Carousel: Offers -->


<?php require_once __DIR__ . '/../inc/below.php'; ?>
