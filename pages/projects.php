<?php
/*
 *
 * The is the Project template page
 *
 */
if ( empty( $urlSlug ) )
	return header( 'Location: /', true, 302 );

require_once __DIR__ . '/../inc/above.php';


$projectPhoneNumberFormatted = '+91' . getContent( '', 'phone_number' );
$projectPhoneNumberUnformatted = str_replace( [ '-', ' ' ], '', $projectPhoneNumberFormatted );
$planGroups = getContent( [ ], 'plans' );
$amenities = getContent( [ ], 'amenity' );
	$amenityImages = getContent( [ ], 'amenities_images' );
$constructionUpdateGroups = getContent( [ ], 'updates' );
$engineeringPartners = getContent( [ ], 'engineering_partners' );
$spotlights = getContent( [ ], 'spotlight_list' );
	$numberOfSpotlight = str_pad( count( $spotlights ), 2, '0', STR_PAD_LEFT );
$events = getContent( [ ], 'events_list' );
	$numberOfEvents = str_pad( count( $events ), 2, '0', STR_PAD_LEFT );
$officeAddresses = getContent( [ ], 'office_addresses' );

?>





<!-- Gallery data -->
<script type="text/javascript">

	// Cover images
	var __DATA = window.__DATA = window.__DATA || { };
	__DATA.galleries = __DATA.galleries || { };
	__DATA.galleries.cover = <?php echo json_encode( getContent( [ ], 'cover_images' ) ) ?>;

</script>
<!-- END: Gallery data -->

<!-- Cover Section -->
<section data-section="Cover" class="cover-section space-25-top space-50-bottom js_gallery_region" data-set="cover">
	<?php $coverImages = getContent( [ ], 'cover_images' ); ?>
	<div class="container">
		<div class="row">
			<div class="cover-image-container image-1 columns small-12 large-12">
				<div class="cover-image fill-neutral-2 js_gallery_item">
					<img src="<?= $coverImages[ 0 ][ 'sizes' ][ 'large' ] ?>">
				</div>
			</div>
			<div class="project-card columns small-8 medium-4 fill-dark space-25">
				<div class="logo space-min-bottom"><a href="<?php echo $baseURL ?>" class="inline"><img class="block" src="../media/indis-logo-light.svg<?php echo $ver ?>"></a></div>
				<div class="title h4 strong"><?= $thePost->post_title ?></div>
				<div class="location label strong text-uppercase text-neutral-4"><?= getContent( '', 'location' ) ?></div>
				<hr class="dash">
				<div class="type h6 strong space-min-top"><?= getContent( '', 'type' ) ?></div>
				<div class="price h5 condensed"><?= getContent( '', 'price' ) ?></div>
			</div>
			<div class="cover-image-strip columns small-4 medium-2 large-6">
				<div class="row">
					<div class="cover-image-container image-2 columns small-12 large-4">
						<div class="cover-image fill-neutral-2 js_modal_trigger js_gallery_item cursor-pointer" tabindex="-1" data-mod-id="image-gallery">
							<img src="<?= $coverImages[ 1 ][ 'sizes' ][ 'small' ] ?>">
						</div>
					</div>
					<div class="cover-image-container image-3 columns small-12 large-4">
						<div class="cover-image fill-neutral-2 js_modal_trigger js_gallery_item cursor-pointer" tabindex="-1" data-mod-id="image-gallery">
							<img src="<?= $coverImages[ 2 ][ 'sizes' ][ 'small' ] ?>">
						</div>
					</div>
					<div class="cover-image-container image-4 columns small-12 large-4">
						<div class="cover-image fill-neutral-2 js_modal_trigger js_gallery_item cursor-pointer" tabindex="-1" data-mod-id="image-gallery">
							<img src="<?= $coverImages[ 3 ][ 'sizes' ][ 'small' ] ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="cover-image-container image-5 columns small-12 medium-6 large-4">
				<div class="cover-image portrait fill-neutral-2 js_modal_trigger js_gallery_item cursor-pointer" tabindex="-1" data-mod-id="image-gallery">
					<img src="<?= $coverImages[ 4 ][ 'sizes' ][ 'medium' ] ?>">
					<div class="icon-button zoom" style="background-image: url('../media/icon/icon-zoom.svg<?php echo $ver ?>');"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- END: Cover Section -->


<!-- Intro Section -->
<section data-section="Intro" class="intro-section">
	<div class="container">
		<div class="row">
			<div class="columns small-12 medium-10 large-6 large-offset-1">
				<div class="project-logo space-25-bottom"><img class="block" src="<?= getContent( '', 'project_logo -> sizes -> thumbnail' ) ?>"></div>
				<div class="title h2 strong text-lowercase space-25-bottom"><?= getContent( '', 'intro_title' ) ?></div>
				<div class="description text-neutral-2 space-25-bottom"><?= getContent( '', 'intro_description' ) ?></div>
				<div class="points row space-50-bottom">
					<?php foreach ( getContent( [ ], 'intro_points' ) as $point ) : ?>
						<div class="point h5 condensed columns small-12 medium-6 space-min-bottom"><span class="inline-middle space-min-right"><img src="<?= '/media/dot-icons/' . $point[ 'intro_point_icon' ] . '.svg' ?>"></span><?= $point[ 'intro_point_text' ] ?></div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- END: Intro Section -->


