<!-- EMBED: NPS Section -->
<?php // require_once __DIR__ . '/../inc/nps.php'; ?>
<!-- END: NPS Section -->



<!-- 
	*** NPS Styles ***
 -->
<style>
.nps-section {}

.nps-option {
	position: relative;
	font-size: 0;
}

.nps-option .nps-input {
	margin-right: 2px;
	margin-bottom: 2px;
}
.nps-option .nps-input:last-child {
	margin-right: 0;
}

.nps-option .nps-input input + .label {
	background-color: var(--dark);
	text-align: center;
}

.nps-option .nps-input input:checked + .label{
	background-color: var(--red-2);
}

@media( min-width: 640px )  {
	.nps-option .nps-input {
		margin-right: 4px;
		margin-bottom: 4px;
	}
}

@media( min-width: 1040px ) {
	.nps-option .nps-input {
		margin-right: 5px;
		margin-bottom: 5px;
	}
}

@media( min-width: 1480px ) {
	.nps-option .nps-input {
		margin-right: 7px;
		margin-bottom: 7px;
	}
}

/* -- NPS Rating -- */
.nps-option .nps-rating {
	position: relative;
	overflow-x: visible;
	padding-top: 16px;
}
.nps-option .nps-rating:nth-child(1):before,
.nps-option .nps-rating:nth-child(11):before {
	font-size: 12px;
	line-height: 1;
	position: absolute;
	top: 0;
	white-space: nowrap;
}
.nps-option .nps-rating:nth-child(1):before { 
	content: 'Not likely at all';
	left: 0; 
}
.nps-option .nps-rating:nth-child(11):before { 
	content: 'Extremely Likely';
	right: 0; 
}

.nps-option .nps-rating input + .label {
	padding: 0;
	min-width: calc(var(--space-min) * 2.5);
}
@media( min-width: 640px )  {
	.nps-option .nps-rating {
		padding-top: 20px;
	}
	.nps-option .nps-rating:nth-child(1):before,
	.nps-option .nps-rating:nth-child(11):before {
		font-size: 15px;
	}

	.nps-option .nps-rating input + .label {
		min-width: var(--space-75);
	}
}
@media( min-width: 1040px ) {
	.nps-option .nps-rating input + .label {
		min-width: var(--space-50);
	}
}
@media( min-width: 1480px ) {
	.nps-option .nps-rating {
		padding-top: 24px;
	}
	.nps-option .nps-rating:nth-child(1):before,
	.nps-option .nps-rating:nth-child(11):before {
		font-size: 18px;
	}

}

/* -- Text Input -- */
.nps-option .text-input textarea {
	width: calc( var(--space-100) * 6 );
	height: calc( var(--space-75) * 3 );
}
@media( min-width: 640px )  {}
@media( min-width: 1040px ) {
	.nps-option .text-input textarea {
		height: calc( var(--space-50) * 3 );
	}
}
@media( min-width: 1480px ) {}

.nps-submit {
	transition: opacity 0.25s ease-in;
}

</style>
 
<!-- 
	*** NPS Markup ***
 -->
<!-- <section data-section="NPS" data-id="nps" class="nps-section space-50-top-bottom"> -->
<section class="nps-section space-50-top-bottom">
	<div class="container js_nps_section">
		<div class="row js_nps_card">
		</div>
	</div>
</section>

