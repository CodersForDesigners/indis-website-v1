<!-- EMBED: NPS Section -->
<?php // require_once __DIR__ . '/../inc/nps.php'; ?>
<!-- END: NPS Section -->



<!-- 
	*** NPS Styles ***
 -->
<style>
.nps-section {}

.nps-answer {
	font-size: 0;
}

.nps-answer .nps-input {
	margin-right: 2px;
	margin-bottom: 2px;
}
.nps-answer .nps-input:last-child {
	margin-right: 0;
}

.nps-answer .nps-input input + .label {
	background-color: var(--dark);
	text-align: center;
}

.nps-answer .nps-input input:checked + .label{
	background-color: var(--red-2);
}

@media( min-width: 640px )  {
	.nps-answer .nps-input {
		margin-right: 4px;
		margin-bottom: 4px;
	}
}

@media( min-width: 1040px ) {
	.nps-answer .nps-input {
		margin-right: 5px;
		margin-bottom: 5px;
	}
}

@media( min-width: 1480px ) {
	.nps-answer .nps-input {
		margin-right: 7px;
		margin-bottom: 7px;
	}
}

/* -- NPS Rating -- */
.nps-answer .nps-rating input + .label {
	padding: 0;
	min-width: calc(var(--space-min) * 2.5);
}
@media( min-width: 640px )  {
	.nps-answer .nps-rating input + .label {
		min-width: var(--space-75);
	}
}
@media( min-width: 1040px ) {
	.nps-answer .nps-rating input + .label {
		min-width: var(--space-50);
	}
}
@media( min-width: 1480px ) {}

/* -- Text Input -- */
.nps-answer .text-input textarea {
	width: calc( var(--space-100) * 6 );
	height: calc( var(--space-75) * 3 );
}
@media( min-width: 640px )  {}
@media( min-width: 1040px ) {
	.nps-answer .text-input textarea {
		height: calc( var(--space-50) * 3 );
	}
}
@media( min-width: 1480px ) {}

</style>
 
<!-- 
	*** NPS Markup ***
 -->