<!-- Action: Callback : Form -->
<section class="action-callback space-100-bottom qpid_login_site js_get_in_touch_section">
	<div class="container">
		<div class="row">
			<div class="intro columns small-10 large-11 large-offset-1">
				<div class="heading h3 condensed space-min-bottom">
					Get In Touch
				</div>
			</div>
			<div class="action-form columns small-10 large-11 large-offset-1">
				<form class="js_get_in_touch_form" data-c="get-in-touch/<?= $urlSlug ?>">
					<div class="row">
						<div class="form-row columns small-12 medium-6 large-3">
							<label>
								<span class="label strong text-uppercase text-neutral-4 cursor-pointer">
									Name
								</span>
								<input class="block" type="text" name="name" required>
							</label>
						</div>
						<!-- Phone Trap -->
						<div class="phone-trap phone-number form-row columns small-12 medium-6 large-3">
							<label for="pt01">
								<span class="label strong text-uppercase text-neutral-4 cursor-pointer">
									Phone
								</span>
							</label>
							<div class="row">
								<div class="columns small-3 prefix-group" style="position: relative; padding-right: 5px; ">
									<select class="form-field block js_phone_country_code" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0">
										<?php include __DIR__ . '/../inc/phone-country-codes.php' ?>
									</select>
									<input class="prefix js_phone_country_code_label strong input-field text-red-2 text-right" value="+91" style="pointer-events: none; width: 100%; padding: 0; padding-right: 3px; border-color: var(--red-2);">
								</div>
								<div class="columns small-9">
									<input id="pt01" class="block" type="text" name="phone-number" required>
								</div>
							</div>
						</div>
						<!-- END: Phone Trap -->
						<div class="form-row columns small-12 medium-6 large-3">
							<label>
								<span class="invisible label strong text-uppercase text-neutral-4 cursor-pointer">
									Submit
								</span>
								<button class="button block fill-red-2 button-icon" type="submit" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--red-1);">Submit</button>
							</label>
						</div>
						<div class="form-row or-call columns small-12 medium-6 large-3">
							<div class="h5 text-lowecase">or call <a href="tel:<?= $projectPhoneNumberUnformatted ?>" class="text-red-2"><?= $projectPhoneNumberFormatted ?></a></div>
						</div>
					</div>
				</form>
				<!-- OTP form -->
				<form class="js_otp_form" style="display: none;">
					<div class="otp-trap row">
						<div class="form-row columns small-12 medium-6 large-3">
							<label class="block text-left">
								<span class="label strong inline text-neutral-4 text-uppercase">Enter the OTP</span>
								<input class="otp block" type="text" name="otp">
							</label>
						</div>
						<div class="form-row columns small-12 medium-6 large-3">
							<label class="submit block">
								<span class="invisible label strong inline text-neutral-4 text-uppercase">Submit</span>
								<button class="button block fill-red-2 button-icon" type="submit" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--red-1);">Contact</button>
							</label>
						</div>
					</div>
					<div class="form-row columns small-12 large-6 clearfix hidden">
						<div class="label strong text-red-2 text-uppercase inline-middle cursor-pointer float-left" tabindex="-1">Re-send OTP</div>
						<div class="label strong text-red-2 text-uppercase inline-middle cursor-pointer float-right" tabindex="-1">Enter different number</div>
					</div>
				</form>
				<!-- END: OTP form -->
			</div>
		</div>
	</div>
</section>
<!-- END: Action: Callback : Form -->


