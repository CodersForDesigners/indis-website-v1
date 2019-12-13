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
			<div class="location-title h2 strong text-red-1 text-lowercase columns small-9 medium-5 xlarge-4"><span class="text-light">The best views</span> for 2 to 3kms in all directions</div>
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


<!-- Engineering Section : Concrete -->
<section class="engineering-section concrete space-50-top-bottom">
	<div class="container">
		<div class="row row-1">
			<div class="section-label columns small-12 xlarge-10 xlarge-offset-1 space-25-bottom">
				<div class="label strong text-neutral-2 text-uppercase">Engineering</div>
			</div>
			<div class="heading columns small-12 medium-6 large-5 xlarge-4 xlarge-offset-1 space-50-bottom">
				<div class="h3 strong text-lowercase">Built with precision moulded concrete structures to ensure <span class="text-red-2">factory-like repeatable quality</span> in each home.</div>
			</div>
			<div class="points columns small-12 medium-5 large-3 xlarge-offset-1">
				<div class="title h4 strong space-25-bottom"><span class="text-red-2">High-Rise Build</span> <br>Engineering</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					The monolithic structure is stronger, has a longer life and is more earthquake resistant. 
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Unified build process. Structure, walls, electrical and plumbing are installed and built simultaneously.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					No need for plastering because the wall surface is smooth and precise. 
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Pleasing and functional interior walls that don’t have visible beams and columns. 
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					The factory-like repetitive ‘build and check’ process ensures predictable quality. 
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Concrete is an excellent insulator. Our buildings are cooler and have better sound insulation.
				</div>
				<div class="space-50-left space-25-bottom">
					<div class="label strong text-neutral-2 text-uppercase space-min-top-bottom">Construction Partner</div>
					<img src="../media/engineering/landt-logo.svg<?php echo $ver ?>">
				</div>
			</div>
			<div class="building-3d-1 hide-for-medium columns small-12 medium-6 medium-offset-1 large-4 xlarge-3 large-offset-0">
				<img class="block" src="../media/engineering/building-3d-1.png<?php echo $ver ?>">
			</div>
		</div>
		<div class="row row-2">
			<div class="film columns small-12 medium-6 large-5 xlarge-6">
				<div class="building-3d-2 space-50-left-right">
					<img class="block" src="../media/engineering/building-3d-2.png<?php echo $ver ?>">
				</div>
				<!-- video embed -->
				<div class="video-embed js_video_embed" data-src="lncVHzsc_QA">
					<div class="video-loading-indicator"></div>
				</div>
			</div>
			<div class="infographic columns small-12 medium-6 large-6 xlarge-6">
				<img class="block" src="../media/engineering/engineering-concrete-infographic.svg<?php echo $ver ?>">
			</div>
		</div>
	</div>
</section>
<!-- END: Engineering Section : Concrete -->

<!-- Engineering Section : Railing -->
<section class="engineering-section railing space-50-top-bottom">
	<div class="container">
		<div class="row row-1">
			<div class="section-label columns small-12 xlarge-11 xlarge-offset-1 space-25-bottom">
				<div class="label strong text-neutral-2 text-uppercase">Engineering</div>
			</div>
			<div class="heading columns small-12 medium-6 large-4 large-offset-1 space-50-bottom">
				<div class="h3 strong text-lowercase">Every balcony railing has vertical divisions. This ensures that <span class="text-red-2">children cannot climb them.</span></div>
			</div>
			<div class="points columns small-12 medium-6 large-4 xlarge-offset-1">
				<div class="title h4 strong space-25-bottom"><span class="text-red-2">High-Rise Safety</span> <br>Engineering</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					1.2m high balcony railings ensures safety on any floor.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Vertical divisions on the railing ensure children cannot climb the railing.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Complaint with the <span style="color: #2E73D8;">Bureau of Indian Standards</span> National Building Code.
				</div>
			</div>
		</div>
		<div class="row row-2">
			<div class="railing-3d columns small-12">
				<img class="block" src="../media/engineering/railing-3d.png<?php echo $ver ?>">
			</div>
		</div>
		<div class="row row-3">
			<div class="film columns small-12 medium-6 large-5 xlarge-6">
				<!-- video embed -->
				<div class="video-embed js_video_embed" data-src="lncVHzsc_QA">
					<div class="video-loading-indicator"></div>
				</div>
			</div>
			<div class="bis-logo columns small-12 medium-6 large-6 xlarge-6">
				<img src="../media/engineering/bis-logo.svg<?php echo $ver ?>">
				<div class="h6 text-neutral-2">Bureau of Indian <br>Standards</div>
			</div>
		</div>
	</div>
