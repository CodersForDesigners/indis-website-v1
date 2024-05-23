<?php
/**
 |
 | Variants section, for Myra Villas
 |
 | - the JavaScript code is present in the `below.php` file
 |
 */

$uploadDirBaseURL = wp_upload_dir()[ 'baseurl' ];
$imageBanner1 = $uploadDirBaseURL . '/' . wp_get_attachment_metadata( 7742 )[ 'file' ];
$imageBanner2 = $uploadDirBaseURL . '/' . wp_get_attachment_metadata( 7741 )[ 'file' ];
$imageBanner3 = $uploadDirBaseURL . '/' . wp_get_attachment_metadata( 8049 )[ 'file' ];

?>
<style>
	.variants-section {}
	/*
	 | Button Group
	 |
	 */
	.variants-section .button-group {
		border: none;
		z-index: 1;
	}
	.variants-section .button-group > * {
		margin-right: 5px;
		margin-bottom: 5px;
	}
	/*
	 | Image (isometric)
	 |
	 */
	.variants-section figure {
		z-index: 0;
	}
	@media ( max-width: 640px ) {
		.variants-section figure {
			position: relative;
		}
	}
	.variants-section img {
		position: relative;
		transform-origin: top left;
		z-index: 0;
	}
		.variants-section figure p {
			position: absolute;
			bottom: calc( -1 * var( --space-125 ) );
			left: 0;
		}
	@media ( min-width: 640px ) {
		.variants-section figure p {
			bottom: 0;
		}
	}
	.variants-section > :nth-child( 1 ) img {
		transform: scale( 1.5 ) translate( -25%, -20% );
	}
		.variants-section > :nth-child( 1 ) figure p {
			/* right: 1.5rem; */
			/* top: -2.5rem; */
			/* width: 15ch; */
		}
	.variants-section > :nth-child( 2 ) img {
		transform: scale( 1.5 ) translate( -15%, -15% );
	}
		.variants-section > :nth-child( 2 ) figure p {
			/* top: -1rem; */
		}
	.variants-section > :nth-child( 3 ) img {
		transform: scale( 1.4 ) translate( -14%, -10% );
	}
		.variants-section > :nth-child( 3 ) figure p {
			/* right: 1.5rem; */
		}
	@media ( min-width: 640px ) {
		.variants-section > :nth-child( 1 ) img {
			transform: scale( 1.8 ) translate( -33%, 0% );
		}
			.variants-section > :nth-child( 1 ) figure p {
				/* right: auto; */
				/* top: -6px; */
				/* width: auto; */
			}
		.variants-section > :nth-child( 2 ) img {
			transform: scale( 1.8 ) translate( -23%, 15% );
		}
			.variants-section > :nth-child( 2 ) figure p {
				bottom: 1rem;
			}
		.variants-section > :nth-child( 3 ) img {
			transform: scale( 1.7 ) translate( -25%, 0% );
		}
			.variants-section > :nth-child( 3 ) figure p {
				bottom: -5rem;
			}
	}
	@media ( min-width: 1040px ) {
		.variants-section > :nth-child( 1 ) img {
			transform: scale( 1.6 ) translate( -30%, 0% );
		}
			.variants-section > :nth-child( 1 ) figure p {
				bottom: -7rem;
			}
		.variants-section > :nth-child( 2 ) img {
			transform: scale( 1.7 ) translate( -20%, -5% );
		}
			.variants-section > :nth-child( 2 ) figure p {
			}
		.variants-section > :nth-child( 3 ) img {
			transform: scale( 1.3 ) translate( -15%, -5% );
		}
			.variants-section > :nth-child( 3 ) figure p {
			}
	}
	@media ( min-width: 1480px ) {
		.variants-section > :nth-child( 1 ) img {
		}
			.variants-section > :nth-child( 1 ) figure p {
				bottom: -18rem;
			}
		.variants-section > :nth-child( 2 ) img {
		}
			.variants-section > :nth-child( 2 ) figure p {
				bottom: -10rem;
			}
		.variants-section > :nth-child( 3 ) img {
		}
			.variants-section > :nth-child( 3 ) figure p {
				bottom: -9rem;
			}
	}

	/*
	 | Copy
	 |
	 */
	.variants-section .copy-heading :first-child {
		line-height: 0.85;
	}
	.variants-section .copy-heading :last-child {
		position: relative;
		margin-left: 3px;
		margin-bottom: 5px;
	}
	.variants-section .copy-heading :last-child:after {
		content: "";
		position: absolute;
		top: 100%;
		left: 0;
		margin-top: 1px;
		width: 4ch;
		height: 3px;
		background-color: currentColor;
		border-radius: 2px;
	}
	@media ( min-width: 1040px ) {
		.variants-section .copy-heading :last-child:after {
			margin-top: -1px;
			height: 4px;
		}
	}
	.variants-section .copy {
		position: relative;
		z-index: 1;
	}

	/*
	 |
	 |
	 */
	.variants-section .variants-container {}
	.variants-section .variants-container > * {
		visibility: hidden;
		opacity: 0;
		transition:
				visibility 0s 0.6s,
				opacity 0.4s 0.1s ease-in;
	}
	.variants-section .variants-container > .visible {
		visibility: visible;
		opacity: 1;
		transition: opacity 0.4s 0.1s ease-in;
	}

	/*
	 |
	 |
	 */
	.variants-section ul {
		list-style-position: outside;
		list-style-type: disc;
		padding-left: 2rem;
	}

	/*
	 | Image banners
	 |
	 */
	.variants-section .image-banner {
		background-repeat: no-repeat;
		background-position: center center;
		background-size: cover;
	}