<!-- Carousel: Spotlight -->
<?php if ( ! empty( $spotlights ) ) : ?>
<div data-section="Spotlight" id="spotlight" class="carousel spotlight indis-carousel js_carousel_container">
	<div class="carousel-list js_carousel_content">
		<div class="carousel-list-item js_carousel_item">
			<div class="carousel-title h2 strong">
				<!-- offers <br>and <span class="text-red-2">best <br>sellers</span> -->
				<span class="text-red-2">spotlight</span> <br>apartment <br>units
			</div>
		</div>
		<?php foreach ( $spotlights as $index => $spotlight ) : ?>
			<div class="carousel-list-item js_carousel_item qpid_login_site js_spotlight <?php if ( $index >= 4 ) echo 'hidden' ?>">
				<div class="card-index text-neutral-2">
					<div class="count h3 inline-bottom"><?= str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ?></div>
					<div class="total label strong text-uppercase inline-bottom"><?= $numberOfSpotlight ?></div>
				</div>
				<div class="carousel-card fill-dark" style="background-image: url( '<?= $spotlight[ 'spotlight_thumbnail' ][ 'sizes' ][ 'small' ] ?>' );">
					<div class="info space-25">
						<div class="info-box">
							<span class="title h5 strong"><?= $spotlight[ 'spotlight_title' ] ?></span>
							<span class="description p text-neutral-2"><?= $spotlight[ 'spotlight_description' ] ?></span>
						</div>
						<div class="price h5 condensed <?= $hide ?>"><?= $spotlight[ 'spotlight_price' ] ?></div>
						<div class="tag">
							<span class="project h6 strong fill-light"><?= $thePost->post_title ?></span>
							<?php if( ! empty( $spotlight[ 'spotlight_series_id' ] ) ) : ?>
							<span class="series-id h6 strong fill-red-2"><?= $spotlight[ 'spotlight_series_id' ] ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<button id="spotlight-<?= $index + 1 ?>-enquire" class="button fill-neutral-4 text-light button-icon js_spotlight_enquire" data-c="/spotlight/<?= $urlSlug ?>" data-spotlight="Spotlight: <?= $thePost->post_title . ': ' . $spotlight[ 'spotlight_series_id' ] ?>" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--neutral-2);">Enquire Now</button>
				<!-- Phone Trap -->
				<div class="phone-trap phone-number columns small-12 large-9 xlarge-10">
					<form class="js_phone_form" style="display: none">
						<div class="form-row">
							<label for="">
								<span class="label strong text-uppercase text-neutral-4 cursor-pointer">
									Enter Your Phone Number
								</span>
							</label>
							<div class="row">
								<div class="columns small-3 prefix-group" style="position: relative; padding-right: 5px; ">
									<select class="form-field block js_phone_country_code" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0">
										<?php include __DIR__ . '/../inc/phone-country-codes.php' ?>
									</select>
									<input class="prefix js_phone_country_code_label strong input-field text-dark text-right" value="+91" style="pointer-events: none; width: 100%; padding: 0; padding-right: 3px; border-color: var(--dark); color: var(--dark) !important;">
								</div>
								<div class="columns small-6">
									<input class="block" type="text" name="phone-number">
								</div>
								<div class="columns small-3 text-right">
									<span class="hidden label strong inline text-neutral-4 text-uppercase">Submit</span><!-- Hidden Because the Fields and button were not Visually Aligning -->
									<button class="icon-button submit" type="submit" style="background-color: var(--dark); background-size: auto; background-image: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>');"></button>
								</div>
							</div>
						</div>
					</form>
					<!-- OTP Form -->
					<form class="js_otp_form" style="display: none;">
						<div class="otp-trap row">
							<label class="form-row columns small-9 text-left">
								<span class="label strong inline text-neutral-4 text-uppercase">Enter the OTP</span>
								<input class="otp block" type="text" name="otp">
							</label>
							<div class="form-row columns small-3 text-right">
								<label>
									<span class="invisible label strong inline text-neutral-4 text-uppercase">Submit</span>
									<button class="icon-button submit" type="submit" style="background-color: var(--dark); background-size: auto; background-image: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>');"></button>
								</label>
							</div>
						</div>
						<div class="form-row columns small-12 clearfix space-min-top hidden">
							<div class="label strong text-red-2 text-uppercase inline-middle cursor-pointer float-left" tabindex="-1">Re-send OTP</div>
							<div class="label strong text-dark text-uppercase inline-middle cursor-pointer float-right" tabindex="-1">Enter different number</div>
						</div>
					</form>
				</div>
				<!-- END: Phone Trap -->
			</div>
		<?php endforeach; ?>
		<div class="carousel-list-item js_carousel_item unlock qpid_login_site js_spotlight_unlock_form_section">
			<div class="carousel-card fill-red-2">
				<div class="info space-25">
					<div class="unlock-icon"><img class="block" src="../media/icon/icon-lock-light.svg<?php echo $ver ?>"></div>
					<div class="unlock-title h3 strong text-lowercase space-min-bottom">Unlock all <br><span class="text-dark"><?= (int) $numberOfSpotlight ?> Spotlight</span> <br>floorplans</div>
					<div class="unlock-form columns small-12">
						<form class="js_spotlights_unlock_form" data-c="/spotlight/<?= $urlSlug ?>">
							<div class="row">
								<div class="form-row columns small-12">
									<label>
										<span class="label strong text-uppercase text-red-1 cursor-pointer">
											Name
										</span>
										<input class="block" type="text" name="name" required>
									</label>
								</div>
								<div class="form-row columns small-12">
									<label>
										<span class="label strong text-uppercase text-red-1 cursor-pointer">
											Email
										</span>
										<input class="block" type="text" name="email-address" required>
									</label>
								</div>
								<!-- Phone Trap -->
								<div class="phone-trap phone-number form-row columns small-12">
									<label for="pt02">
										<span class="label strong text-uppercase text-red-1 cursor-pointer">
											Phone
										</span>
									</label>
									<div class="row">
										<div class="columns small-3 prefix-group" style="position: relative; padding-right: 5px; ">
											<select class="form-field block js_phone_country_code" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0">
												<?php include __DIR__ . '/../inc/phone-country-codes.php' ?>
											</select>
											<input class="prefix js_phone_country_code_label strong input-field text-dark text-right" value="+91" style="pointer-events: none; width: 100%; padding: 0; padding-right: 3px; border-color: var(--dark); color: var(--dark) !important;">
										</div>
										<div class="columns small-9">
											<input id="pt02" class="block" type="text" name="phone-number" required>
										</div>
									</div>
								</div>
								<!-- END: Phone Trap -->
								<button type="submit" class="hidden">Submit</button>
							</div>
						</form>
						<!-- OTP form -->
						<form class="js_otp_form" style="display: none;">
							<div class="otp-trap row">
								<div class="form-row columns small-12">
									<label class="block text-left">
										<span class="label strong inline text-red-1 text-uppercase">Enter the OTP</span>
										<input class="otp block" type="text" name="otp">
									</label>
								</div>
							</div>
							<div class="form-row columns small-12 clearfix hidden">
								<div class="label strong text-dark text-uppercase inline-middle cursor-pointer float-left" tabindex="-1">Re-send OTP</div>
								<div class="label strong text-dark text-uppercase inline-middle cursor-pointer float-right" tabindex="-1">Enter different number</div>
							</div>
						</form>
						<!-- END: OTP form -->
					</div>
				</div>
			</div>
			<button class="button fill-red-2 text-light button-icon js_spotlight_unlock_all" type="submit" style="--bg-i: url('../media/icon/icon-lock-light.svg<?php echo $ver ?>'); --bg-c: var(--red-1);">Unlock Now</button>
		</div>
	</div>
	<div class="carousel-controls clearfix">
		<div class="container">
			<div class="prev float-left"><button class="button js_pager" data-dir="left"><img class="block" src="../media/icon/icon-left-triangle-dark.svg<?php echo $ver ?>"></button></div>
			<div class="next float-right"><button class="button js_pager" data-dir="right"><img class="block" src="../media/icon/icon-right-triangle-dark.svg<?php echo $ver ?>"></button></div>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- END: Carousel: Spotlight -->


