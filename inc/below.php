
			<!-- ~/~/~/~/~/~/~/~/~/~/~/~/~/~/~/~/ -->
			<!-- Page-specific content goes here. -->
			<!-- ~/~/~/~/~/~/~/~/~/~/~/~/~/~/~/~/ -->

		</div> <!-- END : Page Content -->


		<!-- Footer Section -->
		<section data-section="About" id="about" class="footer-section space-50-top-bottom">
			<div class="row space-50-top space-25-bottom">
				<div class="container">
					<div class="footer-info columns small-12 medium-10 large-8">
						<div class="title h3 text-lowercase space-25-bottom">More than a decade and <?php echo getContent( '', 'total_units_sold'); ?> happy customers later, we are still obsessed with the engineering of a high-rise building.</div>
						<div class="description p text-neutral-3 space-25-bottom">
							<div class="p space-min-bottom">
								In its journey spanning a decade, from the handover of its first tower in the year 2010, at its maiden and flagship project - PBEL CITY, till now, INDIS has come a long way. Having successfully launched 3 more major projects in the interim – ONE CITY, VB CITY and VIVA CITY, INDIS now has about 4,500 customers on board.
							</div>
							<div class="p space-min-bottom">
								With its continuous efforts in building Engineering capabilities; use of robust technologies, such as the shear wall method of construction; engaging reputed construction partners; collaboration with renowned fund houses; sturdy systems and processes and its unwavering focus on customer service, INDIS has built its reputation of being a progressive; reliable, innovative and a transparent Real Estate Company.
							</div>
							<div class="p">
								With Excellence in Engineering; Constant Innovation and Learning at its core, INDIS is set to cross many more milestones in the coming years.
							</div>
						</div>
					</div>
					<div class="logo columns small-8 medium-6 large-4 xlarge-3 xlarge-offset-1">
						<img class="block" src="../media/indis-logo-color.svg<?php echo $ver ?>">
					</div>
				</div>
			</div>
			<div class="row space-25-top-bottom">
				<div class="container">
					<div class="footer-links columns small-12 large-8">
						<div class="row">
							<?php foreach ( $allProjectsExcludingCurrent as $project ) : ?>
								<div class="project-links columns small-6 medium-3">
									<a href="<?= $project[ 'permalink' ] ?>" class="title h6 strong text-red-2"><?= $project[ 'post_title' ] ?>
										<span class="location block label strong text-uppercase text-red-1"><?= getContent( '', 'location', $project[ 'ID' ] ) ?></span>
									</a>
									<?php if ( getContent( false, 'plans', $project[ 'ID' ] ) ) : ?>
										<a href="<?= $project[ 'permalink' ] . '#plans' ?>" class="link h6 strong text-neutral-2">Floorplans</a>
									<?php endif; ?>
									<a href="<?= $project[ 'permalink' ] . '#location' ?>" class="link h6 strong text-neutral-2">Location</a>
									<?php if ( getContent( false, 'plans', $project[ 'ID' ] ) ) : ?>
										<a href="<?= $project[ 'permalink' ] . '#plans' ?>" class="link h6 strong text-neutral-2">Masterplan</a>
									<?php endif; ?>
									<?php if ( getContent( false, 'amenity', $project[ 'ID' ] ) ) : ?>
										<a href="<?= $project[ 'permalink' ] . '#amenities' ?>" class="link h6 strong text-neutral-2">Amenities</a>
									<?php endif; ?>
									<?php if ( getContent( false, 'updates', $project[ 'ID' ] ) ) : ?>
										<a href="<?= $project[ 'permalink' ] . '#updates' ?>" class="link h6 strong text-neutral-2">Updates</a>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="footer-address columns small-12 large-4 xlarge-3 xlarge-offset-1">
						<div class="title h6 strong text-uppercase space-min-bottom">Corporate Address :</div>
						<div class="address h4 text-neutral-2 space-min-bottom">Plot No. 825, Road No.44, <br>Jubilee Hills, Hyderabad, <br>Telangana — 500033.</div>
						<div class="title h6 strong text-uppercase space-min-top space-min-bottom">Corporate Phone :</div>
						<div class="address h4 text-neutral-2 space-min-bottom"><a href="tel:+914068989898" class="text-red-2">+91 40 6898 9898</a></div>
						<a href="https://goo.gl/maps/jFcbmAJ1rhwwh5Wo6" target="_blank" class="hidden link label strong text-red-2 text-uppercase inline-middle">Open in Google Maps <img class="link-icon inline-middle" src="../media/icon/icon-location-color.svg<?php echo $ver ?>"></a>

						<a href="mailto:corporateaffairs@indis.co.in" target="_blank" class="label strong text-neutral-4 inline-middle">
							corporateaffairs@indis.co.in
							<span class="small strong text-uppercase text-neutral-2">for Corporate Enquiries</span>
						</a><br>
						<a href="mailto:ask@indis.co.in" target="_blank" class="label strong text-neutral-4 inline-middle">
							ask@indis.co.in
							<span class="small strong text-uppercase text-neutral-2">for General Enquiries</span>
						</a><br>
						<a href="mailto:careers@indis.co.in" target="_blank" class="label strong text-neutral-4 inline-middle">
							careers@indis.co.in
							<span class="small strong text-uppercase text-neutral-2">for Careers Enquiries</span>
						</a>
					</div>
				</div>
			</div>
			
			<div class="row space-25-top-bottom">
				<div class="container">
					<!-- Social Media Icons -->
					<?php if ( ! ( empty( $twitter_link ) and empty( $facebook_link ) and empty( $youtube_link ) and empty( $instagram_link ) and empty( $whatsapp_link ) and empty( $linkedin_link ) ) ) : ?>
						<div class="social-media-icons columns small-12 space-25-bottom">
							<?php if ( ! empty( $twitter_link ) ) : ?><a class="social-icon inline-middle fill-dark" tabindex="-1" target="_blank" href="<?= $twitter_link ?>"><?php require_once __DIR__ . '/../media/icon/social/icon-twitter.svg'; ?></a><?php endif; ?>
							<?php if ( ! empty( $facebook_link ) ) : ?><a class="social-icon inline-middle fill-dark" tabindex="-1" target="_blank" href="<?= $facebook_link ?>"><?php require_once __DIR__ . '/../media/icon/social/icon-facebook.svg'; ?></a><?php endif; ?>
							<?php if ( ! empty( $youtube_link ) ) : ?><a class="social-icon inline-middle fill-dark" tabindex="-1" target="_blank" href="<?= $youtube_link ?>"><?php require_once __DIR__ . '/../media/icon/social/icon-youtube.svg'; ?></a><?php endif; ?>
							<?php if ( ! empty( $instagram_link ) ) : ?><a class="social-icon inline-middle fill-dark" tabindex="-1" target="_blank" href="<?= $instagram_link ?>"><?php require_once __DIR__ . '/../media/icon/social/icon-instagram.svg'; ?></a><?php endif; ?>
							<?php if ( ! empty( $whatsapp_link ) ) : ?><a class="social-icon inline-middle fill-dark" tabindex="-1" target="_blank" href="<?= $whatsapp_link ?>"><?php require_once __DIR__ . '/../media/icon/social/icon-whatsapp.svg'; ?></a><?php endif; ?>
							<?php if ( ! empty( $linkedin_link ) ) : ?><a class="social-icon inline-middle fill-dark" tabindex="-1" target="_blank" href="<?= $linkedin_link ?>"><?php require_once __DIR__ . '/../media/icon/social/icon-linkedin.svg'; ?></a><?php endif; ?>
						</div>
					<?php endif; ?>

					<!-- Footer Menu -->
					<div class="footer-menu columns small-12 large-8">
						<?php foreach ( $footerNavigation as $item ) : ?>
							<a class="link h6 strong text-red-2" tabindex="-1" href="<?= $item[ 'url' ] ?>"><?= $item[ 'label' ] ?></a>
						<?php endforeach; ?>
					</div>

				</div>
			</div>
			<!-- End: Footer Menu -->
		</section>
		<!-- END: Footer Section -->


		<!-- Lazaro Signature -->
		<?php lazaro_signature(); ?>
		<!-- END : Lazaro Signature -->

	</div><!-- END : Page Wrapper -->

	<?php require_once __DIR__ . '/modals.php' ?>

	<!--  ☠  MARKUP ENDS HERE  ☠  -->

	<?php echo BFS_ENV_PRODUCTION ? rera_disclaimer() : lazaro_disclaimer() ?>









	<!-- JS Modules -->
	<script type="text/javascript" src="/js/modules/utils.js<?= $ver ?>"></script>
	<!-- <script type="text/javascript" src="/js/modules/device-charge.js<?= $ver ?>"></script> -->
	<script type="text/javascript" src="/js/modules/disclaimer.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/navigation.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/carousel.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/modal_box.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/form.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/phone_country_code.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/gallery.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/tabs.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/video_embed.js<?= $ver ?>"></script>
	<?php if ( $postType === 'projects' ) : ?>
		<script type="text/javascript" src="/js/modules/image-sequencer.js<?= $ver ?>"></script>
	<?php endif; ?>
	<script type="text/javascript" src="/js/modules/cupid/utils.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/cupid/user.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/login-prompts.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/forms.js<?= $ver ?>"></script>

	<!-- Slick Carousel -->
	<script type="text/javascript" src="/plugins/slick/slick.min.js<?php echo $ver ?>"></script>

	<!-- NPS -->
	<script type="text/javascript" src="/plugins/SheetJS/xlsx-core-v0.16.0.min.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/plugins/xlsx-calc/xlsx-calc-v0.4.1.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/spreadsheet-formulae.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/cupid/nps.js<?= $ver ?>"></script>


	<script type="text/javascript">

		/*
		 *	CUPID: Record Website Visits
		 */
		$( function () {
			var person = __CUPID.Person.get();
			if ( person.isRegistered() ) {
				setTimeout( function () {
					__CUPID.utils.getAnalyticsId()
						.then( function ( deviceId ) {
							person.hasDeviceId( deviceId );
							person.isOnWebsite();
						} )
				}, 1500 );
			}

		} );

		/*
		 *	NPS: Start the questionnaire
		 */
		$( function main () {
			fetchQuestionnaireSpreadsheet().then( initQuestionnaire ).then( function () {
				var person = __CUPID.Person.get();
				var version = window.__CUPID.NPS.questionnaireSettings.Version;
				if ( person.hasCompletedQuestionnaire( version ) )
					return;
				var questionnaire = person.getQuestionnaire();

				// If even one question was answered, don't present the questionnaire
				if ( questionnaire && questionnaire.version === version && questionnaire.qAndAs.length )
					return;

				if ( ! questionnaire || ! questionnaire.qAndAs || ! questionnaire.qAndAs.length )
					return __CUPID.NPS.askQuestion();

				<?php
				/*
				 * Resume the questionnaire
				 */
				/*
				// var currentQuestionIndex = questionnaire.qAndAs.slice( -1 )[ 0 ].index - 1;
				// var answers = questionnaire.qAndAs.map( function ( qAndA ) { return [ qAndA.answer ] } );
				// __CUPID.NPS.setAnswers( answers );
				// var nextQuestionIndex = __CUPID.NPS.getNextQuestionIndex( currentQuestionIndex );
				// if ( __CUPID.NPS.questionnaire[ nextQuestionIndex ].type === "phone_number" )
				// 	if ( person.isRegistered() )
				// 		nextQuestionIndex = __CUPID.NPS.getNextQuestionIndex( nextQuestionIndex );
				// __CUPID.NPS.askQuestion( nextQuestionIndex );
				*/
				?>
			} );
		} );

	</script>

	<!-- Other Modules -->
	<?php // require __DIR__ . '/inc/can-user-hover.php' ?>


	<?= getContent( '', 'arbitrary_code -> before_body_closing' ); ?>

	<?php if ( CMS_ENABLED and is_user_logged_in() ) : ?>
		<!-- Query Monitor -->
		<script type="text/javascript" src="cms/wp-content/plugins/query-monitor/assets/query-monitor.js<?= $ver ?>"></script>
	<?php endif; ?>


</body>

</html>