</style>

<section data-section="variants" data-id="variants" id="variants" class="variants-section js_variants_section">
	<div class="fill-neutral-4 text-light">
		<div class="container py-75 js_variant_subsection">
			<h3 class="block mb-50 h3 strong">a 22 foot master bedroom with room for options.</h3>
			<div class="button-group relative mb-50 md:mb-0">
				<button class="button fill-red-2 text-white strong js_variant_option">Variant 1</button>
				<button class="button fill-neutral-3 text-black strong js_variant_option">Variant 2</button>
				<button class="button fill-neutral-3 text-black strong js_variant_option">Variant 3</button>
				<button class="button fill-neutral-3 text-black strong js_variant_option">Variant 4</button>
			</div>
			<div class="variants-container relative">
				<div class="row relative js_variant_content visible">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/master-bedroom/1.png<?= $ver ?>" alt="" loading="lazy">
						<p class="label text-neutral-1">*Provided as default variant</p>
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">01</span>
							<span class="h6 md:h3">King-size and Walk-in</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">Don’t compromise. You have the space.</p>
						<p class="p xl:h6 text-neutral-1">Opt to really live like a king.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Reading Area.</li>
							<li>King Size Bed.</li>
							<li>Walk-in Wardrobe.</li>
							<li>Entertainment Wall.</li>
						</ul>
					</div>
				</div>
				<div class="row relative js_variant_content absolute top-0">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/master-bedroom/2.png<?= $ver ?>" alt="" loading="lazy">
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">02</span>
							<span class="h6 md:h3">Hybrid Ready</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">If you have embraced the ‘new normal’ and regularly work from home.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Dual Wardrobes.</li>
							<li>King Size Bed.</li>
							<li>Dedicated Work-from-home Pod.</li>
							<li>Entertainment Wall.</li>
						</ul>
					</div>
				</div>
				<div class="row relative js_variant_content absolute top-0">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/master-bedroom/3.png<?= $ver ?>" alt="" loading="lazy">
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">03</span>
							<span class="h6 md:h3">Queen Size with Study</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">Sometimes just open space and some breathing room are your preference.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Work Area + Reading Corner.</li>
							<li>Queen Size Bed.</li>
							<li>Entertainment Wall.</li>
							<li>Wall Length Wardrobe.</li>
						</ul>
					</div>
				</div>
				<div class="row relative js_variant_content absolute top-0">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/master-bedroom/4.png<?= $ver ?>" alt="" loading="lazy">
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">04</span>
							<span class="h6 md:h3">Twin Queens</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">Stay on the 2rd floor. Give the master bedroom to your twin daughters.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Twin Queen Size Beds.</li>
							<li>Entertainment Wall.</li>
							<li>Study Area.</li>
							<li>Wall Length Wardrobes.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="image-banner py-250 lg:mt-75 xl:mt-150" style="background-image: url( '<?= $imageBanner1 ?>' )"></div>
	</div>
	<div class="fill-neutral-5 text-light">
		<div class="container py-75 js_variant_subsection">
			<h3 class="block mb-50 h3 strong">
				every family has different needs.
				make your ground floor different.
			</h3>
			<div class="button-group relative mb-50 md:mb-0">
				<button class="button fill-neutral-3 text-black strong js_variant_option">Variant 1</button>
				<button class="button fill-neutral-3 text-black strong js_variant_option">Variant 2</button>
				<button class="button fill-red-2 text-white strong js_variant_option">Variant 3</button>
			</div>
			<div class="variants-container relative">
				<div class="row relative js_variant_content absolute top-0">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/living-and-dining/1.png<?= $ver ?>" alt="" loading="lazy">
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">01</span>
							<span class="h6 md:h3">Home and a little work</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">If you bring work home on a regular basis. You’ll want to keep it private.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Dedicated Meeting Den.</li>
							<li>Island Kitchen and Dining.</li>
							<li>Entertainment Wall.</li>
							<li>Family Room.</li>
							<li>Outdoor Patio.</li>
						</ul>
					</div>
				</div>
				<div class="row relative js_variant_content absolute top-0">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/living-and-dining/2.png<?= $ver ?>" alt="" loading="lazy">
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">02</span>
							<span class="h6 md:h3">One Large Space</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">When you can afford to stretch out and enjoy the extra open space.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Island Kitchen and Breakfast Counter.</li>
							<li>Dining Area.</li>
							<li>Entertainment Wall.</li>
							<li>Family Room.</li>
							<li>Outdoor Patio.</li>
						</ul>
					</div>
				</div>
				<div class="row relative js_variant_content visible">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/living-and-dining/3.png<?= $ver ?>" alt="" loading="lazy">
						<p class="label text-neutral-1">*Provided as default variant</p>
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">03</span>
							<span class="h6 md:h3">Spaces for everthing</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">You might be the person who likes dedicated spaces for every activity.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Kitchen with Mini Breakfast Counter.</li>
							<li>Dining Area.</li>
							<li>Living Room.</li>
							<li>Entertainment Wall.</li>
							<li>Family Room.</li>
							<li>Outdoor Patio.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="image-banner py-250 xl:mt-75" style="background-image: url( '<?= $imageBanner2 ?>' )"></div>
	</div>
	<div class="fill-neutral-4 text-light">
		<div class="container py-75 js_variant_subsection">
			<h3 class="block mb-50 h3 strong">
				there is more, make the 2nd floor suit your lifestyle choices
			</h3>
			<div class="button-group relative mb-50 md:mb-0">
				<button class="button fill-neutral-3 text-black strong js_variant_option">Variant 1</button>
				<button class="button fill-neutral-3 text-black strong js_variant_option">Variant 2</button>
				<button class="button fill-red-2 text-white strong js_variant_option">Variant 3</button>
			</div>
			<div class="variants-container relative">
				<div class="row relative js_variant_content absolute top-0">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/second-floor/1.png<?= $ver ?>" alt="" loading="lazy">
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">01</span>
							<span class="h6 md:h3">Bedroom & Lounge</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">A fourth bedroom for a large family and a second lounge area on the 2nd floor.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Fourth Bedroom.</li>
							<li>Lounge.</li>
							<li>Entertainment Wall.</li>
							<li>Open Terrace</li>
						</ul>
					</div>
				</div>
				<div class="row relative js_variant_content absolute top-0">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/second-floor/2.png<?= $ver ?>" alt="" loading="lazy">
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">02</span>
							<span class="h6 md:h3">One Large Space</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">Remove the seperating wall and create one large room on the 2nd floor.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Home Theatre Room.</li>
							<li>Bar & Lounge.</li>
							<li>Open Terrace,</li>
						</ul>
					</div>
				</div>
				<div class="row relative js_variant_content visible">
					<figure class="column small-12 medium-5 m-0">
						<img src="/media/isometrics/myra/second-floor/3.png<?= $ver ?>" alt="" loading="lazy">
						<p class="label text-neutral-1">*Provided as default variant</p>
					</figure>
					<div class="copy column small-12 medium-7">
						<h4 class="copy-heading flex items-end mt-150 md:mt-50">
							<span class="h1" style="">03</span>
							<span class="h6 md:h3">Home Theatre & Gym</span>
						</h4>
						<p class="block mt-25 p xl:h6 text-neutral-1">A dedicated home theatre room and a personal gym on the 2nd floor.</p>
						<ul class="mt-25 p xl:h6 text-neutral-1">
							<li>Dedicated Home Theatre Room</li>
							<li>Personal Gym</li>
							<li>Open Terrace</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="image-banner py-250 md:mt-100 lg:mt-75" style="background-image: url( '<?= $imageBanner3 ?>' )"></div>
	</div>
</section>