<!-- Location Section -->
<section data-section="Location" id="location" class="location-section space-50-top-bottom">
	<div class="container">
		<div class="row">
			<div class="location-image-container columns small-12 large-12">
				<div class="location-image fill-neutral-2" style="background-image: url( '<?= getContent( '', 'location_panorama_static_image -> sizes -> large' ) ?>' );"></div>
				<div class="panorama-viewer">
					<iframe class="panorama-embed" src="<?= getContent( '', 'location_panorama' ) ?>" frameborder="0"></iframe>
				</div>
			</div>
			<div class="location-card columns small-8 medium-4 fill-light space-25">
				<div class="title h3 strong text-lowercase">Location</div>
				<div class="location label strong text-uppercase text-neutral-2"><?= getContent( '', 'location' ) ?></div>
				<hr class="dash">
				<div class="address h6 text-neutral-2 space-min-top hide-for-small"><?= getContent( '', 'location_address' ) ?></div>
				<a href="<?= getContent( '', 'location_google_maps_url' ) ?>" target="_blank" class="label strong text-red-2 text-uppercase space-min-top-bottom inline-middle">Open in Google Maps <img class="link-icon inline-middle" src="../media/icon/icon-location-color.svg<?php echo $ver ?>"></a>
			</div>
			<div class="location-title h2 strong text-light text-lowercase columns small-9 medium-5 xlarge-4"><?= getContent( '', 'location_title' ) ?></div>
		</div>
	</div>
</section>
<!-- END: Location Section -->


<!-- Download Brochure -->
<section class="download-brochure <?= $hide ?>">
	<div class="container">
		<div class="row">
			<div class="brochure-mockup columns small-12 medium-5 large-6 inline-middle">
				<img class="block" src="<?= getContent( '', 'brochure_thumbnail -> sizes -> medium' ) ?>">
			</div>
			<div class="brochure-action fill-light columns small-10 small-offset-1 medium-7 medium-offset-0 large-6 inline-middle">
				<div class="download-title h3 text-lowercase strong space-25-bottom">If you're in a hurry, <br>just <span class="text-red-2">download the <span class="text-uppercase">PDF</span> brochure</span></div>
				<a href="" target="_blank" class="button fill-dark text-light button-icon" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--neutral-4);">Download Now</a>
				<div class="courier-description p text-neutral-2 space-min-top">Or, if you'd like a copy of the physical brochure couriered to your location. <br><a href="" target="_blank" class="text-red-2">Click Here</a></div>
			</div>
		</div>
	</div>
</section>
<!-- END: Download Brochure -->


<!-- Engineering Section : Concrete -->
<section data-section="Engineering — High-rise" class="engineering-section concrete space-50-top-bottom">
	<div class="container">
		<div class="row row-1">
			<div class="section-label columns small-12 xlarge-10 xlarge-offset-1 space-25-bottom">
				<div class="label strong text-neutral-2 text-uppercase">Engineering</div>
			</div>
			<div class="heading columns small-12 medium-6 large-5 xlarge-4 xlarge-offset-1 space-50-bottom">
				<div class="h3 strong text-lowercase">Built with precision moulded concrete structures to ensure <span class="text-red-2">factory-like repeatable quality</span> in each home.</div>
			</div>
			<div class="points columns small-12 medium-5 large-3 large-offset-1">
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
			<div class="building-3d-1 hide-for-medium columns small-12 medium-6 medium-offset-1 large-3 large-offset-0">
				<img class="block" src="../media/engineering/building-3d-1.png<?php echo $ver ?>">
			</div>
		</div>
		<div class="row row-2">
			<div class="film columns small-12 medium-6">
				<div class="building-3d-2 space-50-left-right">
					<img class="block" src="../media/engineering/building-3d-2.png<?php echo $ver ?>">
				</div>
				<!-- video embed -->
				<div class="video-embed js_video_embed <?= $hide ?>" data-src="lncVHzsc_QA">
					<div class="video-loading-indicator"></div>
				</div>
			</div>
			<div class="infographic columns small-12 medium-6 <?= $hide ?>">
				<img class="block" src="../media/engineering/engineering-concrete-infographic.svg<?php echo $ver ?>">
			</div>
		</div>
	</div>
</section>
<!-- END: Engineering Section : Concrete -->


<!-- Carousel Mini: Affiliates Section -->
<?php if ( ! empty( $engineeringPartners ) ) : ?>
<section data-section="Affiliates" class="affiliates-section space-50-bottom js_tab_container">
	<div class="affiliates-carousel-menu text-center">
		<div class="container">
			<div class="tab-menu hide-for-medium js_tab_headings">
				<?php foreach ( $engineeringPartners as $partner ) : ?>
					<div tabindex="-1" class="h6 tab-button js_tab_heading"><?= $partner[ 'partner_title' ] ?></div>
				<?php endforeach; ?>
			</div>
			<select class="select-menu button strong fill-neutral-2 show-for-medium js_tab_headings" style="margin-left: auto; margin-right: auto;">
				<?php foreach ( $engineeringPartners as $partner ) : ?>
					<option><?= $partner[ 'partner_title' ] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php foreach ( $engineeringPartners as $index => $partner ) : ?>
		<div class="carousel carousel-mini affiliates-carousel js_carousel_container js_tab <?php if ( $index ) echo 'hidden' ?>" data-tab="<?= $partner[ 'partner_title' ] ?>">
			<div class="carousel-list js_carousel_content">
				<?php foreach ( $partner[ 'partner_logos' ] as $image ) : ?>
					<div class="carousel-list-item js_carousel_item">
						<div class="carousel-mini-image" style="background-image: url( '<?= $image[ 'sizes' ][ 'medium' ] ?>' );"></div>
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
	<?php endforeach; ?>
</section>
<?php endif; ?>
<!-- END: Carousel Mini: Affiliates Section -->