<!-- <section data-section="NPS" data-id="nps" class="nps-section space-50-top-bottom"> -->
<section class="nps-section space-50-top-bottom">
	<div class="container">
		<div class="row">
			<div class="nps-question columns small-12 xlarge-offset-1 xlarge-10">
				<div class="label strong text-uppercase text-neutral-2 space-min-bottom">Give us your feedback</div>
				<div class="h4 strong space-25-bottom">How likely are <span class="text-red-2">you</span> to recommend INDIS to a friend or colleague?</div>
			</div>
			<div class="nps-answer columns small-12 xlarge-offset-1 xlarge-10">
				<!-- NPS Rating -->
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="0">
					<span class="label button strong">0</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="1">
					<span class="label button strong">1</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="2">
					<span class="label button strong">2</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="3">
					<span class="label button strong">3</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="4">
					<span class="label button strong">4</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="5">
					<span class="label button strong">5</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="6">
					<span class="label button strong">6</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="7">
					<span class="label button strong">7</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="8">
					<span class="label button strong">8</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="9">
					<span class="label button strong">9</span>
				</label>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="nps-rating" value="0">
					<span class="label button strong">10</span>
				</label>
				<!-- END: NPS Rating -->
				<div class="nps-submit space-25-top">
					<button class="fill-neutral-1 strong">Submit</button>
				</div>
			</div>
		</div>
		<hr style="margin: var(--space-50) 0; opacity: 0.125;">
		<div class="row">
			<div class="nps-question columns small-12 xlarge-offset-1 xlarge-10">
				<div class="h4 strong space-25-bottom">Please <span class="text-red-2">pick 2 things</span> that INDIS can improve.</div>
			</div>
			<div class="nps-answer columns small-12 xlarge-offset-1 xlarge-10">
				<!-- Multi Select -->
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="checkbox" name="multi-select" value="pricing too high">
					<span class="label button">Pricing too high</span>
				</label>
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="checkbox" name="multi-select" value="quality of phone calls">
					<span class="label button">Quality of phone calls</span>
				</label>
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="checkbox" name="multi-select" value="number of locations">
					<span class="label button">Number of locations</span>
				</label>
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="checkbox" name="multi-select" value="quality of website">
					<span class="label button">Quality of website</span>
				</label>
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="checkbox" name="multi-select" value="quality of advertising">
					<span class="label button">Quality of advertising</span>
				</label>
				<!-- END: Multi Select -->
				<div class="nps-submit space-25-top">
					<button class="fill-neutral-1 strong">Submit</button>
				</div>
			</div>
		</div>
		<hr style="margin: var(--space-50) 0; opacity: 0.125;">
		<div class="row">
			<div class="nps-question columns small-12 xlarge-offset-1 xlarge-10">
				<div class="h4 strong space-min-bottom">That was super helpful!</div>
				<div class="h5 space-25-bottom">We have a couple of new ideas in the making. Can we contact you on the phone to pick your brains?</div>
			</div>
			<div class="nps-answer columns small-12 xlarge-offset-1 xlarge-10">
				<!-- Single Select -->
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="single-select" value="yes">
					<span class="label button">Yes</span>
				</label>
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="single-select" value="no">
					<span class="label button">No</span>
				</label>
				<!-- END: Single Select -->
				<div class="nps-submit space-25-top">
					<button class="fill-neutral-1 strong">Submit</button>
				</div>
			</div>
			<hr style="margin: var(--space-50) 0; opacity: 0.125;">
			<div class="nps-question columns small-12 xlarge-offset-1 xlarge-10">
				<div class="h4 strong space-25-bottom">Thank you!! What did <span class="text-red-2">you</span> like about INDIS?</div>
			</div>
			<div class="nps-answer columns small-12 xlarge-offset-1 xlarge-10">
				<!-- Text Input -->
				<label class="nps-input text-input cursor-pointer inline">
					<!-- <input class="visuallyhidden" type="radio" name="single-select" value="no"> -->
					<!-- <span class="label button">No</span> -->
					<textarea class="fill-dark block" name="text-input" placeholder="Type your message here!"></textarea>
				</label>
				<!-- END: Text Input -->
				<div class="nps-submit space-25-top">
					<button class="fill-neutral-1 strong">Submit</button>
				</div>
			</div>
		</div>
		<hr style="margin: var(--space-50) 0; opacity: 0.125;">
		<div class="row">
			<div class="nps-question columns small-12 xlarge-offset-1 xlarge-10">
				<div class="h4 strong space-25-bottom">Enter your <span class="text-red-2">phone number</span>.</div>
			</div>
			<div class="nps-answer columns small-12 xlarge-offset-1 xlarge-10">
				<!-- Phone Trap -->
				<div class="nps-input phone-trap columns small-12 medium-6 large-3">
					<div class="row">
						<div class="columns small-3 prefix-group" style="position: relative; padding-right: 5px; ">
							<select class="form-field block js_phone_country_code" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0">
								<?php include __DIR__ . '/../inc/phone-country-codes.php' ?>
							</select>
							<input class="prefix strong input-field text-red-2 text-right no-pointer js_phone_country_code_label" tabindex="-1" value="+91" style="width: 100%; padding: 0; padding-right: 3px; border-color: var(--red-2);">
						</div>
						<div class="columns small-9">
							<input class="block" type="text" name="phone-number" required>
						</div>
					</div>
				</div>
				<!-- END: Phone Trap -->
				<div class="nps-submit space-25-top">
					<button class="fill-neutral-1 strong">Submit</button>
				</div>
			</div>
		</div>
		<hr style="margin: var(--space-50) 0; opacity: 0.125;">
		<div class="row">
			<div class="nps-question columns small-12 xlarge-offset-1 xlarge-10">
				<div class="h4 strong space-25-bottom">Enter the <span class="text-red-2">OTP</span>.</div>
			</div>
			<div class="nps-answer columns small-12 xlarge-offset-1 xlarge-10">
				<!-- Phone OTP -->
				<div class="nps-input phone-otp columns small-12 medium-6 large-3">
					<div class="row">
						<div class="columns small-12">
							<input class="otp block" type="text" name="otp">
						</div>
					</div>
				</div>
				<!-- END: Phone OTP -->
				<div class="nps-submit space-25-top">
					<button class="fill-neutral-1 strong">Submit</button>
				</div>
			</div>
		</div>
	</div>
</section>
