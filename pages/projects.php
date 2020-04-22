<?php
/*
 *
 * The is the Project template page
 *
 */
if ( empty( $urlSlug ) )
	return header( 'Location: /', true, 302 );



require_once __DIR__ . '/../inc/utils.php';
initWordPress();

$metaDescription = getContent( '', 'intro_title' ) ?? null;
$coverImages = getContent( [ ], 'cover_images' );
$metaImage = $coverImages[ 0 ][ 'image' ] ?? [ ];

$projectPhoneNumberFormatted = getContent( '', 'phone_number' );
$projectPhoneNumberUnformatted = str_replace( [ '-', ' ' ], '', $projectPhoneNumberFormatted );
$planGroups = getContent( [ ], 'plans' );
$amenities = getContent( [ ], 'amenity' );
	$amenityImages = getContent( [ ], 'amenities_images' );
$constructionUpdateGroups = getContent( [ ], 'updates' );
$constructionPartnerLogo = getContent( '', 'construction_partner_logo -> sizes -> thumbnail' );
$engineeringPartners = getContent( [ ], 'engineering_partners' );
$spotlights = getContent( [ ], 'spotlight_list' );
	$numberOfSpotlight = str_pad( count( $spotlights ), 2, '0', STR_PAD_LEFT );
$events = getContent( [ ], 'events_list' );
	$numberOfEvents = str_pad( count( $events ), 2, '0', STR_PAD_LEFT );
$officeAddresses = getContent( [ ], 'office_addresses' );

$showEngineeringConcrete = getContent( [ ], 'engineering_section_concrete' );
$showEngineeringRailing = getContent( [ ], 'engineering_section_railing' );
$showEngineeringFire = getContent( [ ], 'engineering_section_fire' );
$showEngineeringFire2 = getContent( [ ], 'engineering_section_fire_2' );


require_once __DIR__ . '/../inc/above.php';


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
	<div class="container">
		<div class="row">
			<div class="cover-image-container image-1 columns small-12 large-12">
				<div class="cover-image fill-neutral-2 js_gallery_item">
					<img src="<?= $coverImages[ 0 ][ 'image' ][ 'sizes' ][ 'large' ] ?>">
				</div>
			</div>
			<div class="project-card columns small-8 medium-4 fill-dark space-25">
				<div class="logo space-min-bottom"><a href="<?php echo $baseURL ?>" class="inline"><img class="block" src="../media/indis-logo-light.svg<?php echo $ver ?>"></a></div>
				<div class="title h4 strong"><?= $thePost[ 'post_title' ] ?></div>
				<div class="location label strong text-uppercase text-red-2"><?= getContent( '', 'location' ) ?></div>
				<hr class="dash">
				<div class="type h6 strong space-min-top"><?= getContent( '', 'type' ) ?></div>
				<div class="price h5 condensed text-neutral-4"><?= getContent( '', 'price' ) ?></div>
			</div>
			<div class="cover-image-strip columns small-4 medium-2 large-6">
				<div class="row">
					<div class="cover-image-container image-2 columns small-12 large-4">
						<div class="cover-image fill-neutral-2 js_modal_trigger js_gallery_item cursor-pointer" tabindex="-1" data-mod-id="image-gallery">
							<img src="<?= $coverImages[ 1 ][ 'image' ][ 'sizes' ][ 'small' ] ?>">
						</div>
					</div>
					<div class="cover-image-container image-3 columns small-12 large-4">
						<div class="cover-image fill-neutral-2 js_modal_trigger js_gallery_item cursor-pointer" tabindex="-1" data-mod-id="image-gallery">
							<img src="<?= $coverImages[ 2 ][ 'image' ][ 'sizes' ][ 'small' ] ?>">
						</div>
					</div>
					<div class="cover-image-container image-4 columns small-12 large-4">
						<div class="cover-image fill-neutral-2 js_modal_trigger js_gallery_item cursor-pointer" tabindex="-1" data-mod-id="image-gallery">
							<img src="<?= $coverImages[ 3 ][ 'image' ][ 'sizes' ][ 'small' ] ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="cover-image-container image-5 columns small-12 medium-6 large-4">
				<div class="cover-image portrait fill-neutral-2 js_modal_trigger js_gallery_item cursor-pointer" tabindex="-1" data-mod-id="image-gallery">
					<img src="<?= $coverImages[ 4 ][ 'image' ][ 'sizes' ][ 'medium' ] ?>">
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
						<div class="point h5 condensed columns small-12 medium-6 space-min-bottom"><span class="inline-middle space-min-right"><img src="<?= '/content/dot-icons/' . $point[ 'intro_point_icon' ] . '.svg' ?>"></span><?= $point[ 'intro_point_text' ] ?></div>
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
									<input class="prefix strong input-field text-red-2 text-right no-pointer js_phone_country_code_label" tabindex="-1" value="+91" style="width: 100%; padding: 0; padding-right: 3px; border-color: var(--red-2);">
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
<script type="text/javascript">
	// Build the spotlight gallery objects
	var __DATA = window.__DATA = window.__DATA || { };
	__DATA.galleries = __DATA.galleries || { };
	<?php foreach ( $spotlights as $index => $spotlight ) : ?>
		<?php if ( ! empty( $spotlight[ 'spotlight_floorplan' ] ) ) : ?>
			__DATA.galleries.spotlight<?= $index + 1 ?> = [ { image: <?php echo json_encode( $spotlight[ 'spotlight_floorplan' ] ) ?> } ];
		<?php endif; ?>
	<?php endforeach; ?>