<!-- Plans Section -->
<?php if ( ! empty( $planGroups ) ) : ?>
<section data-section="Masterplans" id="plans" class="plans-section space-100-top space-75-bottom fill-dark js_tab_container">
	<div class="container">
		<div class="plans-intro row space-25-bottom">
			<div class="heading h2 strong text-lowercase columns small-12">
				Masterplan and <br>
				<span class="text-red-2">Floorplans</span>
			</div>
		</div>
		<div class="plans row">
			<div class="plans-menu-1 columns small-12 large-2">
				<div class="tab-menu hide-for-medium text-right js_tab_headings">
					<?php foreach ( $planGroups as $group ) : ?>
						<div tabindex="-1" class="h5 tab-button tab-button-large js_tab_heading"><?= $group[ 'plan_group_title' ] ?></div>
					<?php endforeach; ?>
				</div>

				<select class="select-menu button strong fill-red-2 show-for-medium js_tab_headings">
					<?php foreach ( $planGroups as $group ) : ?>
						<option><?= $group[ 'plan_group_title' ] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php foreach ( $planGroups as $index => $group ) : ?>
				<div class="plan columns small-12 large-10 js_tab js_tab_container <?php if ( $index ) echo 'hidden' ?>" data-tab="<?= $group[ 'plan_group_title' ] ?>">
					<div class="plans-menu-2 <?php if ( count( $group[ 'plan_group' ] ) === 1 and empty( trim( $group[ 'plan_group' ][ 0 ][ 'plan_name' ] ) ) ) echo 'hidden' ?>">
						<div class="tab-menu hide-for-medium js_tab_headings">
							<?php foreach ( $group[ 'plan_group' ] as $plan ) : ?>
								<div tabindex="-1" class="h6 tab-button js_tab_heading"><?= $plan[ 'plan_name' ] ?></div>
							<?php endforeach; ?>
						</div>

						<select class="select-menu button strong fill-neutral-2 show-for-medium js_tab_headings">
							<?php foreach ( $group[ 'plan_group' ] as $plan ) : ?>
								<option><?= $plan[ 'plan_name' ] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<?php foreach ( $group[ 'plan_group' ] as $index => $plan ) : ?>
						<div class="plan-viewer js_tab <?php if ( $index ) echo 'hidden' ?>" data-tab="<?= $plan[ 'plan_name' ] ?>">
							<iframe class="plan-embed js_plan_embed" src="<?= $plan[ 'plan_image' ] ?>" frameborder="0"></iframe>
						</div>
						<div class="help-message p strong text-red-2 space-min-top"><img class="inline-middle" width="20px" src="../media/icon/icon-orientation.svg<?php echo $ver ?>"> Rotate device for best experience!</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
<!-- END: Plans Section -->


<!-- Carousel Mini: Amenities -->
<?php if ( ! empty( $amenityImages ) ) : ?>
<script type="text/javascript">
	// Amenity images
	var __DATA = window.__DATA = window.__DATA || { };
	__DATA.galleries = __DATA.galleries || { };
	__DATA.galleries.amenities = <?php echo json_encode( $amenityImages ) ?>;
</script>
<div class="carousel carousel-mini amenities-carousel fill-dark js_carousel_container js_gallery_region" data-set="amenities">
	<div class="carousel-list js_carousel_content">
		<?php foreach ( $amenityImages as $image ) : ?>
			<div class="carousel-list-item js_carousel_item">
				<div class="carousel-mini-image cursor-pointer js_modal_trigger js_gallery_item" data-mod-id="image-gallery" style="background-image: url( '<?= $image[ 'sizes' ][ 'small' ] ?>' );"></div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="carousel-controls clearfix">
		<div class="container">
			<div class="prev float-left"><button class="button js_pager" data-dir="left"><img class="block" src="../media/icon/icon-left-triangle-light.svg<?php echo $ver ?>"></button></div>
			<div class="next float-right"><button class="button js_pager" data-dir="right"><img class="block" src="../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>"></button></div>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- END: Carousel Mini: Amenities -->


<!-- Amenities Section -->
<?php if ( ! empty( $amenities ) ) : ?>
<section data-section="Amenities" id="amenities" class="amenities-section space-75-top space-100-bottom fill-dark js_tab_container">
	<div class="container">
		<div class="amenities-intro row space-25-bottom">
			<div class="heading h2 strong text-lowercase columns small-12">
				Amenities
			</div>
		</div>
		<div class="amenities row">
			<div class="amenities-menu-1 columns small-12 large-2">
				<div class="tab-menu hide-for-medium text-right js_tab_headings">
					<?php foreach ( $amenities as $amenity ) : ?>
						<div tabindex="-1" class="h5 tab-button tab-button-large js_tab_heading"><?= $amenity[ 'amenity_group_title' ] ?></div>
					<?php endforeach; ?>
				</div>

				<select class="select-menu button strong fill-red-2 show-for-medium js_tab_headings">
					<?php foreach ( $amenities as $amenity ) : ?>
						<option><?= $amenity[ 'amenity_group_title' ] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php foreach ( $amenities as $index => $amenity ) : ?>
				<div class="amenitie columns small-12 large-10 js_tab js_tab_container <?php if ( $index ) echo 'hidden' ?>" data-tab="<?= $amenity[ 'amenity_group_title' ] ?>">
					<div class="amenities-menu-2 <?php if ( count( $amenity[ 'amenity_group' ] ) === 1 and empty( trim( $amenity[ 'amenity_group' ][ 0 ][ 'amenity_name' ] ) ) ) echo 'hidden' ?>">
						<div class="tab-menu hide-for-medium js_tab_headings">
							<?php foreach ( $amenity[ 'amenity_group' ] as $amenityGroup ) : ?>
								<div tabindex="-1" class="h6 tab-button js_tab_heading"><?= $amenityGroup[ 'amenity_name' ] ?></div>
							<?php endforeach; ?>
						</div>
						<select class="select-menu button strong fill-neutral-2 show-for-medium js_tab_headings">
							<?php foreach ( $amenity[ 'amenity_group' ] as $amenityGroup ) : ?>
								<option><?= $amenityGroup[ 'amenity_name' ] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<?php foreach ( $amenity[ 'amenity_group' ] as $index => $amenityGroup ) : ?>
						<div class="row js_tab <?php if ( $index ) echo 'hidden' ?>" data-tab="<?= $amenityGroup[ 'amenity_name' ] ?>">
							<div class="amenitie-viewer columns small-12 large-5 <?php if ( empty( $amenityGroup[ 'amenity_image' ] ) ) echo 'hidden' ?>">
								<img class="block" src="<?= $amenityGroup[ 'amenity_image' ][ 'sizes' ][ 'medium' ] ?>" srcset="<?= $amenityGroup[ 'amenity_image' ][ 'sizes' ][ 'small' ] . ' ' . $amenityGroup[ 'amenity_image' ][ 'sizes' ][ 'small-width' ] . 'w, ' . $amenityGroup[ 'amenity_image' ][ 'sizes' ][ 'medium' ] . ' ' . $amenityGroup[ 'amenity_image' ][ 'sizes' ][ 'medium-width' ] . 'w, ' . $amenityGroup[ 'amenity_image' ][ 'sizes' ][ 'large' ] . ' ' . $amenityGroup[ 'amenity_image' ][ 'sizes' ][ 'large-width' ] . 'w' ?>">
							</div>
							<div class="points columns small-12 large-7">
								<?php foreach ( $amenityGroup[ 'amenity_points' ] as $amenityPoint ) : ?>
									<div class="point h5 condensed space-min-bottom"><span class="inline-middle space-min-right"><img src="<?= '/media/dot-icons/' . $amenityPoint[ 'amenity_point_icon' ] . '.svg' ?>"></span><?= $amenityPoint[ 'amenity_point_text' ] ?></div>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
