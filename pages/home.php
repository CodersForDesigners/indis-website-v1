<?php
/*
 *
 * This is a sample page you can copy and use as boilerplate for any new page.
 *
 */

// Page-specific preparatory code goes here.

?>

<?php require_once __DIR__ . '/../inc/above.php'; ?>





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
				<div class="list-title space-50-top-bottom">
					<div class="h2 strong text-lowercase">Find an <span class="text-red-2">Indis</span> home near you</div>
				</div>
			</div>
			<div class="project-item-container columns small-12 medium-6 large-4">
				<a href="/project-single" class="project-item block fill-neutral-2" tabindex="-1" style="background-image: url('../media/listing-cover/one-city.jpg<?php echo $ver ?>');">
					<div class="project-card fill-dark space-25">
						<div class="title h4 strong">One City, HYD</div>
						<div class="location label">Kukatpally</div>
						<hr class="dash">
						<div class="type h6 strong space-25-top">2 & 3 BHK Apartments</div>
						<div class="price h5 condensed">50Lakhs to 1.3Cr</div>
					</div>
				</a>
			</div>
			<div class="project-item-container columns small-12 medium-6 large-4">
				<a href="/project-single" class="project-item block fill-neutral-2" tabindex="-1" style="background-image: url('../media/listing-cover/pbel-city.jpg<?php echo $ver ?>');">
					<div class="project-card fill-dark space-25">
						<div class="title h4 strong">PBEL City, HYD</div>
						<div class="location label">Appa Junction</div>
						<hr class="dash">
						<div class="type h6 strong space-25-top">2 & 3 BHK Apartments</div>
						<div class="price h5 condensed">80Lakhs to 1.5Cr</div>
					</div>
				</a>
			</div>
			<div class="project-item-container columns small-12 medium-6 large-4">
				<a href="/project-single" class="project-item block fill-neutral-2" tabindex="-1" style="background-image: url('../media/listing-cover/vb-city.jpg<?php echo $ver ?>');">
					<div class="project-card fill-dark space-25">
						<div class="title h4 strong">VB City, HYD</div>
						<div class="location label">Bolarum</div>
						<hr class="dash">
						<div class="type h6 strong space-25-top">2 & 3 BHK Apartments</div>
						<div class="price h5 condensed">40Lakhs to 80Lakhs</div>
					</div>
				</a>
			</div>
			<div class="project-item-container columns small-12 medium-6 large-4">
				<a href="/project-single" class="project-item block fill-neutral-2" tabindex="-1" style="background-image: url('../media/listing-cover/some-city.jpg<?php echo $ver ?>');">
					<div class="project-card fill-dark space-25">
						<div class="title h4 strong">Some City, HYD</div>
						<div class="location label">Kondapur</div>
						<hr class="dash">
						<div class="type h6 strong space-25-top">2 & 3 BHK Apartments</div>
						<div class="price h5 condensed">40Lakhs to 80Lakhs</div>
					</div>
				</a>
			</div>
		</div>
	</div>
</section>
<!-- END: Project List Section -->





<?php require_once __DIR__ . '/../inc/below.php'; ?>