</script>
<div data-section="Spotlight" id="spotlight" class="carousel spotlight indis-carousel js_carousel_container">
	<div class="carousel-list js_carousel_content">
		<div class="carousel-list-item js_carousel_item">
			<div class="carousel-title h2 strong">
				<!-- offers <br>and <span class="text-red-2">best <br>sellers</span> -->
				<span class="text-red-2">spotlight</span> <br>apartment <br>units
			</div>
		</div>
		<?php foreach ( $spotlights as $index => $spotlight ) : ?>
			<div class="carousel-list-item js_carousel_item js_gallery_region qpid_login_site js_spotlight <?php if ( $index >= 4 ) echo 'hidden' ?>" data-set="spotlight<?= $index + 1 ?>">
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
							<span class="project h6 strong fill-light"><?= $thePost[ 'post_title' ] ?></span>
							<?php if( ! empty( $spotlight[ 'spotlight_series_id' ] ) ) : ?>
							<span class="series-id h6 strong fill-red-2"><?= $spotlight[ 'spotlight_series_id' ] ?></span>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<button id="spotlight-<?= $index + 1 ?>-enquire" class="button fill-neutral-4 text-light button-icon js_spotlight_enquire" data-c="/spotlight/<?= $urlSlug ?>" data-spotlight="Spotlight: <?= $thePost[ 'post_title' ] . ': ' . $spotlight[ 'spotlight_series_id' ] ?>" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--neutral-2);">Enquire Now</button>
				<!-- This button will be shown after verification (if there's a floorplan) -->
				<button class="button fill-neutral-4 text-light button-icon hidden js_view_spotlight_floorplan js_modal_trigger js_gallery_item" data-mod-id="image-gallery" data-series-id="<?= $spotlight[ 'spotlight_series_id' ] ?>" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--neutral-2);">View <?= $spotlight[ 'spotlight_series_id' ] ?> Floorplan</button>
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
									<input class="prefix strong input-field text-dark text-right no-pointer js_phone_country_code_label" tabindex="-1" value="+91" style="width: 100%; padding: 0; padding-right: 3px; border-color: var(--dark); color: var(--dark) !important;">
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
											<input class="prefix strong input-field text-dark text-right no-pointer js_phone_country_code_label" tabindex="-1" value="+91" style="width: 100%; padding: 0; padding-right: 3px; border-color: var(--dark); color: var(--dark) !important;">
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
			<div class="location-title no-pointer h2 strong text-light text-lowercase columns small-9 medium-5 xlarge-4"><?= getContent( '', 'location_title' ) ?></div>
		</div>
	</div>
</section>
<!-- END: Location Section -->


<!-- Download Brochure -->
<section class="download-brochure">
	<div class="container">
		<div class="row">
			<div class="brochure-mockup columns small-12 medium-5 large-6 inline-middle">
				<img class="block" src="<?= getContent( '', 'brochure_thumbnail -> sizes -> medium' ) ?>">
			</div>
			<div class="brochure-action fill-light columns small-10 small-offset-1 medium-7 medium-offset-0 large-6 inline-middle">
				<div class="download-title h3 text-lowercase strong space-25-bottom">If you're in a hurry, <br>just <span class="text-red-2">download the <span class="text-uppercase">PDF</span> brochure</span></div>
				<a href="" target="_blank" class="button fill-dark text-light button-icon" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--neutral-4);">Download Now</a>
				<div class="courier-description p text-neutral-2 space-min-top <?= $hide ?>">Or, if you'd like a copy of the physical brochure couriered to your location. <br><a href="" target="_blank" class="text-red-2">Click Here</a></div>
			</div>
		</div>
	</div>
</section>
<!-- END: Download Brochure -->


