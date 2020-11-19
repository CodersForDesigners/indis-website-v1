<?php

// Among the vars that are provided: $block, $content, $is_preview, $post_id

$name = get_field( 'nombre' );
$hat = get_field( 'cap' );

?>

<p>
	I'm <strong><?= $name ?></strong>, and I rock a <?= $hat ?> capa!
</p>
<?php if ( $is_preview ) : ?>
	<pre>
		<?= json_encode( [ $block, $content ], JSON_PRETTY_PRINT ) ?>
	</pre>
<?php endif; ?>
