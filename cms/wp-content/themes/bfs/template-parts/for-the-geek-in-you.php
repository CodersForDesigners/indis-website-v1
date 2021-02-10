<?php

// Among the vars that are provided: $block, $content, $is_preview, $post_id

$title = get_field( 'ftgiy_title' );
$link = get_field( 'ftgiy_link' );
$ctaText = get_field( 'ftgiy_cta_text' );

?>
<div class="associate-article-block fill-red-2">
	<div class="container">
		<div class="row space-25-top-bottom">
			<div class="columns small-12 large-9 xlarge-8">
				<div class="label text-uppercase space-min-bottom">For the Geek in you</div>
				<div class="associate-article-title h3 space-25-bottom"><?= $title ?></div>
				<a href="<?= $link ?>" class="aa-cta button fill-dark" target="_blank"><?= $ctaText ?></a>
			</div>
		</div>
	</div>
</div>