<!-- Engineering Section : Concrete -->
<?php if( ! empty( $showEngineeringConcrete ) ) : ?>
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
				<div class="title h4 strong space-25-bottom"><span class="text-red-2">Shear Wall</span> <br>Engineering</div>
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
				<?php if ( ! empty( $constructionPartnerLogo ) ) : ?>
				<div class="space-50-left space-25-bottom">
					<div class="label strong text-neutral-2 text-uppercase space-min-top-bottom">Construction Partner</div>
					<div class="construction-partner-logo">
						<img class="block" src="<?= $constructionPartnerLogo ?><?php echo $ver ?>">
					</div>
				</div>
				<?php endif; ?>
			</div>
			<div class="building-3d-1 hide-for-medium columns small-12 medium-6 medium-offset-1 large-3 large-offset-0">
				<img class="block" src="../media/engineering/building-3d-1.png<?php echo $ver ?>">
			</div>
		</div>
		<div class="row row-2">
			<div class="film columns small-12 medium-6">
				<div class="building-3d-2 space-50-left-right">
					<canvas style="width: 100%" class="hidden js_building_image_sequence">
						<img class="block" src="../media/engineering/building-3d-2.png<?php echo $ver ?>">
					</canvas>
					<img class="block js_building_image_sequence_placeholder" src="../media/engineering/building-3d-2.png<?php echo $ver ?>">
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
<?php endif; ?>
<!-- END: Engineering Section : Concrete -->


<!-- Carousel Mini: Affiliates Section -->
<?php if ( ! empty( $engineeringPartners ) ) : ?>
<section data-section="Affiliates" class="affiliates-section space-50-bottom js_tab_container">
	<div class="row">
		<div class="container">
			<div class="columns small-12 text-center space-25-bottom">
				<div class="h5">Material <span class="text-red-2">Brands</span> Used</div>
			</div>
		</div>
	</div>
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
							<?php if ( ! empty( $plan[ 'compass_offset' ] ) or $plan[ 'compass_offset' ] === '0' ) : ?>
								<div class="icon-compass" style="transform: rotate(<?= $plan[ 'compass_offset' ] ?>deg);"><img class="block" src="../media/icon/icon-compass.svg<?php echo $ver ?>"></div>
							<?php endif; ?>
						</div>
						<div class="help-message p strong text-red-2 space-min-top"><img class="inline-middle" width="20px" src="../media/icon/icon-orientation.svg<?php echo $ver ?>"> Rotate device for best experience!</div>
						<div class="plan-status row">
							<div class="columns small-12 medium-9 large-7">
								<div class="title h5 condensed space-min-top">
									<?= $plan[ 'plan_status_title' ] ?>
								</div>
								<div class="description h6 text-neutral-2 space-min-top">
									<?= $plan[ 'plan_status_description' ] ?>
								</div>
							</div>
						</div>
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
				<div class="carousel-mini-image cursor-pointer js_modal_trigger js_gallery_item" data-mod-id="image-gallery" style="background-image: url( '<?= $image[ 'image' ][ 'sizes' ][ 'small' ] ?>' );"></div>
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
									<div class="point h5 condensed space-min-bottom"><span class="inline-middle space-min-right"><img src="<?= '/content/dot-icons/' . $amenityPoint[ 'amenity_point_icon' ] . '.svg' ?>"></span><?= $amenityPoint[ 'amenity_point_text' ] ?></div>
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
<?php if( ! empty( $showEngineeringRailing ) ) : ?>
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
				<div class="title h4 strong space-25-bottom"><span class="text-red-2">Safety</span> <br>Engineering</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					1.2m high balcony railings ensures safety on any floor.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Apart from the 3 horizontal railing members that are a structural requirement, all other railing members are vertical.
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
<?php endif; ?>
<!-- END: Engineering Section : Railing -->


<!-- Engineering Section : Fire -->
<?php if( ! empty( $showEngineeringFire ) ) : ?>
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
				<div class="title h4 strong space-25-bottom"><span class="text-red-2">Fire Safety</span> <br>Engineering</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Early warning heat detectors <span class="text-dark">in your kitchen</span>. Multi-detectors <span class="text-dark">for heat and smoke in all the remaining rooms.</span>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Detectors trigger an early warning fire alarm alerting residents and personnel in the building with the location of a potential fire.
				</div>
				<div class="smoke-detector text-center">
					<img class="block" src="../media/engineering/smoke-detector.png<?php echo $ver ?>">
					<div class="label strong text-neutral-2 text-uppercase space-min-top-bottom">Smoke and Heat Detector</div>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Every floor has <span class="text-red-2">early warning fire measures</span> like hand-held extinguishers and water hoses.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					In case a fire is too intense for early warning fire measures, <span class="text-red-2">follow the exit signs and evacuate the building.</span>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					A pressurized network of pipes feed the <span class="text-dark">fire sprinklers in every room of your house.</span>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Every fire sprinkler has a <span class="text-dark">temperature activated glass bulb</span> that melts at 68° Celsius.
				</div>
			</div>
			<div class="points points-2 columns small-12 medium-6 medium-offset-6 large-3 large-offset-0">
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					<span class="text-dark">Only the fire sprinklers in the region of the fire will activate when a fire melts the glass bulbs.</span>
				</div>
				<div class="fire-sprinkler text-center">
					<img class="block" src="../media/engineering/fire-sprinkler.png<?php echo $ver ?>">
					<div class="label strong text-neutral-2 text-uppercase space-min-top-bottom">Temperature Activated Sprinkler</div>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Three redundant <span class="text-dark">water pumps activate in sequence</span> when they sense a drop in water pressure. This ensures the sprinklers are fed with a constant water pressure.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					<span class="text-red-2">Pump 1</span> is an electric pump capable of delivering 180 litres per minute.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					<span class="text-red-2">Pump 2</span> is a high capacity electric pump which can deliver up to 2250 or 2850 litres per minute, depending on the height of the building. This pump switches on if Pump 1 is unable to maintain water pressure.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					<span class="text-red-2">Pump 3</span> is a high capacity diesel pump which can also deliver up to 2250 or 2850 litres per minute, depending on the height of the building.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					This diesel pump switches on if Pump 1 and 2 are unable to maintain water pressure or <span class="text-dark">if the electrical power supply fails.</span>
				</div>
			</div>
		</div>
		<div class="row row-2">
			<div class="fire-infographic columns small-12">
				<img class="block" src="../media/engineering/engineering-fire-infographic.png<?php echo $ver ?>">
			</div>
		</div>
		<div class="row row-3 <?= $showMedium ?>">
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
<?php endif; ?>
<!-- END: Engineering Section : Fire -->

