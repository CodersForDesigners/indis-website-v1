<?php

# * - Error Reporting
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

/* ------------------------------- \
 * Request Parsing
 \-------------------------------- */
# Get JSON as a string
$json = file_get_contents( 'php://input' );
# Convert the JSON string to an object
$error = null;
try {
	$input = json_decode( $json, true );
	if ( empty( $input ) )
		throw new \Exception( "No data provided." );
}
catch ( \Exception $e ) {
	$error = $e->getMessage();
}

$question = $input[ 'question' ];
$index = $input[ 'index' ];
$type = $input[ 'type' ];
$options = $input[ 'options' ];

?>

<div class="row js_question_card">
	<div class="nps-question columns small-12 xlarge-offset-1 xlarge-10">
		<?= $question ?>
	</div>
	<div class="nps-answer columns small-12 xlarge-offset-1 xlarge-10">

		<?php if ( $type === 'nps_range' ) : ?>
			<!-- NPS Rating -->
			<?php foreach ( $options as $option ) : ?>
				<label class="nps-input nps-rating cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="q<?= $index ?>" value="<?= strtolower( $option ) ?>">
					<span class="label button strong"><?= $option ?></span>
				</label>
			<?php endforeach; ?>
			<!-- END: NPS Rating -->
		<?php endif; ?>

		<?php if ( $type === 'text_input' ) : ?>
			<!-- Text Input -->
			<textarea class="fill-dark block" name="q<?= $index ?>" placeholder="Type your message here!"></textarea>
			<!-- END: Text Input -->
		<?php endif; ?>

		<?php if ( $type === 'single_select' ) : ?>
			<!-- Single Select -->
			<?php foreach ( $options as $option ) : ?>
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="radio" name="q<?= $index ?>" value="<?= strtolower( $option ) ?>">
					<span class="label button"><?= $option ?></span>
				</label>
			<?php endforeach; ?>
			<!-- END: Single Select -->
		<?php endif; ?>

		<?php if ( $type === 'multi_select' ) : ?>
			<!-- Multi Select -->
			<?php foreach ( $options as $option ) : ?>
				<label class="nps-input single-select cursor-pointer inline">
					<input class="visuallyhidden" type="checkbox" name="q<?= $index ?>" value="<?= strtolower( $option ) ?>">
					<span class="label button"><?= $option ?></span>
				</label>
			<?php endforeach; ?>
			<!-- END: Multi Select -->
		<?php endif; ?>

		<?php if ( $type === 'phone_number' ) : ?>
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
		<?php endif; ?>

		<?php if ( $type === 'phone_otp' ) : ?>
		<?php endif; ?>

		<div class="nps-submit space-25-top">
			<button class="fill-neutral-1 strong">Submit</button>
		</div>
	</div>
</div>
