<?php
/*
 *
 * This is a sample page you can copy and use as boilerplate for any new page.
 *
 */
require_once __DIR__ . '/../inc/utils.php';
initWordPress();

require_once __DIR__ . '/../inc/above.php';

require_once __DIR__ . '/../inc/nps.php';

?>

<div style="padding: 10rem"></div>

<section class="nps-section space-50-top-bottom">
	<div class="container js_nps_section">
		<div class="row js_nps_card">
		</div>
	</div>
</section>

<script type="text/javascript" src="/js/modules/utils.js"></script>
<script type="text/javascript" src="/js/modules/cupid/utils.js"></script>
<script type="text/javascript" src="/plugins/SheetJS/xlsx-core-v0.16.0.min.js"></script>
<script type="text/javascript" src="/plugins/xlsx-calc/xlsx-calc-v0.4.1.js"></script>
<script type="text/javascript" src="/js/modules/spreadsheet-formulae.js"></script>
<script type="text/javascript" src="/js/modules/cupid/nps.js"></script>

<script type="text/javascript">

	$( ".nps-section" ).first().remove();

	/*
	 *
	 * Start the questionnaire
	 *
	 */
	$( function main () {
		fetchQuestionnaireSpreadsheet()
			.then( initQuestionnaire )
			.then( function () {
				$( document ).trigger( "nps/question/ask" );
			} );
	} );

</script>
