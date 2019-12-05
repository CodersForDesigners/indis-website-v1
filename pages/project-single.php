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
			</div>
		</div>
	</div>
</section>
<!-- END: Sample Section -->


<!-- Navigation Section -->
<section class="navigation-section space-25-top">
	<div class="container">
		<div class="row">
			<div class="navigation columns small-12 text-right space-50-right">
				<a href="/" class="link h6 strong text-uppercase inline space-min-top-bottom">Projects</a>
				<a href="/" class="link h6 strong text-uppercase inline space-min-top-bottom">Floorplans</a>
				<a href="/" class="link h6 strong text-uppercase inline space-min-top-bottom">Location</a>
				<a href="/" class="link h6 strong text-uppercase inline space-min-top-bottom">Masterplan</a>
				<a href="/" class="link h6 strong text-uppercase inline space-min-top-bottom">Amenities</a>
				<a href="/" class="link h6 strong text-uppercase inline space-min-top-bottom">Updates</a>
				<a href="/" class="link h6 strong text-uppercase inline space-min-top-bottom">+91-99860-99860</a>
			</div>
		</div>
	</div>
</section>
<!-- END: Navigation Section -->


<!-- Cover Section -->
<section class="cover-section space-25-top space-100-bottom">
	<div class="container">
		<div class="row">
			<div class="cover-image-container image-1 columns small-12 large-12"><div class="cover-image fill-neutral-2" style="background-image: url('../media/project-cover/1.jpg<?php echo $ver ?>');"></div></div>
			<div class="project-card columns small-8 medium-4 fill-dark space-25">
				<div class="logo space-min-bottom"><img class="block" src="../media/indis-logo.svg<?php echo $ver ?>"></div>
				<div class="title h4 strong">One City, HYD</div>
				<div class="location label">Kukatpally</div>
				<hr class="dash">
				<div class="type h6 strong space-min-top">2 & 3 BHK Apartments</div>
				<div class="price h5 condensed">50Lakhs to 1.3Cr</div>
			</div>
			<div class="cover-image-strip columns small-4 medium-2 large-6">
				<div class="row">
					<div class="cover-image-container image-2 columns small-12 large-4"><div class="cover-image fill-neutral-2 cursor-pointer" tabindex="-1" style="background-image: url('../media/project-cover/2.jpg<?php echo $ver ?>');"></div></div>
					<div class="cover-image-container image-3 columns small-12 large-4"><div class="cover-image fill-neutral-2 cursor-pointer" tabindex="-1" style="background-image: url('../media/project-cover/3.jpg<?php echo $ver ?>');"></div></div>
					<div class="cover-image-container image-4 columns small-12 large-4"><div class="cover-image fill-neutral-2 cursor-pointer" tabindex="-1" style="background-image: url('../media/project-cover/4.jpg<?php echo $ver ?>');"></div></div>
				</div>
			</div>
			<div class="cover-image-container image-5 columns small-12 medium-6 large-4"><div class="cover-image portrait fill-neutral-2 cursor-pointer" tabindex="-1" style="background-image: url('../media/project-cover/5.jpg<?php echo $ver ?>');"></div></div>
		</div>
	</div>
</section>
<!-- END: Cover Section -->


<!-- Intro Section -->
<section class="intro-section fill-neutral-1" style="height: 2000px;">
	<div class="container">
		<div class="row">
			<div class="columns small-12">
			</div>
		</div>
	</div>
</section>
<!-- END: Intro Section -->

<?php require_once __DIR__ . '/../inc/below.php'; ?>
