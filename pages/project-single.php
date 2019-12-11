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
				<div class="logo space-min-bottom"><img class="block" src="../media/indis-logo-light.svg<?php echo $ver ?>"></div>
				<div class="title h4 strong">PBEL City, HYD</div>
				<div class="location label strong text-uppercase text-neutral-4">Appa Junction</div>
				<hr class="dash">
				<div class="type h6 strong space-min-top">2 & 3 BHK Apartments</div>
				<div class="price h5 condensed">80Lakhs to 1.5Cr</div>
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


<!-- Carousel: Best Sellers -->
<div class="carousel indis-carousel js_carousel_container">
	<div class="carousel-list js_carousel_content">
		<div class="carousel-list-item js_carousel_item">
			<div class="carousel-title h2 strong">
				offers <br>and <span class="text-red-2">best <br>sellers</span>
			</div>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">01</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-neutral-2">
				<div class="info space-25">
					<div class="price h5 condensed">Starting at 47 Lakhs</div>
					<div class="title h4 strong">1450sft 2BHK on the 14th floor with a view of the Lake.</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">02</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-neutral-2">
				<div class="info space-25">
					<div class="price h5 condensed">Starting at 50 Lakhs</div>
					<div class="title h4 strong">1775sft 3BHK on the 3rd or 4th floor overlooking the sports arena.</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">03</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-neutral-2">
				<div class="info space-25">
					<div class="price h5 condensed">Starting at 43 Lakhs</div>
					<div class="title h4 strong">Most compact 3BHK at just 1680sft. Available from the 5th to 28th floor.</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
		<div class="carousel-list-item js_carousel_item">
			<div class="card-index text-neutral-2">
				<div class="count h3 inline-bottom">04</div>
				<div class="total label strong text-uppercase inline-bottom">14</div>
			</div>
			<div class="carousel-card fill-neutral-2">
				<div class="info space-25">
					<div class="price h5 condensed">Starting at 51 Lakhs</div>
					<div class="title h4 strong">Uninterrupted views for 4 to 5km. Spacious 1995sft 3BHK on the 18th or 20th floors.</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Enquire Now</a>
		</div>
		<div class="carousel-list-item js_carousel_item unlock">
			<div class="carousel-card">
				<div class="info space-25">
					<div class="unlock-title h3 strong text-lowercase">Unlock all 14 Floorplan details</div>
				</div>
			</div>
			<a href="" class="carousel-action button">Unlock Now</a>
		</div>
	</div>
	<div class="carousel-controls clearfix">
		<div class="container">
			<div class="prev float-left"><button class="button fill-light js_pager" data-dir="left"><img class="block" src="../media/icon/icon-left-triangle-dark.svg<?php echo $ver ?>"></button></div>
			<div class="next float-right"><button class="button fill-light js_pager" data-dir="right"><img class="block" src="../media/icon/icon-right-triangle-dark.svg<?php echo $ver ?>"></button></div>
		</div>
	</div>
</div>
<!-- END: Carousel: Best Sellers -->


<!-- Location Section -->
<section class="location-section space-50-top-bottom">
	<div class="container">
		<div class="row">
			<div class="location-image-container columns small-12 large-12"><div class="location-image fill-neutral-2" style="background-image: url('../media/location-image/1.png<?php echo $ver ?>');"></div></div>
			<div class="location-card columns small-8 medium-4 fill-light space-25">
				<div class="title h3 strong text-lowercase">Location</div>
				<div class="location label strong text-uppercase text-neutral-2">Appa Junction</div>
				<hr class="dash">
				<div class="address h6 text-neutral-2 space-min-top">Nehru Outer Ring Rd, Power Welfare Society, Kokapet, HYD, Telangana — 500075</div>
				<a href="" class="label strong text-red-2 text-uppercase space-min-top-bottom inline-middle">Open in Google Maps <img class="link-icon inline-middle" src="../media/icon/icon-location-color.svg<?php echo $ver ?>"></a>
			</div>
			<div class="location-title h2 strong text-neutral-2 text-lowercase columns small-9 medium-5 xlarge-4"><span class="text-light">The best views</span> for 2 to 3kms in all directions</div>
		</div>
	</div>
</section>
<!-- END: Location Section -->


<!-- Download Brochure -->
<section class="download-brochure">
	<div class="container">
		<div class="row">
			<div class="brochure-mockup columns small-12 medium-5 large-6 inline-middle">
				<img class="block" src="../media/mockup-download-brochure.png<?php echo $ver ?>">
			</div>
			<div class="brochure-action fill-light columns small-10 small-offset-1 medium-7 medium-offset-0 large-6 inline-middle">
				<div class="download-title h3 text-lowercase strong space-25-bottom">If you're in a hurry, <br>just <span class="text-red-2">download the <span class="text-uppercase">PDF</span> brochure</span></div>
				<button class="button">Download Now</button>
				<div class="courier-description p text-neutral-2 space-min-top">Or, if you'd like a copy of the physical brochure couriered to your location. <br><a href="" class="text-red-2">Click Here</a></div>
			</div>
		</div>
	</div>
</section>
<!-- END: Download Brochure -->


<?php require_once __DIR__ . '/../inc/below.php'; ?>