<!-- END: Amenities Section -->


<!-- Engineering Section : Railing -->
<section data-section="Engineering — Railing" class="engineering-section railing space-50-top-bottom">
	<div class="container">
		<div class="row row-1">
			<div class="section-label columns small-12 xlarge-11 xlarge-offset-1 space-25-bottom">
				<div class="label strong text-neutral-2 text-uppercase">Engineering</div>
			</div>
			<div class="heading columns small-12 medium-6 large-5 large-offset-1 space-50-bottom">
				<div class="h3 strong text-lowercase">Every balcony railing has vertical divisions. This ensures that <span class="text-red-2">children cannot climb them.</span></div>
			</div>
			<div class="points columns small-12 medium-6 large-5 xlarge-4 xlarge-offset-1">
				<div class="title h4 strong space-25-bottom"><span class="text-red-2">High-Rise Safety</span> <br>Engineering</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					1.2m high balcony railings ensures safety on any floor.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Vertical divisions on the railing ensure children cannot climb the railing.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Compliant with the <span style="color: #2E73D8;">Bureau of Indian Standards</span> National Building Code.
				</div>
			</div>
		</div>
		<div class="row row-2">
			<div class="railing-3d columns small-12">
				<img class="block" src="../media/engineering/railing-3d.png<?php echo $ver ?>">
			</div>
		</div>
		<div class="row row-3">
			<div class="film columns small-12 medium-6 <?= $hide ?>">
				<!-- video embed -->
				<div class="video-embed js_video_embed" data-src="lncVHzsc_QA">
					<div class="video-loading-indicator"></div>
				</div>
			</div>
			<div class="bis-logo columns small-12 medium-6 large-6">
				<img src="../media/engineering/bis-logo.svg<?php echo $ver ?>">
				<div class="h6 text-neutral-2">Bureau of Indian <br>Standards</div>
			</div>
		</div>
	</div>
</section>
<!-- END: Engineering Section : Railing -->


<!-- Engineering Section : Fire -->
<section data-section="Engineering — Fire" class="engineering-section fire space-50-top-bottom">
	<div class="container">
		<div class="row row-1">
			<div class="section-label columns small-12 xlarge-10 xlarge-offset-1 space-25-bottom">
				<div class="label strong text-neutral-2 text-uppercase">Engineering</div>
			</div>
			<div class="heading columns small-12 medium-6 large-5 xlarge-4 xlarge-offset-1 space-50-bottom">
				<div class="h3 strong text-lowercase">4 level redundancy fire fighting infrastructure. <span class="text-red-2">Early warning smoke detectors and triple pump fire sprinkler system.</span></div>
			</div>
			<div class="points points-1 columns small-12 medium-6 large-3 large-offset-1">
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
					A pressurized network of pipes feed the fire sprinklers in every room of your house.
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
			<div class="film inline-bottom columns small-12 medium-6 large-6 <?= $hide ?>">
				<!-- video embed -->
				<div class="video-embed js_video_embed" data-src="lncVHzsc_QA">
					<div class="video-loading-indicator"></div>
				</div>
			</div>
			<div class="sprinkler-bulb inline-bottom columns small-12 medium-6 large-6">
				<div class="h3 text-red-2 strong"><span class="h2">68°</span>celsius</div>
				<div class="h6 text-neutral-2 space-min-bottom">will melt the temperature activated glass bulb <br>and active the sprinkler.</div>
				<img src="../media/engineering/sprinkler-bulb.png<?php echo $ver ?>">
			</div>
		</div>
	</div>
</section>
<!-- END: Engineering Section : Fire -->