</section>
<!-- END: Engineering Section : Railing -->

<!-- Engineering Section : Fire -->
<section class="engineering-section fire space-50-top-bottom">
	<div class="container">
		<div class="row row-1">
			<div class="section-label columns small-12 xlarge-10 xlarge-offset-1 space-25-bottom">
				<div class="label strong text-neutral-2 text-uppercase">Engineering</div>
			</div>
			<div class="heading columns small-12 medium-6 large-5 xlarge-4 xlarge-offset-1 space-50-bottom">
				<div class="h3 strong text-lowercase">4 level redundancy fire fighting infrastructure. <span class="text-red-2">Early warning smoke detectors and triple pump fire sprinkler system.</span></div>
			</div>
			<div class="points points-1 columns small-12 medium-6 large-3 xlarge-offset-1">
				<div class="title h4 strong space-25-bottom"><span class="text-red-2">High-Rise Safety</span> <br>Engineering</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Early warning smoke detectors in your kitchen and living room. 
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Smoke detectors trigger an early warning fire alarm with an exact indication of the location of a potential fire.
				</div>
				<div class="smoke-detector text-center">
					<img class="block" src="../media/engineering/smoke-detector.png<?php echo $ver ?>">
					<div class="label strong text-neutral-2 text-uppercase space-min-top-bottom">Early Warning Smoke Detector</div>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Every floor has early warning fire measures like hand-held extinguishers and water hoses.
				</div>
			</div>
			<div class="points points-2 columns small-12 medium-6 medium-offset-6 large-3 large-offset-0">
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					In case a fire is to intense for early warning fire measures, evacuation is recommended. 
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					A pressurised network of pipes feed the fire sprinklers in every room of your house.
				</div>
				<div class="fire-sprinkler text-center">
					<img class="block" src="../media/engineering/fire-sprinkler.png<?php echo $ver ?>">
					<div class="label strong text-neutral-2 text-uppercase space-min-top-bottom">Temperature Activated Sprinkler</div>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Every fire sprinkler has a temperature activated glass bulb that melts at 68° Celsius. 
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Only the fire sprinklers in the region of the fire will activate when a fire melts the glass bulbs only. 
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Triple redundant water pumps activate when they sense a drop in water pressure. This ensures the sprinklers are fed with a constant water pressure.
				</div>
			</div>
		</div>
		<div class="row row-2">
			<div class="fire-infographic columns small-12">
				<img class="block" src="../media/engineering/engineering-fire-infographic.png<?php echo $ver ?>">
			</div>
		</div>
		<div class="row row-3">
			<div class="film inline-bottom columns small-12 medium-6 large-5 xlarge-6">
				<!-- video embed -->
				<div class="video-embed js_video_embed" data-src="lncVHzsc_QA">
					<div class="video-loading-indicator"></div>
				</div>
			</div>
			<div class="sprinkler-bulb inline-bottom columns small-12 medium-6 large-6 xlarge-6">
				<div class="h3 text-red-2 strong"><span class="h2">68°</span>celsius</div>
				<div class="h6 text-neutral-2 space-min-bottom">will melt the temperature activated glass bulb <br>and active the sprinkler.</div>
				<img src="../media/engineering/sprinkler-bulb.png<?php echo $ver ?>">
			</div>
		</div>
	</div>
</section>
<!-- END: Engineering Section : Fire -->

<?php require_once __DIR__ . '/../inc/below.php'; ?>