<!-- Engineering Section : Fire 2 -->
<?php if( ! empty( $showEngineeringFire2 ) ) : ?>
<section data-section="Engineering — Fire" class="engineering-section fire fire-2 space-50-top-bottom">
	<div class="container">
		<div class="row row-1">
			<div class="section-label columns small-12 xlarge-10 xlarge-offset-1 space-25-bottom">
				<div class="label strong text-neutral-2 text-uppercase">Engineering</div>
			</div>
			<div class="heading columns small-12 medium-6 large-5 xlarge-4 xlarge-offset-1 space-50-bottom">
				<div class="h3 strong text-lowercase">4 level redundancy fire fighting infrastructure. <span class="text-red-2">Early warning smoke detectors and triple pump fire sprinkler system.</span></div>
			</div>
			<div class="points points-1 columns small-12 medium-6 large-3 large-offset-1">
				<div class="title h4 strong space-25-bottom"><span class="text-red-2">Fire Safety</span> <br>Engineering</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Every floor has <span class="text-red-2">early warning fire measures</span> like hand-held extinguishers and water hoses.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					In case a fire is too intense for early warning fire measures, <span class="text-red-2">follow the exit signs and evacuate the building.</span>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					A pressurized network of pipes feed the <span class="text-dark">fire sprinklers in every room of your house.</span>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Every fire sprinkler has a <span class="text-dark">temperature activated glass bulb</span> that melts at 68° Celsius.
				</div>
			</div>
			<div class="points points-2 columns small-12 medium-6 medium-offset-6 large-3 large-offset-0">
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					<span class="text-dark">Only the fire sprinklers in the region of the fire will activate when a fire melts the glass bulbs.</span>
				</div>
				<div class="fire-sprinkler text-center">
					<img class="block" src="../media/engineering/fire-sprinkler.png<?php echo $ver ?>">
					<div class="label strong text-neutral-2 text-uppercase space-min-top-bottom">Temperature Activated Sprinkler</div>
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					Three redundant <span class="text-dark">water pumps activate in sequence</span> when they sense a drop in water pressure. This ensures the sprinklers are fed with a constant water pressure.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					<span class="text-red-2">Pump 1</span> is an electric pump capable of delivering 180 litres per minute.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					<span class="text-red-2">Pump 2</span> is a high capacity electric pump which can deliver up to 2250 or 2850 litres per minute, depending on the height of the building. This pump switches on if Pump 1 is unable to maintain water pressure.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					<span class="text-red-2">Pump 3</span> is a high capacity diesel pump which can also deliver up to 2250 or 2850 litres per minute, depending on the height of the building.
				</div>
				<div class="point h5 condensed text-neutral-3 space-min-bottom">
					This diesel pump switches on if Pump 1 and 2 are unable to maintain water pressure or <span class="text-dark">if the electrical power supply fails.</span>
				</div>
			</div>
		</div>
		<div class="row row-2">
			<div class="fire-infographic columns small-12">
				<img class="block" src="../media/engineering/engineering-fire-infographic.png<?php echo $ver ?>">
			</div>
		</div>
		<div class="row row-3 <?= $showMedium ?>">
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
<?php endif; ?>
<!-- END: Engineering Section : Fire 2 -->


