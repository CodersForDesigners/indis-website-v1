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

<!-- Cover Section -->
<section class="cover-section space-25-top space-50-bottom">
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
			<div class="cover-image-container image-5 columns small-12 medium-6 large-4"><div class="cover-image portrait fill-neutral-2 cursor-pointer" tabindex="-1" style="background-image: url('../media/project-cover/5.jpg<?php echo $ver ?>');"><div class="icon-button zoom" style="background-image: url('../media/icon/icon-zoom.svg<?php echo $ver ?>');"></div></div></div>
		</div>
	</div>
</section>
<!-- END: Cover Section -->


<!-- Intro Section -->
<section class="intro-section">
	<div class="container">
		<div class="row">
			<div class="columns small-12 medium-10 large-6 large-offset-1">
				<div class="project-logo space-25-bottom"><img class="block" src="../media/project-logo/pbel-city.png<?php echo $ver ?>"></div>
				<div class="title h2 strong text-lowercase space-25-bottom">Your commute to Hitec City or Financial district is <span class="text-red-2">just a 15 to 17 minute drive</span> on the Nehru Outer Ring Road.</div>
				<div class="description text-neutral-2 space-25-bottom">Body Copy if required. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</div>
				<div class="points row space-50-bottom">
					<div class="point h5 condensed columns small-12 medium-6 space-min-bottom"><span class="inline-middle space-min-right"><img src="https://via.placeholder.com/32"></span>1208sft to 1979sft</div>
					<div class="point h5 condensed columns small-12 medium-6 space-min-bottom"><span class="inline-middle space-min-right"><img src="https://via.placeholder.com/32"></span>Ready to move-in</div>
					<div class="point h5 condensed columns small-12 medium-6 space-min-bottom"><span class="inline-middle space-min-right"><img src="https://via.placeholder.com/32"></span>1800+ Families Live Here</div>
					<div class="point h5 condensed columns small-12 medium-6 space-min-bottom"><span class="inline-middle space-min-right"><img src="https://via.placeholder.com/32"></span>Near the Airport</div>
					<div class="point h5 condensed columns small-12 medium-6 space-min-bottom"><span class="inline-middle space-min-right"><img src="https://via.placeholder.com/32"></span>Swimming Pool</div>
					<div class="point h5 condensed columns small-12 medium-6 space-min-bottom"><span class="inline-middle space-min-right"><img src="https://via.placeholder.com/32"></span>Fully Equiped Gymnasium</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- END: Intro Section -->

<?php require_once __DIR__ . '/../inc/below.php'; ?>