<!-- Updates Section -->
<?php if ( ! empty( $constructionUpdateGroups ) ) : ?>
<section data-section="Construction Updates" id="updates" class="updates-section space-75-top space-100-bottom fill-dark js_tab_container">
	<div class="container">
		<div class="updates-intro row space-25-bottom">
			<div class="heading h2 strong text-lowercase columns small-12">
				<span class="text-red-2">Construction</span> <br>
				Updates
			</div>
		</div>
		<div class="updates row">
			<div class="updates-menu-1 columns small-12 large-2">
				<div class="tab-menu hide-for-medium text-right js_tab_headings">
					<?php foreach ( $constructionUpdateGroups as $group ) : ?>
						<div tabindex="-1" class="h5 tab-button tab-button-large js_tab_heading"><?= $group[ 'update_group_title' ] ?></div>
					<?php endforeach; ?>
				</div>

				<select class="select-menu button strong fill-red-2 show-for-medium js_tab_headings">
					<?php foreach ( $constructionUpdateGroups as $group ) : ?>
						<option><?= $group[ 'update_group_title' ] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php foreach ( $constructionUpdateGroups as $groupIndex => $group ) : ?>
				<div class="update columns small-12 large-10 js_tab js_tab_container <?php if ( $groupIndex ) echo 'hidden' ?>" data-tab="<?= $group[ 'update_group_title' ] ?>">
					<div class="updates-menu-2 <?php if ( count( $group[ 'update_group' ] ) === 1 and empty( trim( $group[ 'update_group' ][ 0 ][ 'update_name' ] ) ) ) echo 'hidden' ?>">
						<div class="tab-menu hide-for-medium js_tab_headings">
							<?php foreach ( $group[ 'update_group' ] as $update ) : ?>
								<div tabindex="-1" class="h6 tab-button js_tab_heading"><?= $update[ 'update_name' ] ?></div>
							<?php endforeach; ?>
						</div>

						<select class="select-menu button strong fill-neutral-2 show-for-medium js_tab_headings">
							<?php foreach ( $group[ 'update_group' ] as $update ) : ?>
								<option><?= $update[ 'update_name' ] ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<?php foreach ( $group[ 'update_group' ] as $updateIndex => $update ) : ?>
						<script type="text/javascript">
							var __DATA = window.__DATA = window.__DATA || { };
							__DATA.galleries = __DATA.galleries || { };
							__DATA.galleries.constructionUpdate_<?= $groupIndex . '_' . $updateIndex ?> = <?php echo json_encode( $update[ 'update_images' ] ) ?>;
						</script>
						<div class="row js_tab <?php if ( $updateIndex ) echo 'hidden' ?> js_gallery_region" data-set="constructionUpdate_<?= $groupIndex . '_' . $updateIndex ?>" data-tab="<?= $update[ 'update_name' ] ?>">
							<div class="update-featured columns small-12 large-5">
								<div class="image cursor-pointer js_modal_trigger js_gallery_item <?php if ( $update[ 'update_images' ][ 0 ][ 'width' ] / $update[ 'update_images' ][ 0 ][ 'height' ] < 1.25 ) echo 'fit-image' ?>" data-mod-id="image-gallery" style="background-image: url( '<?= $update[ 'update_images' ][ 0 ][ 'sizes' ][ 'medium' ] ?>' );"></div>
								<div class="icon-button zoom " style="background-image: url('../media/icon/icon-zoom-white.svg<?php echo $ver ?>');"></div>
							</div>
							<div class="update-gallery columns small-12 large-7">
								<div class="block row position-relative">
									<?php foreach ( array_slice( $update[ 'update_images' ], 1, 9 ) as $image ) : ?>
										<div class="image-container columns small-6 medium-4"><div class="image cursor-pointer js_modal_trigger js_gallery_item <?php if ( $image[ 'width' ] / $image[ 'height' ] < 1.25 ) echo 'fit-image' ?>" data-mod-id="image-gallery" style="background-image: url( '<?= $image[ 'sizes' ][ 'small' ] ?>' );"></div></div>
									<?php endforeach; ?>
								</div>
							</div>
							<?php if ( ! empty( $update[ 'rera_number' ] ) ) : ?>
							<div class="update-rera columns small-12">
								<div class="h5 condensed text-red-2">TS RERA Number: <?= $update[ 'rera_number' ] ?></div>
								<img class="icon-ts-rera" src="../media/construction/icon-ts-rera.png<?php echo $ver ?>">
							</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
<!-- END: Updates Section -->


<section class="events-section space-100-top-bottom">
	<div class="container">
		<div class="row">
			<div class="graphic columns small-6 medium-4 xlarge-3"><img class="block" src="../media/events/events-graphic.svg<?php echo $ver ?>"></div>
			<div class="info columns small-12 medium-8 large-7 xlarge-6">
				<div class="title h3 strong text-lowercase space-min-bottom">At indis, we don’t just build landmarks, <span class="text-red-2">we build Lifemarks.</span></div>
				<div class="description p text-neutral-2 space-25-bottom">Built on the ethos of community living, you will always find more people sharing your interests and making life more meaningful. Sport plays an important role in character building. Kids need to explore and spread their wings to become well-rounded individuals, and adults need to stretch a little to uncover a healthier version of themselves.</div>
				<a href="" target="blank" class="button fill-red-2 text-light button-icon" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--red-1);">Discover How</a>
			</div>
		</div>
	</div>
</section>


<!-- Carousel: Events -->
<?php if ( ! empty( $events ) ) : ?>
<div data-section="Events" class="carousel events indis-carousel js_carousel_container space-75-bottom">
	<div class="carousel-list js_carousel_content">
		<div class="carousel-list-item js_carousel_item">
			<div class="carousel-title h2 strong text-lowercase">
				Can an <br>Apartment <br><span class="text-red-2">change <br>your life?</span>
			</div>
		</div>
		<?php foreach ( $events as $index => $event ) : ?>
			<?php $hasYoutubeURL = ! empty( $event[ 'youtube_embed' ] ); ?>
			<div <?php if ( $hasYoutubeURL ) echo 'id="event-' . $index . '"' ?> class="carousel-list-item js_carousel_item <?php if ( $hasYoutubeURL ) echo 'youtube js_modal_trigger' ?>" <?php if ( $hasYoutubeURL ) echo 'data-mod-id="youtube-video"' ?> <?php if ( $hasYoutubeURL ) echo 'data-src="' . $event[ 'youtube_embed' ] . '"' ?>>
				<div class="card-index text-neutral-2">
					<div class="count h3 inline-bottom"><?= str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ?></div>
					<div class="total label strong text-uppercase inline-bottom"><?= $numberOfEvents ?></div>
				</div>
				<div class="carousel-card fill-dark">
					<div class="thumbnail <?php if ( $hasYoutubeURL ) echo 'cursor-pointer' ?>" style="background-image: url( '<?= $event[ 'event_thumbnail' ][ 'sizes' ][ 'small' ] ?>' );"></div>
					<div class="info space-25">
						<div class="price h5 condensed"><?= $event[ 'event_sub_title' ] ?></div>
						<div class="title h4 strong"><?= $event[ 'event_title' ] ?></div>
					</div>
				</div>
				<a href="<?= $event[ 'page_link' ] ?>" class="button fill-neutral-4 text-light button-icon <?php if ( empty( $event[ 'page_link' ] ) ) echo 'hidden' ?>" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--neutral-2);"><?= $event[ 'button_title' ] ?></a>
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
<!-- END: Carousel: Events -->


