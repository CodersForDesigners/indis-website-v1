
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
								INDIS has a long history. Its roots can be traced to an international partnership in 2006 with the formation of PBEL Property Development Private Limited. This began as a partnership between INCOR, the Indian partner and two Israeli companies, PBC and Electra. The vision was to provide high quality gated community lifestyles to Indian families. PBEL City was the flagship project that kicked off this partnership. They launched PBEL City projects across Hyderabad and Chennai which are successes in their respective geographies.
							</div>
							<div class="p">
								With the exit of both Israeli partners in 2016, INCOR became a wholly Indian-owned company. The central vision of providing Indian families with gated community lifestyles expanded to building an engineering capability and team. The high rise engineering experience gained in PBEL City helped standardise materials and establish safety and maintenance protocols. A strong ethos of partnership, assembling a team of reputed architects, engineering consultants, contractors and material suppliers laid the foundation for this engineering capability. INCOR has diversified its businesses over the years and has recently created a brand called INDIS as part of the INCOR Group, which builds engineered gated communities. INDIS scaled to newer heights by adding more projects, ONE CITY, VB City and VIVA CITY.
							</div>
						</div>
					</div>
					<div class="logo columns small-8 medium-6 large-4 xlarge-3 xlarge-offset-1">
						<img class="block" src="../media/indis-lifemarks-logo-color.svg<?php echo $ver ?>">
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

	<?php require_once 'modals.php' ?>

	<!--  ☠  MARKUP ENDS HERE  ☠  -->

	<?php echo BFS_ENV_PRODUCTION ? rera_disclaimer() : lazaro_disclaimer() ?>









	<!-- JS Modules -->
	<script type="text/javascript" src="/js/modules/utils.js<?= $ver ?>"></script>
	<!-- <script type="text/javascript" src="/js/modules/device-charge.js<?= $ver ?>"></script> -->
	<script type="text/javascript" src="/js/navigation.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/carousel.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/modal_box.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/form.js<?= $ver ?>"></script>
	<script type="text/javascript" src="/js/modules/disclaimer.js<?= $ver ?>"></script>
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
	
	<script type="text/javascript">

		$( function () {

		/*
		 * Slick Slide Gallery
		 */

			$('.blocks-gallery-grid').slick({
				arrows: true,
				dots: false,
				infinite: true,
				speed: 800,
				autoplaySpeed: 3000,
				slidesToShow: 1,
				centerMode: true,
				variableWidth: true,
				lazyLoad: 'ondemand'
			}).slickNext();


		} );

	</script>

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