<!-- Updates Section -->
<?php if ( ! empty( $constructionUpdateGroups ) ) : ?>
<section data-section="Construction Updates" id="updates" class="updates-section space-75-top space-100-bottom fill-dark js_section_construction_updates js_tab_container">
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
						<div tabindex="-1" class="h5 tab-button tab-button-large js_tab_heading js_vertical_tab_heading"><?= $group[ 'update_group_title' ] ?></div>
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
					<div class="updates-menu-2 js_construction_update_heading_carousel <?php if ( count( $group[ 'update_group' ] ) === 1 and empty( trim( $group[ 'update_group' ][ 0 ][ 'update_name' ] ) ) ) echo 'hidden' ?>">
						<div class="tab-menu hide-for-medium js_tab_headings js_construction_update_heading_row">
							<?php foreach ( $group[ 'update_group' ] as $update ) : ?>
								<div tabindex="-1" class="h6 tab-button js_tab_heading"><?= $update[ 'update_name' ] ?></div>
							<?php endforeach; ?>
						</div>
						<div class="scroll-controls clearfix js_construction_update_heading_controls">
							<div class="prev float-left"><button class="button fill-neutral-4 js_pager" data-dir="left"><img class="block" src="../media/icon/icon-left-triangle-light.svg<?php echo $ver ?>"></button></div>
							<div class="next float-right"><button class="button fill-neutral-4 js_pager" data-dir="right"><img class="block" src="../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>"></button></div>
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
								<div class="image cursor-pointer js_modal_trigger js_gallery_item <?php if ( $update[ 'update_images' ][ 0 ][ 'image' ][ 'width' ] / $update[ 'update_images' ][ 0 ][ 'image' ][ 'height' ] < 1.25 ) echo 'fit-image' ?>" data-mod-id="image-gallery" style="background-image: url( '<?= $update[ 'update_images' ][ 0 ][ 'image' ][ 'sizes' ][ 'medium' ] ?>' );"></div>
								<div class="icon-button zoom " style="background-image: url('../media/icon/icon-zoom-white.svg<?php echo $ver ?>');"></div>
							</div>
							<div class="update-gallery columns small-12 large-7">
								<div class="block row position-relative">
									<?php foreach ( array_slice( $update[ 'update_images' ], 1, 9 ) as $image ) : ?>
										<div class="image-container columns small-6 medium-4"><div class="image cursor-pointer js_modal_trigger js_gallery_item <?php if ( $image[ 'image' ][ 'width' ] / $image[ 'image' ][ 'height' ] < 1.25 ) echo 'fit-image' ?>" data-mod-id="image-gallery" style="background-image: url( '<?= $image[ 'image' ][ 'sizes' ][ 'small' ] ?>' );"></div></div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="row">
								<div class="update-rera columns small-12 large-5">
									<?php if ( ! empty( $update[ 'rera_number' ] ) ) : ?>
										<div class="h5 condensed text-red-2 space-min-top">TS RERA Number: <?= $update[ 'rera_number' ] ?></div>
										<img class="icon-ts-rera" src="../media/construction/icon-ts-rera.png<?php echo $ver ?>">
									<?php endif; ?>
								</div>
								<div class="update-status columns small-12 medium-9 large-7">
									<div class="title h5 condensed space-min-top">
										<?= $update[ 'update_status_title' ] ?>
									</div>
									<div class="description h6 text-neutral-2 space-min-top">
										<?= $update[ 'update_status_description' ] ?>
									</div>
								</div>
							</div>
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
			<div class="graphic columns small-6 medium-4 xlarge-3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 327.25"><polygon points="287.58 0 12.42 0 12.42 0 0 0 0 0 0 0 0 12.42 0 12.42 0 128.87 12.42 140.96 12.42 12.42 287.58 12.42 287.58 314.83 12.42 314.83 12.42 198.02 72 198.02 84.08 185.59 12.42 185.59 12.42 185.59 0 185.59 0 314.83 0 327.25 12.42 327.25 287.58 327.25 300 327.25 300 314.83 300 12.42 300 0 287.58 0" style="fill:#c0343c"/><path d="M41.41,33.15V73.92c0,3.78,1.66,5.13,4.3,5.13S50,77.7,50,73.92V33.15h7.86V73.39c0,8.46-4.23,13.29-12.39,13.29S33.1,81.85,33.1,73.39V33.15Z" style="fill:#c0343c"/><path d="M88.14,46.21v6.87c0,8.46-4.08,13.06-12.38,13.06H71.83V86h-8.3V33.15H75.76C84.06,33.15,88.14,37.75,88.14,46.21ZM71.83,40.7V58.59h3.93c2.64,0,4.08-1.2,4.08-5V45.68c0-3.77-1.44-5-4.08-5Z" style="fill:#c0343c"/><path d="M104.45,56.55h11.63V73.32c0,8.45-4.23,13.28-12.39,13.28S91.31,81.77,91.31,73.32V45.83c0-8.45,4.23-13.28,12.38-13.28s12.39,4.83,12.39,13.28V51h-7.86V45.31c0-3.78-1.66-5.21-4.3-5.21s-4.3,1.43-4.3,5.21V73.84c0,3.78,1.66,5.14,4.3,5.14s4.3-1.36,4.3-5.14V64.1h-3.77Z" style="fill:#c0343c"/><path d="M138.8,86c-.45-1.36-.75-2.19-.75-6.49V71.2c0-4.91-1.66-6.72-5.44-6.72h-2.87V86h-8.3V33.15H134c8.61,0,12.31,4,12.31,12.16v4.15c0,5.43-1.74,8.91-5.44,10.64v.15c4.15,1.74,5.51,5.67,5.51,11.18v8.15a15.57,15.57,0,0,0,.91,6.42Zm-9.06-45.3V56.93H133c3.09,0,5-1.36,5-5.58V46.14c0-3.78-1.28-5.44-4.23-5.44Z" style="fill:#c0343c"/><path d="M178.67,86h-8.38l-1.44-9.59H158.66L157.22,86H149.6l8.45-52.85h12.16Zm-19-16.76h8l-3.93-26.73h-.15Z" style="fill:#c0343c"/><path d="M182.52,33.15h13.13c8.31,0,12.39,4.6,12.39,13.06V72.94C208,81.39,204,86,195.65,86H182.52Zm8.3,7.55V78.45h4.68c2.64,0,4.23-1.36,4.23-5.13V45.83c0-3.77-1.59-5.13-4.23-5.13Z" style="fill:#c0343c"/><path d="M221.62,55.42H233V63h-11.4V78.45H236V86H213.32V33.15H236V40.7H221.62Z" style="fill:#c0343c"/><path d="M241.1,33.15h13.14c8.3,0,12.38,4.6,12.38,13.06V72.94c0,8.45-4.08,13.06-12.38,13.06H241.1Zm8.31,7.55V78.45h4.68c2.64,0,4.23-1.36,4.23-5.13V45.83c0-3.77-1.59-5.13-4.23-5.13Z" style="fill:#c0343c"/><g style="opacity:0.5;isolation:isolate"><path d="M43.21,259.5H56v9H43.21v26h-9.9v-63H59.5v9H43.21Z" style="fill:#c0343c"/><path d="M94.24,294.51h-10l-1.71-11.43H70.39l-1.71,11.43H59.59l10.08-63H84.16Zm-22.59-20h9.54l-4.68-31.86h-.18Z" style="fill:#c0343c"/><path d="M118.81,276.24H119l6.66-44.73h13.77v63h-9.36V249.33h-.18l-6.66,45.18h-9.36L106.66,250h-.18v44.55H97.84v-63h13.77Z" style="fill:#c0343c"/><path d="M145.72,231.51h9.9v63h-9.9Z" style="fill:#c0343c"/><path d="M161.92,231.51h9.9v54h16.29v9H161.92Z" style="fill:#c0343c"/><path d="M191.53,231.51h9.89v63h-9.89Z" style="fill:#c0343c"/><path d="M217.62,258.06h13.59v9H217.62v18.45h17.1v9h-27v-63h27v9h-17.1Z" style="fill:#c0343c"/><path d="M253.26,230.79c9.63,0,14.58,5.76,14.58,15.84v2h-9.36V246c0-4.5-1.8-6.21-5-6.21s-4.95,1.71-4.95,6.21,2,8,8.46,13.68c8.28,7.29,10.89,12.51,10.89,19.71,0,10.08-5,15.84-14.76,15.84s-14.75-5.76-14.75-15.84v-3.87h9.35V280c0,4.5,2,6.12,5.13,6.12S258,284.52,258,280s-2-8-8.46-13.68c-8.28-7.29-10.89-12.51-10.89-19.71C238.68,236.55,243.63,230.79,253.26,230.79Z" style="fill:#c0343c"/></g><g style="opacity:0.5;isolation:isolate"><path d="M33.22,91.82h7.59v41.4H53.3v6.9H33.22Z" style="fill:#c0343c"/><path d="M56.61,91.82H64.2v48.3H56.61Z" style="fill:#c0343c"/><path d="M77.31,113.28h9.8v6.89h-9.8v20H69.72V91.82H89.8v6.9H77.31Z" style="fill:#c0343c"/><path d="M101,112.17h10.42v6.9H101v14.15h13.12v6.9H93.46V91.82h20.7v6.9H101Z" style="fill:#c0343c"/><path d="M129.06,91.26c7.38,0,11.18,4.42,11.18,12.15v1.52h-7.18v-2c0-3.45-1.38-4.76-3.79-4.76s-3.8,1.31-3.8,4.76,1.52,6.15,6.49,10.49c6.34,5.59,8.35,9.59,8.35,15.11,0,7.73-3.87,12.15-11.32,12.15s-11.32-4.42-11.32-12.15v-3h7.18V129c0,3.45,1.52,4.69,3.93,4.69s3.94-1.24,3.94-4.69-1.52-6.14-6.49-10.49c-6.35-5.59-8.35-9.59-8.35-15.11C117.88,95.68,121.68,91.26,129.06,91.26Z" style="fill:#c0343c"/><path d="M142.44,91.82H165.9v6.9H158v41.4h-7.59V98.72h-7.94Z" style="fill:#c0343c"/><path d="M176.32,124.11l-9.59-32.29h7.94l5.72,22h.14l5.73-22h7.24l-9.59,32.29v16h-7.59Z" style="fill:#c0343c"/><path d="M196.54,91.82h7.59v41.4h12.49v6.9H196.54Z" style="fill:#c0343c"/><path d="M227.52,112.17h10.42v6.9H227.52v14.15h13.11v6.9h-20.7V91.82h20.7v6.9H227.52Z" style="fill:#c0343c"/><path d="M255.53,91.26c7.39,0,11.18,4.42,11.18,12.15v1.52h-7.17v-2c0-3.45-1.38-4.76-3.8-4.76S252,99.47,252,102.92s1.51,6.15,6.48,10.49c6.35,5.59,8.35,9.59,8.35,15.11,0,7.73-3.86,12.15-11.32,12.15s-11.31-4.42-11.31-12.15v-3h7.17V129c0,3.45,1.52,4.69,3.94,4.69s3.93-1.24,3.93-4.69-1.52-6.14-6.49-10.49c-6.34-5.59-8.34-9.59-8.34-15.11C244.36,95.68,248.15,91.26,255.53,91.26Z" style="fill:#c0343c"/></g><path d="M14.29,157.7c0-3.41,1.8-5.37,5.1-5.37s5.09,2,5.09,5.37v11.11c0,3.41-1.8,5.36-5.09,5.36s-5.1-1.95-5.1-5.36ZM17.65,169c0,1.52.67,2.1,1.74,2.1s1.74-.58,1.74-2.1V157.49c0-1.53-.67-2.11-1.74-2.11s-1.74.58-1.74,2.11Z" style="fill:#c0343c"/><path d="M29.39,162.06h4.33v3.05H29.39v8.82H26V152.58h8.87v3H29.39Z" style="fill:#c0343c"/><path d="M39.76,157.7c0-3.41,1.8-5.37,5.09-5.37s5.1,2,5.1,5.37v11.11c0,3.41-1.8,5.36-5.1,5.36s-5.09-1.95-5.09-5.36ZM43.12,169c0,1.52.67,2.1,1.73,2.1s1.74-.58,1.74-2.1V157.49c0-1.53-.67-2.11-1.74-2.11s-1.73.58-1.73,2.11Z" style="fill:#c0343c"/><path d="M56.51,170h.06l2.53-17.42h3.08l-3.29,21.35h-5l-3.29-21.35H54Z" style="fill:#c0343c"/><path d="M66.48,161.58h4.61v3H66.48v6.25h5.8v3.05H63.12V152.58h9.16v3h-5.8Z" style="fill:#c0343c"/><path d="M80.75,173.93a6.68,6.68,0,0,1-.3-2.62V168c0-2-.67-2.71-2.2-2.71H77.09v8.69H73.74V152.58H78.8c3.48,0,5,1.61,5,4.91v1.68c0,2.19-.7,3.6-2.19,4.3v.06c1.68.7,2.22,2.29,2.22,4.51v3.3a6.21,6.21,0,0,0,.37,2.59Zm-3.66-18.3v6.56h1.32c1.25,0,2-.55,2-2.26v-2.11c0-1.52-.52-2.19-1.71-2.19Z" style="fill:#c0343c"/><text transform="translate(90.69 218.09)" style="font-size:101px;fill:#c0343c;font-family: 'Bebas Neue', BebasNeue"><?php echo getContent( [ ], 'total_units_sold'); ?></text></svg></div>
			<div class="info columns small-12 medium-8 large-7 xlarge-6">
				<div class="title h3 strong text-lowercase space-min-bottom">At <span class="text-uppercase">INDIS</span>, we don’t just build landmarks, <span class="text-red-2">we build Lifemarks.</span></div>
				<div class="description p text-neutral-2 space-25-bottom">Built on the ethos of community living, you will always find more people sharing your interests and making life more meaningful. Sport plays an important role in character building. Kids need to explore and spread their wings to become well-rounded individuals, and adults need to stretch a little to uncover a healthier version of themselves.</div>
				<a href="" target="blank" class="button fill-red-2 text-light button-icon <?= $hide ?>" style="--bg-i: url('../media/icon/icon-right-triangle-light.svg<?php echo $ver ?>'); --bg-c: var(--red-1);">Discover How</a>
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
									<input class="prefix strong input-field text-red-2 text-right no-pointer js_phone_country_code_label" tabindex="-1" value="+91" style="width: 100%; padding: 0; padding-right: 3px; border-color: var(--red-2);">
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
					<div class="title label text-lowercase"><?= $address[ 'address_label' ] ?></div>
					<div class="name h6 condensed text-red-2"><?= $address[ 'name' ] ?></div>
					<div class="description label text-neutral-2"><?= $address[ 'address' ] ?></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
