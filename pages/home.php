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
<section data-section="Projects List" class="project-list-section space-25-top space-100-bottom">
	<div class="container">
		<div class="project-list row">
			<div class="project-item-container columns small-12 medium-6 large-4">
				<div class="project-list-intro space-25-left">
					<div class="logo"><a href="<?php echo $baseURL ?>" class="inline"><img class="block" src="../media/indis-logo-dark.svg<?php echo $ver ?>"></a></div>
					<div class="list-title space-50-top-bottom">
						<div class="h2 strong text-lowercase">Find an <span class="text-red-2">Indis</span> home near you</div>
					</div>
				</div>
			</div>
			<?php foreach ( $projects as $project ) : ?>
				<div class="project-item-container columns small-12 medium-6 large-4">
					<a href="<?= $project[ 'permalink' ] ?>" class="project-item block fill-neutral-2 js_project_item" tabindex="-1">
						<img src="<?= getContent( '', 'cover_images -> 0 -> sizes -> large', $project[ 'ID' ] ) ?>">
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


<?php require_once __DIR__ . '/../inc/below.php'; ?>
<script type="text/javascript" src="/js/home.js<?= $ver ?>"></script>