<!-- Action: Site Visit : Form -->
<section class="action-site-visit fill-dark space-25-top-bottom qpid_login_site js_book_site_visit_section">
	<div class="container">
		<div class="row">
			<div class="intro columns small-6 medium-3 large-2">
				<div class="heading h3 strong text-lowercase space-min-bottom">
					Book a <br>
					<span class="text-red-2">Site Visit</span>
				</div>
				<div class="description h5 condensed text-neutral-4">
					Register for pick up and drop from your location.
				</div>
			</div>
			<div class="action-form columns small-10 medium-8 medium-offset-1 large-6 large-offset-0">
				<form class="js_book_site_visit_form" data-c="book-site-visit/<?= $urlSlug ?>">
					<div class="row">
						<div class="form-row columns small-12 medium-6">
							<label>
								<span class="label strong text-uppercase text-neutral-4 cursor-pointer">
									Name
								</span>
								<input class="block input-dark" type="text" name="name" required>
							</label>
						</div>
						<div class="form-row columns small-12 medium-6">
							<label>
								<span class="label strong text-uppercase text-neutral-4 cursor-pointer">
									Email
								</span>
								<input class="block input-dark" type="text" name="email-address" required>
							</label>
						</div>
						<!-- Phone Trap -->
						<div class="phone-trap phone-number form-row columns small-12 medium-6">
							<label for="pt03">
								<span class="label strong text-uppercase text-neutral-4 cursor-pointer">
									Phone
								</span>
							</label>
							<div class="row">
								<div class="columns small-3 prefix-group" style="position: relative; padding-right: 5px; ">
									<select class="form-field block js_phone_country_code" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0">
										<?php include __DIR__ . '/../inc/phone-country-codes.php' ?>
									</select>
									<input class="prefix js_phone_country_code_label strong input-field text-red-2 text-right" value="+91" style="pointer-events: none; width: 100%; padding: 0; padding-right: 3px; border-color: var(--red-2);">
								</div>
								<div class="columns small-9">
									<input id="pt03" class="block input-dark" type="text" name="phone-number" required>
								</div>
							</div>
						</div>
						<!-- END: Phone Trap -->
						<div class="form-row columns small-12 medium-6">
							<label>
								<span class="invisible label strong text-uppercase text-neutral-4 cursor-pointer">
									Submit
								</span>
								<button class="button block fill-red-2 button-icon" type="submit" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--red-1);">Submit</button>
							</label>
						</div>
					</div>
				</form>
				<!-- OTP form -->
				<form class="js_otp_form" style="display: none;">
					<div class="otp-trap row">
						<div class="form-row columns small-12 medium-6">
							<label class="block text-left">
								<span class="label strong inline text-neutral-4 text-uppercase">Enter the OTP</span>
								<input class="otp block input-dark" type="text" name="otp">
							</label>
						</div>
						<div class="form-row columns small-12 medium-6">
							<label class="submit block">
								<span class="invisible label inline text-neutral-4 text-uppercase">Submit</span>
								<button class="button block fill-red-2 button-icon" type="submit" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--red-1);">Book Now</button>
							</label>
						</div>
					</div>
					<div class="form-row columns small-12 clearfix hidden">
						<div class="label strong text-red-2 text-uppercase inline-middle cursor-pointer float-left" tabindex="-1">Re-send OTP</div>
						<div class="label strong text-red-2 text-uppercase inline-middle cursor-pointer float-right" tabindex="-1">Enter different number</div>
					</div>
				</form>
				<!-- END: OTP form -->
			</div>
			<div class="or-call columns small-10 medium-6 medium-offset-0 large-4 large-offset-0">
				<div class="h5 text-lowecase">or call <a href="tel:<?= $projectPhoneNumberUnformatted ?>" class="text-red-2"><?= $projectPhoneNumberFormatted ?></a></div>
			</div>
		</div>
	</div>
</section>
<!-- END: Action: Site Visit : Form -->


<!-- Office Addresses Section -->
<?php if ( ! empty( $officeAddresses ) ) : ?>
<section class="addresses-section fill-black space-25-bottom">
	<div class="container">
		<div class="row">
			<?php foreach ( $officeAddresses as $address ) : ?>
				<div class="address columns small-10 medium-8 large-4 space-25-top space-25-right">
					<div class="title h6 text-lowercase"><?= $address[ 'address_label' ] ?></div>
					<div class="name h5 condensed text-red-2"><?= $address[ 'name' ] ?></div>
					<div class="description h6 text-neutral-2"><?= $address[ 'address' ] ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
<!-- END: Office Addresses Section -->


<?php require_once __DIR__ . '/../inc/below.php'; ?>

<script type="text/javascript">


	function unlockSpotlights () {
		var user = __CUPID.utils.getUser();
		if ( ! user )
			return;
		$( ".js_spotlight" ).removeClass( "hidden" );
		$( ".js_spotlight_unlock_form_section" ).addClass( "hidden" );
	}
	unlockSpotlights();

</script>
