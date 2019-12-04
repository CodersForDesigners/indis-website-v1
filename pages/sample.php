<?php
/*
 *
 * This is a sample page you can copy and use as boilerplate for any new page.
 *
 */
require_once __DIR__ . '/../inc/above.php';

// Page-specific preparatory code goes here.

?>





<!-- Sample Section -->
<section class="sample-section">
	<div class="container">
		<div class="row">
			<div class="columns small-12">
				<div class="h3 space-half-top space-min-bottom">Um, what happened to the sample?</div>
				<div class="h5"><?php echo getContent( 'Not sure.', 'about_the_sample', $pageId ) ?></div>
			</div>
		</div>
	</div>
</section>
<!-- END: Sample Section -->





<?php require_once __DIR__ . '/../inc/below.php'; ?>
