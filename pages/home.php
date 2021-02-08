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


/*
 * ----- Projects to Highlight
 */
$projectToHighlight1 = getContent( false, 'project_hightlight_1' );
$projectToHighlight2 = getContent( false, 'project_hightlight_2' );
$projectsToHighlight = [ ];
if ( $projectToHighlight1 )
	$projectsToHighlight[ $projectToHighlight1[ 'name' ] ] = $projectToHighlight1;
if ( $projectToHighlight2 )
	$projectsToHighlight[ $projectToHighlight2[ 'name' ] ] = $projectToHighlight2;
if ( ! empty( $projectsToHighlight ) )
	foreach ( $projects as $index => $project ) {
		if ( ! in_array( $project[ 'ID' ], array_keys( $projectsToHighlight ) ) )
			continue;
		$project[ 'highlight' ] = [
			'label' => $projectsToHighlight[ $project[ 'ID' ] ][ 'label' ],
			'value' => $projectsToHighlight[ $project[ 'ID' ] ][ 'value' ]
		];
		// Overwrite the project with the new data
		$projects[ $index ] = $project;
	}

// Consolidate the featured spotlights across all projects
$featuredSpotlights = [ ];
foreach ( $projects as $project ) {
	$projectSpotlights = getContent( [ ], 'spotlight_list', $project[ 'ID' ] );
	foreach ( $projectSpotlights as $spotlight ) {
		if ( ! $spotlight[ 'spotlight_featured' ] )
			continue;
		$spotlight[ 'project' ] = $project[ 'post_title' ];
		$spotlight[ 'location' ] = getContent( "", 'location', $project[ 'ID' ] );
		$spotlight[ 'permalink' ] = $project[ 'permalink' ];
		$featuredSpotlights[ ] = $spotlight;
	}
}
shuffle( $featuredSpotlights );
$numberOfSpotlights = str_pad( count( $featuredSpotlights ), 2, '0', STR_PAD_LEFT );

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
<section data-section="Project List" data-id="project-list" class="project-list-section space-25-top space-100-bottom">
	<div class="container">
		<div class="project-list row">
			<div class="project-item-container columns small-12 medium-6 large-4">
				<div class="project-list-intro space-25-left">
					<div class="logo"><a href="<?php echo $baseURL ?>" class="inline"><img class="block" src="../media/indis-logo-color.svg<?php echo $ver ?>"></a></div>
					<div class="list-title space-50-top-bottom">
						<div class="h2 strong text-lowercase">Engineered <span class="text-red-2">Homes</span> in Hyderabad</div>
					</div>
				</div>
			</div>
			<?php foreach ( $projects as $project ) : ?>
				<div class="project-item-container columns small-12 medium-6 large-4">
					<a href="<?= $project[ 'permalink' ] ?>" class="project-item block fill-neutral-2 js_project_item" tabindex="-1">
						<img src="<?= getContent( '', 'cover_images -> 0 -> image -> sizes -> large', $project[ 'ID' ] ) ?>">
						<div class="project-card fill-dark space-25">
							<div class="title h4 strong"><?= $project[ 'post_title' ] ?></div>
							<div class="location label strong text-uppercase text-red-2"><?= getContent( '', 'location', $project[ 'ID' ] ) ?></div>
							<hr class="dash">
							<div class="type h6 strong space-25-top"><?= getContent( '', 'type', $project[ 'ID' ] ) ?></div>
							<div class="price h5 condensed text-neutral-3"><?= getContent( '', 'price', $project[ 'ID' ] ) ?></div>
						</div>
						<?php if ( ! empty( $project[ 'highlight' ] ) ) : ?>
							<div class="tag">
								<span class="project h6 strong fill-light"><?= $project[ 'highlight' ][ 'label' ] ?></span>
								<span class="series-id h6 strong fill-red-2"><?= $project[ 'highlight' ][ 'value' ] ?></span>
							</div>
						<?php endif; ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<!-- END: Project List Section -->


<!-- Carousel: Spotlights -->
<?php if ( ! empty( $featuredSpotlights ) ) : ?>
<div data-section="Spotlight" data-id="spotlight" id="spotlight" class="carousel spotlight indis-carousel js_carousel_container">
	<div class="carousel-list js_carousel_content">
		<div class="carousel-list-item js_carousel_item">
			<div class="carousel-title h2 strong">
				<span class="text-red-2">spotlight</span> <br>apartment <br>units
			</div>
		</div>
		<?php foreach ( $featuredSpotlights as $index => $spotlight ) : ?>
			<div class="carousel-list-item js_carousel_item">
				<div class="card-index text-neutral-2">
					<div class="count h3 inline-bottom"><?= str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ?></div>
					<div class="total label strong text-uppercase inline-bottom"><?= $numberOfSpotlights ?></div>
				</div>
				<div class="carousel-card fill-dark" style="background-image: url( '<?= $spotlight[ 'spotlight_thumbnail' ][ 'sizes' ][ 'small' ] ?>' );">
					<div class="info space-25">
						<div class="info-box">
							<span class="title h5 strong"><?= $spotlight[ 'spotlight_title' ] ?></span>
							<span class="description p text-neutral-2"><?= $spotlight[ 'spotlight_description' ] ?></span>
						</div>
						<div class="price h5 condensed <?= $hide ?>"><?= $spotlight[ 'spotlight_price' ] ?></div>
						<div class="tag">
							<span class="project h6 strong fill-light"><?= $spotlight[ 'project' ] ?></span>
							<?php if( ! empty( $spotlight[ 'spotlight_series_id' ] ) ) : ?>
							<span class="series-id h6 strong fill-red-2"><?= $spotlight[ 'spotlight_series_id' ] ?></span>
							<?php endif; ?>
						</div>
						<div class="location label text-red-2 strong text-uppercase"><?= $spotlight[ 'location' ] ?></div>
					</div>
				</div>
				<a href="<?= $spotlight[ 'permalink' ] ?>" target="_blank" class="button fill-neutral-4 text-light button-icon" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--neutral-2);">Visit Project</a>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="carousel-controls clearfix">
		<div class="container">
			<div class="prev float-left"><button class="button js_pager" data-dir="left"><img class="block" src="../media/icon/icon-left-triangle-dark.svg<?php echo $ver ?>"></button></div>
			<div class="next float-right"><button class="button js_pager" data-dir="right"><img class="block" src="../media/icon/icon-right-triangle-dark.svg<?php echo $ver ?>"></button></div>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- END: Carousel: Spotlights -->


<?php require_once __DIR__ . '/../inc/below.php'; ?>
<script type="text/javascript" src="/js/home.js<?= $ver ?>"></script>