<!-- END: Office Addresses Section -->


<?php require_once __DIR__ . '/../inc/below.php'; ?>

<script type="text/javascript">

	/*
	 *
	 * Unlock all the spotlights if the user is already logged in
	 *
	 */
	function unlockSpotlights () {
		var user = __CUPID.utils.getUser();
		if ( ! user )
			return;
		$( ".js_spotlight" ).removeClass( "hidden" );
		$( ".js_spotlight_unlock_form_section" ).addClass( "hidden" );
	}
	unlockSpotlights();


	/*
	 *
	 * The Construction Updates row heading carousel
	 *
	 */

	// This function hides/shows the carousel's arrow button when necessary
	var adjustConstructionUpdateRowHeadingCarousel = function () {
			var $tabHeadings = $( ".js_section_construction_updates .js_vertical_tab_heading" );
			var $tabs = $( ".js_section_construction_updates .js_tab_container[ data-tab ]" );
			return eventually( function () {
				// 1. Get the active tab heading row
				var activeTabName = $tabHeadings.filter( ".active" ).text();
				var $tab = $tabs.filter( "[ data-tab = '" + activeTabName + "' ]" );
				var domHeadingRow = $tab.find( ".js_construction_update_heading_row" ).get( 0 );
				var $carouselControls = $tab.find( ".js_construction_update_heading_controls" );
				// 2. Hide the carousel controls for the tabs that aren't active
				$tabs.not( $tab ).find( ".js_construction_update_heading_controls .js_pager" ).removeClass( "fade-in" );
				// 3. Hide/show the arrow buttons depending on how the width of row heading compares to the content it encloses
				if ( domHeadingRow.offsetWidth < domHeadingRow.scrollWidth ) {
					// $carouselControls.removeClass( "hidden" );

					if ( domHeadingRow.scrollLeft < 15 )
						$carouselControls.find( "[ data-dir = 'left' ]" ).removeClass( "fade-in" );
					else
						$carouselControls.find( "[ data-dir = 'left' ]" ).addClass( "fade-in" );

					var maximumScrollLeft = domHeadingRow.scrollWidth - domHeadingRow.offsetWidth;
					if ( maximumScrollLeft - domHeadingRow.scrollLeft < 15 )
						$carouselControls.find( "[ data-dir = 'right' ]" ).removeClass( "fade-in" );
					else
						$carouselControls.find( "[ data-dir = 'right' ]" ).addClass( "fade-in" );
				}
				else {
					// $carouselControls.addClass( "hidden" );
					$carouselControls.find( "[ data-dir ]" ).hide();
				}
			}, 0.5 );
	}();
	$( document ).on( "click", ".js_section_construction_updates .js_vertical_tab_heading", adjustConstructionUpdateRowHeadingCarousel );
	$( window ).on( "resize", adjustConstructionUpdateRowHeadingCarousel );

	// This handler scrolls the tab headings when the arrow buttons are hit
	$( document ).on( "click", ".js_construction_update_heading_controls .js_pager", function ( event ) {

		/*
		 * 1. Get references to all the relevant elements
		 */
		var $carouselArrowButton = $( event.currentTarget );
		var domCarouselContent = $carouselArrowButton
					.closest( ".js_construction_update_heading_carousel" )
					.find( ".js_construction_update_heading_row" )
					.get( 0 );

		/*
		 * 2. Get the amount of scroll that has to be done to center the next item
		 */
		var scrollDirection = $carouselArrowButton.data( "dir" );
		var scrollOffset = domCarouselContent.scrollLeft;
		if ( scrollDirection == "left" )
			scrollOffset -= domCarouselContent.offsetWidth / 3;
		else
			scrollOffset += domCarouselContent.offsetWidth / 3;

		/*
		 * 3. Finally, scroll the carousel.
		 */
		try {
			domCarouselContent.scrollTo( { left: scrollOffset, behavior: "smooth" } );
		}
		catch ( e ) {
			domCarouselContent.scrollTo( scrollOffset, 0 );
		}
		adjustConstructionUpdateRowHeadingCarousel();

	} );


	/*
	 *
	 * Set up the building image sequence
	 *
	 */
	var imageSequencer = new ImageSequencer( "/content/building-frames/short-building-{i}.png", 5, $( "canvas" ).get( 0 ) );
	$( ".js_building_image_sequence_placeholder" ).addClass( "hidden" );
	$( ".js_building_image_sequence" ).removeClass( "hidden" );
	imageSequencer.onReady( function () {
		imageSequencer.loop = true;
		imageSequencer.play();
	} );

</script>
