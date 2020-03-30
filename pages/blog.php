<?php
/*
 *
 * This is the default blog post template
 *
 */
require_once __DIR__ . '/../inc/above.php';

// Page-specific preparatory code goes here.

?>





<!-- Blog Page -->
<section class="blog-page">
	<div class="blog-header fill-dark">
		<div class="container">
			<div class="row">
				<div class="columns small-12">
					<div class="logo"><a href="<?php echo $baseURL ?>" class="inline"><img class="block" src="../media/indis-logo-light.svg<?php echo $ver ?>"></a></div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="columns small-12 large-8 large-offset-2">
				<div class="blog-title h1 strong text-lowercase space-50-top-bottom"><?= $thePost[ 'post_title' ] ?></div>
			</div>
			<div class="columns small-12 large-8 large-offset-2">
				<div class="blog-content"><?= $thePost[ 'post_content' ] ?></div>
			</div>
		</div>
	</div>
</section>
<!-- END: Blog Page -->





<?php require_once __DIR__ . '/../inc/below.php'; ?>
