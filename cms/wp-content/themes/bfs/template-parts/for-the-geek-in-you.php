<?php

// Among the vars that are provided: $block, $content, $is_preview, $post_id

$aa_title = get_field( 'aa_title' );
$aa_link = get_field( 'aa_link' );
$aa_cta_text = get_field( 'aa_cta_text' );

?>

<div class="associate-article-block fill-red-2">
	<div class="container">
		<div class="row space-25-top-bottom">
			<div class="columns small-12 large-8 large-offset-2">
				<div class="label text-uppercase space-min-bottom">For the Geek in you</div>
				<div class="associate-article-title h3 space-25-bottom"><?= $aa_title ?></div>
				<a href="<?= $aa_link ?>" class="aa-cta button fill-dark" target="_blank"><?= $aa_cta_text ?></a>
			</div>
		</div>
	</div>
</div>

