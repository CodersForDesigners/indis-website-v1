<?php
/*
 *
 * This is the default blog post template
 *
 */
require_once __DIR__ . '/../inc/above.php';

// Page-specific preparatory code goes here.

?>





<!-- Post Content -->
<section class="sample-section">
	<div class="container">
		<div class="row">
			<div class="title"><?= $thePost->post_title ?></div>
			<div class="content"><?= $thePost->post_content ?></div>
		</div>
	</div>
</section>
<!-- END: Post Content -->





<?php require_once __DIR__ . '/../inc/below.php'; ?>
